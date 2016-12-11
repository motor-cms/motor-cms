<?php

namespace Motor\CMS\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\Language;

class PageForm extends Form
{
    public function buildForm()
    {
        $clients = config('motor-backend.models.client')::lists('name', 'id')->toArray();
        $this
            ->add('client_id', 'select', ['label' => trans('motor-backend::backend/clients.client'), 'choices' => $clients, 'empty_value' => trans('motor-backend::backend/global.please_choose')])
            ->add('language_id', 'select', ['label' => trans('motor-backend::backend/languages.language'), 'choices' => Language::lists('native_name', 'id')->toArray(), 'empty_value' => trans('motor-backend::backend/global.please_choose')])
            ->add('template', 'select', ['label' => trans('motor-cms::backend/pages.template'), 'rules' => 'required', 'choices' => ['default' => 'default']])
            ->add('name', 'text', ['label' => trans('motor-cms::backend/pages.name'), 'rules' => 'required'])
            ->add('meta_description', 'textarea', ['label' => trans('motor-cms::backend/pages.meta_description')])
            ->add('meta_keywords', 'text', ['label' => trans('motor-cms::backend/pages.meta_keywords')])
            ->add('is_active', 'checkbox', ['label' => trans('motor-cms::backend/pages.is_active')])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('motor-cms::backend/pages.save')]);
    }
}
