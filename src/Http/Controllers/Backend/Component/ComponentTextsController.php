<?php

namespace Motor\CMS\Http\Controllers\Backend\Component;

use Motor\CMS\Http\Controllers\Component\ComponentController;
use Illuminate\Http\Request;
use Motor\CMS\Models\Component\ComponentText;
use Motor\CMS\Services\Component\ComponentTextService;
use Motor\CMS\Forms\Backend\Component\ComponentTextForm;
use Kris\LaravelFormBuilder\FormBuilderTrait;

/**
 * Class ComponentTextsController
 * @package Motor\CMS\Http\Controllers\Backend\Component
 */
class ComponentTextsController extends ComponentController
{

    use FormBuilderTrait;


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->form = $this->form(ComponentTextForm::class);

        return response()->json($this->getFormData('component.texts.store', [ 'mediapool' => true ]));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->form = $this->form(ComponentTextForm::class);

        if ( ! $this->isValid()) {
            return $this->respondWithValidationError();
        }

        ComponentTextService::createWithForm($request, $this->form);

        return response()->json([ 'message' => trans('motor-cms::component/texts.created') ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param ComponentText $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(ComponentText $record)
    {
        $this->form = $this->form(ComponentTextForm::class, [
            'model' => $record
        ]);

        return response()->json($this->getFormData('component.texts.update', [ 'mediapool' => true ]));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request       $request
     * @param ComponentText $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ComponentText $record)
    {
        $form = $this->form(ComponentTextForm::class);

        if ( ! $this->isValid()) {
            return $this->respondWithValidationError();
        }

        ComponentTextService::updateWithForm($record, $request, $form);

        return response()->json([ 'message' => trans('motor-cms::component/texts.updated') ]);
    }
}
