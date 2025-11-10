<?php

namespace App\Http\Requests\Web\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'full_name' => 'bail|required',
            'email' => 'bail|required|email|unique:users,email,null,deleted_at',
            'password' => 'bail|required|size:32|confirmed',
            'password_confirmation' => 'bail|required',
            'agree' => 'bail|accepted',
        ];

        return $rules;
    }
}
