<style>
    #quiz-box .modal-body {
        padding: 2rem;
        min-height: 400px;
    }

    .quiz-question {
        display: none;
    }

    .quiz-question.active {
        display: block;
    }

    .quiz-question-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #333;
    }

    .quiz-options {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .quiz-option {
        padding: 1rem;
        margin-bottom: 0.75rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .quiz-option:hover {
        border-color: #5625e8;
        background-color: #f8f9ff;
    }

    .quiz-option.selected {
        border-color: #5625e8;
        background-color: #f0f2ff;
    }

    .quiz-option.correct {
        border-color: #28a745;
        background-color: #d4edda;
    }

    .quiz-option.incorrect {
        border-color: #dc3545;
        background-color: #f8d7da;
    }

    .quiz-option.disabled {
        cursor: not-allowed;
        opacity: 0.7;
    }

    .quiz-option-label {
        font-weight: 500;
        margin-right: 0.5rem;
        color: #5625e8;
    }

    .quiz-option-text {
        color: #333;
    }

    .quiz-explanation {
        margin-top: 1.5rem;
        padding: 1rem;
        border-radius: 8px;
        display: none;
    }

    .quiz-explanation.show {
        display: block;
    }

    .quiz-explanation.error {
        background-color: #f8d7da;
        border-left: 4px solid #dc3545;
    }

    .quiz-explanation-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #dc3545;
    }

    .quiz-explanation-content {
        color: #721c24;
        margin-bottom: 0.5rem;
    }

    .quiz-correct-answer {
        color: #155724;
        font-weight: 500;
    }

    .quiz-progress {
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        color: #666;
    }

    .quiz-actions {
        margin-top: 1.5rem;
        text-align: right;
    }

    .quiz-next-btn {
        display: none;
    }

    .quiz-next-btn.show {
        display: inline-block;
    }

    .quiz-complete {
        text-align: center;
        padding: 2rem;
    }

    .quiz-complete-icon {
        font-size: 4rem;
        color: #28a745;
        margin-bottom: 1rem;
    }

    .quiz-complete-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .quiz-complete-message {
        color: #666;
        margin-bottom: 1.5rem;
    }
</style>

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

        function loadQuiz(unitId) {
            // 从页面中获取单元信息
            const $unit = $(`li[data-unit="${unitId}"]`);
            if (!$unit.length) {
                showError('{{__('未找到单元信息')}}');
                return;
            }

            const unitInfo = $unit.data('info');
            if (!unitInfo || !unitInfo.quiz_id) {
                showError('{{__('该单元没有关联的测验')}}');
                return;
            }

            // 获取quiz详情
            const quizId = unitInfo.quiz_id;
            loadQuizById(quizId);
        }

        function loadQuizById(quizId) {
            if (!quizId) {
                showError('{{__('测验ID无效')}}');
                return;
            }

            $.ajax({
                url: `/quiz/${quizId}.html`,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.code !== 0) {
                        showError(response.msg || '{{__('获取测验数据失败')}}');
                        return;
                    }

                    if (response.data) {
                        renderQuiz(response.data);
                    } else {
                        showError('{{__('测验数据为空')}}');
                    }
                },
                error: function (xhr) {
                    let errorMsg = '{{__('获取测验数据失败')}}';
                    if (xhr.responseJSON && xhr.responseJSON.msg) {
                        errorMsg = xhr.responseJSON.msg;
                    }
                    showError(errorMsg);
                }
            });
        }

        function renderQuiz(quiz) {
            if (!quiz || !quiz.questions || !Array.isArray(quiz.questions) || quiz.questions.length === 0) {
                showError('{{__('测验数据无效')}}');
                return;
            }

            quizData = quiz;
            currentQuestionIndex = 0;
            selectedAnswer = null;
            isAnswered = false;

            let html = '<div class="quiz-container">';
            html += '<div class="quiz-progress">';
            html += `<span>{{__('第')}} <strong>1</strong> {{__('题，共')}} <strong>${quiz.questions.length}</strong> {{__('题')}}</span>`;
            html += '</div>';

            // 渲染所有题目
            quiz.questions.forEach((question, index) => {
                html += renderQuestion(question, index, quiz.questions.length);
            });

            html += '</div>';
            $quizContent.html(html);

            // 显示第一题
            showQuestion(0);
        }

        function renderQuestion(question, index, totalQuestions) {
            const isLastQuestion = index === totalQuestions - 1;
            const buttonText = isLastQuestion ? '{{__('提交')}}' : '{{__('下一题')}}';
            
            let html = `<div class="quiz-question" data-question-index="${index}">`;
            html += `<div class="quiz-question-title">${index + 1}. ${escapeHtml(question.title || '')}</div>`;
            html += '<ul class="quiz-options">';

            if (question.options && Array.isArray(question.options)) {
                question.options.forEach((option, optIndex) => {
                    const optionText = typeof option === 'string' ? option : (option.text || option);
                    html += `<li class="quiz-option" data-option-index="${optIndex}">`;
                    html += `<span class="quiz-option-label">${String.fromCharCode(65 + optIndex)}.</span>`;
                    html += `<span class="quiz-option-text">${escapeHtml(optionText)}</span>`;
                    html += '</li>';
                });
            }

            html += '</ul>';

            // 解释区域
            html += '<div class="quiz-explanation">';
            html += '<div class="quiz-explanation-title">{{__('解析')}}</div>';
            html += `<div class="quiz-explanation-content">${escapeHtml(question.explanation || '{{__('暂无解析')}}')}</div>`;
            html += `<div class="quiz-correct-answer">{{__('正确答案')}}: <strong>${getCorrectAnswerText(question)}</strong></div>`;
            html += '</div>';

            // 操作按钮
            html += '<div class="quiz-actions">';
            html += `<button class="btn btn-primary quiz-next-btn" data-is-last="${isLastQuestion}">${buttonText}</button>`;
            html += '</div>';

            html += '</div>';
            return html;
        }

        function getCorrectAnswerText(question) {
            if (!question.options || !Array.isArray(question.options)) {
                return '';
            }
            const correctIndex = parseInt(question.correct_answer) || 0;
            if (correctIndex >= 0 && correctIndex < question.options.length) {
                const option = question.options[correctIndex];
                const optionText = typeof option === 'string' ? option : (option.text || option);
                return String.fromCharCode(65 + correctIndex) + '. ' + optionText;
            }
            return '';
        }

        function showQuestion(index) {
            if (!quizData || !quizData.questions || index < 0 || index >= quizData.questions.length) {
                return;
            }

            // 隐藏所有题目
            $('.quiz-question').removeClass('active');

            // 显示当前题目
            const $question = $(`.quiz-question[data-question-index="${index}"]`);
            $question.addClass('active');

            // 更新进度
            $('.quiz-progress').html(`<span>{{__('第')}} <strong>${index + 1}</strong> {{__('题，共')}} <strong>${quizData.questions.length}</strong> {{__('题')}}</span>`);

            // 更新按钮文本（判断是否是最后一题）
            const isLastQuestion = index === quizData.questions.length - 1;
            const $nextBtn = $question.find('.quiz-next-btn');
            if (isLastQuestion) {
                $nextBtn.text('{{__('提交')}}').attr('data-is-last', 'true');
            } else {
                $nextBtn.text('{{__('下一题')}}').attr('data-is-last', 'false');
            }

            // 重置状态
            selectedAnswer = null;
            isAnswered = false;
            $question.find('.quiz-option').removeClass('selected correct incorrect disabled');
            $question.find('.quiz-explanation').removeClass('show');
            $nextBtn.removeClass('show');

            // 绑定选项点击事件
            $question.find('.quiz-option').off('click').on('click', function() {
                if (isAnswered) return;

                const $option = $(this);
                const optionIndex = parseInt($option.data('option-index'));
                const question = quizData.questions[index];
                const correctAnswer = parseInt(question.correct_answer) || 0;
                const isLastQuestion = index === quizData.questions.length - 1;

                // 移除之前的选择标记（但保留正确/错误标记）
                $question.find('.quiz-option').removeClass('selected');

                // 标记当前选择
                $option.addClass('selected');
                selectedAnswer = optionIndex;

                // 判断答案
                if (optionIndex === correctAnswer) {
                    // 正确答案
                    // 移除之前的错误标记（如果有）
                    $question.find('.quiz-option').removeClass('incorrect');
                    $option.addClass('correct');
                    
                    // 标记正确答案（如果还没标记）
                    $question.find(`.quiz-option[data-option-index="${correctAnswer}"]`).addClass('correct');
                    
                    // 显示解释（如果还没显示）
                    if (!$question.find('.quiz-explanation').hasClass('show')) {
                        $question.find('.quiz-explanation').addClass('show');
                    }
                    
                    // 禁用所有选项
                    $question.find('.quiz-option').addClass('disabled');
                    
                    // 显示下一题/提交按钮
                    $question.find('.quiz-next-btn').addClass('show');
                    
                    isAnswered = true;
                } else {
                    // 错误答案
                    $option.addClass('incorrect');
                    
                    // 标记正确答案（如果还没标记）
                    const $correctOption = $question.find(`.quiz-option[data-option-index="${correctAnswer}"]`);
                    if (!$correctOption.hasClass('correct')) {
                        $correctOption.addClass('correct');
                    }
                    
                    // 显示解释
                    $question.find('.quiz-explanation').addClass('show error');
                    
                    // 不禁用选项，允许用户重新选择正确答案
                    // 不显示下一题按钮，直到用户选择正确答案
                    // 不设置 isAnswered = true，允许继续选择
                }
            });

            // 绑定下一题/提交按钮
            $question.find('.quiz-next-btn').off('click').on('click', function() {
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
                // 所有题目完成
                showComplete();
            }
        }

        function showComplete() {
            let html = '<div class="quiz-complete">';
            html += '<div class="quiz-complete-icon"><i class="fa-solid fa-circle-check"></i></div>';
            html += '<div class="quiz-complete-title">{{__('测验完成')}}</div>';
            html += '<div class="quiz-complete-message">{{__('恭喜您完成了本次测验！')}}</div>';
            html += '<button class="btn btn-primary" data-dismiss="modal">{{__('关闭')}}</button>';
            html += '</div>';
            $quizContent.html(html);
        }

        function showError(message) {
            $quizContent.html(`<div class="alert alert-danger text-center">${escapeHtml(message)}</div>`);
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // 监听模态框显示事件
        $quizModal.on('show.bs.modal', function (event) {
            // 从play.blade.php中获取当前单元ID
            const $playModal = $('#play-box');
            // 尝试从全局变量或DOM中获取当前单元信息
            let unitId = null;

            // 从play.blade.php的全局变量中获取
            if (typeof currentUnit !== 'undefined' && currentUnit) {
                unitId = currentUnit;
            } else {
                // 从DOM中获取最后播放的单元
                const $lastPlayed = $('li[data-unit]').filter(function() {
                    return $(this).data('info');
                }).last();
                if ($lastPlayed.length) {
                    unitId = $lastPlayed.data('unit');
                }
            }

            if (!unitId) {
                showError('{{__('未找到单元信息')}}');
                return;
            }

            loadQuiz(unitId);
        });

        // 监听模态框隐藏事件，重置状态
        $quizModal.on('hidden.bs.modal', function () {
            quizData = null;
            currentQuestionIndex = 0;
            selectedAnswer = null;
            isAnswered = false;
            $quizContent.html('<div class="d-flex justify-content-center align-items-center" style="height: 100%;"><div class="spinner-border" role="status"><span class="sr-only">{{__('加载中...')}}</span></div></div>');
        });

        // 从play.blade.php接收quiz数据（备用方法）
        window.setQuizData = function(quiz) {
            if (quiz) {
                renderQuiz(quiz);
            }
        };
    });
</script>
