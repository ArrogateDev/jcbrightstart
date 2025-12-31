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
            'name.required' => __('证书名称不能为空'),
            'name.string' => __('证书名称必须是字符串'),
            'name.max' => __('证书名称不能超过255个字符'),
            'image.required' => __('证书图片不能为空'),
            'image.image' => __('证书图片必须是图片格式'),
            'name_config.array' => __('姓名配置必须是数组'),
            'name_config.left.required' => __('姓名配置左边距不能为空'),
            'name_config.top.required' => __('姓名配置上边距不能为空'),
            'name_config.font_size.required' => __('姓名配置字体大小不能为空'),
            'name_config.fill.required' => __('姓名配置填充颜色不能为空'),
            'name_config.text_align.required' => __('姓名配置文本对齐不能为空'),
            'date_config.array' => __('日期配置必须是数组'),
            'date_config.left.required' => __('日期配置左边距不能为空'),
            'date_config.top.required' => __('日期配置上边距不能为空'),
            'date_config.font_size.required' => __('日期配置字体大小不能为空'),
            'date_config.fill.required' => __('日期配置填充颜色不能为空'),
            'date_config.text_align.required' => __('日期配置文本对齐不能为空'),
            'width.required' => __('宽度不能为空'),
            'width.integer' => __('宽度必须是整数'),
            'width.min' => __('宽度不能小于100'),
            'width.max' => __('宽度不能大于2000'),
            'height.required' => __('高度不能为空'),
            'height.integer' => __('高度必须是整数'),
            'height.min' => __('高度不能小于100'),
            'height.max' => __('高度不能大于2000'),
        ];
    }
}
