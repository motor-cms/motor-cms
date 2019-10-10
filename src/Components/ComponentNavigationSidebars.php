<?php

namespace Motor\CMS\Components;

use Illuminate\Http\Request;
use Motor\CMS\Models\PageVersionComponent;

/**
 * Class ComponentNavigationSidebars
 * @package Motor\CMS\Components
 */
class ComponentNavigationSidebars
{
    protected $pageVersionComponent;


    /**
     * ComponentNavigationSidebars constructor.
     * @param PageVersionComponent $pageVersionComponent
     */
    public function __construct(PageVersionComponent $pageVersionComponent)
    {
        $this->pageVersionComponent = $pageVersionComponent;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return $this->render();
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view(
            config('motor-cms-page-components.components.' . $this->pageVersionComponent->component_name . '.view'),
            []
        );
    }
}
