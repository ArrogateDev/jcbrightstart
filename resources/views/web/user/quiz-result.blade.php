<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/css/user.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/lodash.js') }}"></script>
    <script src="{{web_resource_url('assets/js/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{web_resource_url('assets/js/wait-me/waitMe.min.css')}}">
    <link href="{{web_resource_url('assets/js/toastr/toastr.min.css')}}" rel="stylesheet"/>
    <script src="{{web_resource_url('assets/js/toastr/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/utils.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
</head>
<body>
<x-web.user.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="pt-[60px]">
            <x-web.user.profile :user="$user"/>
        </div>

        <div class="grid grid-cols-12 gap-x-12">

            <x-web.user.sidebar active="quiz"/>

            <div class="lg:col-span-9">

                <x-web.user.breadcrumb title="{{__('我的测验')}}"/>

                <div class="mb-5 flex flex-col gap-4 border-b border-[#998675] pb-5 lg:flex-row lg:items-center lg:justify-between">
                    <h5 class="text-xl font-bold">{{__('我的测验')}}</h5>
                </div>

                @if($is_completed)
                    <div class="mb-4 rounded-2xl border border-slate-200 bg-white shadow-sm j-user-box">
                            <div class="p-6">
                            <div class="flex justify-center m-0 mb-3">
                                <div
                                    @class(['flex-none', 'radial-progress', 'text-[10px]', 'text-red-600' => $quiz_statistics->correct_rate <= 50, 'text-orange-500' => $quiz_statistics->finishing_rat > 50 && $quiz_statistics->finishing_rat < 100, 'text-green-700' => $quiz_statistics->correct_rate == 100]) style="--value:{{$quiz_statistics->correct_rate}};--size:38px; --thickness: 4px;"
                                    aria-valuenow="{{$quiz_statistics->correct_rate}}" role="progressbar">{{$quiz_statistics->correct_rate}}%
                                </div>
                            </div>
                            <div class="mb-3 text-center">
                                @if($quiz_statistics->correct_rate >= 80)
                                    <h6 class="mb-1 text-lg font-semibold text-slate-900">{{__('恭喜！您通过了测验')}}</h6>
                                    <p class="text-sm text-slate-600">{{__('您成功完成了测验。继续保持！')}}</p>
                                @else
                                    <h6 class="mb-1 text-lg font-semibold text-slate-900">{{__('抱歉，您这次没有通过')}}</h6>
                                    <p class="text-sm text-slate-600">{{__('别担心，从这次尝试中学习，下次会更强！')}}</p>
                                @endif
                                <div class="mt-3 space-y-1 text-sm text-slate-700">
                                    <p><strong>{{__('正确')}}:</strong> {{$quiz_statistics->correct}} / {{$quiz_statistics->total_questions}}</p>
                                    <p><strong>{{__('正确率')}}:</strong> {{round($quiz_statistics->correct_rate, 2)}}%</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center">
                                <a href="{{route('user.quiz.html')}}" class="inline-flex items-center rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200">
                                    <i class="isax isax-arrow-left-2 me-1 fs-10"></i>{{__('返回测验列表')}}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- 显示所有题目和答案 --}}
                    @if($quiz_data && count($quiz_data) > 0)
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm j-user-box">
                            <div class="border-b border-slate-200 px-6 py-4">
                                <h5 class="mb-0 text-lg font-semibold text-slate-900">{{__('题目详情')}}</h5>
                            </div>
                            <div class="p-6">
                                @foreach($quiz_data as $index => $question)
                                    @php
                                        $user_answer = $user_answers[$index] ?? null;
                                        $is_correct = $user_answer && $user_answer['is_correct'];
                                        $user_answer_idx = $user_answer ? $user_answer['user_answer'] : null;
                                        $correct_answer_idx = $user_answer ? $user_answer['correct_answer'] : ($question['correct_answer'] ?? 0);
                                    @endphp
                                    <div class="mb-3 rounded-2xl border {{$is_correct ? 'border-emerald-300 bg-emerald-50/60' : 'border-rose-300 bg-rose-50/60'}} p-4">
                                        <div class="mb-3 flex items-start">
                                            <span class="mr-2 inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-sm font-semibold text-white {{$is_correct ? 'bg-emerald-500' : 'bg-rose-500'}}">{{$index + 1}}</span>
                                            <h6 class="mb-0 flex-1 text-base font-semibold text-slate-900">{{$question['title'] ?? ''}}</h6>
                                        </div>

                                        <div class="mb-3 space-y-2">
                                            @if(isset($question['options']) && is_array($question['options']))
                                                @foreach($question['options'] as $opt_idx => $option)
                                                    @php
                                                        $is_user_answer = $user_answer_idx !== null && $user_answer_idx == $opt_idx;
                                                        $is_correct_answer = $correct_answer_idx == $opt_idx;
                                                        $option_class = '';
                                                        if ($is_correct_answer) {
                                                            $option_class = 'text-emerald-700 font-semibold';
                                                        } elseif ($is_user_answer && !$is_correct) {
                                                            $option_class = 'text-rose-700 font-medium';
                                                        }
                                                    @endphp
                                                    <div class="flex items-center rounded-xl border border-slate-200 bg-white px-3 py-2 {{$option_class}}">
                                                        <input class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500" type="radio" disabled
                                                            {{$is_user_answer ? 'checked' : ''}}>
                                                        <label class="flex-1 cursor-default text-sm text-slate-700">
                                                            <span>{{chr(65 + $opt_idx)}}.</span> {{$option}}
                                                            @if($is_correct_answer)
                                                                <i class="fa-solid fa-check ml-2 text-emerald-600"></i>
                                                            @endif
                                                            @if($is_user_answer && !$is_correct)
                                                                <i class="fa-solid fa-times ml-2 text-rose-600"></i>
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        <div class="rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-slate-700">
                                            <div class="mb-2 font-semibold text-slate-900">{{__('解析')}}</div>
                                            <div>{{$question['explanation'] ?? __('暂无解析')}}</div>
                                            <div class="mt-2">
                                                <strong>{{__('正确答案')}}:</strong>
                                                <span class="text-emerald-700">
                                                        {{chr(65 + $correct_answer_idx)}}.
                                                        @if(isset($question['options'][$correct_answer_idx]))
                                                        {{$question['options'][$correct_answer_idx]}}
                                                    @endif
                                                    </span>
                                            </div>
                                            @if($user_answer_idx !== null)
                                                <div class="mt-1">
                                                    <strong>{{__('您的答案')}}:</strong>
                                                    <span class="{{$is_correct ? 'text-emerald-700' : 'text-rose-700'}}">
                                                            {{chr(65 + $user_answer_idx)}}.
                                                            @if(isset($question['options'][$user_answer_idx]))
                                                            {{$question['options'][$user_answer_idx]}}
                                                        @endif
                                                        </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <div id="quiz-container" class="quiz-wizard">
                        <div class="quiz-attempt-card rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <div class="quiz-attempt-body p-0">
                                <div id="quiz-content">
                                    <div class="flex items-center justify-center" style="min-height: 300px;">
                                        <div class="h-10 w-10 animate-spin rounded-full border-4 border-slate-200 border-t-indigo-600" role="status">
                                            <span class="sr-only">{{__('加载中...')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>

@if(!$is_completed)
    <script>
        $(function () {
            const $quizContent = $('#quiz-content');
            let quizData = null;
            let currentQuestionIndex = 0;
            let selectedAnswer = null;
            let isAnswered = false;
            let currentCourseId = {{ $course_id }};
            let currentChapterId = {{ $quiz_statistics->chapter_id }};
            let currentUnitId = {{ $quiz_statistics->unit_id }};
            let currentQuizId = {{ $quiz_statistics->quiz_id }};
            let wrongAnswers = {};
            let isAllCompleted = false;

            function loadQuiz(unitId) {
                $.ajax({
                    url: `/quiz/${unitId}.html`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.code !== 0) {
                            showToast('error', response.msg || '{{__('获取测验数据失败')}}');
                            return;
                        }

                        if (!response.data || !response.data.questions || response.data.questions.length <= 0) {
                            showToast('error', '{{__('测验数据为空')}}');
                            return;
                        }

                        renderQuiz(response.data);
                    },
                    error: function () {
                        showToast('error', 'Failed, please try again later')
                    }
                });
            }

            function renderQuiz(quiz) {
                if (!quiz || !quiz.questions || !Array.isArray(quiz.questions) || quiz.questions.length === 0) {
                    showToast('error', '{{__('测验数据无效')}}');
                    return;
                }

                quizData = quiz;
                selectedAnswer = null;
                isAnswered = false;

                getAnsweredQuestions(function (data) {
                    const answeredQuestions = data.answered_questions || [];

                    let startIndex = 0;
                    for (let i = 0; i < quiz.questions.length; i++) {
                        if (!answeredQuestions.includes(i)) {
                            startIndex = i;
                            break;
                        }
                    }

                    if (answeredQuestions.length >= quiz.questions.length) {
                        startIndex = 0;
                    }

                    currentQuestionIndex = startIndex;
                    showQuestion(startIndex);
                });
            }

            function getAnsweredQuestions(callback) {
                if (!currentCourseId || !currentChapterId || !currentUnitId || !currentQuizId) {
                    callback([]);
                    return;
                }

                $.ajax({
                    url: `/course/${currentCourseId}/answered-questions.html`,
                    type: 'GET',
                    data: {
                        chapter_id: currentChapterId,
                        unit_id: currentUnitId,
                        quiz_id: currentQuizId,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.code === 0 && response.data) {
                            callback(response.data);
                        } else {
                            callback({answered_questions: [], completed_questions: []});
                        }
                    },
                    error: function () {
                        callback([]);
                    }
                });
            }

            function renderQuestion(question, index, totalQuestions) {
                const isLastQuestion = index === totalQuestions - 1;
                const buttonText = isLastQuestion ? '{{__('完成')}}' : '{{__('下一题')}}';

                let html = `<div class="quiz-question mb-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm" data-question-index="${index}">`;
                html += `<div class="quiz-question-title mb-3"><h6 class="text-base font-semibold text-slate-900">${index + 1}. ${question.title || ''}</h6></div>`;
                html += '<ul class="quiz-options mb-0 list-none space-y-2 p-0">';

                if (question.options && Array.isArray(question.options)) {
                    question.options.forEach((option, optIndex) => {
                        html += `<li class="quiz-option flex items-center rounded-xl border border-slate-200 px-4 py-3 transition hover:border-indigo-300 hover:bg-slate-50" data-option-index="${optIndex}">`;
                        html += `<input class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500" type="radio" name="question-${index}" id="question-${index}-option-${optIndex}">`;
                        html += `<label class="flex flex-1 cursor-pointer items-center gap-1 px-2 text-sm text-slate-700" for="question-${index}-option-${optIndex}">`;
                        html += `<span class="quiz-option-label font-medium text-slate-900">${String.fromCharCode(65 + optIndex)}.</span> `;
                        html += `<span class="quiz-option-text">${option}</span>`;
                        html += '</label>';
                        html += '</li>';
                    });
                }

                html += '</ul>';

                html += '<div class="quiz-explanation mt-3 rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-slate-700" style="display: none;">';
                html += '<div class="quiz-explanation-title mb-2 font-semibold text-slate-900">{{__('解析')}}</div>';
                html += `<div class="quiz-explanation-content">${question.explanation || '{{__('暂无解析')}}'}</div>`;
                html += '</div>';

                html += '<div class="quiz-actions mt-3">';
                html += `<button class="quiz-next-btn inline-flex items-center rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200 disabled:cursor-not-allowed disabled:opacity-60" data-is-last="${isLastQuestion}" style="display: none;">${buttonText}</button>`;
                html += '</div>';

                html += '</div>';
                return html;
            }

            function showQuestion(index) {
                if (!quizData || !quizData.questions || index < 0 || index >= quizData.questions.length) {
                    return;
                }

                const question = quizData.questions[index];
                const isLastQuestion = index === quizData.questions.length - 1;

                // 只渲染当前题目
                let html = '<div class="quiz-container">';
                html += '<div class="quiz-progress mb-3 text-sm text-slate-600">';
                html += `<span>{{__('第')}} <strong class="font-semibold text-slate-900">${index + 1}</strong> {{__('题，共')}} <strong class="font-semibold text-slate-900">${quizData.questions.length}</strong> {{__('题')}}</span>`;
                html += '</div>';
                html += renderQuestion(question, index, quizData.questions.length);
                html += '</div>';
                $quizContent.html(html);

                const $question = $(`.quiz-question[data-question-index="${index}"]`);
                const $nextBtn = $question.find('.quiz-next-btn');
                if (isLastQuestion) {
                    $nextBtn.text('{{__('完成')}}').attr('data-is-last', 'true');
                } else {
                    $nextBtn.text('{{__('下一题')}}').attr('data-is-last', 'false');
                }

                selectedAnswer = null;
                isAnswered = false;
                $question.find('.quiz-explanation').hide();
                $nextBtn.hide();

                $question.find('.quiz-option input[type="radio"]').off('change').on('change', function () {
                    if (isAnswered) return;

                    const $option = $(this).closest('.quiz-option');
                    const optionIndex = parseInt($option.data('option-index'), 10);
                    const question = quizData.questions[index];

                    let correctAnswer = 0;
                    if (question.correct_answer !== undefined && question.correct_answer !== null) {
                        correctAnswer = parseInt(question.correct_answer, 10);
                        if (isNaN(correctAnswer)) {
                            correctAnswer = 0;
                        }
                    }

                    selectedAnswer = optionIndex;

                    if (optionIndex === correctAnswer) {
                        $option.addClass('border-emerald-300 bg-emerald-50');

                        if (!$question.find('.quiz-explanation').is(':visible')) {
                            $question.find('.quiz-explanation').show();
                        }

                        $question.find('.quiz-option input[type="radio"]').prop('disabled', true);
                        $question.find('.quiz-next-btn').show();

                        isAnswered = true;

                        const wrongAnswer = wrongAnswers[index] !== undefined ? wrongAnswers[index] : null;
                        const $nextBtn = $question.find('.quiz-next-btn');
                        $nextBtn.prop('disabled', true).text('{{__('保存中...')}}');

                        saveQuizAnswer(index, optionIndex, wrongAnswer)
                            .then(function (response) {
                                delete wrongAnswers[index];
                                $nextBtn.prop('disabled', false);
                                const isLast = index === quizData.questions.length - 1;
                                if (isLast) {
                                    if (response.completed === true) {
                                        isAllCompleted = true;
                                        showComplete(true);
                                    } else {
                                        isAllCompleted = false;
                                        $nextBtn.text('{{__('完成')}}');
                                    }
                                } else {
                                    $nextBtn.text('{{__('下一题')}}');
                                }
                            })
                            .catch(function (error) {
                                console.error('保存答案失败:', error);
                                showToast('error', '{{__('保存答案失败，请重试')}}');
                                $nextBtn.prop('disabled', false);
                                const isLast = index === quizData.questions.length - 1;
                                if (isLast) {
                                    $nextBtn.text('{{__('完成')}}');
                                } else {
                                    $nextBtn.text('{{__('下一题')}}');
                                }
                            });
                    } else {
                        $option.addClass('border-rose-300 bg-rose-50');

                        if (wrongAnswers[index] === undefined) {
                            wrongAnswers[index] = optionIndex;
                        }
                    }
                });

                $question.find('.quiz-next-btn').off('click').on('click', function () {
                    const isLast = $(this).attr('data-is-last') === 'true';
                    if (isLast) {
                        showComplete(isAllCompleted);
                    } else {
                        nextQuestion();
                    }
                });
            }

            function nextQuestion() {
                if (currentQuestionIndex < quizData.questions.length - 1) {
                    currentQuestionIndex++;
                    showQuestion(currentQuestionIndex);
                } else {
                    showComplete();
                }
            }

            function showComplete(allCompleted = false) {
                let html = '<div class="quiz-complete rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm">';
                html += '<div class="quiz-complete-icon mb-3"><i class="fa-solid fa-circle-check fa-3x text-emerald-600"></i></div>';
                html += '<div class="quiz-complete-title mb-2"><h5 class="text-lg font-semibold text-slate-900">{{__('测验完成')}}</h5></div>';
                if (allCompleted) {
                    html += '<div class="quiz-complete-message mb-3"><p class="text-sm text-slate-600">{{__('恭喜您完成了所有课程！')}}</p></div>';
                } else {
                    html += '<div class="quiz-complete-message mb-3"><p class="text-sm text-slate-600">{{__('恭喜您完成了本次测验！')}}</p></div>';
                }
                html += '<div class="mt-4">';
                html += '<a href="{{route('user.quiz.html')}}" class="inline-flex items-center rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200">{{__('返回测验列表')}}</a>';
                html += '</div>';
                html += '</div>';
                $quizContent.html(html);

                setTimeout(function () {
                    window.location.reload();
                }, 1500);
            }

            function saveQuizAnswer(questionIndex, userAnswer, wrongAnswer = null) {
                return new Promise(function (resolve, reject) {
                    if (!currentCourseId || !currentChapterId || !currentUnitId || !currentQuizId) {
                        reject(new Error('缺少必要的参数'));
                        return;
                    }

                    userAnswer = parseInt(userAnswer, 10) || 0;

                    if (wrongAnswer !== null && wrongAnswer !== undefined) {
                        wrongAnswer = parseInt(wrongAnswer, 10);
                        if (!isNaN(wrongAnswer)) {
                            userAnswer = wrongAnswer;
                        }
                    }

                    showLoading()

                    $.ajax({
                        url: `/course/${currentCourseId}/quiz-answer.html`,
                        type: 'POST',
                        data: {
                            chapter_id: currentChapterId,
                            unit_id: currentUnitId,
                            quiz_id: currentQuizId,
                            question_index: questionIndex,
                            user_answer: userAnswer,
                            _token: '{{csrf_token()}}'
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.code !== 0) {
                                console.error('保存答题记录失败:', response.msg);
                                reject(new Error(response.msg || '保存答题记录失败'));
                            } else {
                                console.log('答题记录保存成功:', response.data);
                                resolve(response.data);
                            }
                        },
                        error: function () {
                            showToast('error', 'Failed, please try again later')
                        },
                        complete: function () {
                            hideLoading()
                        }
                    });
                });
            }

            // 页面加载时自动加载测验
            loadQuiz({{ $quiz_statistics->unit_id }});
        });
    </script>
@endif

<x-web.footer/>
</body>

</html>
