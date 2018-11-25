<?php

namespace Motor\CMS\Forms\Backend\Component;

use Kris\LaravelFormBuilder\Form;

class ComponentTextForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('headline', 'text', ['label' => trans('motor-cms::component/texts.headline'), 'rules' => 'required'])
            ->add('body', 'htmleditor', ['label' => trans('motor-cms::component/texts.body')])
            ->add('image', 'file_association', ['label' => trans('motor-backend::backend/global.image')]);
    }
}
