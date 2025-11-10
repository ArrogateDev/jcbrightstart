<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function rules()
    {
        $rules = [
            'email' => 'bail|required_without:phone|email|unique:users,email',
            'phone' => 'bail|required_without:email|unique:users,phone',
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
            'email.unique' => '電郵地址已註冊',
            'phone.required_without' => '輸入您的電話號碼',
            'phone.unique' => '電話號碼已註冊',
            'password.required' => '輸入您的密碼',
            'password.size' => '輸入您的密碼',
            'code.required' => '輸入您的驗證碼',
            'code.size' => '輸入您的驗證碼',
        ];
    }
}
