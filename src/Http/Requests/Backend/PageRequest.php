<?php

namespace Motor\CMS\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class PageRequest
 *
 * @package Motor\CMS\Http\Requests\Backend
 */
class PageRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="PageRequest",
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="New page name"
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
     *   @OA\Property(
     *     property="publish",
     *     type="boolean",
     *     example="false",
     *     description="If true, the page will go live"
     *   ),
     *   @OA\Property(
     *     property="duplicate",
     *     type="boolean",
     *     example="false",
     *     description="If true, a new draft will be created"
     *   ),
     *   required={"name", "client_id", "language_id", "template", "publish", "is_active"},
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
            'name'             => 'required',
            'client_id'        => 'required|integer',
            'language_id'      => 'required|integer',
            'template'         => 'required',
            'meta_description' => 'nullable',
            'meta_keywords'    => 'nullable',
            'is_active'        => 'nullable|boolean',
            'publish'          => 'nullable|boolean',
        ];
    }
}
