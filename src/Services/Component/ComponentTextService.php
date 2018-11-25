<?php

namespace Motor\CMS\Services\Component;

use Motor\CMS\Models\Component\ComponentText;
use Motor\CMS\Services\ComponentBaseService;

class ComponentTextService extends ComponentBaseService
{

    protected $model = ComponentText::class;

    protected $name = 'text';


    public function afterCreate()
    {
        parent::afterCreate();
        $this->addFileAssociation('image');
    }


    public function afterUpdate()
    {
        parent::afterUpdate();
        $this->addFileAssociation('image');
    }
}
