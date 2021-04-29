<?php

namespace Motor\CMS\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Motor\CMS\Http\Requests\Backend\PageVersionRequest;
use Motor\CMS\Http\Resources\PageVersionCollection;
use Motor\CMS\Http\Resources\PageVersionResource;
use Motor\CMS\Models\Page;
use Motor\CMS\Models\PageVersion;
use Motor\CMS\Services\PageVersionService;
use Motor\Core\Filter\Renderers\WhereRenderer;

/**
 * Class PagesController
 *
 * @package Motor\CMS\Http\Controllers\Api
 */
class PageVersionsController extends ApiController
{
    protected string $model = 'Motor\CMS\Models\PageVersion';
    protected string $modelResource = 'page_version';

    /**
     * @OA\Get (
     *   tags={"PageVersionsController"},
     *   path="/api/pages/{page}/page_versions",
     *   summary="Get page versions collection",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="page",
     *     parameter="page",
     *     description="Page id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/PageVersionResource")
     *       ),
     *       @OA\Property(
     *         property="meta",
     *         ref="#/components/schemas/PaginationMeta"
     *       ),
     *       @OA\Property(
     *         property="links",
     *         ref="#/components/schemas/PaginationLinks"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Collection read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   )
     * )
     *
     * Display a listing of the resource.
     *
     * @param \Motor\CMS\Models\Page $page
     * @return \Motor\CMS\Http\Resources\PageVersionCollection
     */
    public function index(Page $page)
    {
        $service = PageVersionService::collection();

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('page_id'))
               ->setValue($page->id);

        $paginator = $service->getPaginator();

        return (new PageVersionCollection($paginator))->additional(['message' => 'Page version collection read']);
    }

    /**
     * @OA\Get (
     *   tags={"PageVersionsController"},
     *   path="/api/pages/{page}/page_versions/{page_version}",
     *   summary="Get single page",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="page",
     *     parameter="page",
     *     description="Page id"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="page_version",
     *     parameter="page_version",
     *     description="Page version id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/PageVersionResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Page read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Display the specified resource.
     *
     * @param \Motor\CMS\Models\Page $page
     * @param \Motor\CMS\Models\PageVersion $record
     * @return \Motor\CMS\Http\Resources\PageVersionResource
     */
    public function show(Page $page, PageVersion $record)
    {
        $result = PageVersionService::show($record)
                                    ->getResult();

        return (new PageVersionResource($result))->additional(['message' => 'Page version read']);
    }

    /**
     * @OA\Put (
     *   tags={"PageVersionsController"},
     *   path="/api/pages/{page}/page_versions/{page_version}",
     *   summary="Update an existing page version",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/PageVersionRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="page",
     *     parameter="page",
     *     description="Page id"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="page_version",
     *     parameter="page_version",
     *     description="Page version id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/PageVersionResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Page version updated"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Update the specified resource in storage.
     *
     * @param \Motor\CMS\Http\Requests\Backend\PageVersionRequest $request
     * @param \Motor\CMS\Models\Page $page
     * @param \Motor\CMS\Models\PageVersion $record
     * @return \Motor\CMS\Http\Resources\PageVersionResource
     */
    public function update(PageVersionRequest $request, Page $page, PageVersion $record)
    {
        $result = PageVersionService::update($record, $request)
                                    ->getResult();

        return (new PageVersionResource($result))->additional(['message' => 'Page version updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"PageVersionsController"},
     *   path="/api/pages/{page}/page_versions/{page_version}",
     *   summary="Delete a page version",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="page",
     *     parameter="page",
     *     description="Page id"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="page_version",
     *     parameter="page_version",
     *     description="Page version id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Page version deleted"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   ),
     *   @OA\Response(
     *     response="400",
     *     description="Bad request",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Problem deleting page version"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param \Motor\CMS\Models\Page $page
     * @param \Motor\CMS\Models\PageVersion $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Page $page, PageVersion $record)
    {
        $result = PageVersionService::delete($record)
                                    ->getResult();

        if ($result) {
            return response()->json(['message' => 'Page version deleted']);
        }

        return response()->json(['message' => 'Problem deleting page version'], 400);
    }
}
