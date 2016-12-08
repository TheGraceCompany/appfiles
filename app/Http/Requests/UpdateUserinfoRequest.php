<?php

/*
 * @author Phillip Madsen
 */

namespace App\Http\Requests;

use App\Models\Userinfo;

class UpdateUserinfoRequest extends Request
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
        return Userinfo::$rules;
    }
}
