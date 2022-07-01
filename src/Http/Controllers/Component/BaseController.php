<?php

namespace Motor\CMS\Http\Controllers\Component;

use Illuminate\Support\Str;
use Motor\Admin\Http\Controllers\Controller;
use Motor\CMS\Http\Requests\Backend\PageRequest;
use Motor\CMS\Http\Requests\Components\ComponentBaseRequest;
use Motor\CMS\Services\ComponentBaseService;

/**
 * Class BaseController
 */
class BaseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  PageRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ComponentBaseRequest $request)
    {
        ComponentBaseService::createPageComponent($request);

        return response()->json([
            'message' => trans('motor-cms::component/global.created', ['name' => Str::ucfirst(str_replace('_', ' ', $request->get('name')))]),
        ]);
    }
}
