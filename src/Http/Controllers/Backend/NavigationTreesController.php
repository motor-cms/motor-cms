<?php

namespace Motor\CMS\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;
use Motor\CMS\Grids\NavigationTreeGrid;
use Motor\CMS\Models\Navigation;
use Motor\CMS\Http\Requests\Backend\NavigationRequest;
use Motor\CMS\Services\NavigationService;
use Motor\CMS\Forms\Backend\NavigationTreeForm;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Core\Filter\Renderers\WhereRenderer;

/**
 * Class NavigationTreesController
 * @package Motor\CMS\Http\Controllers\Backend
 */
class NavigationTreesController extends Controller
{

    use FormBuilderTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new NavigationTreeGrid(Navigation::class);

        $service = NavigationService::collection($grid);

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('parent_id'))->setDefaultValue(null)->setAllowNull(true);

        $grid->setFilter($filter);

        $paginator = $service->getPaginator();

        return view('motor-cms::backend.navigation_trees.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(NavigationTreeForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.navigation_trees.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('motor-cms::backend.navigation_trees.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NavigationRequest $request)
    {
        $form = $this->form(NavigationTreeForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        NavigationService::createWithForm($request, $form);

        flash()->success(trans('motor-cms::backend/navigation_trees.created'));

        return redirect('backend/navigation_trees');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Navigation $record)
    {
        $form = $this->form(NavigationTreeForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.navigation_trees.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('motor-cms::backend.navigation_trees.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(NavigationRequest $request, Navigation $record)
    {
        $form = $this->form(NavigationTreeForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        NavigationService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-cms::backend/navigation_trees.updated'));

        return redirect('backend/navigation_trees');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Navigation $record)
    {
        NavigationService::delete($record);

        flash()->success(trans('motor-cms::backend/navigation_trees.deleted'));

        return redirect('backend/navigation_trees');
    }
}
