<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
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
        if ($status == 2) {
            $rules['thumbnail'] = 'bail|required|image';
            $rules['video_url'] = 'bail|required|url';
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

        if ($this->method() === 'PUT') {
            $course = $this->route('course');
            $rules['image'] = 'bail|nullable|image';
        }

        if ($status == 2 && $this->method() === 'PUT') {
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
        ];
    }
}
