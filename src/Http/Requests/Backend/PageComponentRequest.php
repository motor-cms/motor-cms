<?php

namespace Motor\CMS\Http\Requests\Backend;

use Motor\Admin\Http\Requests\Request;

/**
 * Class PageComponentRequest
 *
 * @OA\Schema(
 *   schema="PageComponentRequest",
 * )
 */
class PageComponentRequest extends Request
{

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
        return [];
    }
}
