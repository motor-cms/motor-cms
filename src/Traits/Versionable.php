<?php

namespace Motor\CMS\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait Versionable
{

    protected $versionState = 'DRAFT';

    protected $insertNewVersion = false;

    protected $versionAttributes = [];

    protected $currentVersion = null;


    /**
     * Boot trait
     */
    public static function bootVersionable()
    {
        // FIXME: these seem to be unused currently - can we get rid of them (incompatibility with Laravel 5.8 as well)
        //$hooks = new VersionableHooks;
        //
        //foreach ([
        //             'isDirty',
        //             'setAttribute',
        //         ] as $method) {
        //    static::observe($method, $hooks->{$method}());
        //}
    }


    /**
     * Override getter so we can return versionable attributes
     *
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (in_array($key, $this->versionableColumns)) {
            $version = $this->getCurrentVersion();
            if ( ! is_null($version)) {
                return $version->getAttribute($key);
            }
        }

        return parent::__get($key);
    }


    /**
     * @return string
     */
    public function getVersionTable()
    {
        return Str::singular($this->getTable()) . '_versions';
    }

    /**
     * @return array
     */
    public function getVersionAttributes()
    {
        return $this->versionAttributes;
    }

    public function setVersionAttributes($attributes)
    {
        $this->versionAttributes = $attributes;
    }

    /**
     * @return string
     */
    public function getVersionModel()
    {
        $class = new \ReflectionClass($this);

        return $class->getNamespaceName() . '\\' . Str::studly(Str::singular($this->getVersionTable()));
    }


    /**
     * Add new version and set as draft
     */
    public function addVersion()
    {
        // 1. clone version and save as new
        $oldVersion                     = $this->getCurrentVersion();
        $newVersion                     = $oldVersion->replicate();
        $newVersion->versionable_state  = 'DRAFT';
        $newVersion->versionable_number = $this->getNextVersionNumber();
        $newVersion->save();

        // 2. clone PageVersionComponents
        foreach ($oldVersion->components()->get() as $component) {

            $c = $component->replicate();
            if ($c->push()) {
                $newVersion->components()->save($c);

                // 3. clone actual components
                if ($c->component_id != null) {
                    $cc = $c->component->replicate();
                    if ($cc->push()) {
                        $cc->component()->save($c);
                    }

                    // 4. clone file associations
                    if (isset($c->component->file_associations)) {
                        foreach ($c->component->file_associations as $file_association) {
                            $fa = $file_association->replicate();
                            $fa->model_id = $cc->id;
                            $fa->save();
                        }
                    }
                }

            }
        }
    }


    /**
     * Set next version state
     *
     * @param $state
     *
     * @return $this
     */
    public function setVersionState($state)
    {
        $this->versionState = $state;

        return $this;
    }

    /**
     * Get current version state
     *
     * @return string
     */
    public function getVersionState()
    {
        return $this->versionState;
    }


    /**
     * Override insert method
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function performInsert(Builder $query)
    {
        $result = parent::performInsert($query);

        // Create version
        $this->createVersion();

        return $result;
    }


    /**
     * Override update method
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function performUpdate(Builder $query)
    {
        $result = parent::performUpdate($query);

        // Update or create new version
        if ($this->insertNewVersion) {
            $this->createVersion();
        } else {
            $this->updateVersion($this->getCurrentVersion());
        }

        return $result;
    }


    /**
     * Save model with new version (currently unused)
     *
     * @param array $options
     *
     * @return mixed
     */
    //public function saveNewVersion(array $options = [])
    //{
    //    $this->insertNewVersion = true;
    //    $result                 = parent::save($options);
    //    $this->insertNewVersion = false;
    //
    //    return $result;
    //}

    /**
     * Sets the current version to a given version number
     *
     * @param $number
     *
     * @return $this
     */
    public function setCurrentVersion($number)
    {
        $model = $this->getVersionModel();
        if ( ! is_null($model::where('versionable_number', $number)->first())) {
            $this->currentVersion = $number;
        }

        return $this;
    }


    /**
     * Return latest version
     *
     * @return mixed
     */
    public function getLatestVersion()
    {
        $model   = $this->getVersionModel();
        $version = $model::where('versionable_id', $this->id)->orderBy('versionable_number', 'DESC')->first();

        return $version;
    }

    /**
     * Return the versionable_number of the currently used version
     *
     * @return int
     */
    public function getLatestVersionNumber()
    {
        $version = $this->getLatestVersion();

        if (is_null($version)) {
            return 0;
        }
        return $version->versionable_number;
    }

    public function getLiveVersion()
    {
        $model = $this->getVersionModel();
        $version = $model::where('versionable_id', $this->id)->where('versionable_state', 'LIVE')->first();

        return $version;
    }


    /**
     * Return currently used version
     *
     * @return mixed
     */
    public function getCurrentVersion()
    {
        $model = $this->getVersionModel();
        if (is_null($this->currentVersion)) {
            $version = $model::where('versionable_id', $this->id)->orderBy('versionable_number', 'DESC')->first();
        } else {
            $version = $model::where('versionable_id', $this->id)->where('versionable_number',
                $this->currentVersion)->first();
        }

        return $version;
    }


    /**
     * Return the versionable_number of the currently used version
     *
     * @return int
     */
    public function getCurrentVersionNumber()
    {
        $version = $this->getCurrentVersion();

        if (is_null($version)) {
            return 0;
        }
        return $version->versionable_number;
    }


    /**
     * Update a version and set the necessary attributes
     *
     * @param $version
     */
    public function updateVersion($version)
    {
        $model = $this->getVersionModel();
        if (is_null($version)) {
            $version                     = new $model();
            $version->versionable_number = $this->getNextVersionNumber();
        }

        if ($this->getVersionState() == 'LIVE') {
            foreach ($model::where('versionable_id', $this->id)->where('versionable_state', 'LIVE')->get() as $v) {
                $v->versionable_state = 'CLEARED';
                $v->save();
            }
        }

        $version->fill($this->getVersionAttributes());
        $version->versionable_id    = $this->id;
        $version->versionable_state = $this->getVersionState();
        $version->created_by        = $this->created_by;
        $version->updated_by        = $this->updated_by;
        $version->save();
    }


    /**
     * Create a new version
     */
    public function createVersion()
    {
        $model                       = $this->getVersionModel();
        $version                     = new $model($this->getVersionAttributes());
        $version->versionable_number = $this->getNextVersionNumber();

        $this->updateVersion($version);
    }


    /**
     * Get next available version number
     *
     * @return int
     */
    public function getNextVersionNumber()
    {
        $model         = $this->getVersionModel();
        $latestVersion = $model::where('versionable_id', $this->id)->orderBy('versionable_number', 'DESC')->first();
        if (is_null($latestVersion)) {
            return 1;
        } else {
            return $latestVersion->versionable_number + 1;
        }
    }
}