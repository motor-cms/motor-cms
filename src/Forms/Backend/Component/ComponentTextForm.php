<?php

namespace Motor\CMS\Forms\Backend\Component;

use Kris\LaravelFormBuilder\Form;

/**
 * Class ComponentTextForm
 * @package Motor\CMS\Forms\Backend\Component
 */
class ComponentTextForm extends Form
{

    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add(
            'headline',
            'text',
            [ 'label' => trans('motor-cms::component/texts.headline'), 'rules' => 'required' ]
        )
            ->add(
                'anchor',
                'text',
                [ 'label' => trans('motor-cms::component/texts.anchor') ]
            )
            ->add('body', 'htmleditor', [ 'label' => trans('motor-cms::component/texts.body') ])
            ->add('image', 'file_association', [ 'label' => trans('motor-backend::backend/global.image') ]);
    }
}
