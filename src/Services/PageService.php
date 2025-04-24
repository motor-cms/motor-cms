<?php

namespace Motor\CMS\Services;

use Motor\Backend\Services\BaseService;
use Motor\CMS\Models\Page;

/**
 * Class PageService
 */
class PageService extends BaseService
{
    protected $model = Page::class;

    public function beforeCreate()
    {
        $this->record->setVersionAttributes($this->data);
    }

    public function beforeUpdate()
    {
        $this->record->setVersionAttributes($this->data);

        if ((int) $this->request->get('duplicate') > 0) {
            $this->record->setCurrentVersion((int) $this->request->get('duplicate'));
            $this->record->addVersion();
            $this->record->setCurrentVersion($this->record->getLatestVersionNumber());
        }
        if ((int) $this->request->get('publish') == 1) {
            $this->record->setVersionState('LIVE');
        }
    }

    public function afterUpdate()
    {
        //
        if ((int) $this->request->get('publish') == 1) {
            $this->record->setVersionState('LIVE');
            $this->record->setVersionAttributes($this->data);
            $this->record->updateVersion($this->record->getCurrentVersion());
            // $previousVersion = $this->record->getCurrentVersion();
            // $previousVersion->versionable_state = 'LIVE';
            // $previousVersion->save();
            $this->record->addVersion();
        }
    }
}
