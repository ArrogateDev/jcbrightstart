<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function rules()
    {
        $rules = [
            'email' => 'bail|required_without:phone|email',
            'phone' => 'bail|required_without:email',
            'password' => 'bail|required|size:32',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'email.required_without' => '輸入您的電郵地址',
            'email.email' => '輸入正確的電郵地址',
            'phone.required_without' => '輸入您的電話號碼',
            'password.required' => '輸入您的密碼',
            'password.size' => '輸入您的密碼',
        ];
    }
}
