<?php

namespace Motor\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\CMS\Traits\Versionable;
use Sofa\Eloquence\Eloquence;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

class Page extends Model
{

    use Eloquence;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;
    use Filterable;
    use Versionable;

    protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the Eloquence trait
     *
     * @var array
     */
    protected $searchableColumns = [ 'name' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'language_id',

        // versioned attributes need to be fillable as well so we can save the record. maybe we need to change something about that...
        'is_active',
        'template',
        'name',
        'meta_keywords',
        'meta_description',
    ];

    protected $versionableColumns = [
        'versionable_state',
        'versionable_number',
        'is_active',
        'template',
        'name',
        'meta_keywords',
        'meta_description',
    ];


    public function versions()
    {
        // we need to join tables and stuff here
        return $this->hasMany(PageVersion::class, 'versionable_id');
    }
}
