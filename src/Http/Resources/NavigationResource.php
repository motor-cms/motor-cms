<?php

namespace Motor\CMS\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Motor\Backend\Http\Resources\ClientResource;
use Motor\Backend\Http\Resources\LanguageResource;

/**
 * @OA\Schema(
 *   schema="NavigationResource",
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
 *     property="slug",
 *     type="string",
 *     example="my-page"
 *   ),
 *   @OA\Property(
 *     property="full_slug",
 *     type="string",
 *     example="/parent-page/my-page"
 *   ),
 *   @OA\Property(
 *     property="is_visible",
 *     type="boolean",
 *     example="true"
 *   ),
 *   @OA\Property(
 *     property="is_active",
 *     type="boolean",
 *     example="true"
 *   ),
 *   @OA\Property(
 *     property="page",
 *     type="object",
 *     ref="#/components/schemas/PageResource"
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
 *   ),
 *   @OA\Property(
 *     property="parent_id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="_lft",
 *     type="integer",
 *     example="3"
 *   ),
 *   @OA\Property(
 *     property="_rgt",
 *     type="integer",
 *     example="5"
 *   ),
 * )
 */
class NavigationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => (int) $this->id,
            'name'       => $this->name,
            'scope'      => $this->scope,
            'slug'       => $this->slug,
            'full_slug'  => $this->full_slug,
            'is_visible' => (bool) $this->is_active,
            'is_active'  => (bool) $this->is_active,
            'page'       => new PageResource($this->page),
            'client'     => new ClientResource($this->client),
            'language'   => new LanguageResource($this->language),
            'parent_id'  => (int) $this->parent_id,
            '_lft'       => (int) $this->_lft,
            '_rgt'       => (int) $this->_rgt,
        ];
    }
}
