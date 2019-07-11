<?php

namespace Motor\CMS\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\CMS\Models\Navigation;
use Motor\CMS\Http\Requests\Backend\NavigationRequest;
use Motor\CMS\Services\NavigationService;
use Motor\CMS\Transformers\NavigationTransformer;

/**
 * Class NavigationsController
 * @package Motor\CMS\Http\Controllers\Api
 */
class NavigationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = NavigationService::collection()->getPaginator();
        $resource  = $this->transformPaginator($paginator, NavigationTransformer::class);

        return $this->respondWithJson('Navigation collection read', $resource);
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
        $result   = NavigationService::create($request)->getResult();
        $resource = $this->transformItem($result, NavigationTransformer::class);

        return $this->respondWithJson('Navigation created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Navigation $record)
    {
        $result   = NavigationService::show($record)->getResult();
        $resource = $this->transformItem($result, NavigationTransformer::class);

        return $this->respondWithJson('Navigation read', $resource);
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
        $result   = NavigationService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, NavigationTransformer::class);

        return $this->respondWithJson('Navigation updated', $resource);
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
        $result = NavigationService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Navigation deleted', [ 'success' => true ]);
        }

        return $this->respondWithJson('Navigation NOT deleted', [ 'success' => false ]);
    }
}