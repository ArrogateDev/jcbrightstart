<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'email' => 'bail|required',
            'first_name' => 'bail|required',
            'last_name' => 'bail|required',
            'gender' => 'bail|required',
            'age' => 'bail|required',
            'status' => 'bail|required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
        ];
    }
}
