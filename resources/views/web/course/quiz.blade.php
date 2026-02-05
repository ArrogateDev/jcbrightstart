<div id="quiz-content">
    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('加载中...')}}</span>
        </div>
    </div>
</div>

<div class="modal fade" id="course-complete-box" tabindex="-1" aria-labelledby="course-complete-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="course-complete-label">{{__('填写证书信息')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="course-complete-form">
                    <div class="form-group">
                        <label for="certificate-name">{{__('请输入您的姓名')}}</label>
                        <input type="text" class="form-control" id="certificate-name" placeholder="{{__('请输入姓名')}}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submit-certificate-btn">{{__('提交')}}</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        const $learnModal = $('#learn-box');
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
        let isAllCompleted = false;

        function renderInitialQuizStart() {
            quizData = null;
            selectedAnswer = null;
            isAnswered = false;

            $learnModal.find('.modal-footer').hide();

            const startHtml = `
                <div class="quiz-start w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                    <div class="quiz-line"></div>
                    <div class="text-center px-8">
                        <div class="display-4 mb-5">
                            {{__('测验准备就绪')}}
                        </div>
                        <p class="mb-5">
                            {{__('您已完成本单元内容的学习，点击下方按钮开始测验')}}
                        </p>
                        <button type="button" id="quiz-start-button">
                            🎯 {{__('开始测验')}}
                        </button>
                    </div>
                    <div class="quiz-line"></div>
                </div>
            `;

            $quizContent.html(startHtml);

            $('#quiz-start-button').off('click').on('click', function () {
                if (!currentUnitId) {
                    return;
                }

                $quizContent.html('<div class="d-flex justify-content-center align-items-center" style="height: 100%;"><div class="spinner-border" role="status"><span class="sr-only">{{__('加载中...')}}</span></div></div>');
                loadQuiz(currentUnitId, true);
            });
        }

        function loadQuiz(unitId, autoStart = false) {
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
                        return;
                    }

                    if (autoStart) {
                        renderQuiz(response.data);
                    } else {
                        renderQuizStart(response.data);
                    }
                },
                error: function () {
                    showToast('error', 'Failed, please try again later')
                }
            });
        }

        function renderQuizStart(quiz) {
            if (!quiz || !quiz.questions || !Array.isArray(quiz.questions) || quiz.questions.length === 0) {
                showToast('error', '{{__('测验数据无效')}}');
                return;
            }

            quizData = quiz;
            selectedAnswer = null;
            isAnswered = false;

            const startHtml = `
                <div class="quiz-start w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                    <div class="quiz-line"></div>
                    <div class="text-center px-8">
                        <div class="display-4 mb-5">
                            {{__('测验准备就绪')}}
                        </div>
                        <p class="mb-5">
                            {{__('您已完成本单元内容的学习，点击下方按钮开始测验')}}
                        </p>
                        <button type="button" id="quiz-start-button">
                            🎯 {{__('开始测验')}}
                        </button>
                    </div>
                    <div class="quiz-line"></div>
                </div>
            `;

            $quizContent.html(startHtml);

            // 点击“开始测验”后再真正渲染题目列表
            $('#quiz-start-button').off('click').on('click', function () {
                renderQuiz(quizData);
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
                let total = quiz.questions.length;
                let progress = Math.floor((startIndex + 1) / total * 100);

                let html = '<div class="quiz-container p-4">';
                html += '<div class="quiz-progress">';
                html += `<span>{{__('第')}} <strong>${startIndex + 1}</strong> {{__('题，共')}} <strong>${total}</strong> {{__('题')}}</span>`;
                html += `<span>${progress}%</span>`;
                html += '</div>';
                html += `<div class="progress mb-3"><div class="progress-bar" role="progressbar" style="width: ${progress}%" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100"></div></div>`;

                quiz.questions.forEach((question, index) => {
                    html += renderQuestion(question, index, quiz.questions.length);
                });

                html += '</div>';
                $quizContent.html(html);

                $learnModal.find('.modal-footer').show();

                showQuestion(startIndex);

                updateNavigationButtons();
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

            let html = `<div class="quiz-question" data-question-index="${index}">`;
            html += `<div class="quiz-question-title"><div class="tag">{{__('问题')}}${index + 1}</div><div class="title">${question.title || ''}</div></div>`;
            html += '<ul class="quiz-options">';

            if (question.options && Array.isArray(question.options)) {
                question.options.forEach((option, optIndex) => {
                    html += `<li class="quiz-option" data-option-index="${optIndex}">`;
                    html += `<span class="quiz-option-label">${String.fromCharCode(65 + optIndex)}</span>`;
                    html += `<span class="quiz-option-text">${option}</span>`;
                    html += '</li>';
                });
            }

            html += '</ul>';

            html += '<div class="quiz-explanation">';
            html += '<div class="quiz-explanation-title">{{__('解析')}}</div>';
            html += `<div class="quiz-explanation-content">${question.explanation || '{{__('暂无解析')}}'}</div>`;
            html += '</div>';

            html += '</div>';
            return html;
        }

        function showQuestion(index) {
            if (!quizData || !quizData.questions || index < 0 || index >= quizData.questions.length) {
                return;
            }

            $('.quiz-question').removeClass('active');
            $learnModal.find('.next-btn').hide().addClass('disabled').prop('disabled', false);

            const $question = $(`.quiz-question[data-question-index="${index}"]`);
            $question.addClass('active');
            let total = quizData.questions.length;
            let progress = Math.floor((index + 1) / total * 100);
            $('.quiz-progress').html(`<span>{{__('第')}} <strong>${index + 1}</strong> {{__('题，共')}} <strong>${quizData.questions.length}</strong> {{__('题')}}</span><span>${progress}%</span>`);

            selectedAnswer = null;
            isAnswered = $question.data('answered') || false;
            $question.find('.quiz-option').removeClass('disabled');
            $question.find('.quiz-explanation').removeClass('show');
            if (isAnswered) {
                $learnModal.find('.next-btn').show().removeClass('disabled').prop('disabled', false);
            }

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
                    $option.addClass('correct');
                    $option.find('.quiz-option-label').addClass('fa fa-check');

                    $question.find(`.quiz-option[data-option-index="${correctAnswer}"]`).addClass('correct');

                    if (!$question.find('.quiz-explanation').hasClass('show')) {
                        $question.find('.quiz-explanation').addClass('show');
                    }

                    $question.find('.quiz-option').addClass('disabled');

                    isAnswered = true;

                    const wrongAnswer = wrongAnswers[index] !== undefined ? wrongAnswers[index] : null;

                    saveQuizAnswer(index, optionIndex, wrongAnswer)
                        .then(function (response) {
                            delete wrongAnswers[index];

                            $question.attr('data-answered', true)
                            $learnModal.find('.next-btn').show().removeClass('disabled').prop('disabled', false);
                            const isLast = index === quizData.questions.length - 1;
                            if (isLast) {
                                if (response.completed === true) {
                                    isAllCompleted = true;
                                    showComplete(true);
                                } else {
                                    isAllCompleted = false;
                                    $learnModal.find('.next-btn').text('{{__('完成')}}');
                                }
                            } else {
                                $learnModal.find('.next-btn').text('{{__('下一题')}} →');
                            }
                        })
                        .catch(function (error) {
                            console.error('保存答案失败:', error);
                            showToast('error', '{{__('保存答案失败，请重试')}}');
                        });
                } else {
                    $option.addClass('incorrect');
                    $option.find('.quiz-option-label').addClass('fa fa-times');

                    if (wrongAnswers[index] === undefined) {
                        wrongAnswers[index] = optionIndex;
                    }
                }
            });

            $question.find('.quiz-next-btn').off('click').on('click', function () {
                // 只有答对题目后才能点击下一题
                if (!isAnswered) {
                    showToast('warning', '{{__('请先回答当前题目')}}');
                    return;
                }

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
                    <a href="#" class="preview-link" data-toggle="modal" data-target="#learn-box" data-tab="play"
                       data-unit="${unitId}"
                       data-status="2"
                       data-play-position="${playPosition}">{{__('打开')}}</a>
                    <i class="fa-solid fa-circle-check text-success ml-3"></i>
                `);
            } else if (newStatus === 1) {
                const courseId = unitInfo ? (unitInfo.course_id || 0) : 0;
                const chapterId = unitInfo ? (unitInfo.chapter_id || 0) : 0;
                const quizId = unitInfo ? (unitInfo.quiz_id || 0) : 0;

                $actionDiv.html(`
                    <a href="#" class="preview-link" data-toggle="modal" data-target="#learn-box" data-tab="quiz"
                       data-course="${courseId}"
                       data-chapter="${chapterId}"
                       data-unit="${unitId}"
                       data-quiz="${quizId}"
                       data-status="1">{{__('测验')}}</a>
                    <i class="fa-solid fa-book text-warning ml-3"></i>
                `);
            }
        }

        function showComplete(allCompleted = false) {
            if (currentUnitId) {
                updateUnitStatus(currentUnitId, 2);
            }

            // 隐藏导航按钮
            $learnModal.find('.modal-footer').hide();

            let html = '<div class="quiz-complete">';
            html += '<div class="quiz-complete-icon"><i class="fa-solid fa-circle-check"></i></div>';
            html += '<div class="quiz-complete-title">{{__('测验完成')}}</div>';
            if (allCompleted) {
                html += '<div class="quiz-complete-message">{{__('恭喜您完成了所有课程！')}}</div>';
            } else {
                html += '<div class="quiz-complete-message">{{__('恭喜您完成了本次测验！')}}</div>';
            }
            if (!allCompleted) {
                html += '<button class="btn btn-primary" data-dismiss="modal">{{__('关闭')}}</button>';
            }
            html += '</div>';
            $quizContent.html(html);

            if (allCompleted) {
                setTimeout(function () {
                    $quizModal.modal('hide');
                    setTimeout(function () {
                        $('#course-complete-box').modal('show');
                    }, 300);
                }, 1500);
            }
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
                showLoading($('#learn-box .modal-content'))

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
                        hideLoading($('#learn-box .modal-content'))
                        if (response.code !== 0) {
                            console.error('保存答题记录失败:', response.msg);
                            reject(new Error(response.msg || '保存答题记录失败'));
                        } else {
                            console.log('答题记录保存成功:', response.data);
                            resolve(response.data);
                        }
                    },
                    error: function (xhr) {
                        hideLoading($('#learn-box .modal-content'))
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

        $learnModal.on('hidden.bs.modal', function () {
            quizData = null;
            currentQuestionIndex = 0;
            selectedAnswer = null;
            isAnswered = false;
            currentChapterId = null;
            currentUnitId = null;
            currentQuizId = null;
            wrongAnswers = {};
            isAllCompleted = false;

            $learnModal.find('.modal-footer').hide();
            $quizContent.html('<div class="d-flex justify-content-center align-items-center" style="height: 100%;"><div class="spinner-border" role="status"><span class="sr-only">{{__('加载中...')}}</span></div></div>');
        });

        // 统一入口：切换到测验Tab后调用，或播放结束自动切换调用
        window.openQuiz = function (paramsOrEl) {
            let course = 0, chapter = 0, unit = 0, quiz = 0;
            // 允许传入 params 对象 或 触发按钮元素
            if (paramsOrEl && paramsOrEl.getAttribute) {
                course = parseInt(paramsOrEl.getAttribute('data-course') || 0);
                chapter = parseInt(paramsOrEl.getAttribute('data-chapter') || 0);
                unit = parseInt(paramsOrEl.getAttribute('data-unit') || 0);
                quiz = parseInt(paramsOrEl.getAttribute('data-quiz') || 0);
            } else if (paramsOrEl) {
                course = parseInt(paramsOrEl.course || 0);
                chapter = parseInt(paramsOrEl.chapter || 0);
                unit = parseInt(paramsOrEl.unit || 0);
                quiz = parseInt(paramsOrEl.quiz || 0);
            }

            if (course <= 0 || chapter <= 0 || unit <= 0 || quiz <= 0) {
                return;
            }
            currentCourseId = course;
            currentChapterId = chapter;
            currentUnitId = unit;
            currentQuizId = quiz;
            // 缓存最近一次unit，方便切回播放Tab自动打开
            $('#learn-box').data('lastUnit', unit);
            // 打开测验时，先展示“开始测验”页，真正加载题目在点击按钮后进行
            renderInitialQuizStart();
        };

        // 点击“测验”打开 learn-box 时：自动切到测验Tab并加载
        $learnModal.on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;
            const tab = button.getAttribute('data-tab') || '';
            if (tab !== 'quiz') return;
            $('#learn-tabs a[href="#learn-quiz"]').tab('show');
            window.openQuiz(button);
        });

        // 从“内容”Tab 手动切换到“测验”Tab 时，如果当前没有加载测验，则自动根据 lastUnit 加载
        $(document).on('shown.bs.tab', 'a[data-toggle="tab"][href="#learn-quiz"]', function () {
            // modal 没打开或已经有 quizData 就不用再加载
            if (!$learnModal.hasClass('show') || quizData) {
                return;
            }

            const lastUnit = parseInt($learnModal.data('lastUnit') || 0);
            if (!lastUnit) {
                return;
            }

            const $unitItem = $(`li[data-unit="${lastUnit}"]`);
            if (!$unitItem.length) {
                return;
            }

            const info = $unitItem.data('info') || {};

            const params = {
                course: parseInt(info.course_id || {{ $course->id }} || 0),
                chapter: parseInt(info.chapter_id || 0),
                unit: lastUnit,
                quiz: parseInt(info.quiz_id || 0),
            };

            if (params.course > 0 && params.chapter > 0 && params.unit > 0 && params.quiz > 0) {
                window.openQuiz(params);
            }
        });

        const $courseCompleteModal = $('#course-complete-box');
        const $certificateNameInput = $('#certificate-name');
        const $submitCertificateBtn = $('#submit-certificate-btn');

        $submitCertificateBtn.on('click', function () {
            const name = $certificateNameInput.val().trim();
            if (!name) {
                showToast('error', '{{__('请输入姓名')}}');
                $certificateNameInput.focus();
                return;
            }

            $submitCertificateBtn.prop('disabled', true).text('{{__('提交中...')}}');
            showLoading($courseCompleteModal.find('.modal-content'));

            $.ajax({
                url: `/course/${currentCourseId}/certificate.html`,
                type: 'POST',
                data: {
                    name: name,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (response) {
                    hideLoading($courseCompleteModal.find('.modal-content'));
                    if (response.code !== 0) {
                        showToast('error', response.msg || '{{__('提交失败')}}');
                        $submitCertificateBtn.prop('disabled', false).text('{{__('提交')}}');
                        return
                    }

                    showToast('success', '{{__('提交成功')}}');
                    $courseCompleteModal.modal('hide');
                    // 可以在这里处理成功后的逻辑，比如跳转或显示证书
                },
                error: function () {
                    hideLoading($courseCompleteModal.find('.modal-content'));
                    showToast('error', 'Failed, please try again later')
                    $submitCertificateBtn.prop('disabled', false).text('{{__('提交')}}');
                }
            });
        });

        $courseCompleteModal.on('hidden.bs.modal', function () {
            $certificateNameInput.val('');
            $submitCertificateBtn.prop('disabled', false).text('{{__('提交')}}');
        });

        // 导航按钮事件处理
        $learnModal.find('.per-btn').on('click', function () {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                showQuestion(currentQuestionIndex);
                // 更新进度条
                updateProgress();
                // 更新按钮状态
                updateNavigationButtons();
            }
        });

        $learnModal.find('.next-btn').on('click', function () {
            // 只有答对题目后才能使用导航按钮跳转
            if (!isAnswered) {
                showToast('warning', '{{__('请先回答当前题目')}}');
                return;
            }

            if (currentQuestionIndex < quizData.questions.length - 1) {
                currentQuestionIndex++;
                showQuestion(currentQuestionIndex);
                // 更新进度条
                updateProgress();
                // 更新按钮状态
                updateNavigationButtons();
            }
        });

        // 更新进度条函数
        function updateProgress() {
            if (!quizData || !quizData.questions) return;

            let total = quizData.questions.length;
            let progress = Math.floor((currentQuestionIndex + 1) / total * 100);

            $('.quiz-progress span').html(`{{__('第')}} <strong>${currentQuestionIndex + 1}</strong> {{__('题，共')}} <strong>${total}</strong> {{__('题')}}`);
            $('.progress-bar').css('width', `${progress}%`).attr('aria-valuenow', progress);
        }

        // 更新导航按钮状态
        function updateNavigationButtons() {
            const $prevBtn = $learnModal.find('.per-btn');
            const $nextBtn = $learnModal.find('.next-btn');

            // 上一题按钮：只有不是第一题时才可点击
            if (currentQuestionIndex > 0) {
                $prevBtn.removeClass('disabled').prop('disabled', false);
            } else {
                $prevBtn.addClass('disabled').prop('disabled', true);
            }

            // 下一题按钮：只有答对当前题目且不是最后一题时才可点击
            const isCurrentAnswered = isAnswered;
            if (currentQuestionIndex < quizData.questions.length - 1 && isCurrentAnswered) {
                $nextBtn.removeClass('disabled').prop('disabled', false);
            } else {
                $nextBtn.addClass('disabled').prop('disabled', true);
            }
        }
    });
</script>

<style>
    .modal-footer .btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }

    .modal-footer .btn.disabled:hover {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
        transform: none !important;
    }

    /* 题目内的下一题按钮样式 */
    .quiz-next-btn.disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background-color: #6c757d !important;
    }

    .quiz-next-btn:not(.disabled) {
        background-color: #007bff !important;
    }
</style>
