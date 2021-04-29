<?php

namespace Motor\CMS\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Motor\CMS\Http\Requests\Backend\NavigationRequest;
use Motor\CMS\Http\Resources\NavigationCollection;
use Motor\CMS\Http\Resources\NavigationResource;
use Motor\CMS\Models\Navigation;
use Motor\CMS\Services\NavigationService;
use Motor\Core\Filter\Renderers\WhereRenderer;

/**
 * Class NavigationsController
 *
 * @package Motor\Backend\Http\Controllers\Api
 */
class NavigationsController extends ApiController
{
    protected string $model = 'Motor\CMS\Models\Navigation';
    protected string $modelResource = 'navigation';

    /**
     * @OA\Get (
     *   tags={"NavigationsController"},
     *   path="/api/navigation_trees/{navigation_tree}/navigations",
     *   summary="Get navigations collection",
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
     *     name="navigation_tree",
     *     parameter="navigation_tree",
     *     description="Navigation tree id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/NavigationResource")
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
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Navigation tree not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Display a listing of the resource.
     *
     * @param \Motor\CMS\Models\Navigation $navigationTree
     * @return \Illuminate\Http\JsonResponse|\Motor\CMS\Http\Resources\NavigationCollection
     */
    public function index(Navigation $navigationTree)
    {
        $service = NavigationService::collection();

        if (! is_null($navigationTree->parent_id)) {
            return response()->json(['message' => ' Navigation tree not found'], 404);
        }

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('scope'))
               ->setValue($navigationTree->scope);
        $filter->add(new WhereRenderer('parent_id'))
               ->setOperator('!=')
               ->setAllowNull(true)
               ->setValue(null);

        $paginator = $service->getPaginator();

        return (new NavigationCollection($paginator))->additional(['message' => 'Navigation collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"NavigationsController"},
     *   path="/api/navigation_trees/{navigation_tree}/navigations",
     *   summary="Create new navigation",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/NavigationRequest")
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
     *     name="navigation_tree",
     *     parameter="navigation_tree",
     *     description="Navigation tree id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/NavigationResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Navigation created"
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
     * Store a newly created resource in storage.
     *
     * @param \Motor\CMS\Http\Requests\Backend\NavigationRequest $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(NavigationRequest $request)
    {
        $result = NavigationService::create($request)
                                   ->getResult();

        return (new NavigationResource($result))->additional(['message' => 'Navigation created'])
                                                ->response()
                                                ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"NavigationsController"},
     *   path="/api/navigation_trees/{navigation_tree}/navigations/{navigation}",
     *   summary="Get single navigation",
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
     *     name="navigation_tree",
     *     parameter="navigation_tree",
     *     description="Navigation tree id"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="navigation",
     *     parameter="navigation",
     *     description="Navigation id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/NavigationResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Navigation read"
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
     * @param \Motor\CMS\Models\Navigation $record
     * @return \Motor\CMS\Http\Resources\NavigationResource
     */
    public function show(Navigation $record)
    {
        $result = NavigationService::show($record)
                                   ->getResult();

        return (new NavigationResource($result))->additional(['message' => 'Navigation read']);
    }

    /**
     * @OA\Put (
     *   tags={"NavigationsController"},
     *   path="/api/navigation_trees/{navigation_tree}/navigations/{navigation}",
     *   summary="Update an existing navigation",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/NavigationRequest")
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
     *     name="navigation_tree",
     *     parameter="navigation_tree",
     *     description="Navigation tree id"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="navigation",
     *     parameter="navigation",
     *     description="Navigation id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/NavigationResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Navigation updated"
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
     * @param \Motor\CMS\Http\Requests\Backend\NavigationRequest $request
     * @param \Motor\CMS\Models\Navigation $record
     * @return \Motor\CMS\Http\Resources\NavigationResource
     */
    public function update(NavigationRequest $request, Navigation $record)
    {
        $result = NavigationService::update($record, $request)
                                   ->getResult();

        return (new NavigationResource($result))->additional(['message' => 'Navigation updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"NavigationsController"},
     *   path="/api/navigation_trees/{navigation_tree}/navigations/{navigation}",
     *   summary="Delete a navigation",
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
     *     name="navigation_tree",
     *     parameter="navigation_tree",
     *     description="Navigation tree id"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="navigation",
     *     parameter="navigation",
     *     description="Navigation id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Navigation deleted"
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
     *         example="Problem deleting navigation"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param \Motor\CMS\Models\Navigation $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Navigation $record)
    {
        $result = NavigationService::delete($record)
                                   ->getResult();

        if ($result) {
            return response()->json(['message' => 'Navigation deleted']);
        }

        return response()->json(['message' => 'Problem deleting navigation'], 400);
    }
}
