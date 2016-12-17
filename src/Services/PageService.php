<?php

namespace Motor\CMS\Services;

use Motor\CMS\Models\Page;
use Motor\Backend\Services\BaseService;

class PageService extends BaseService
{

    protected $model = Page::class;


    public function beforeCreate()
    {

    }


    public function beforeUpdate()
    {
        if ((int)$this->request->get('duplicate') > 0) {
            $this->record->setCurrentVersion((int)$this->request->get('duplicate'));
            $this->record->addVersion();
            $this->record->setCurrentVersion($this->record->getLatestVersionNumber());
        }
        if ((int)$this->request->get('publish') == 1) {
            $this->record->setVersionState('LIVE');
        }
    }

    public function afterUpdate()
    {
        if ((int)$this->request->get('publish') == 1) {
            $this->record->addVersion();
        }
    }
}
