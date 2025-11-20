<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class AdminRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'name' => 'bail|required',
            'account' => 'bail|required',
            'role_id' => 'bail|required',
            'password' => 'bail|required|size:32|confirmed',
            'password_confirmation' => 'bail|required',
            'status' => 'bail|required',
        ];

        if ($this->method() === 'PUT') {
            $rules['password'] = [
                'nullable',
                'bail',
                'size',
                'confirmed',
            ];
            $rules['password_confirmation'] = [
                'nullable',
                'bail'
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
        ];
    }
}
