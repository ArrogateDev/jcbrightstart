<div id="quiz-content">
    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('加载中...')}}</span>
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
            } else {
                // 如果没有传入quiz参数，清空quizData，确保不会使用旧数据
                quizData = null;
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

                // 总是重新加载当前单元的数据，确保使用最新的数据
                showQuizLoading();
                loadQuiz(currentUnitId, true);
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
            $unitItem.attr('data-status', newStatus)

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

            // 先清空内容区域，避免显示上一个单元的内容
            showQuizLoading();
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
                    const totalQuestions = parseInt(stats.total_questions) || 0;
                    const answered = parseInt(stats.answered) || 0;
                    const correctRate = parseFloat(stats.correct_rate) || 0;
                    const isAllCompleted = stats.is_all_completed || false;
                    const hasSignature = stats.has_signature || false;
                    const certificateFile = stats.certificate_file || null;
                    const nextUnit = stats.next_unit || null;

                    // 根据状态确定按钮文本和类型
                    let mainButtonText = '{{__('下一个单元')}}';
                    let mainButtonClass = 'btn-primary';
                    let mainButtonAction = 'next-unit';

                    if (isAllCompleted && !hasSignature) {
                        // 完成所有测验但没设置签名 -> 设置签名
                        mainButtonText = '{{__('确定证书姓名及下载')}}';
                        mainButtonClass = 'btn-warning';
                        mainButtonAction = 'set-signature';
                    }

                    const html = `
                        <div class="quiz-statistics">
                            <div class="quiz-statistics-icon">🎉</div>
                            <h4 class="quiz-statistics-title">{{__('测验完成')}}</h4>
                            <div class="quiz-statistics-progress">
                                <h1>${answered} / ${totalQuestions}</h1>
                                <div class="progress-value">
                                    ${isNaN(correctRate) ? 0 : Math.round(correctRate)}%
                                </div>
                            </div>
                            <div class="quiz-statistics-btn">
                                <button class="btn ${mainButtonClass} w-100 p-3 mb-4 btn-main-action"
                                    data-action="${mainButtonAction}"
                                    data-certificate-file="${certificateFile || ''}"
                                    data-next-unit-id="${nextUnit ? nextUnit.id : ''}"
                                    data-next-chapter-id="${nextUnit ? nextUnit.chapter_id : ''}"
                                    ${mainButtonAction === 'no-action' ? 'disabled' : ''}>${mainButtonText}</button>
                                <button class="btn btn-light w-100 p-3 mb-4 btn-review">{{__('复习答案')}}</button>
                                <button class="btn btn-danger w-100 p-3 mb-4 btn-close">{{__('关闭')}}</button>
                            </div>
                        </div>
                    `;
                    $quizContent.html(html);

                    // 初始化圆形进度条
                    if (typeof initCircleProgress === 'function') {
                        initCircleProgress();
                    } else {
                        // 简单的圆形进度条初始化
                        $('.circle-progress').each(function () {
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

                    // 绑定按钮事件
                    $('.btn-main-action').off('click').on('click', function () {
                        const $btn = $(this);
                        const action = $btn.data('action');

                        if (action === 'download-certificate') {
                            // 下载证书
                            const certificateFile = $btn.data('certificate-file');
                            if (certificateFile) {
                                window.open(`/download.html?file=${encodeURIComponent(certificateFile)}`, '_blank');
                            } else {
                                showToast('error', '{{__('证书文件不存在')}}');
                            }
                        } else if (action === 'set-signature') {
                            // 设置签名，关闭当前窗口并显示证书填写框
                            $learnModal.modal('hide');
                            $('#course-certificate').val(currentCourseId)
                            setTimeout(function () {
                                $('#course-complete-box').modal('show');
                            }, 300);
                        } else if (action === 'next-unit') {
                            // 跳转到下一单元
                            findAndOpenNextUnit();
                        }
                    });

                    $('.btn-review').off('click').on('click', function () {
                        // 点击复习答案，总是重新加载当前单元的数据，确保使用最新的数据
                        showQuizLoading();
                        loadQuiz(currentUnitId, true);
                    });

                    $('.btn-close').off('click').on('click', function () {
                        // 点击关闭，关闭窗口
                        $learnModal.modal('hide');
                    });
                },
                error: function () {
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

        // 查找并打开下一单元（优先查找 status=0 的单元）
        function findAndOpenNextUnit() {
            if (!currentUnitId) {
                showToast('warning', '{{__('无法确定当前单元')}}');
                return;
            }

            // 获取所有单元项
            const $allUnits = $('.unit-item');
            if ($allUnits.length === 0) {
                showToast('warning', '{{__('未找到单元列表')}}');
                return;
            }

            let foundUnit = $('.unit-item[data-status=0]').eq(0);
            if (!foundUnit) {
                foundUnit = $('.unit-item[data-status=1]').eq(0);
            }

            if (!foundUnit) {
                showToast('info', '{{__('没有找到下一个未开始的单元')}}');
                return;
            }

            // 获取单元信息
            const unitInfo = foundUnit.data('info') || {};
            const unitId = parseInt(foundUnit.data('unit') || 0);
            const status = parseInt(foundUnit.data('status') || 0);

            const title = foundUnit.data('title') || ''
            $('#learn-label').text(title);

            // 如果没有链接，根据状态手动打开
            if (status === 0 || status === 2) {
                // status=0 或 status=2，打开播放内容
                const playPosition = unitInfo.play_position || 0;
                window.openPlay(unitId, playPosition);
            } else if (status === 1) {
                // status=1，打开测验
                const params = {
                    course: parseInt(unitInfo.course_id || currentCourseId || 0),
                    chapter: parseInt(unitInfo.chapter_id || 0),
                    unit: unitId,
                    quiz: parseInt(unitInfo.quiz_id || 0),
                };
                window.openQuiz(params);
            }
        }

        // 打开测验的统一入口
        window.openQuiz = function (paramsOrEl) {
            const params = parseQuizParams(paramsOrEl);
            if (!params) return;

            // 重置测验状态，确保新单元开始时状态是干净的
            resetQuizState();

            // 立即清空内容区域，避免显示上一个单元的内容
            showQuizLoading();

            // 确保切换到quiz tab
            $('#learn-tabs a[href="#learn-quiz"]').tab('show');

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

            // 清空旧的测验数据，确保不会显示上一个单元的内容
            quizData = null;
            answeredQuestionsList = [];
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
                            // 已完成，保存测验数据并直接显示统计内容
                            quizData = response.data;
                            answeredQuestionsList = answeredQuestions;
                            showQuizStatistics();
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
            if (!$learnModal.hasClass('show')) return;

            // 如果已经有当前单元的数据，且quizData存在，说明已经加载过了，不需要重复加载
            const lastUnit = parseInt($learnModal.data('lastUnit') || 0);
            if (!lastUnit) return;

            // 检查当前单元ID是否匹配，如果匹配且quizData存在，说明已经加载了当前单元的数据
            if (currentUnitId === lastUnit && quizData) return;

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
    });
</script>
