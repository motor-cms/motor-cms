<?php

namespace Motor\CMS\Http\Requests\Backend;

use Illuminate\Validation\Rule;
use Motor\Backend\Http\Requests\Request;

/**
 * Class NavigationRequest
 */
class NavigationTreeRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="NavigationTreeRequest",
     *
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
        $request = $this;

        return [
            'name' => 'required',
            'scope' => [
                'required',
                Rule::unique('navigations')
                    ->where(function ($query) use ($request) {
                        if ($request->method() == 'PATCH' || $request->method() == 'PUT') {
                            return $query->where('scope', $request->scope)
                                ->where('parent_id', null)
                                ->where('id', '!=', $request->route()
                                    ->originalParameter('navigation'));
                        } else {
                            return $query->where('scope', $request->scope)
                                ->where('parent_id', null);
                        }
                    }),
            ],
            'client_id' => 'required|integer',
            'language_id' => 'nullable|integer',
        ];
    }
}
