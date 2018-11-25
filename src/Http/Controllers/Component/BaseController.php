<?php

namespace Motor\CMS\Http\Controllers\Component;

use Illuminate\Support\Str;
use Motor\Backend\Http\Controllers\Controller;

use Motor\CMS\Http\Requests\Backend\PageRequest;
use Motor\CMS\Services\ComponentBaseService;

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
        ComponentBaseService::createPageComponent($request);

        return response()->json(['message' => trans('motor-cms::component/global.created', ['name' => Str::ucfirst(str_replace('_', ' ', $request->get('name')))])]);
    }
}
