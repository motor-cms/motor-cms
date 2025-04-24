<?php

namespace Motor\CMS\Http\Requests\Components;

use Motor\Backend\Http\Requests\Request;

/**
 * Class ComponentBaseRequest
 */
class ComponentBaseRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="ComponentBaseRequest",
     *
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="New page name"
     *   ),
     *   required={"name"},
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
        if ($this->method() == 'GET') {
            return [];
        }

        return [
            'name' => 'required',
        ];
    }
}
