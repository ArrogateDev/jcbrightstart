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
            'title' => 'bail|required',
            'type' => 'bail|required|in:0,1',
            'pdf_file' => 'bail|nullable|filled|mimes:pdf|max:15360',
            'sort' => 'bail|required|numeric|min:0|max:99',
            'status' => 'bail|required|in:0,1,2'
        ];

        $status = (int)$this->input('status');
        $type = (int)$this->input('type');
        if ($status == Resource::STATUS_PUBLISHED) {
            $rules['category_id'] = 'bail|required_if:type,0|exists:resource_categories,id';
            $rules['short'] = 'bail|required_if:type,0';
            $rules['description'] = 'bail|required';
        }

        $resource = $this->route('resource');
        if ($status == Resource::STATUS_PUBLISHED && $this->method() === 'PUT') {
            // 当 type=0(图文) 时，thumbnail 和 thumbnail_url 必须提供一个
            if ($type === Resource::TYPE_ARTICLE) {
                $rules['thumbnail'] = 'bail|required_without:thumbnail_url|image';
                $rules['thumbnail_url'] = 'bail|required_without:thumbnail|file_exists';
            }
            // 当 type=1(视频) 时，video 字段必填
            if ($type === Resource::TYPE_VIDEO) {
                $rules['video'] = 'bail|required|starts_with:https://www.youtube.com,https://youtu.be';
            }
        }

        if ($this->method() === 'PUT') {
            $id = $resource instanceof Resource ? $resource->id : $resource;
            $rules['title'] = [
                'bail',
                'required',
                Rule::unique('resources')->ignore($id)->where('deleted_at', null)
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'type.required' => __('资源类型不能为空'),
            'type.in' => __('资源类型格式错误'),
            'pdf_file.filled' => __('PDF文件不能为空'),
            'pdf_file.mimes' => __('PDF文件必须是PDF格式'),
            'pdf_file.max' => __('PDF最大15Mb'),
            'status.required' => __('状态不能为空'),
            'status.in' => __('状态格式错误'),
            'title.required' => __('标题不能为空'),
            'title.unique' => __('标题已经存在'),
            'category_id.required_if' => __('分类不能为空'),
            'sort.required' => __('请填写权重值'),
            'sort.numeric' => __('权重值必须为数组'),
            'sort.min' => __('权重值最小：:min'),
            'sort.max' => __('权重值最大：:max'),
            'short.required_if' => __('简介不能为空'),
            'description.required' => __('描述不能为空'),
            'thumbnail.required_if' => __('缩略图或缩略图链接必须提供一个'),
            'thumbnail.required_without' => __('缩略图或缩略图链接必须提供一个'),
            'thumbnail.image' => __('缩略图必须是图片格式'),
            'thumbnail_url.required_if' => __('缩略图或缩略图链接必须提供一个'),
            'thumbnail_url.required_without' => __('缩略图或缩略图链接必须提供一个'),
            'thumbnail_url.file_exists' => __('缩略图链接文件不存在'),
            'video.required_if' => __('视频链接必须提供'),
            'video.starts_with' => __('视频链接必须以 https://www.youtube.com 或 https://youtu.be 开头'),
        ];
    }
}
