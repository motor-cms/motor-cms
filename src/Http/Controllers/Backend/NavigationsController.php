<?php

namespace Motor\CMS\Http\Controllers\Backend;

use Illuminate\Support\NamespacedItemResolver;
use Kalnoy\Nestedset\NestedSet;
use Motor\Backend\Http\Controllers\Controller;

use Motor\CMS\Models\Navigation;
use Motor\CMS\Http\Requests\Backend\NavigationRequest;
use Motor\CMS\Services\NavigationService;
use Motor\CMS\Grids\NavigationGrid;
use Motor\CMS\Forms\Backend\NavigationForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Core\Filter\Renderers\WhereRenderer;

class NavigationsController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Navigation $record)
    {
        $grid = new NavigationGrid(Navigation::class);
        $grid->setSorting(NestedSet::LFT, 'ASC');

        $service = NavigationService::collection($grid);

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('scope'))->setValue($record->scope);
        $filter->add(new WhereRenderer('parent_id'))->setOperator('!=')->setAllowNull(true)->setValue(null);

        $grid->filter = $filter;

        $paginator    = $service->getPaginator();

        return view('motor-cms::backend.navigations.index', compact('paginator', 'grid', 'record'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Navigation $record)
    {
        $form = $this->form(NavigationForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.navigations.store',
            'enctype' => 'multipart/form-data'
        ]);

        $trees = Navigation::where('scope', $record->scope)->defaultOrder()->get()->toTree();
        $newItem = true;
        $selectedItem = null;

        return view('motor-cms::backend.navigations.create', compact('form', 'trees', 'newItem', 'selectedItem'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NavigationRequest $request)
    {
        $form = $this->form(NavigationForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $record = NavigationService::createWithForm($request, $form)->getResult();

        $root = $record->ancestors()->get()->first();

        flash()->success(trans('motor-cms::backend/navigations.created'));

        return redirect('backend/navigations/'.$root->id);
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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Navigation $record)
    {
        $root = $record->ancestors()->get()->first();

        $trees = Navigation::where('scope', $root->scope)->defaultOrder()->get()->toTree();

        $form = $this->form(NavigationForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.navigations.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        $newItem = false;
        $selectedItem = $record->id;

        return view('motor-cms::backend.navigations.edit', compact('form', 'trees', 'root', 'newItem', 'selectedItem'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(NavigationRequest $request, Navigation $record)
    {
        $form = $this->form(NavigationForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $record = NavigationService::updateWithForm($record, $request, $form)->getResult();

        $root = $record->ancestors()->get()->first();

        flash()->success(trans('motor-cms::backend/navigations.updated'));

        return redirect('backend/navigations/'.$root->id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Navigation $record)
    {
        $root = $record->ancestors()->get()->first();

        NavigationService::delete($record);

        flash()->success(trans('motor-cms::backend/navigations.deleted'));

        return redirect('backend/navigations/'.$root->id);
    }
}
