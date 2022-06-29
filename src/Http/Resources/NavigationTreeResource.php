<?php

namespace Motor\CMS\Http\Resources;

use Motor\Backend\Http\Resources\BaseResource;
use Motor\Backend\Http\Resources\ClientResource;
use Motor\Backend\Http\Resources\LanguageResource;

/**
 * @OA\Schema(
 *   schema="NavigationTreeResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="My Start Page"
 *   ),
 *   @OA\Property(
 *     property="scope",
 *     type="string",
 *     example="my-navigation-tree"
 *   ),
 *   @OA\Property(
 *     property="client",
 *     type="object",
 *     ref="#/components/schemas/ClientResource"
 *   ),
 *   @OA\Property(
 *     property="language",
 *     type="object",
 *     ref="#/components/schemas/LanguageResource"
 *   )
 * )
 */
class NavigationTreeResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'       => (int) $this->id,
            'name'     => $this->name,
            'scope'    => $this->scope,
            'client'   => new ClientResource($this->client),
            'language' => new LanguageResource($this->language),
            'children' => NavigationResource::collection($this->whenLoaded('children')),
        ];
    }
}
