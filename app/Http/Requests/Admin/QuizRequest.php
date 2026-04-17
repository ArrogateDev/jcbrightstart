<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Quiz;
use Illuminate\Validation\Rule;

class QuizRequest extends BaseRequest
{

    public function rules()
    {
        $rules = [
            'title' => [
                'bail',
                'required',
                Rule::unique('quizzes')->withoutTrashed()
            ],
            'questions' => 'bail|required|array|min:1',
            'questions.*.title' => 'bail|required',
            'questions.*.options' => 'bail|required|array|min:2',
            'questions.*.correct_answer' => 'bail|required',
        ];

        if ($this->method() === 'PUT') {
            $quiz = $this->route('quiz');
            $id = $quiz instanceof Quiz ? $quiz->id : $quiz;

            $rules['title'] = [
                'bail',
                'required',
                Rule::unique('quizzes')->ignore($id)->withoutTrashed()
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => __('测验标题不能为空'),
            'title.unique' => __('测验标题已经存在'),
            'questions.required' => __('问题不能为空'),
            'questions.array' => __('问题必须是数组'),
            'questions.min' => __('至少需要一个问题'),
            'questions.*.title.required' => __('问题标题不能为空'),
            'questions.*.options.required' => __('问题选项不能为空'),
            'questions.*.options.array' => __('问题选项必须是数组'),
            'questions.*.options.min' => __('每个问题至少需要2个选项'),
            'questions.*.correct_answer.required' => __('正确答案不能为空'),
        ];
    }
}
