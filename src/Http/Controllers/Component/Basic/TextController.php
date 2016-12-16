<?php

namespace Motor\CMS\Http\Controllers\Component\Basic;

use Motor\Backend\Http\Controllers\Controller;

use Motor\CMS\Forms\Component\Basic\TextForm;
use Motor\CMS\Models\Component\ComponentText;
use Motor\CMS\Models\Page;
use Motor\CMS\Http\Requests\Backend\PageRequest;
use Motor\CMS\Services\Component\TextService;
use Motor\CMS\Forms\Backend\PageForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class TextController extends Controller
{

    use FormBuilderTrait;


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(TextForm::class, [
            'method'  => 'POST',
            'route' => 'component.text.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('motor-cms::component.basic.text.form', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $form = $this->form(TextForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        TextService::createWithForm($request, $form);
        dd("created");

        flash()->success(trans('motor-cms::backend/pages.created'));

        return redirect('backend/pages');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ComponentText $record, PageRequest $request)
    {
        $form = $this->form(TextForm::class, [
            'method'  => 'PATCH',
            'url'     => route('component.text.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('motor-cms::component.basic.text.form', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, ComponentText $record)
    {
        $form = $this->form(TextForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        TextService::updateWithForm($record, $request, $form);

        //flash()->success(trans('motor-cms::backend/pages.updated'));

        //return redirect('backend/pages');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComponentText $record)
    {
        TextService::delete($record);

        flash()->success(trans('motor-cms::backend/pages.deleted'));

        return redirect('backend/pages');
    }
}
