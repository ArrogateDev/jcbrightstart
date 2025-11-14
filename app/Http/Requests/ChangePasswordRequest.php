<?php

namespace App\Http\Requests;

class ChangePasswordRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'current_password' => 'bail|required|size:32',
            'password' => 'bail|required|size:32|confirmed',
            'password_confirmation' => 'bail|required',
        ];

        return $rules;
    }
}
