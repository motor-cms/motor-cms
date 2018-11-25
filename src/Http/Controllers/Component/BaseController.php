<?php

namespace Motor\CMS\Http\Controllers\Component;

use Motor\Backend\Http\Controllers\Controller;

use Motor\CMS\Http\Requests\Backend\PageRequest;
use Motor\CMS\Services\Component\ComponentService;

class BaseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        ComponentService::createPageComponent($request);

        return response()->json(['message' => trans('motor-cms::component/global.created', ['name' => $request->get('name')])]);
    }
}
