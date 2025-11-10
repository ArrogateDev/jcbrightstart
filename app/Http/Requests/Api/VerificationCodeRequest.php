<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class VerificationCodeRequest extends BaseRequest
{
    public function rules()
    {
        $rules = [
            'email' => 'bail|required_without:phone|email',
            'phone' => 'bail|required_without:email',
            'scene' => 'bail|required|in:register,forgot_password',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'email.required_without' => '輸入您的電郵地址',
            'email.email' => '輸入正確的電郵地址',
            'phone.required_without' => '輸入您的電話號碼',
            'scene.required' => '場景錯誤',
            'scene.in' => '場景錯誤',
        ];
    }
}
