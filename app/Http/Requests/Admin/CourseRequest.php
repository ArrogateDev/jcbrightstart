<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Validation\Rule;

class CourseRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'status' => 'bail|required|in:0,1,2',
            'chapters' => 'bail|nullable|array|min:1',
            'chapters.*.units' => 'bail|nullable|array|min:1',
            'chapters.*.units.*.video_url' => 'bail|nullable|starts_with:https://www.youtube.com,https://youtu.be',
            'chapters.*.units.*.pdf' => 'bail|nullable|filled|mimes:pdf',
            'chapters.*.units.*.type' => 'bail|nullable|in:0,1',
            'chapters.*.units.*.quiz_id' => 'bail|nullable|exists:quizzes,id',
        ];

        $status = $this->input('status');
        if ($status == Course::STATUS_PUBLISHED) {
            $rules['category_id'] = 'bail|required';
            $rules['level'] = 'bail|required';
            $rules['language'] = 'bail|required';
            $rules['short'] = 'bail|required';
            $rules['description'] = 'bail|required';
            $rules['chapters'] = 'bail|required|array|min:1';
            $rules['chapters.*.units'] = 'bail|required|array|min:1';
            $rules['chapters.*.units.*.video_url'] = 'bail|required_if:type,0|starts_with:https://www.youtube.com,https://youtu.be';
            $rules['chapters.*.units.*.pdf'] = 'bail|required_if:type,1|filled|mimes:pdf';
            $rules['chapters.*.units.*.type'] = 'bail|required|in:0,1';
            $rules['chapters.*.units.*.quiz_id'] = 'bail|required|exists:quizzes,id';
            $rules['certificate_id'] = 'bail|required|exists:certificates,id';
        }

        if ($status == Course::STATUS_PUBLISHED && $this->method() === 'PUT') {
            $course = $this->route('course');
            $rules['thumbnail'] = 'bail|required_without:thumbnail_url|image';
            $rules['thumbnail_url'] = 'bail|required_without:thumbnail|file_exists';
            $id = $course instanceof Quiz ? $course->id : $course;
            $rules['title'] = [
                'bail',
                'required',
                Rule::unique('courses')->ignore($id)
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'status.required' => __('状态不能为空'),
            'status.in' => __('状态格式错误'),
            'category_id.required' => __('分类不能为空'),
            'level.required' => __('级别不能为空'),
            'language.required' => __('语言不能为空'),
            'short.required' => __('简介不能为空'),
            'description.required' => __('描述不能为空'),
            'chapters.required' => __('章节不能为空'),
            'chapters.array' => __('章节必须是数组'),
            'chapters.min' => __('至少需要一个章节'),
            'chapters.*.units.required' => __('章节单元不能为空'),
            'chapters.*.units.array' => __('章节单元必须是数组'),
            'chapters.*.units.min' => __('每个章节至少需要一个单元'),
            'chapters.*.units.*.video_url.required_if' => __('当类型为视频时，视频链接不能为空'),
            'chapters.*.units.*.video_url.starts_with' => __('视频链接必须以 https://www.youtube.com 或 https://youtu.be 开头'),
            'chapters.*.units.*.pdf.required_if' => __('当类型为PDF时，PDF文件不能为空'),
            'chapters.*.units.*.pdf.filled' => __('PDF文件不能为空'),
            'chapters.*.units.*.pdf.mimes' => __('PDF文件必须是PDF格式'),
            'chapters.*.units.*.type.required' => __('单元类型不能为空'),
            'chapters.*.units.*.type.in' => __('单元类型格式错误'),
            'chapters.*.units.*.quiz_id.required' => __('测验不能为空'),
            'chapters.*.units.*.quiz_id.exists' => __('选择的测验不存在'),
            'certificate_id.required' => __('证书不能为空'),
            'certificate_id.exists' => __('选择的证书不存在'),
            'thumbnail.required_without' => __('缩略图或缩略图链接必须提供一个'),
            'thumbnail.image' => __('缩略图必须是图片格式'),
            'thumbnail_url.required_without' => __('缩略图或缩略图链接必须提供一个'),
            'thumbnail_url.file_exists' => __('缩略图链接文件不存在'),
            'title.required' => __('标题不能为空'),
            'title.unique' => __('标题已经存在'),
        ];
    }
}
