<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Course\Course;
use App\Models\Quiz;
use Illuminate\Contracts\Validation\Validator;
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
            'chapters.*.units.*.pdf' => 'bail|nullable|filled|mimes:pdf|max:15360',
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
            $rules['chapters.*.units.*.video_url'] = 'bail|nullable|starts_with:https://www.youtube.com,https://youtu.be';
            $rules['chapters.*.units.*.pdf'] = 'bail|nullable|filled|mimes:pdf|max:15360';
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

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $status = $this->input('status');
            if ($status == Course::STATUS_PUBLISHED) {
                $chapters = $this->input('chapters', []);
                foreach ($chapters as $chapter_idx => $chapter) {
                    $units = $chapter['units'] ?? [];
                    foreach ($units as $unit_idx => $unit) {
                        $type = isset($unit['type']) ? (int)$unit['type'] : null;
                        $video_url = $unit['video_url'] ?? null;
                        $unit_id = $unit['id'] ?? null;

                        // 检查是否有文件上传（尝试不同的字段路径格式）
                        $pdf_file_key1 = "chapters.$chapter_idx.units.$unit_idx.pdf";
                        $pdf_file_key2 = "chapters.$chapter_idx.units.$unit_idx.pdf";
                        $has_pdf_file = $this->hasFile($pdf_file_key1) || $this->hasFile($pdf_file_key2);

                        // 如果 hasFile 返回 false，尝试检查所有上传的文件中是否有匹配的
                        if (!$has_pdf_file) {
                            $all_files = $this->allFiles();
                            foreach ($all_files as $key => $file) {
                                // 检查字段名是否匹配（支持不同的格式）
                                if (preg_match('/chapters[\.\[]' . preg_quote($chapter_idx, '/') . '[\]]units[\.\[]' . preg_quote($unit_idx, '/') . '[\]]pdf/i', $key)) {
                                    $has_pdf_file = true;
                                    break;
                                }
                            }
                        }

                        // 检查是否有已存在的单元ID（更新时可能已有文件）
                        $is_existing_unit = !empty($unit_id);

                        if ($type === 0 && empty($video_url)) {
                            $validator->errors()->add(
                                "chapters.$chapter_idx.units.$unit_idx.video_url",
                                __('当类型为视频时，视频链接不能为空')
                            );
                        }

                        // 对于PDF类型：如果是新单元，必须上传文件；如果是已存在的单元，可以不上传（保留旧文件）
                        if ($type === 1 && !$is_existing_unit && !$has_pdf_file) {
                            $validator->errors()->add(
                                "chapters.$chapter_idx.units.$unit_idx.pdf",
                                __('当类型为PDF时，PDF文件不能为空')
                            );
                        }
                    }
                }
            }
        });
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
            'chapters.*.units.*.pdf.max' => __('PDF最大15Mb'),
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
