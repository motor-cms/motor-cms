<?php

namespace Motor\CMS\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\CMS\Models\Page;
use Motor\CMS\Http\Requests\Backend\PageRequest;
use Motor\CMS\Services\PageService;
use Motor\CMS\Transformers\PageTransformer;

/**
 * Class PagesController
 * @package Motor\CMS\Http\Controllers\Api
 */
class PagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = PageService::collection()->getPaginator();
        $resource  = $this->transformPaginator($paginator, PageTransformer::class);

        return $this->respondWithJson('Page collection read', $resource);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $result   = PageService::create($request)->getResult();
        $resource = $this->transformItem($result, PageTransformer::class);

        return $this->respondWithJson('Page created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Page $record)
    {
        $result   = PageService::show($record)->getResult();
        $resource = $this->transformItem($result, PageTransformer::class);

        return $this->respondWithJson('Page read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $record)
    {
        $result   = PageService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, PageTransformer::class);

        return $this->respondWithJson('Page updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $record)
    {
        $result = PageService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Page deleted', [ 'success' => true ]);
        }

        return $this->respondWithJson('Page NOT deleted', [ 'success' => false ]);
    }
}