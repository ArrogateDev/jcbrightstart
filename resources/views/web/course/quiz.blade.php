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
        const LOADING_HTML = '<div class="d-flex justify-content-center align-items-center" style="height: 100%;"><div class="spinner-border" role="status"><span class="sr-only">{{__('加载中...')}}</span></div></div>';

        let quizData = null;
        let currentQuestionIndex = 0;
        let isAnswered = false;
        let currentCourseId = {{ $course->id }};
        let currentChapterId = null;
        let currentUnitId = null;
        let currentQuizId = null;
        let wrongAnswers = {};
        let isAllCompleted = false;
        let answeredQuestionsList = []; // 保存已答题列表

        // 重置状态
        function resetQuizState() {
            quizData = null;
            currentQuestionIndex = 0;
            isAnswered = false;
            currentChapterId = null;
            currentUnitId = null;
            currentQuizId = null;
            wrongAnswers = {};
            isAllCompleted = false;
            answeredQuestionsList = [];
        }

        // 显示加载状态（仅用于quiz内容区域）
        function showQuizLoading() {
            $quizContent.html(LOADING_HTML);
        }

        // 渲染开始页面
        function renderQuizStart(quiz = null) {
            if (quiz) {
                quizData = quiz;
            }

            isAnswered = false;
            $learnModal.find('.modal-footer').hide();

            const startHtml = `
                <div class="quiz-start w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                    <div class="quiz-line"></div>
                    <div class="text-center px-8">
                        <div class="display-4 mb-5">{{__('测验准备就绪')}}</div>
                        <p class="mb-5">{{__('您已完成本单元内容的学习，点击下方按钮开始测验')}}</p>
                        <button type="button" id="quiz-start-button">🎯 {{__('开始测验')}}</button>
                    </div>
                    <div class="quiz-line"></div>
                </div>
            `;

            $quizContent.html(startHtml);

            $('#quiz-start-button').off('click').on('click', function () {
                if (!currentUnitId) return;

                if (quizData) {
                    renderQuiz(quizData);
                } else {
                    showQuizLoading();
                    loadQuiz(currentUnitId, true);
                }
            });
        }

        // 加载测验数据
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

                    if (!response.data || !response.data.questions || !Array.isArray(response.data.questions) || response.data.questions.length === 0) {
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
                    showToast('error', '{{__('加载失败，请重试')}}');
                }
            });
        }

        // 渲染测验题目
        function renderQuiz(quiz) {
            if (!quiz || !quiz.questions || !Array.isArray(quiz.questions) || quiz.questions.length === 0) {
                showToast('error', '{{__('测验数据无效')}}');
                return;
            }

            quizData = quiz;
            isAnswered = false;

            getAnsweredQuestions(function (data) {
                const answeredQuestions = data.answered_questions || [];
                answeredQuestionsList = answeredQuestions; // 保存已答题列表
                let startIndex = 0;

                // 找到第一个未答题的题目
                for (let i = 0; i < quiz.questions.length; i++) {
                    if (!answeredQuestions.includes(i)) {
                        startIndex = i;
                        break;
                    }
                }

                currentQuestionIndex = startIndex;
                const total = quiz.questions.length;
                const progress = Math.floor((startIndex + 1) / total * 100);

                let html = '<div class="quiz-container p-4">';
                html += '<div class="quiz-progress">';
                html += `<span>{{__('第')}} <strong>${startIndex + 1}</strong> {{__('题，共')}} <strong>${total}</strong> {{__('题')}}</span>`;
                html += `<span>${progress}%</span>`;
                html += '</div>';
                html += `<div class="progress mb-3"><div class="progress-bar" role="progressbar" style="width: ${progress}%" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100"></div></div>`;

                quiz.questions.forEach((question, index) => {
                    html += renderQuestion(question, index);
                });

                html += '</div>';
                $quizContent.html(html);
                $learnModal.find('.modal-footer').show();
                showQuestion(startIndex);
                updateNavigationButtons();
            });
        }

        // 获取已答题列表
        function getAnsweredQuestions(callback) {
            if (!currentCourseId || !currentChapterId || !currentUnitId || !currentQuizId) {
                callback({answered_questions: [], completed_questions: []});
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
                    callback({answered_questions: [], completed_questions: []});
                }
            });
        }

        // 渲染单个题目
        function renderQuestion(question, index) {
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

        // 显示指定题目
        function showQuestion(index) {
            if (!quizData || !quizData.questions || index < 0 || index >= quizData.questions.length) {
                return;
            }

            $('.quiz-question').removeClass('active');
            const $question = $(`.quiz-question[data-question-index="${index}"]`);
            $question.addClass('active');

            updateProgress(index);
            isAnswered = $question.data('answered') || false;

            // 检查题目是否已答过
            const isQuestionAnswered = answeredQuestionsList.includes(index);

            $question.find('.quiz-option').removeClass('disabled selected correct incorrect');
            $question.find('.quiz-option-label').removeClass('fa fa-check fa-times');
            $question.find('.quiz-explanation').removeClass('show');

            // 如果题目已答过，显示正确答案
            if (isQuestionAnswered) {
                isAnswered = true;
                const question = quizData.questions[index];
                const correctAnswer = parseInt(question.correct_answer, 10) || 0;

                // 标记正确答案
                const $correctOption = $question.find(`.quiz-option[data-option-index="${correctAnswer}"]`);
                $correctOption.addClass('correct');
                $correctOption.find('.quiz-option-label').addClass('fa fa-check');

                // 禁用所有选项
                $question.find('.quiz-option').addClass('disabled');

                // 显示解析
                $question.find('.quiz-explanation').addClass('show');

                // 标记为已答
                $question.attr('data-answered', true);

                // 移除选项点击事件（已答题不能再点击）
                $question.find('.quiz-option').off('click');
            } else {
                // 绑定选项点击事件
                bindOptionClick($question, index);
            }

            if (isAnswered) {
                $learnModal.find('.next-btn').show().removeClass('disabled').prop('disabled', false);
            } else {
                $learnModal.find('.next-btn').hide().addClass('disabled');
            }
        }

        // 绑定选项点击事件处理
        function bindOptionClick($question, questionIndex) {
            $question.find('.quiz-option').off('click').on('click', function () {
                if (isAnswered || $question.data('saving')) return;

                const $option = $(this);
                const optionIndex = parseInt($option.data('option-index'), 10);
                const question = quizData.questions[questionIndex];
                const correctAnswer = parseInt(question.correct_answer, 10) || 0;

                $question.find('.quiz-option').removeClass('selected');
                $option.addClass('selected');

                if (optionIndex === correctAnswer) {
                    $question.data('saving', true);
                    handleCorrectAnswer($question, $option, questionIndex, correctAnswer);
                } else {
                    handleIncorrectAnswer($option, questionIndex, optionIndex);
                }
            });
        }

        // 处理正确答案
        function handleCorrectAnswer($question, $option, questionIndex, correctAnswer) {
            $option.addClass('correct');
            $option.find('.quiz-option-label').addClass('fa fa-check');
            $question.find(`.quiz-option[data-option-index="${correctAnswer}"]`).addClass('correct');
            $question.find('.quiz-explanation').addClass('show');
            $question.find('.quiz-option').addClass('disabled');
            isAnswered = true;

            showLoading($learnModal);

            $question.find('.quiz-option').off('click');

            const wrongAnswer = wrongAnswers[questionIndex];
            saveQuizAnswer(questionIndex, correctAnswer, wrongAnswer)
                .then(function (response) {
                    // 隐藏loading
                    if (typeof hideLoading === 'function') {
                        hideLoading();
                    }

                    delete wrongAnswers[questionIndex];
                    $question.attr('data-answered', true);

                    // 更新已答题列表
                    if (!answeredQuestionsList.includes(questionIndex)) {
                        answeredQuestionsList.push(questionIndex);
                    }

                    const isLast = questionIndex === quizData.questions.length - 1;
                    const $nextBtn = $learnModal.find('.next-btn');
                    $nextBtn.show().removeClass('disabled').prop('disabled', false);

                    if (isLast) {
                        // 最后一题完成，保存是否全部完成的状态
                        isAllCompleted = response.completed === true;
                    }

                    // 更新导航按钮（会在最后一题时显示"完成"按钮）
                    updateNavigationButtons();
                    $question.data('saving', false);
                })
                .catch(function (error) {
                    console.error('保存答案失败:', error);
                    showToast('error', '{{__('保存答案失败，请重试')}}');
                    // 恢复选项点击（允许重试）
                    isAnswered = false;
                    $question.data('saving', false);
                    $question.find('.quiz-option').removeClass('disabled');
                    // 重新绑定点击事件
                    bindOptionClick($question, questionIndex);
                })
                .finally(function () {
                    hideLoading($learnModal);
                });
        }

        // 处理错误答案
        function handleIncorrectAnswer($option, questionIndex, optionIndex) {
            $option.addClass('incorrect');
            $option.find('.quiz-option-label').addClass('fa fa-times');
            if (wrongAnswers[questionIndex] === undefined) {
                wrongAnswers[questionIndex] = optionIndex;
            }
        }

        // 更新单元状态
        function updateUnitStatus(unitId, newStatus) {
            const $unitItem = $(`li[data-unit="${unitId}"]`);
            if (!$unitItem.length) return;

            const $actionDiv = $unitItem.find('.unit-status');
            if (!$actionDiv.length) return;

            const unitInfo = $unitItem.data('info') || {};
            if (unitInfo) {
                unitInfo.status = newStatus;
                $unitItem.data('info', unitInfo);
            }

            if (newStatus === 2) {
                const playPosition = unitInfo.play_position || 0;
                $actionDiv.html(`
                    <a href="#" class="preview-link" data-toggle="modal" data-target="#learn-box" data-tab="play"
                       data-unit="${unitId}" data-status="2" data-play-position="${playPosition}">{{__('打开')}}</a>
                    <i class="fa-solid fa-circle-check text-success ml-3"></i>
                `);
            } else if (newStatus === 1) {
                $actionDiv.html(`
                    <a href="#" class="preview-link" data-toggle="modal" data-target="#learn-box" data-tab="quiz"
                       data-course="${unitInfo.course_id || 0}" data-chapter="${unitInfo.chapter_id || 0}"
                       data-unit="${unitId}" data-quiz="${unitInfo.quiz_id || 0}" data-status="1">{{__('测验')}}</a>
                    <i class="fa-solid fa-book text-warning ml-3"></i>
                `);
            }
        }

        // 显示统计内容
        function showQuizStatistics() {
            if (!currentCourseId || !currentChapterId || !currentUnitId || !currentQuizId) {
                showToast('error', '{{__('参数错误')}}');
                return;
            }

            showLoading($learnModal);
            $learnModal.find('.modal-footer').hide();

            // 获取统计信息
            $.ajax({
                url: `/course/${currentCourseId}/quiz-statistics.html`,
                type: 'GET',
                data: {
                    chapter_id: currentChapterId,
                    unit_id: currentUnitId,
                    quiz_id: currentQuizId,
                },
                dataType: 'json',
                success: function (response) {
                    hideLoading($learnModal);
                    if (response.code !== 0) {
                        showToast('error', response.msg || '{{__('获取统计信息失败')}}');
                        return;
                    }

                    const stats = response.data || {};
                    const totalQuestions = parseInt(stats.total_questions) || quizData.questions.length;
                    const correct = parseInt(stats.correct) || 0;
                    const incorrect = parseInt(stats.incorrect) || 0;
                    const correctRate = parseFloat(stats.correct_rate) || 0;
                    const passed = correctRate >= 80;

                    const html = `
                        <div class="quiz-statistics p-4">
                            <div class="text-center mb-4">
                                <div class="quiz-statistics-icon mb-3">
                                    <i class="fa-solid fa-circle-check fa-3x ${passed ? 'text-success' : 'text-danger'}"></i>
                                </div>
                                <h4 class="mb-2">{{__('测验完成')}}</h4>
                                <div class="quiz-statistics-progress mb-3">
                                    <div class="circle-progress" data-value="${isNaN(correctRate) ? 0 : Math.round(correctRate)}">
                                        <span class="progress-left">
                                            <span class="progress-bar ${passed ? 'border-success' : 'border-danger'}"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar ${passed ? 'border-success' : 'border-danger'}"></span>
                                        </span>
                                        <div class="progress-value ${passed ? 'text-success' : 'text-danger'} fw-bold fs-24">
                                            ${isNaN(correctRate) ? 0 : Math.round(correctRate)}%
                                        </div>
                                    </div>
                                    <p class="text-center fs-14 mt-2">Pass Score : 80%</p>
                                </div>
                                <div class="quiz-statistics-message mb-3">
                                    ${passed
                                        ? '<h6 class="mb-1">{{__('恭喜！您通过了测验')}}</h6><p class="fs-14">{{__('您成功完成了测验。继续保持！')}}</p>'
                                        : '<h6 class="mb-1">{{__('抱歉，您这次没有通过')}}</h6><p class="fs-14">{{__('别担心，从这次尝试中学习，下次会更强！')}}</p>'
                                    }
                                </div>
                                <div class="quiz-statistics-details">
                                    <p class="mb-1"><strong>{{__('正确')}}:</strong> ${correct} / ${totalQuestions}</p>
                                    <p class="mb-1"><strong>{{__('错误')}}:</strong> ${incorrect} / ${totalQuestions}</p>
                                    <p class="mb-0"><strong>{{__('正确率')}}:</strong> ${isNaN(correctRate) ? '0.00' : correctRate.toFixed(2)}%</p>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button class="btn btn-primary" data-dismiss="modal">{{__('关闭')}}</button>
                            </div>
                        </div>
                    `;
                    $quizContent.html(html);

                    // 初始化圆形进度条
                    if (typeof initCircleProgress === 'function') {
                        initCircleProgress();
                    } else {
                        // 简单的圆形进度条初始化
                        $('.circle-progress').each(function() {
                            const $this = $(this);
                            const value = parseFloat($this.data('value')) || 0;
                            const percentage = Math.min(100, Math.max(0, value));
                            const degree = (percentage / 100) * 360;

                            if (percentage <= 50) {
                                $this.find('.progress-right .progress-bar').css('transform', `rotate(${degree}deg)`);
                            } else {
                                $this.find('.progress-right .progress-bar').css('transform', 'rotate(180deg)');
                                $this.find('.progress-left .progress-bar').css('transform', `rotate(${degree - 180}deg)`);
                            }
                        });
                    }

                    // 更新单元状态
                    if (currentUnitId) {
                        updateUnitStatus(currentUnitId, 2);
                    }

                    // 如果全部课程完成，在关闭modal后显示证书填写框
                    if (isAllCompleted) {
                        $('.btn[data-dismiss="modal"]').on('click', function() {
                            setTimeout(function() {
                                $('#course-complete-box').modal('show');
                            }, 300);
                        });
                    }
                },
                error: function () {
                    hideLoading($learnModal);
                    showToast('error', '{{__('获取统计信息失败，请重试')}}');
                }
            });
        }

        // 保存答题记录
        function saveQuizAnswer(questionIndex, userAnswer, wrongAnswer = null) {
            return new Promise(function (resolve, reject) {
                if (!currentCourseId || !currentChapterId || !currentUnitId || !currentQuizId) {
                    reject(new Error('缺少必要的参数'));
                    return;
                }

                // 如果有错误答案记录，使用错误答案
                if (wrongAnswer !== null && wrongAnswer !== undefined) {
                    const wrong = parseInt(wrongAnswer, 10);
                    if (!isNaN(wrong)) {
                        userAnswer = wrong;
                    }
                } else {
                    userAnswer = parseInt(userAnswer, 10) || 0;
                }

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
                            reject(new Error(response.msg || '{{__('保存答题记录失败')}}'));
                        } else {
                            resolve(response.data);
                        }
                    },
                    error: function (xhr) {
                        const errorMsg = xhr.responseJSON?.msg || '{{__('保存答题记录失败')}}';
                        reject(new Error(errorMsg));
                    }
                });
            });
        }

        // 解析参数（支持元素或对象）
        function parseQuizParams(paramsOrEl) {
            if (!paramsOrEl) return null;

            let course = 0, chapter = 0, unit = 0, quiz = 0;

            if (paramsOrEl.getAttribute) {
                // 元素对象
                course = parseInt(paramsOrEl.getAttribute('data-course') || 0);
                chapter = parseInt(paramsOrEl.getAttribute('data-chapter') || 0);
                unit = parseInt(paramsOrEl.getAttribute('data-unit') || 0);
                quiz = parseInt(paramsOrEl.getAttribute('data-quiz') || 0);
            } else {
                // 普通对象
                course = parseInt(paramsOrEl.course || 0);
                chapter = parseInt(paramsOrEl.chapter || 0);
                unit = parseInt(paramsOrEl.unit || 0);
                quiz = parseInt(paramsOrEl.quiz || 0);
            }

            if (course > 0 && chapter > 0 && unit > 0 && quiz > 0) {
                return {course, chapter, unit, quiz};
            }
            return null;
        }

        // 打开测验的统一入口
        window.openQuiz = function (paramsOrEl) {
            const params = parseQuizParams(paramsOrEl);
            if (!params) return;

            currentCourseId = params.course;
            currentChapterId = params.chapter;
            currentUnitId = params.unit;
            currentQuizId = params.quiz;
            $learnModal.data('lastUnit', params.unit);

            // 检查测验是否已完成，如果已完成直接进入内容，否则显示开始页
            checkQuizCompletion();
        };

        // 检查测验是否已完成
        function checkQuizCompletion() {
            if (!currentCourseId || !currentChapterId || !currentUnitId || !currentQuizId) {
                renderQuizStart();
                return;
            }

            showQuizLoading();

            // 先加载测验数据获取题目总数
            $.ajax({
                url: `/quiz/${currentUnitId}.html`,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.code !== 0 || !response.data || !response.data.questions || !Array.isArray(response.data.questions)) {
                        renderQuizStart();
                        return;
                    }

                    const totalQuestions = response.data.questions.length;
                    if (totalQuestions === 0) {
                        renderQuizStart();
                        return;
                    }

                    // 获取已答题列表
                    getAnsweredQuestions(function (data) {
                        const answeredQuestions = data.answered_questions || [];
                        const isCompleted = answeredQuestions.length >= totalQuestions;

                        if (isCompleted) {
                            // 已完成，直接渲染测验内容
                            renderQuiz(response.data);
                        } else {
                            // 未完成，显示开始页面（使用已加载的数据）
                            renderQuizStart(response.data);
                        }
                    });
                },
                error: function () {
                    renderQuizStart();
                }
            });
        }

        // Modal关闭时重置状态
        $learnModal.on('hidden.bs.modal', function () {
            resetQuizState();
            $learnModal.find('.modal-footer').hide();
            $quizContent.html(LOADING_HTML);
        });

        // 点击"测验"打开Modal时自动切换到测验Tab
        $learnModal.on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;

            const tab = button.getAttribute('data-tab') || '';
            if (tab !== 'quiz') return;

            $('#learn-tabs a[href="#learn-quiz"]').tab('show');
            window.openQuiz(button);
        });

        // 手动切换到测验Tab时自动加载
        $(document).on('shown.bs.tab', 'a[data-toggle="tab"][href="#learn-quiz"]', function () {
            if (!$learnModal.hasClass('show') || quizData) return;

            const lastUnit = parseInt($learnModal.data('lastUnit') || 0);
            if (!lastUnit) return;

            const $unitItem = $(`li[data-unit="${lastUnit}"]`);
            if (!$unitItem.length) return;

            const info = $unitItem.data('info') || {};
            const params = {
                course: parseInt(info.course_id || {{ $course->id }} || 0),
                chapter: parseInt(info.chapter_id || 0),
                unit: lastUnit,
                quiz: parseInt(info.quiz_id || 0),
            };

            window.openQuiz(params);
        });

        // 更新进度条
        function updateProgress(index = currentQuestionIndex) {
            if (!quizData || !quizData.questions) return;

            const total = quizData.questions.length;
            const progress = Math.floor((index + 1) / total * 100);
            const progressHtml = `{{__('第')}} <strong>${index + 1}</strong> {{__('题，共')}} <strong>${total}</strong> {{__('题')}}`;

            $('.quiz-progress').html(`<span>${progressHtml}</span><span>${progress}%</span>`);
            $('.progress-bar').css('width', `${progress}%`).attr('aria-valuenow', progress);
        }

        // 更新导航按钮状态
        function updateNavigationButtons() {
            const $prevBtn = $learnModal.find('.per-btn');
            const $nextBtn = $learnModal.find('.next-btn');

            $prevBtn.toggleClass('disabled', currentQuestionIndex === 0)
                .prop('disabled', currentQuestionIndex === 0);

            const isLastQuestion = currentQuestionIndex === quizData.questions.length - 1;
            const canGoNext = isAnswered;

            if (isLastQuestion && isAnswered) {
                // 最后一题且已答，显示"完成"按钮
                $nextBtn.text('{{__('完成')}}').show().removeClass('disabled').prop('disabled', false);
            } else if (isAnswered) {
                // 非最后一题且已答，显示"下一题"按钮
                $nextBtn.text('{{__('下一题')}} →').show().removeClass('disabled').prop('disabled', false);
            } else {
                // 未答题，隐藏或禁用按钮
                $nextBtn.hide().addClass('disabled').prop('disabled', true);
            }
        }

        // 导航按钮事件
        $learnModal.find('.per-btn').on('click', function () {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                showQuestion(currentQuestionIndex);
                updateNavigationButtons();
            }
        });

        $learnModal.find('.next-btn').on('click', function () {
            if (!isAnswered) {
                showToast('warning', '{{__('请先回答当前题目')}}');
                return;
            }

            const isLastQuestion = currentQuestionIndex === quizData.questions.length - 1;

            if (isLastQuestion) {
                // 最后一题，显示统计内容
                showQuizStatistics();
            } else {
                // 非最后一题，显示下一题
                currentQuestionIndex++;
                showQuestion(currentQuestionIndex);
                updateNavigationButtons();
            }
        });

        // 证书提交处理
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
                        return;
                    }

                    showToast('success', '{{__('提交成功')}}');
                    $courseCompleteModal.modal('hide');
                },
                error: function () {
                    hideLoading($courseCompleteModal.find('.modal-content'));
                    showToast('error', '{{__('提交失败，请重试')}}');
                    $submitCertificateBtn.prop('disabled', false).text('{{__('提交')}}');
                }
            });
        });

        $courseCompleteModal.on('hidden.bs.modal', function () {
            $certificateNameInput.val('');
            $submitCertificateBtn.prop('disabled', false).text('{{__('提交')}}');
        });
    });
</script>
