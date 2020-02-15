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
        $this->addFileAssociation('image', [
            'position'    => $this->request->get('image_position'),
            'enlarge'     => $this->request->get('image_enlarge'),
            'description' => $this->request->get('image_description')
        ]);
    }


    public function afterUpdate(): void
    {
        var_dump($this->request->all());
        parent::afterUpdate();
        $this->addFileAssociation('image', [
            'position'    => $this->request->get('image_position'),
            'enlarge'     => $this->request->get('image_enlarge'),
            'description' => $this->request->get('image_description')
        ]);
    }
}
