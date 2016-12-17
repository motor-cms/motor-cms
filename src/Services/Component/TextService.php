<?php

namespace Motor\CMS\Services\Component;

use Motor\CMS\Models\Component\ComponentText;
use Motor\Backend\Services\BaseService;
use Motor\CMS\Models\PageVersionComponent;

class TextService extends BaseService
{

    protected $model = ComponentText::class;

    protected $name = 'text';

    public function beforeCreate()
    {
    }

    public function afterCreate()
    {
        // Create the page component
        $pageComponent = new PageVersionComponent();
        $pageComponent->page_version_id = $this->request->get('page_version_id');
        $pageComponent->container = $this->request->get('container');
        $pageComponent->component_name = $this->name;
        $pageComponent->sort_position = PageVersionComponent::where('page_version_id', $this->request->get('page_version_id'))->where('container', $this->request->get('container'))->count()+1;
        $this->record->component()->save($pageComponent);
    }

    public function beforeDelete()
    {
        $this->record->component()->delete();
    }

    public function beforeUpdate()
    {

    }
}
