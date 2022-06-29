<?php

namespace Motor\CMS\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class NavigationRequest
 */
class NavigationRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="NavigationRequest",
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="New category name"
     *   ),
     *   @OA\Property(
     *     property="parent_id",
     *     type="integer",
     *     example="1"
     *   ),
     *   @OA\Property(
     *     property="previous_sibling_id",
     *     type="integer",
     *     example="2"
     *   ),
     *   @OA\Property(
     *     property="next_sibling_id",
     *     type="integer",
     *     example="4"
     *   ),
     *   @OA\Property(
     *     property="page_id",
     *     type="integer",
     *     example="288"
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
     *   required={"name", "parent_id"},
     * )
     */

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                => 'required',
            'parent_id'           => 'required|integer',
            'previous_sibling_id' => 'nullable|integer',
            'next_sibling_id'     => 'nullable|integer',
            'page_id'             => 'nullable|integer',
            'is_visible'          => 'nullable|boolean',
            'is_active'           => 'nullable|boolean',
        ];
    }
}
