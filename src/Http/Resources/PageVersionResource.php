<?php

namespace Motor\CMS\Http\Resources;

use Motor\Backend\Http\Resources\BaseResource;

/**
 * @OA\Schema(
 *   schema="PageVersionResource",
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
 *     property="template",
 *     type="string",
 *     example="base-page-with-navigation"
 *   ),
 *   @OA\Property(
 *     property="meta_description",
 *     type="string",
 *     example="My fancy page description"
 *   ),
 *   @OA\Property(
 *     property="meta_keywords",
 *     type="string",
 *     example="MyPage,MotorCMS,Sustainability,Growth,Profit"
 *   ),
 *   @OA\Property(
 *     property="is_active",
 *     type="boolean",
 *     example="true"
 *   ),
 *   @OA\Property(
 *     property="versionable_state",
 *     type="string",
 *     example="LIVE"
 *   ),
 *   @OA\Property(
 *     property="versionable_number",
 *     type="integer",
 *     example="5"
 *   ),
 *   @OA\Property(
 *     property="versionable_id",
 *     type="integer",
 *     example="288"
 *   ),
 *   @OA\Property(
 *     property="components",
 *     type="array",
 *     @OA\Items(
 *       ref="#/components/schemas/PageVersionComponentResource"
 *     ),
 *   ),
 * )
 */
class PageVersionResource extends BaseResource
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
            'id'                 => (int) $this->id,
            'name'               => $this->name,
            'template'           => $this->template,
            'is_active'          => (bool) $this->is_active,
            'meta_description'   => $this->meta_description,
            'meta_keywords'      => $this->meta_keywords,
            'versionable_state'  => $this->versionable_state,
            'versionable_number' => (int) $this->versionable_number,
            'versionable_id'     => (int) $this->versionable_id,
            'components'         => PageVersionComponentResource::collection($this->components),
        ];
    }
}
