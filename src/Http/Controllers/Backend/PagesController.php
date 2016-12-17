<?php

namespace Motor\CMS\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;

use Motor\CMS\Models\Page;
use Motor\CMS\Http\Requests\Backend\PageRequest;
use Motor\CMS\Services\PageService;
use Motor\CMS\Grids\PageGrid;
use Motor\CMS\Forms\Backend\PageForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class PagesController extends Controller
{

    use FormBuilderTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new PageGrid(Page::class);

        $service      = PageService::collection($grid);
        $grid->filter = $service->getFilter();
        $paginator    = $service->getPaginator();

        return view('motor-cms::backend.pages.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(PageForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.pages.store',
            'enctype' => 'multipart/form-data'
        ]);

        $templates  = config('motor-cms-page-templates');
        $components = config('motor-cms-page-components');

        return view('motor-cms::backend.pages.create', compact('form', 'templates', 'components'));
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
        $form = $this->form(PageForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        PageService::createWithForm($request, $form);

        flash()->success(trans('motor-cms::backend/pages.created'));

        return redirect('backend/pages');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function components(Page $record)
    {
        $templates  = config('motor-cms-page-templates');

        return view('motor-cms::layouts.partials.template-loop', ['templates' => $templates, 'record' => $record]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $record, PageRequest $request)
    {
        $form = $this->form(PageForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.pages.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        $templates  = config('motor-cms-page-templates');
        $components = config('motor-cms-page-components');

        return view('motor-cms::backend.pages.edit', compact('form', 'templates', 'components', 'record'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $record)
    {
        $form = $this->form(PageForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        PageService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-cms::backend/pages.updated'));

        return redirect('backend/pages');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $record)
    {
        PageService::delete($record);

        flash()->success(trans('motor-cms::backend/pages.deleted'));

        return redirect('backend/pages');
    }
}
