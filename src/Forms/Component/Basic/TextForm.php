<?php

namespace Motor\CMS\Forms\Component\Basic;

use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\Language;

class TextForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('page_version_id', 'hidden')
            ->add('container', 'hidden')
            ->add('headline', 'text', ['label' => trans('motor-cms::component/text.headline'), 'rules' => 'required'])
            ->add('body', 'htmleditor', ['label' => trans('motor-cms::component/text.body')])
            ->add('image', 'file_association', ['label' => trans('motor-backend::backend/global.image')])
            ->add('date', 'datepicker',  ['label' => 'Date']);
    }
}
