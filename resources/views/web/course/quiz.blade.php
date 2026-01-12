<div class="modal fade" id="quiz-box" tabindex="-1" aria-labelledby="quiz-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quiz-label">{{__('课程测验')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="quiz-content">
                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">{{__('加载中...')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        const $quizModal = $('#quiz-box');
        const $quizContent = $('#quiz-content');
        let quizData = null;
        let currentQuestionIndex = 0;
        let selectedAnswer = null;
        let isAnswered = false;
        let currentCourseId = {{ $course->id }};
        let currentChapterId = null;
        let currentUnitId = null;
        let currentQuizId = null;
        let wrongAnswers = {};

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

                    if (!response.data || response.data.length <= 0) {
                        showToast('error', '{{__('测验数据为空')}}');
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

                let html = '<div class="quiz-container">';
                html += '<div class="quiz-progress">';
                html += `<span>{{__('第')}} <strong>${startIndex + 1}</strong> {{__('题，共')}} <strong>${quiz.questions.length}</strong> {{__('题')}}</span>`;
                html += '</div>';

                quiz.questions.forEach((question, index) => {
                    html += renderQuestion(question, index, quiz.questions.length);
                });

                html += '</div>';
                $quizContent.html(html);

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

            let html = `<div class="quiz-question" data-question-index="${index}">`;
            html += `<div class="quiz-question-title">${index + 1}. ${question.title || ''}</div>`;
            html += '<ul class="quiz-options">';

            if (question.options && Array.isArray(question.options)) {
                question.options.forEach((option, optIndex) => {
                    html += `<li class="quiz-option" data-option-index="${optIndex}">`;
                    html += `<span class="quiz-option-label">${String.fromCharCode(65 + optIndex)}.</span>`;
                    html += `<span class="quiz-option-text">${option}</span>`;
                    html += '</li>';
                });
            }

            html += '</ul>';

            html += '<div class="quiz-explanation">';
            html += '<div class="quiz-explanation-title">{{__('解析')}}</div>';
            html += `<div class="quiz-explanation-content">${question.explanation || '{{__('暂无解析')}}'}</div>`;
            html += '</div>';

            html += '<div class="quiz-actions">';
            html += `<button class="btn btn-primary quiz-next-btn" data-is-last="${isLastQuestion}">${buttonText}</button>`;
            html += '</div>';

            html += '</div>';
            return html;
        }

        function showQuestion(index) {
            if (!quizData || !quizData.questions || index < 0 || index >= quizData.questions.length) {
                return;
            }

            $('.quiz-question').removeClass('active');

            const $question = $(`.quiz-question[data-question-index="${index}"]`);
            $question.addClass('active');

            $('.quiz-progress').html(`<span>{{__('第')}} <strong>${index + 1}</strong> {{__('题，共')}} <strong>${quizData.questions.length}</strong> {{__('题')}}</span>`);

            const isLastQuestion = index === quizData.questions.length - 1;
            const $nextBtn = $question.find('.quiz-next-btn');
            if (isLastQuestion) {
                $nextBtn.text('{{__('完成')}}').attr('data-is-last', 'true');
            } else {
                $nextBtn.text('{{__('下一题')}}').attr('data-is-last', 'false');
            }

            selectedAnswer = null;
            isAnswered = false;
            $question.find('.quiz-option').removeClass('selected correct incorrect disabled');
            $question.find('.quiz-explanation').removeClass('show');
            $nextBtn.removeClass('show');

            $question.find('.quiz-option').off('click').on('click', function () {
                if (isAnswered) return;

                const $option = $(this);
                const optionIndex = parseInt($option.data('option-index'), 10);
                const question = quizData.questions[index];

                let correctAnswer = 0;
                if (question.correct_answer !== undefined && question.correct_answer !== null) {
                    correctAnswer = parseInt(question.correct_answer, 10);
                    if (isNaN(correctAnswer)) {
                        correctAnswer = 0;
                    }
                }

                $question.find('.quiz-option').removeClass('selected');

                $option.addClass('selected');
                selectedAnswer = optionIndex;

                if (optionIndex === correctAnswer) {
                    $question.find('.quiz-option').removeClass('incorrect');
                    $option.addClass('correct');

                    $question.find(`.quiz-option[data-option-index="${correctAnswer}"]`).addClass('correct');

                    if (!$question.find('.quiz-explanation').hasClass('show')) {
                        $question.find('.quiz-explanation').addClass('show');
                    }

                    $question.find('.quiz-option').addClass('disabled');

                    isAnswered = true;

                    const wrongAnswer = wrongAnswers[index] !== undefined ? wrongAnswers[index] : null;

                    const $nextBtn = $question.find('.quiz-next-btn');
                    $nextBtn.prop('disabled', true).text('{{__('保存中...')}}');

                    saveQuizAnswer(index, optionIndex, wrongAnswer)
                        .then(function (response) {
                            console.log(response)
                            delete wrongAnswers[index];
                            $nextBtn.prop('disabled', false).addClass('show');
                            const isLast = index === quizData.questions.length - 1;
                            if (isLast) {
                                $nextBtn.text('{{__('完成')}}');
                            } else {
                                $nextBtn.text('{{__('下一题')}}');
                            }
                        })
                        .catch(function (error) {
                            console.error('保存答案失败:', error);
                            showToast('error', '{{__('保存答案失败，请重试')}}');
                            $nextBtn.prop('disabled', false).addClass('show');
                            const isLast = index === quizData.questions.length - 1;
                            if (isLast) {
                                $nextBtn.text('{{__('完成')}}');
                            } else {
                                $nextBtn.text('{{__('下一题')}}');
                            }
                        });
                } else {
                    $option.addClass('incorrect');

                    $question.find('.quiz-explanation').addClass('show error');

                    if (wrongAnswers[index] === undefined) {
                        wrongAnswers[index] = optionIndex;
                    }

                    $question.find('.quiz-option').each(function () {
                        const $opt = $(this);
                        const optIndex = parseInt($opt.data('option-index'), 10);
                        if (optIndex !== correctAnswer) {
                            $opt.addClass('disabled');
                        }
                    });
                }
            });

            $question.find('.quiz-next-btn').off('click').on('click', function () {
                const isLast = $(this).attr('data-is-last') === 'true';
                if (isLast) {
                    showComplete();
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

        function updateUnitStatus(unitId, newStatus) {
            const $unitItem = $(`li[data-unit="${unitId}"]`);
            if (!$unitItem.length) {
                return;
            }

            const $actionDiv = $unitItem.find('.d-flex.align-items-center');
            if (!$actionDiv.length) {
                return;
            }

            let unitInfo = $unitItem.data('info');
            if (unitInfo) {
                unitInfo.status = newStatus;
                $unitItem.data('info', unitInfo);
            }

            if (newStatus === 2) {
                const playPosition = unitInfo ? (unitInfo.play_position || 0) : 0;

                $actionDiv.html(`
                    <a href="#" class="preview-link" data-toggle="modal" data-target="#play-box"
                       data-unit="${unitId}"
                       data-status="2"
                       data-play-position="${playPosition}">Preview</a>
                    <i class="fa-solid fa-circle-check text-success ml-3"></i>
                `);
            } else if (newStatus === 1) {
                const courseId = unitInfo ? (unitInfo.course_id || 0) : 0;
                const chapterId = unitInfo ? (unitInfo.chapter_id || 0) : 0;
                const quizId = unitInfo ? (unitInfo.quiz_id || 0) : 0;

                $actionDiv.html(`
                    <a href="#" class="preview-link" data-toggle="modal" data-target="#quiz-box"
                       data-course="${courseId}"
                       data-chapter="${chapterId}"
                       data-unit="${unitId}"
                       data-quiz="${quizId}"
                       data-status="1">Quiz</a>
                    <i class="fa-solid fa-book text-warning ml-3"></i>
                `);
            }
        }

        function showComplete() {
            if (currentUnitId) {
                updateUnitStatus(currentUnitId, 2);
            }

            let html = '<div class="quiz-complete">';
            html += '<div class="quiz-complete-icon"><i class="fa-solid fa-circle-check"></i></div>';
            html += '<div class="quiz-complete-title">{{__('测验完成')}}</div>';
            html += '<div class="quiz-complete-message">{{__('恭喜您完成了本次测验！')}}</div>';
            html += '<button class="btn btn-primary" data-dismiss="modal">{{__('关闭')}}</button>';
            html += '</div>';
            $quizContent.html(html);
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
                showLoading($('#quiz-box .modal-content'))

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
                        hideLoading($('#quiz-box .modal-content'))
                        if (response.code !== 0) {
                            console.error('保存答题记录失败:', response.msg);
                            reject(new Error(response.msg || '保存答题记录失败'));
                        } else {
                            console.log('答题记录保存成功:', response.data);
                            resolve(response.data);
                        }
                    },
                    error: function (xhr) {
                        hideLoading($('#quiz-box .modal-content'))
                        console.error('保存答题记录失败:', xhr);
                        if (xhr.responseJSON) {
                            console.error('错误详情:', xhr.responseJSON);
                            reject(new Error(xhr.responseJSON.msg || '保存答题记录失败'));
                        } else {
                            reject(new Error('保存答题记录失败'));
                        }
                    }
                });
            });
        }

        $quizModal.on('show.bs.modal', function (event) {
            const button = event.relatedTarget
            const params = $(this).data('params');
            let course = 0
            let chapter = 0
            let unit = 0
            let quiz = 0
            if (button) {
                course = parseInt(button.getAttribute('data-course') || 0)
                chapter = parseInt(button.getAttribute('data-chapter') || 0)
                unit = parseInt(button.getAttribute('data-unit') || 0)
                quiz = parseInt(button.getAttribute('data-quiz') || 0)
            } else if (params) {
                course = params.course
                chapter = params.chapter
                unit = params.unit
                quiz = params.quiz
            }

            if (course <= 0 || chapter <= 0 || unit <= 0 || quiz <= 0) {
                $quizModal.modal('hide')
                return;
            }
            currentCourseId = course
            currentChapterId = chapter
            currentUnitId = unit
            currentQuizId = quiz

            loadQuiz(unit);
        });

        $quizModal.on('hidden.bs.modal', function () {
            quizData = null;
            currentQuestionIndex = 0;
            selectedAnswer = null;
            isAnswered = false;
            currentChapterId = null;
            currentUnitId = null;
            currentQuizId = null;
            wrongAnswers = {};
            $quizContent.html('<div class="d-flex justify-content-center align-items-center" style="height: 100%;"><div class="spinner-border" role="status"><span class="sr-only">{{__('加载中...')}}</span></div></div>');
        });

        window.setQuizData = function (quiz) {
            if (quiz) {
                renderQuiz(quiz);
            }
        };
    });
</script>
