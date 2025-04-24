<?php

namespace Motor\CMS\Http\Controllers\Backend;

use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Http\Controllers\Controller;
use Motor\CMS\Forms\Backend\PageForm;
use Motor\CMS\Grids\PageGrid;
use Motor\CMS\Http\Requests\Backend\PageComponentRequest;
use Motor\CMS\Http\Requests\Backend\PageRequest;
use Motor\CMS\Models\Page;
use Motor\CMS\Models\PageVersionComponent;
use Motor\CMS\Services\PageService;

/**
 * Class PagesController
 */
class PagesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \ReflectionException
     */
    public function index()
    {
        $grid = new PageGrid(Page::class);

        $service = PageService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

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
            'method' => 'POST',
            'route' => 'backend.pages.store',
            'enctype' => 'multipart/form-data',
        ]);

        $templates = config('motor-cms-page-templates');
        $components = json_encode(config('motor-cms-page-components'));

        return view('motor-cms::backend.pages.create', compact('form', 'templates', 'components'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PageRequest $request)
    {
        $form = $this->form(PageForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        PageService::createWithForm($request, $form);

        flash()->success(trans('motor-cms::backend/pages.created'));

        return redirect('backend/pages');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * @param  PageRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function patch_component_data(Page $record, PageComponentRequest $request)
    {
        foreach ($request->all() as $components) {
            foreach ($components as $component) {
                $pageVersionComponent = PageVersionComponent::where(
                    'page_version_id',
                    $component['page_component_data']['page_version_id']
                )
                    ->where('id', $component['page_component_data']['id'])
                    ->first();
                if (! is_null($pageVersionComponent)) {
                    $pageVersionComponent->container = $component['page_component_data']['container'];
                    $pageVersionComponent->sort_position = $component['page_component_data']['sort_position'];
                    $pageVersionComponent->save();
                }
            }
        }

        return response()->json(['message' => 'Success']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \ReflectionException
     */
    public function component_data(Page $record)
    {
        $returnArray = [];
        foreach ($record->getCurrentVersion()
            ->components()
            ->orderBy('container')
            ->orderBy('sort_position')
            ->get() as $pageComponent) {
            if (! isset($returnArray[$pageComponent->container])) {
                $returnArray[$pageComponent->container] = [];
            }

            if ($pageComponent->component_id == null) {
                $returnArray[$pageComponent->container][] = [
                    'component_slug' => $pageComponent->component_name,
                    'page_component_data' => $pageComponent->toArray(),
                    'preview' => '',
                    'component_name' => config('motor-cms-page-components.components.'.$pageComponent->component_name.'.name'),
                ];
            } else {
                $preview = $pageComponent->component->preview();
                $returnArray[$pageComponent->container][] = [
                    'component_slug' => $pageComponent->component_name,
                    'page_component_data' => $pageComponent->toArray(),
                    'component_name' => $preview['name'],
                    'preview' => $preview['preview'],
                ];
            }
        }

        return response()->json($returnArray);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function destroyComponent(Page $page, PageVersionComponent $pageVersionComponent)
    {
        if ((int) $pageVersionComponent->component_id > 0) {
            $pageVersionComponent->component()->delete();
        }
        $componentName = $pageVersionComponent->component_name;
        $pageVersionComponent->delete();

        return response()->json([
            'message' => trans(
                'motor-cms::component/global.deleted',
                ['name' => Str::ucfirst(str_replace('_', ' ', $componentName))]
            ),
        ]);
    }

    // public function components(Page $record)
    // {
    //    $templates  = config('motor-cms-page-templates');
    //
    //    return view('motor-cms::layouts.partials.template-loop', ['templates' => $templates, 'record' => $record]);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \ReflectionException
     */
    public function edit(Page $record, PageRequest $request)
    {
        // if ($request->get('version_number')) {
        //    $record->setCurrentVersion($request->get('version_number'));
        // }

        $form = $this->form(PageForm::class, [
            'method' => 'PATCH',
            'url' => route('backend.pages.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model' => $record,
        ]);

        $templates = config('motor-cms-page-templates');
        $components = json_encode(config('motor-cms-page-components'));

        $template = json_encode($templates[$record->getCurrentVersion()->template]['items']);

        return view('motor-cms::backend.pages.edit', compact('form', 'templates', 'template', 'components', 'record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PageRequest $request, Page $record)
    {
        $form = $this->form(PageForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        PageService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-cms::backend/pages.updated'));

        return redirect('backend/pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Page $record)
    {
        PageService::delete($record);

        flash()->success(trans('motor-cms::backend/pages.deleted'));

        return redirect('backend/pages');
    }
}
