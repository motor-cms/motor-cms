<?php

namespace Motor\CMS\Components;

use Illuminate\Http\Request;
use Motor\CMS\Models\PageVersionComponent;

/**
 * Class ComponentTexts
 * @package Motor\CMS\Components
 */
class ComponentTexts
{
    protected $component;

    protected $pageVersionComponent;


    /**
     * ComponentTexts constructor.
     * @param PageVersionComponent                      $pageVersionComponent
     * @param \Motor\CMS\Models\Component\ComponentText $component
     */
    public function __construct(
        PageVersionComponent $pageVersionComponent,
        \Motor\CMS\Models\Component\ComponentText $component
    ) {
        $this->component = $component;
        //dd($this->component->getMedia('image'));
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
            [ 'component' => $this->component ]
        );
    }
}
