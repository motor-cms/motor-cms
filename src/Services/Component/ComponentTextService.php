<?php

namespace Motor\CMS\Services\Component;

use Motor\CMS\Models\Component\ComponentText;
use Motor\CMS\Services\ComponentBaseService;

/**
 * Class ComponentTextService
 * @package Motor\CMS\Services\Component
 */
class ComponentTextService extends ComponentBaseService
{
    protected $model = ComponentText::class;

    protected $name = 'text';


    public function afterCreate(): void
    {
        parent::afterCreate();
        $this->addFileAssociation('image');
    }


    public function afterUpdate(): void
    {
        parent::afterUpdate();
        $this->addFileAssociation('image');
    }
}
