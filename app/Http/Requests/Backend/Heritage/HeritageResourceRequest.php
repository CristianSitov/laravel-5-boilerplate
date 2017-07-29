<?php

namespace App\Http\Requests\Backend\Heritage;

use App\Http\Requests\Request;

/**
 * Class ManageUserRequest.
 */
class HeritageResourceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->hasPermission(2);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
