<?php

namespace Motor\CMS\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Motor\CMS\Http\Requests\Backend\NavigationRequest;
use Motor\CMS\Http\Resources\NavigationTreeCollection;
use Motor\CMS\Http\Resources\NavigationTreeResource;
use Motor\CMS\Models\Navigation;
use Motor\CMS\Services\NavigationService;
use Motor\Core\Filter\Renderers\WhereRenderer;

/**
 * Class NavigationsController
 */
class NavigationTreesController extends ApiController
{
    protected string $model = 'Motor\CMS\Models\Navigation';

    protected string $modelResource = 'navigation';

    /**
     * @OA\Get (
     *   tags={"NavigationTreesController"},
     *   path="/api/navigation_trees",
     *   summary="Get navigation tree collection",
     *
     *   @OA\Parameter(
     *
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *
     *         @OA\Items(ref="#/components/schemas/NavigationTreeResource")
     *       ),
     *
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
     *
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   )
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Motor\CMS\Http\Resources\NavigationTreeCollection
     */
    public function index()
    {
        $service = NavigationService::collection();

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('parent_id'))
            ->setDefaultValue(null)
            ->setAllowNull(true);

        $paginator = $service->getPaginator();

        return (new NavigationTreeCollection($paginator))->additional(['message' => 'Navigation tree collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"NavigationTreesController"},
     *   path="/api/navigation_trees",
     *   summary="Create new navigation tree",
     *
     *   @OA\RequestBody(
     *
     *     @OA\JsonContent(ref="#/components/schemas/NavigationTreeRequest")
     *   ),
     *
     *   @OA\Parameter(
     *
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/NavigationTreeResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Navigation tree created"
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NavigationRequest $request)
    {
        $result = NavigationService::create($request)
            ->getResult();

        return (new NavigationTreeResource($result))->additional(['message' => 'Navigation tree created'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"NavigationTreesController"},
     *   path="/api/navigation_trees/{navigation}",
     *   summary="Get single navigation tree",
     *
     *   @OA\Parameter(
     *
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *
     *   @OA\Parameter(
     *
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="navigation",
     *     parameter="navigation",
     *     description="Navigation tree id"
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/NavigationTreeResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Navigation tree read"
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Display the specified resource.
     *
     * @return \Motor\CMS\Http\Resources\NavigationTreeResource
     */
    public function show(Navigation $record)
    {
        $result = NavigationService::show($record)
            ->getResult();

        return (new NavigationTreeResource($result->load('children')))->additional(['message' => 'Navigation tree read']);
    }

    /**
     * @OA\Put (
     *   tags={"NavigationTreesController"},
     *   path="/api/navigation_trees/{navigation}",
     *   summary="Update an existing navigation tree",
     *
     *   @OA\RequestBody(
     *
     *     @OA\JsonContent(ref="#/components/schemas/NavigationTreeRequest")
     *   ),
     *
     *   @OA\Parameter(
     *
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *
     *   @OA\Parameter(
     *
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="navigation",
     *     parameter="navigation",
     *     description="Navigation tree id"
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/NavigationTreeResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Navigation tree updated"
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Update the specified resource in storage.
     *
     * @return \Motor\CMS\Http\Resources\NavigationTreeResource
     */
    public function update(NavigationRequest $request, Navigation $record)
    {
        $result = NavigationService::update($record, $request)
            ->getResult();

        return (new NavigationTreeResource($result))->additional(['message' => 'Navigation tree updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"NavigationTreesController"},
     *   path="/api/navigation_trees/{navigation}",
     *   summary="Delete a navigation tree",
     *
     *   @OA\Parameter(
     *
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *
     *   @OA\Parameter(
     *
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="navigation",
     *     parameter="navigation",
     *     description="Navigation tree id"
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Navigation tree deleted"
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   ),
     *
     *   @OA\Response(
     *     response="400",
     *     description="Bad request",
     *
     *     @OA\JsonContent(
     *
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Problem deleting navigation tree"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Navigation $record)
    {
        $result = NavigationService::delete($record)
            ->getResult();

        if ($result) {
            return response()->json(['message' => 'Navigation tree deleted']);
        }

        return response()->json(['message' => 'Problem deleting navigation tree'], 400);
    }
}
