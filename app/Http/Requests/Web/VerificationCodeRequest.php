<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\BaseRequest;

class VerificationCodeRequest extends BaseRequest
{
    public function rules()
    {
        $rules = [
            'email' => 'bail|required:email',
            'scene' => 'bail|required|in:register',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'email.required_without' => __('输入您的電郵地址'),
            'email.email' => __('輸入正確的電郵地址'),
            'scene.required' => __('場景錯誤'),
            'scene.in' => __('場景錯誤'),
        ];
    }
}
