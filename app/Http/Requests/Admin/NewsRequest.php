<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\News\News;
use Illuminate\Validation\Rule;

class NewsRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'sort' => 'bail|required|numeric|min:0|max:9999',
            'status' => 'bail|required|in:0,1,2'
        ];

        $status = $this->input('status');
        if ($status == News::STATUS_PUBLISHED) {
            $rules['title'] = 'bail|required';
            $rules['category_id'] = 'bail|required|exists:news_categories,id';
            $rules['short'] = 'bail|required';
            $rules['release_date'] = 'bail|required|date:Y-m-d';
//            $rules['start_date'] = 'bail|required|date:Y-m-d';
//            $rules['end_date'] = 'bail|required|date:Y-m-d|after_or_equal:start_date';
//            $rules['start_time'] = 'bail|required|date_format:h:i A';
//            $rules['end_time'] = 'bail|required|date_format:h:i A';
            $rules['description'] = 'bail|required';
        }

        if ($status == News::STATUS_PUBLISHED && $this->method() === 'PUT') {
            $news = $this->route('news');
            $rules['thumbnail'] = 'bail|required_without:thumbnail_url|image';
            $rules['thumbnail_url'] = 'bail|required_without:thumbnail|file_exists';
            $id = $news instanceof News ? $news->id : $news;
            $rules['title'] = [
                'bail',
                'required',
                Rule::unique('news')->ignore($id)
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
            'release_date.required' => __('发布日期不能为空'),
            'release_date.date' => __('发布日期格式错误'),
            'start_date.required' => __('开始日期不能为空'),
            'start_date.date' => __('开始日期格式错误'),
            'end_date.required' => __('结束日期不能为空'),
            'end_date.date' => __('结束日期格式错误'),
            'end_date.after_or_equal' => __('结束日期必须大于或等于开始日期'),
            'start_time.required' => __('开始时间不能为空'),
            'start_time.date' => __('开始时间格式错误'),
            'end_time.required' => __('结束时间不能为空'),
            'end_time.date' => __('结束时间格式错误'),
            'end_time.after_or_equal' => __('结束时间必须大于或等于开始时间'),
            'description.required' => __('描述不能为空'),
            'thumbnail.required_without' => __('缩略图或缩略图链接必须提供一个'),
            'thumbnail.image' => __('缩略图必须是图片格式'),
            'thumbnail_url.required_without' => __('缩略图或缩略图链接必须提供一个'),
            'thumbnail_url.file_exists' => __('缩略图链接文件不存在'),
        ];
    }
}
