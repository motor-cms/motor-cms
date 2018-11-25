<?php

namespace Motor\CMS\Http\Controllers\Component\Basic;

use Illuminate\Http\Request;
use Motor\CMS\Forms\Component\Basic\TextForm;
use Motor\CMS\Http\Controllers\Component\ComponentController;
use Motor\CMS\Models\Component\ComponentText;
use Motor\CMS\Services\Component\ComponentTextService;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class ComponentTextController extends ComponentController
{

    use FormBuilderTrait;


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->form = $this->form(TextForm::class);

        return response()->json($this->getFormData('component.text.store', ['mediapool' => true]));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->form = $this->form(TextForm::class);

        if ( ! $this->isValid()) {
            return $this->respondWithValidationError();
        }

        ComponentTextService::createWithForm($request, $this->form);

        return response()->json(['message' => trans('motor-cms::component/text.created')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ComponentText $record)
    {
        $this->form = $this->form(TextForm::class, [
            'model' => $record
        ]);

        return response()->json($this->getFormData('component.text.update', ['mediapool' => true]));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComponentText $record)
    {
        $form = $this->form(TextForm::class);

        if ( ! $this->isValid()) {
            return $this->respondWithValidationError();
        }

        ComponentTextService::updateWithForm($record, $request, $form);

        return response()->json(['message' => trans('motor-cms::component/text.updated')]);
    }
}
