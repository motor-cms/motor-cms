<?php

namespace Motor\CMS\Http\Resources;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Motor\Backend\Http\Resources\BaseResource;
use ReflectionClass;

/**
 * @OA\Schema(
 *   schema="PageVersionComponentResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="page_version_id",
 *     type="integer",
 *     example="5"
 *   ),
 *   @OA\Property(
 *     property="container",
 *     type="string",
 *     example="full-width"
 *   ),
 *   @OA\Property(
 *     property="sort_position",
 *     type="integer",
 *     example="5"
 *   ),
 *   @OA\Property(
 *     property="component_name",
 *     type="string",
 *     example="text"
 *   ),
 *   @OA\Property(
 *     property="component_type",
 *     type="string",
 *     example="Motor\CMS\Models\Component\ComponentText"
 *   ),
 *   @OA\Property(
 *     property="component_id",
 *     type="integer",
 *     example="1"
 *   )
 * )
 */
class PageVersionComponentResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $componentResourceClass = Str::replaceFirst('\\Models\\Component\\', '\\Http\\Resources\\Components\\', $this->component_type).'Resource';
        $componentResource = false;
        if (class_exists($componentResourceClass)) {
            $ref = new ReflectionClass($componentResourceClass);
            $componentResource = $ref->newInstanceArgs(array($this->component));
        } else {
            Log::warning('ComponentResourceClass does not exist', [$componentResourceClass]);
        }

        return [
            'id'              => (int) $this->id,
            'page_version_id' => (int) $this->page_version_id,
            'container'       => $this->container,
            'sort_position'   => (int) $this->sort_position,
            'component_name'  => $this->component_name,
            'component_type'  => $this->component_type,
            'component_id'    => (int) $this->component_id,
            'component'       => $this->when($componentResource, $componentResource),
        ];
    }
}
