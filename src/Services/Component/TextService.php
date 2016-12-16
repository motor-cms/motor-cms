<?php

namespace Motor\CMS\Services\Component;

use Motor\CMS\Models\Component\ComponentText;
use Motor\Backend\Services\BaseService;
use Motor\CMS\Models\PageComponent;

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
        $pageComponent = new PageComponent();
        $pageComponent->page_id = $this->request->get('page_id');
        $pageComponent->container = $this->request->get('container');
        $pageComponent->component_name = $this->name;
        $pageComponent->sort_position = PageComponent::where('page_id', $this->request->get('page_id'))->where('container', $this->request->get('container'))->count()+1;
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
