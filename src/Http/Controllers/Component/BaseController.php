<?php

namespace Motor\CMS\Http\Controllers\Component;

use Illuminate\Support\Str;
use Motor\Backend\Http\Controllers\Controller;
use Motor\CMS\Http\Requests\Backend\PageRequest;
use Motor\CMS\Services\ComponentBaseService;

/**
 * Class BaseController
 * @package Motor\CMS\Http\Controllers\Component
 */
class BaseController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param PageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PageRequest $request)
    {
        ComponentBaseService::createPageComponent($request);

        return response()->json([
            'message' => trans('motor-cms::component/global.created',
                [ 'name' => Str::ucfirst(str_replace('_', ' ', $request->get('name'))) ])
        ]);
    }
}
