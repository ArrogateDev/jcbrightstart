<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class ForgotPasswordRequest extends BaseRequest
{
    public function rules()
    {
        $rules = [
            'email' => 'bail|required_without:phone|email|exists:users,email',
            'phone' => 'bail|required_without:email|exists:users,phone',
            'password' => 'bail|required|size:32',
            'code' => 'bail|required|size:6',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'email.required_without' => '輸入您的電郵地址',
            'email.email' => '輸入正確的電郵地址',
            'email.exists' => '電郵地址不存在',
            'phone.required_without' => '輸入您的電話號碼',
            'phone.exists' => '電話號碼不存在',
            'password.required' => '輸入您的密碼',
            'password.size' => '輸入您的密碼',
            'code.required' => '輸入您的驗證碼',
            'code.size' => '輸入您的驗證碼',
        ];
    }
}
