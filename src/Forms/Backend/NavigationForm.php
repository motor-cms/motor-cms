<?php

namespace Motor\CMS\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Motor\CMS\Models\Page;

/**
 * Class NavigationForm
 */
class NavigationForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('parent_id', 'hidden')
            ->add('previous_sibling_id', 'hidden')
            ->add('next_sibling_id', 'hidden')
            ->add('name', 'text', ['label' => trans('motor-cms::backend/navigations.name'), 'rules' => 'required'])
            ->add('page_id', 'select2', [
                'label' => trans('motor-cms::backend/pages.page'),
                'empty_value' => trans('motor-backend::backend/global.please_choose'),
                'choices' => Page::all()->pluck('name', 'id')->toArray(),
            ])
            ->add('is_visible', 'checkbox', ['label' => trans('motor-cms::backend/navigations.is_visible')])
            ->add('is_active', 'checkbox', ['label' => trans('motor-cms::backend/navigations.is_active')])
            ->add('submit', 'submit', [
                'attr' => ['class' => 'btn btn-primary'],
                'label' => trans('motor-cms::backend/navigations.save'),
            ]);
    }
}
