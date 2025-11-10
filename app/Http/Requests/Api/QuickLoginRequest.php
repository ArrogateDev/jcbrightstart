<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class QuickLoginRequest extends BaseRequest
{
    public function rules()
    {
        $rules = [
            'email' => 'bail|required_without:phone|email',
            'password' => 'bail|required|size:32',
            'type' => 'bail|required|in:google,apple',
            'data' => 'bail|required',
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
            'type.required' => '輸入您的登陸方式',
            'type.in' => '輸入正確的登陸方式',
            'data.required' => '輸入您的參數',
        ];
    }
}
