<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class CertificateRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'name' => 'bail|required|string|max:255',
            'image' => 'bail|required|image',
            'name_config' => 'bail|array',
            'name_config.left' => 'bail|required',
            'name_config.top' => 'bail|required',
            'name_config.font_size' => 'bail|required',
            'name_config.fill' => 'bail|required',
            'name_config.text_align' => 'bail|required',
            'date_config' => 'bail|array',
            'date_config.left' => 'bail|required',
            'date_config.top' => 'bail|required',
            'date_config.font_size' => 'bail|required',
            'date_config.fill' => 'bail|required',
            'date_config.text_align' => 'bail|required',
            'width' => 'bail|required|integer|min:100|max:2000',
            'height' => 'bail|required|integer|min:100|max:2000',
        ];

        if ($this->method() == 'PUT') {
            $rules['image'] = 'bail|nullable|image';
        }

        return $rules;
    }

    public function messages()
    {
        return [

        ];
    }
}
