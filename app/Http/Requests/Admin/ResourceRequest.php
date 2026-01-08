<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Resource\Resource;
use Illuminate\Validation\Rule;

class ResourceRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'status' => 'bail|required|in:0,1,2'
        ];

        $status = $this->input('status');
        if ($status == Resource::STATUS_PUBLISHED) {
            $rules['title'] = 'bail|required';
            $rules['category_id'] = 'bail|required|exists:resource_categories,id';
            $rules['short'] = 'bail|required';
            $rules['description'] = 'bail|required';
        }

        if ($status == Resource::STATUS_PUBLISHED && $this->method() === 'PUT') {
            $resource = $this->route('resource');
            $rules['thumbnail'] = 'bail|required_without:thumbnail_url|image';
            $rules['thumbnail_url'] = 'bail|required_without:thumbnail|file_exists';
            $id = $resource instanceof Resource ? $resource->id : $resource;
            $rules['title'] = [
                'bail',
                'required',
                Rule::unique('resources')->ignore($id)
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'status.required' => __('状态不能为空'),
            'status.in' => __('状态格式错误'),
            'title.required' => __('标题不能为空'),
            'title.unique' => __('标题已经存在'),
            'category_id.required' => __('分类不能为空'),
            'category_id.exists' => __('选择的分类不存在'),
            'short.required' => __('简介不能为空'),
            'description.required' => __('描述不能为空'),
            'thumbnail.required_without' => __('缩略图或缩略图链接必须提供一个'),
            'thumbnail.image' => __('缩略图必须是图片格式'),
            'thumbnail_url.required_without' => __('缩略图或缩略图链接必须提供一个'),
            'thumbnail_url.file_exists' => __('缩略图链接文件不存在'),
        ];
    }
}
