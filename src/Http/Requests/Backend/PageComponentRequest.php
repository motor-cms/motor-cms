<?php

namespace Motor\CMS\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class PageComponentRequest
 *
 * @package Motor\CMS\Http\Requests\Backend
 */
class PageComponentRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="PageComponentRequest",
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
        return [];
    }
}
