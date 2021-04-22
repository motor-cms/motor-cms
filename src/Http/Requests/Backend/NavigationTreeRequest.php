<?php

namespace Motor\CMS\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class NavigationRequest
 *
 * @package Motor\CMS\Http\Requests\Backend
 */
class NavigationTreeRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="NavigationTreeRequest",
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="New navigation tree"
     *   ),
     *   @OA\Property(
     *     property="scope",
     *     type="string",
     *     example="new-navigation-scope"
     *   ),
     *   @OA\Property(
     *     property="client_id",
     *     type="integer",
     *     example="1"
     *   ),
     *   @OA\Property(
     *     property="language_id",
     *     type="integer",
     *     example="2"
     *   ),
     *   required={"name", "scope", "client_id"},
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
            'name'        => 'required',
            'scope'       => 'required|unique',
            'client_id'   => 'required|integer',
            'language_id' => 'nullable|integer',
        ];
    }
}
