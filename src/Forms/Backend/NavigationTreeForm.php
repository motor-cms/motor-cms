<?php

namespace Motor\CMS\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\Language;

/**
 * Class NavigationTreeForm
 * @package Motor\CMS\Forms\Backend
 */
class NavigationTreeForm extends Form
{

    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $clients = config('motor-backend.models.client')::pluck('name', 'id')->toArray();
        $this->add('client_id', 'select', [
                'label'       => trans('motor-backend::backend/clients.client'),
                'choices'     => $clients,
                'empty_value' => trans('motor-backend::backend/global.please_choose')
            ])
             ->add('language_id', 'select', [
                 'label'       => trans('motor-backend::backend/languages.language'),
                 'choices'     => Language::pluck('native_name', 'id')->toArray(),
                 'empty_value' => trans('motor-backend::backend/global.please_choose')
             ])
             ->add('name', 'text', [ 'label' => trans('motor-cms::backend/navigations.name'), 'rules' => 'required' ])
             ->add('scope', 'text',
                 [ 'label' => trans('motor-cms::backend/navigation_trees.scope'), 'rules' => 'required' ])
             ->add('is_visible', 'checkbox', [ 'label' => trans('motor-cms::backend/navigations.is_visible') ])
             ->add('is_active', 'checkbox', [ 'label' => trans('motor-cms::backend/navigations.is_active') ])
             ->add('submit', 'submit', [
                 'attr'  => [ 'class' => 'btn btn-primary' ],
                 'label' => trans('motor-cms::backend/navigation_trees.save')
             ]);
    }
}
