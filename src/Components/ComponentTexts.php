<?php

namespace Motor\CMS\Components;

use Illuminate\Http\Request;
use Motor\CMS\Models\PageVersionComponent;

class ComponentTexts {

    protected $component;
    protected $pageVersionComponent;

    public function __construct(PageVersionComponent $pageVersionComponent, \Motor\CMS\Models\Component\ComponentText $component)
    {
        $this->component = $component;
        //dd($this->component->getMedia('image'));
        $this->pageVersionComponent = $pageVersionComponent;
    }

    public function index(Request $request)
    {
        return $this->render();
    }


    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), ['component' => $this->component]);
    }

}
