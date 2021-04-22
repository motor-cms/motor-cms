<?php

namespace Motor\CMS\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class PageVersionRequest
 *
 * @package Motor\CMS\Http\Requests\Backend
 */
class PageVersionRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="PageVersionRequest",
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="New page name"
     *   ),
     *   @OA\Property(
     *     property="is_active",
     *     type="boolean",
     *     example="true"
     *   ),
     *   @OA\Property(
     *     property="template",
     *     type="string",
     *     example="base-page-with-navigation",
     *     description="Existing page template"
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
     *   required={"name", "template"},
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
            'name'             => 'required',
            'template'         => 'required',
            'meta_description' => 'nullable',
            'meta_keywords'    => 'nullable',
            'is_active'        => 'required|boolean',
        ];
    }
}
