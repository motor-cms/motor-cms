<?php

namespace Motor\CMS\Http\Resources;

use Motor\Backend\Http\Resources\BaseResource;
use Motor\Backend\Http\Resources\ClientResource;
use Motor\Backend\Http\Resources\LanguageResource;

/**
 * @OA\Schema(
 *   schema="PageResource",
 *
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
 *     property="live_version",
 *     type="object",
 *     ref="#/components/schemas/PageVersionResource"
 *   ),
 *   @OA\Property(
 *     property="current_version",
 *     type="object",
 *     ref="#/components/schemas/PageVersionResource"
 *   )
 * )
 */
class PageResource extends BaseResource
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
            'id' => (int) $this->id,
            'name' => $this->name,
            'template' => $this->template,
            'is_active' => (bool) $this->is_active,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'client' => new ClientResource($this->client),
            'language' => new LanguageResource($this->language),
            'live_version' => new PageVersionResource($this->getLiveVersion()),
            'current_version' => new PageVersionResource($this->getCurrentVersion()),
        ];
    }
}
