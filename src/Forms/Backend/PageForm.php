<?php

namespace Motor\CMS\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\Language;

/**
 * Class PageForm
 * @package Motor\CMS\Forms\Backend
 */
class PageForm extends Form
{

    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $clients = config('motor-backend.models.client')::pluck('name', 'id')->toArray();

        $templates       = config('motor-cms-page-templates');
        $templateChoices = [];
        foreach ($templates as $template => $templateData) {
            $templateChoices[$template] = $templateData['meta']['name'];
        }

        $this->add('client_id', 'select', [
            'label'       => trans('motor-backend::backend/clients.client'),
            'rules'       => [ 'required' ],
            'choices'     => $clients,
            'empty_value' => trans('motor-backend::backend/global.please_choose')
        ])
             ->add('language_id', 'select', [
                 'label'       => trans('motor-backend::backend/languages.language'),
                 'choices'     => Language::pluck('native_name', 'id')->toArray(),
                 'empty_value' => trans('motor-backend::backend/global.please_choose')
             ])
             ->add('template', 'select', [
                 'label'   => trans('motor-cms::backend/pages.template'),
                 'rules'   => 'required',
                 'choices' => $templateChoices
             ])
             ->add('name', 'text', [ 'label' => trans('motor-cms::backend/pages.name'), 'rules' => 'required' ])
             ->add('meta_description', 'textarea', [ 'label' => trans('motor-cms::backend/pages.meta_description') ])
             ->add('meta_keywords', 'text', [ 'label' => trans('motor-cms::backend/pages.meta_keywords') ])
             ->add('is_active', 'checkbox', [ 'label' => trans('motor-cms::backend/pages.is_active') ])
             ->add('publish', 'submit', [
                 'attr'  => [ 'name' => 'publish', 'value' => 1, 'class' => 'btn btn-primary' ],
                 'label' => trans('motor-cms::backend/pages.save_and_publish')
             ])
             ->add('submit', 'submit',
                 [ 'attr' => [ 'class' => 'btn btn-primary' ], 'label' => trans('motor-cms::backend/pages.save') ]);

        if (is_object($this->model)) {
            if ($this->model->getCurrentVersionNumber() != $this->model->getLatestVersionNumber()) {
                $this->add('duplicate', 'hidden', [ 'value' => $this->model->getCurrentVersionNumber() ]);
            }
        }
    }
}
