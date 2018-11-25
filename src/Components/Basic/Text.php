<?php

namespace Motor\CMS\Components\Basic;

use Illuminate\Http\Request;
use Motor\CMS\Models\Component\ComponentText;
use Motor\CMS\Models\PageVersionComponent;

class Text
{

    protected $component;
    protected $pageVersionComponent;
    protected $request;

    public function __construct(PageVersionComponent $pageVersionComponent, ComponentText $component)
    {
        $this->component = $component;
        $this->pageVersionComponent = $pageVersionComponent;
    }

    public function index(Request $request)
    {
        $this->request = $request;
        return $this->render();
    }


    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), ['component' => $this->component]);
    }

}