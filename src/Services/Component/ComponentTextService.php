<?php

namespace Motor\CMS\Services\Component;

use Motor\CMS\Models\Component\ComponentText;
use Motor\CMS\Services\ComponentBaseService;

/**
 * Class ComponentTextService
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
            'description' => $this->request->get('image_description'),
            'crop'        => $this->request->get('image_crop'),
        ]);
    }

    public function afterUpdate(): void
    {
        parent::afterUpdate();
        $this->addFileAssociation('image', [
            'position'    => $this->request->get('image_position'),
            'enlarge'     => $this->request->get('image_enlarge'),
            'description' => $this->request->get('image_description'),
            'crop'        => $this->request->get('image_crop'),
        ]);
    }
}
