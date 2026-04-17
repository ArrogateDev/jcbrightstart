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
            'type' => 'bail|required|in:0,1',
            'thumbnail_show' => 'bail|required|in:0,1',
            'sort' => 'bail|required|numeric|min:0|max:99',
            'status' => 'bail|required|in:0,1,2'
        ];

        $status = $this->input('status');
        $type = (int)$this->input('type');
        if ($status == News::STATUS_PUBLISHED) {
            $rules['category_id'] = 'bail|required_if:type,0|exists:resource_categories,id';
            $rules['short'] = 'bail|required_if:type,0';
            $rules['release_date'] = 'bail|required_if:type,0|nullable|date:Y-m-d';
//            $rules['start_date'] = 'bail|required|date:Y-m-d';
//            $rules['end_date'] = 'bail|required|date:Y-m-d|after_or_equal:start_date';
//            $rules['start_time'] = 'bail|required|date_format:h:i A';
//            $rules['end_time'] = 'bail|required|date_format:h:i A';
            $rules['description'] = 'bail|required';
        }

        $news = $this->route('news');
        if ($status == News::STATUS_PUBLISHED && $this->method() === 'PUT') {
            // 当 type=0(图文) 时，thumbnail 和 thumbnail_url 必须提供一个
            if ($type === News::TYPE_ARTICLE) {
                $rules['thumbnail'] = 'bail|required_without:thumbnail_url|image';
                $rules['thumbnail_url'] = 'bail|required_without:thumbnail|file_exists';
            }
            // 当 type=1(视频) 时，video 字段必填
            if ($type === News::TYPE_VIDEO) {
                $rules['video'] = 'bail|required|starts_with:https://www.youtube.com,https://youtu.be';
            }
        }

        $id = $news instanceof News ? $news->id : $news;
        if ($this->method() === 'PUT') {
            $rules['title'] = [
                'bail',
                'required',
                Rule::unique('news')->ignore($id)->where('deleted_at', null)
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'type.required' => __('资源类型不能为空'),
            'type.in' => __('资源类型格式错误'),
            'status.required' => __('状态不能为空'),
            'status.in' => __('状态格式错误'),
            'title.required' => __('标题不能为空'),
            'title.unique' => __('标题已经存在'),
            'category_id.required_if' => __('分类不能为空'),
            'category_id.exists' => __('选择的分类不存在'),
            'sort.required' => __('请填写权重值'),
            'sort.numeric' => __('权重值必须为数组'),
            'sort.min' => __('权重值最小：:min'),
            'sort.max' => __('权重值最大：:max'),
            'short.required_if' => __('简介不能为空'),
            'release_date.required_if' => __('发布日期不能为空'),
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
            'video.required_if' => __('视频链接必须提供'),
            'video.starts_with' => __('视频链接必须以 https://www.youtube.com 或 https://youtu.be 开头'),
        ];
    }
}
