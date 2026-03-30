<div class="quiz-card" id="quizCard">
    <div class="quiz-header">
        <div class="quiz-title">
            <div class="quiz-icon">✏️</div>
            <span class="quiz-label">{{__('随堂测验')}}：{{$quiz->title}}</span>
        </div>
        <button class="collapse-btn" onclick="toggleQuiz()" title="{{__('折叠测验区')}}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 6 9 12 15 18"/>
            </svg>
        </button>
    </div>

    <div class="quiz-progress">
        <div class="quiz-progress-bar">
            <div class="quiz-progress-fill" style="width: 33%;" id="quizProgressFill"></div>
        </div>
        <div class="quiz-progress-text">
            <span id="quizCurrent">0</span>/<span id="quizTotal">0</span>
        </div>
    </div>

    <div id="quizPanelContent">
        <div id="quizStartView">
            <div class="quiz-start w-100">
                <div class="text-center px-4">
                    <div class="display-4 mb-2">{{__('测验准备就绪')}}</div>
                    <p class="mb-3">{{__('您已完成本单元内容的学习，点击下方按钮开始测验')}}</p>
                    <button type="button" class="btn btn-primary w-100" id="quizStartButton">🎯 {{__('开始测验')}}</button>
                </div>
            </div>
        </div>

        <div class="quiz-question d-none" id="quizQuestionView">
            <div class="question-text" id="quizQuestionText"></div>
            <div class="options-list" id="quizOptionsList"></div>
        </div>

        <div class="quiz-feedback" id="quizFeedback">
            <div class="feedback-title" id="feedbackTitle">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span id="feedbackText"></span>
            </div>
            <div class="feedback-text">
                <p id="feedbackExplanation"></p>
            </div>
        </div>

        <div class="quiz-statistics" id="quizStatisticsView" style="display: none;">
            <div class="quiz-statistics-icon">🎉</div>
            <h4 class="quiz-statistics-title">{{__('测验完成')}}</h4>
            <div class="quiz-statistics-progress">
                <h1><span id="quizStatsAnswered">0 / 0</span></h1>
                <div class="progress-value">
                    <span id="quizStatsCorrectRate">0%</span>
                </div>
            </div>
            <div class="w-100">
                <div class="quiz-statistics-btn">
                    <button class="btn btn-light w-100 p-3 mb-4 btn-review">{{__('复习答案')}}</button>
                </div>
                <div class="close-unit-btn" style="display: none;">
                    <button class="btn btn-danger w-100 p-3 mb-4">{{__('关闭')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="quiz-actions d-none" id="quizActions">
        <button class="btn btn-outline" id="quizPrevBtn" type="button" disabled>{{__('上一题')}}</button>
        <button class="btn btn-primary" id="quizNextBtn" type="button" disabled>{{__('下一题')}}</button>
    </div>
</div>
<style>
    .quiz-statistics {
        margin: 10px auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2rem;
    }

    .quiz-statistics-icon {
        height: 95px;
        line-height: normal;
        font-size: 5rem;
    }

    .quiz-statistics-title {
        color: #1f2937;
        font-weight: 700;
        font-size: 1.875rem;
        line-height: 2.25rem;
    }

    .quiz-statistics-progress {
        width: 100%;
        text-align: center;
        background-image: linear-gradient(to right, #6366f1, #9333ea);
        border-radius: 1rem;
        padding: 1.5rem;
        color: white;
    }

    .quiz-statistics-progress h1 {
        color: white;
        font-size: 3rem;
        line-height: 1;
        margin-bottom: .5rem;
    }

    .quiz-statistics-progress .progress-value {
        opacity: .9;
        font-size: 1.25rem;
        line-height: 1.75rem;
    }

    .quiz-statistics-btn {
        width: 100%;
    }

    .quiz-statistics-btn .btn {
        width: 100%;
        border-radius: .75rem;
        font-weight: 700;
    }
</style>
<script>

    // Quiz Panel Toggle
    function toggleQuiz() {
        const $rightCol = $('#rightColumn');
        const isHidden = $rightCol.length && $rightCol.hasClass('hidden');
        if (isHidden) {
            showQuizPanel();
        } else {
            hideQuizPanel();
        }

        // 右栏切换会改变 left-column 宽高，确保 PDF（dFlip）自动适配当前尺寸
        if (typeof window.resizePdfViewer === 'function') {
            requestAnimationFrame(function () {
                window.resizePdfViewer();
            });
            setTimeout(function () {
                window.resizePdfViewer();
            }, 250);
        }
    }

    function showQuizPanel() {
        const $rightCol = $('#rightColumn');
        const $mainLayout = $('#mainLayout');
        const $expandHintWrapper = $('#btn-quiz');

        if (!$rightCol.length) return;
        $rightCol.removeClass('hidden');
        if ($mainLayout.length) $mainLayout.removeClass('quiz-hidden');
        if ($expandHintWrapper.length) $expandHintWrapper.removeClass('show');

        if (typeof window.ensureQuizLoaded === 'function') {
            window.ensureQuizLoaded({autoStart: false});
        }
    }

    function hideQuizPanel() {
        const $rightCol = $('#rightColumn');
        const $mainLayout = $('#mainLayout');
        const $expandHintWrapper = $('#btn-quiz');

        if (!$rightCol.length) return;
        $rightCol.addClass('hidden');
        if ($mainLayout.length) $mainLayout.addClass('quiz-hidden');
        if ($expandHintWrapper.length) $expandHintWrapper.addClass('show');
    }

    window.showQuizPanel = showQuizPanel;
    window.hideQuizPanel = hideQuizPanel;

    $(function () {
        const $quizCard = $('#quizCard');
        const $quizStartView = $('#quizStartView');
        const $quizQuestionView = $('#quizQuestionView');
        const $quizQuestionText = $('#quizQuestionText');
        const $quizOptionsList = $('#quizOptionsList');
        const $quizFeedback = $('#quizFeedback');
        const $feedbackTitle = $('#feedbackTitle');
        const $feedbackText = $('#feedbackText');
        const $feedbackExplanation = $('#feedbackExplanation');
        const $quizStatisticsView = $('#quizStatisticsView');

        const $quizProgressFill = $('#quizProgressFill');
        const $quizCurrent = $('#quizCurrent');
        const $quizTotal = $('#quizTotal');

        const $quizStartButton = $('#quizStartButton');
        const $quizActions = $('#quizActions');
        const $quizPrevBtn = $('#quizPrevBtn');
        const $quizNextBtn = $('#quizNextBtn');

        const $quizStatsAnswered = $('#quizStatsAnswered');
        const $quizStatsCorrectRate = $('#quizStatsCorrectRate');

        if (!$quizCard.length) return;

        // 初始化：来自后端的已答题列表（用于打开时决定从第几个题开始）
        const initialAnsweredQuestionsList = @json($answered_questions ?? []);
        const initialCompletedQuestionsList = @json($completed_questions ?? []);

        // 测验内容已随页面直接返回：来自 $quiz->questions
        const serverQuizQuestions = @json($quiz->questions ?? []);
        const serverQuestionNum = @json($quiz->question_num ?? null);

        let answeredQuestionsList = Array.isArray(initialAnsweredQuestionsList)
            ? initialAnsweredQuestionsList.slice()
            : [];
        let completedQuestionsList = Array.isArray(initialCompletedQuestionsList)
            ? initialCompletedQuestionsList.slice()
            : [];

        let quizData = {
            questions: Array.isArray(serverQuizQuestions) ? serverQuizQuestions : [],
            question_num: serverQuestionNum,
        };
        let currentQuestionIndex = 0;
        let isAnswered = false;
        let isReviewMode = false;
        let wrongAnswers = {}; // 记录用户本轮对某题的“错误选项”，用于保存请求兼容旧逻辑

        let currentCourseId = {{ $course->id }};
        let currentChapterId = {{ $unit->chapter_id }};
        let currentUnitId = {{ $unit->id }};
        let currentQuizId = {{ $unit->quiz_id ?? 0 }};
        const serverUnitStatus = @json($play_record->status ?? 0);

        function hideEl($el) {
            if (!$el || !$el.length) return;
            $el.addClass('d-none').hide();
        }

        function showEl($el) {
            if (!$el || !$el.length) return;
            $el.removeClass('d-none').show();
        }

        function showQuizActions(show) {
            if (!$quizActions.length) return;
            if (show) showEl($quizActions);
            else hideEl($quizActions);
        }

        function updateQuestionNavButtons() {
            if (!quizData || !Array.isArray(quizData.questions)) return;

            const isFirst = currentQuestionIndex <= 0;
            const isLast = currentQuestionIndex >= quizData.questions.length - 1;

            if ($quizPrevBtn.length) {
                $quizPrevBtn.prop('disabled', isFirst);
            }
            if ($quizNextBtn.length) {
                $quizNextBtn.prop('disabled', !isAnswered).text(isLast
                    ? (isReviewMode ? '{{__('完成')}}' : '{{__('提交答案')}}')
                    : '{{__('下一题')}}');
            }
        }

        function setFeedback(type, titleText, explanationText) {
            if (!$quizFeedback.length || !$feedbackTitle.length || !$feedbackText.length) return;

            $quizFeedback.removeClass('show correct incorrect');
            $feedbackTitle.removeClass('correct incorrect');

            if (type === 'correct') {
                $quizFeedback.addClass('correct show');
                $feedbackTitle.addClass('correct');
            } else if (type === 'incorrect') {
                $quizFeedback.addClass('incorrect show');
                $feedbackTitle.addClass('incorrect');
            } else {
                $quizFeedback.addClass('show');
            }

            $feedbackText.text(titleText || '');
            // 后端解析可能包含 HTML，这里保持与旧版一致用 innerHTML
            $feedbackExplanation.html(explanationText || '');
        }

        function clearFeedback() {
            if (!$quizFeedback.length) return;
            $quizFeedback.removeClass('show correct incorrect');
            if ($feedbackTitle.length) $feedbackTitle.removeClass('correct incorrect');
            if ($feedbackText.length) $feedbackText.text('');
            if ($feedbackExplanation.length) $feedbackExplanation.text('');
        }

        function updateProgress(index) {
            if (!quizData || !Array.isArray(quizData.questions)) return;
            const total = quizData.questions.length;
            const current = index + 1;
            const progress = Math.floor((current / total) * 100);
            if ($quizTotal.length) $quizTotal.text(String(total));
            if ($quizCurrent.length) $quizCurrent.text(String(current));
            if ($quizProgressFill.length) $quizProgressFill.css('width', `${progress}%`);
        }

        function resetQuizState() {
            // 保持题目内容无需额外请求
            quizData = {
                questions: Array.isArray(serverQuizQuestions) ? serverQuizQuestions : [],
                question_num: serverQuestionNum,
            };
            currentQuestionIndex = 0;
            isAnswered = false;
            isReviewMode = false;
            wrongAnswers = {};

            answeredQuestionsList = Array.isArray(initialAnsweredQuestionsList)
                ? initialAnsweredQuestionsList.slice()
                : [];
            completedQuestionsList = Array.isArray(initialCompletedQuestionsList)
                ? initialCompletedQuestionsList.slice()
                : [];

            if ($quizProgressFill.length) $quizProgressFill.css('width', '0%');
            if ($quizCurrent.length) $quizCurrent.text('0');
            if ($quizTotal.length) $quizTotal.text('0');

            if ($quizStatisticsView.length) hideEl($quizStatisticsView);
            if ($quizQuestionView.length) hideEl($quizQuestionView);
            if ($quizStartView.length) showEl($quizStartView);
            showQuizActions(false);

            clearFeedback();
            if ($quizPrevBtn.length) $quizPrevBtn.prop('disabled', true).text('{{__('上一题')}}');
            if ($quizNextBtn.length) $quizNextBtn.prop('disabled', true).text('{{__('下一题')}}');

            if ($quizOptionsList.length) $quizOptionsList.empty();
            if ($quizQuestionText.length) $quizQuestionText.text('');
            $('.close-unit-btn').hide()
        }

        function renderQuizStart() {
            if ($quizStartView.length) showEl($quizStartView);
            if ($quizQuestionView.length) hideEl($quizQuestionView);
            if ($quizStatisticsView.length) hideEl($quizStatisticsView);
            showQuizActions(false);
            clearFeedback();

            const totalQuestions = quizData && Array.isArray(quizData.questions) ? quizData.questions.length : 0;
            const isCompleted = totalQuestions > 0 && answeredQuestionsList.length >= totalQuestions;

            if ($quizStartButton.length) {
                $quizStartButton.text(isCompleted ? '{{__('复习答案')}}' : '🎯 {{__('开始测验')}}');
                $quizStartButton.off('click').on('click', function () {
                    showQuestion(isCompleted ? 0 : findFirstUnansweredIndex());
                });
            }
        }

        function renderOptions(question) {
            if (!$quizOptionsList.length) return;
            const options = Array.isArray(question.options) ? question.options : [];
            const html = options.map((optText, optIndex) => (
                `<div class="option-item" data-option-index="${optIndex}">
                    <div class="option-marker">${String.fromCharCode(65 + optIndex)}</div>
                    <div class="option-text">${_.escape(optText)}</div>
                </div>`
            )).join('');
            $quizOptionsList.html(html);
        }

        function markAnsweredQuestion(index) {
            const question = quizData.questions[index];
            const correctAnswer = parseInt(question.correct_answer, 10) || 0;

            isAnswered = true;
            showQuizActions(true);
            updateQuestionNavButtons();

            if ($quizOptionsList.length) {
                $quizOptionsList.find('.option-item').each(function () {
                    const $el = $(this);
                    const optIdx = parseInt($el.attr('data-option-index') || '0', 10);
                    $el.removeClass('selected correct incorrect');
                    if (optIdx === correctAnswer) {
                        $el.addClass('selected correct');
                    }
                });
            }

            // 已答题：直接展示解析（与旧版保持一致）
            setFeedback(
                'correct',
                '{{__('正確！')}}',
                question.explanation || '{{__('暂无解析')}}'
            );

            // 禁用继续点击：通过检查 isAnswered 控制即可，但这里也清空事件（避免重复绑定）
            $quizOptionsList.off('click.quizOption');

            const isLast = index === quizData.questions.length - 1;
            if ($quizNextBtn.length) $quizNextBtn.text(isLast ? '{{__('提交答案')}}' : '{{__('下一题')}}');
            updateQuestionNavButtons();
        }

        function markReviewQuestion(index) {
            const question = quizData.questions[index];
            const correctAnswer = parseInt(question.correct_answer, 10) || 0;

            isAnswered = true;
            showQuizActions(true);
            updateQuestionNavButtons();

            if ($quizOptionsList.length) {
                $quizOptionsList.find('.option-item').each(function () {
                    const $el = $(this);
                    const optIdx = parseInt($el.attr('data-option-index') || '0', 10);
                    $el.removeClass('selected correct incorrect');
                    if (optIdx === correctAnswer) {
                        $el.addClass('selected correct');
                    }
                });
            }

            setFeedback(
                'correct',
                '{{__('正確！')}}',
                question.explanation || '{{__('暂无解析')}}'
            );

            // 复习模式下只允许上一题/下一题切换，不允许点击选项
            $quizOptionsList.off('click.quizOption');
        }

        function bindOptionClick(index) {
            if (!$quizOptionsList.length) return;
            const question = quizData.questions[index];
            const correctAnswer = parseInt(question.correct_answer, 10) || 0;

            $quizOptionsList
                .off('click.quizOption')
                .on('click.quizOption', '.option-item', function () {
                    if (isAnswered) return;
                    const $el = $(this);
                    const optIndex = parseInt($el.data('option-index') || 0, 10);

                    $el.addClass('selected');

                    if (optIndex === correctAnswer) {
                        handleCorrectAnswer(index, optIndex);
                    } else {
                        handleIncorrectAnswer(index, optIndex);
                    }
                });
        }

        function handleIncorrectAnswer(questionIndex, optionIndex) {
            isAnswered = false;

            // 错误反馈不立即展示解析，仅把当前选项标红，并记录错误选项
            if ($quizOptionsList.length) $quizOptionsList.find(`.option-item[data-option-index="${optionIndex}"]`).addClass('incorrect');

            if (wrongAnswers[questionIndex] === undefined) {
                wrongAnswers[questionIndex] = optionIndex;
            }

            showQuizActions(true);
            updateQuestionNavButtons();
            clearFeedback();
        }

        function saveQuizAnswer(questionIndex, userAnswer, wrongAnswer = null) {
            return new Promise(function (resolve, reject) {
                if (!currentCourseId || !currentChapterId || !currentUnitId || !currentQuizId) {
                    reject(new Error('缺少必要的参数'));
                    return;
                }

                // 兼容旧逻辑：wrongAnswer 存在时覆盖 userAnswer
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
                            return;
                        }
                        resolve(response.data || {});
                    },
                    error: function (xhr) {
                        const errorMsg = xhr.responseJSON?.msg || '{{__('保存答题记录失败')}}';
                        reject(new Error(errorMsg));
                    }
                });
            });
        }

        function handleCorrectAnswer(questionIndex, optionIndex) {
            const question = quizData.questions[questionIndex];
            const correctAnswer = parseInt(question.correct_answer, 10) || 0;

            // 标记正确答案选项
            if ($quizOptionsList.length) $quizOptionsList.find(`.option-item[data-option-index="${correctAnswer}"]`).addClass('correct');

            setFeedback(
                'correct',
                '{{__('正確！')}}',
                question.explanation || '{{__('暂无解析')}}'
            );

            isAnswered = true;
            showQuizActions(true);
            updateQuestionNavButtons();

            const wrongAnswer = wrongAnswers[questionIndex];
            saveQuizAnswer(questionIndex, correctAnswer, wrongAnswer)
                .then(function (response) {
                    if (wrongAnswers[questionIndex] !== undefined) {
                        delete wrongAnswers[questionIndex];
                    }

                    // 更新已答题列表
                    if (!answeredQuestionsList.includes(questionIndex)) {
                        answeredQuestionsList.push(questionIndex);
                    }

                    const isLast = questionIndex === quizData.questions.length - 1;
                    if ($quizNextBtn.length) $quizNextBtn.text(isLast ? '{{__('提交答案')}}' : '{{__('下一题')}}');

                    updateProgress(questionIndex);
                    updateQuestionNavButtons();
                })
                .catch(function (error) {
                    console.error(error);
                    showToast('error', error.message || '{{__('保存答案失败，请重试')}}');
                    isAnswered = false;
                    updateQuestionNavButtons();
                    // 发生保存失败：回到当前题可继续作答
                    showQuestion(questionIndex);
                });
        }

        function showQuestion(index) {
            if (!quizData || !Array.isArray(quizData.questions)) return;
            if (index < 0 || index >= quizData.questions.length) return;

            currentQuestionIndex = index;
            const question = quizData.questions[index];

            if ($quizStartView.length) hideEl($quizStartView);
            if ($quizStatisticsView.length) hideEl($quizStatisticsView);
            if ($quizQuestionView.length) showEl($quizQuestionView);
            showQuizActions(true);

            clearFeedback();

            if ($quizQuestionText.length) $quizQuestionText.text(question.title || '');

            renderOptions(question);
            updateProgress(index);

            if (isReviewMode) {
                markReviewQuestion(index);
                updateQuestionNavButtons();
                return;
            }

            const isQuestionAnswered = answeredQuestionsList.includes(index);
            if (isQuestionAnswered) {
                markAnsweredQuestion(index);
                updateQuestionNavButtons();
                return;
            }

            // 未答题：允许点击
            isAnswered = false;
            updateQuestionNavButtons();
            clearFeedback();
            bindOptionClick(index);
        }

        function findFirstUnansweredIndex() {
            if (!quizData || !Array.isArray(quizData.questions)) return 0;
            for (let i = 0; i < quizData.questions.length; i++) {
                if (!answeredQuestionsList.includes(i)) return i;
            }
            return 0;
        }

        function showQuizStatistics() {
            if (!currentCourseId || !currentChapterId || !currentUnitId || !currentQuizId) {
                showToast('error', '{{__('参数错误')}}');
                return;
            }
            const $reviewBtn = $('#quizStatisticsView .btn-review');

            if ($quizStartView.length) hideEl($quizStartView);
            if ($quizQuestionView.length) hideEl($quizQuestionView);
            showQuizActions(false);
            clearFeedback();
            if ($quizStatisticsView.length) showEl($quizStatisticsView);

            if ($quizStatsAnswered.length) $quizStatsAnswered.text('{{__('加载中...')}}');
            if ($quizStatsCorrectRate.length) $quizStatsCorrectRate.text('0%');
            // 统计数据加载完成前不显示“复习答案”
            $reviewBtn.hide().off('click');

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
                    if (response.code !== 0) {
                        showToast('error', response.msg || '{{__('获取统计信息失败')}}');
                        return;
                    }

                    const stats = response.data || {};
                    const totalQuestions = parseInt(stats.total_questions) || 0;
                    const answered = parseInt(stats.answered) || 0;
                    const correctRate = parseFloat(stats.correct_rate) || 0;
                    const isAllCompleted = stats.is_all_completed || false;

                    if ($quizStatsAnswered.length) $quizStatsAnswered.text(`${answered} / ${totalQuestions}`);
                    if ($quizStatsCorrectRate.length) $quizStatsCorrectRate.text(`${isNaN(correctRate) ? 0 : Math.round(correctRate)}%`);
                    $('.close-unit-btn').show()

                    // 统计数据加载完成后显示“复习答案”
                    $reviewBtn.show().on('click', function () {
                        loadQuiz(currentUnitId, {startIndexMode: 'review'});
                    });

                    // 标记单元完成测验（尽力而为：DOM 中不一定存在对应 unit 列表）
                    if (typeof window.updateUnitStatus === 'function') {
                        window.updateUnitStatus(currentUnitId, 2, isAllCompleted);
                    }

                    // 同步更新本页“观看/完成”状态为已完成（status=2）
                    if (typeof window.setPlayRecordStatus === 'function') {
                        window.setPlayRecordStatus(2);
                    }
                },
                error: function () {
                    showToast('error', '{{__('获取统计信息失败，请重试')}}');
                }
            });
        }

        function loadQuiz(unitId, {startIndexMode = 'first_unanswered', autoStart = false} = {}) {
            // 题目内容已直接返回，不再请求 `/quiz/{unit}.html`
            if (!unitId) unitId = currentUnitId;

            currentQuestionIndex = 0;
            isAnswered = false;
            isReviewMode = (startIndexMode === 'review');
            wrongAnswers = {};

            clearFeedback();
            if ($quizStatisticsView.length) hideEl($quizStatisticsView);

            const totalQuestions = quizData && Array.isArray(quizData.questions) ? quizData.questions.length : 0;
            if ($quizTotal.length) $quizTotal.text(String(totalQuestions));
            if ($quizProgressFill.length) $quizProgressFill.css('width', '0%');

            const isCompleted = totalQuestions > 0 && answeredQuestionsList.length >= totalQuestions;
            const startIndex = isCompleted ? 0 : findFirstUnansweredIndex();

            if (startIndexMode === 'review') {
                showQuestion(0);
                return;
            }

            if (autoStart) {
                showQuestion(startIndex);
                return;
            }

            renderQuizStart();
        }

        // 公开：播放结束后自动进入测验
        window.openQuiz = function (paramsOrEl) {
            let params = paramsOrEl;
            if (paramsOrEl && typeof paramsOrEl.getAttribute === 'function') {
                params = {
                    course: parseInt(paramsOrEl.getAttribute('data-course') || 0),
                    chapter: parseInt(paramsOrEl.getAttribute('data-chapter') || 0),
                    unit: parseInt(paramsOrEl.getAttribute('data-unit') || 0),
                    quiz: parseInt(paramsOrEl.getAttribute('data-quiz') || 0),
                };
            }
            if (!params) return;

            currentCourseId = parseInt(params.course || 0) || currentCourseId;
            currentChapterId = parseInt(params.chapter || 0) || currentChapterId;
            currentUnitId = parseInt(params.unit || 0) || currentUnitId;
            currentQuizId = parseInt(params.quiz || 0) || currentQuizId;

            // 展开右侧测验区，但不要调用 ensureQuizLoaded，避免与下面的 loadQuiz(autoStart=true) 产生重复请求
            const $rightCol = $('#rightColumn');
            const $mainLayout = $('#mainLayout');
            const $expandHintWrapper = $('#btn-quiz');
            if ($rightCol.length) $rightCol.removeClass('hidden');
            if ($mainLayout.length) $mainLayout.removeClass('quiz-hidden');
            if ($expandHintWrapper.length) $expandHintWrapper.removeClass('show');

            resetQuizState();

            const totalQuestions = quizData && Array.isArray(quizData.questions) ? quizData.questions.length : 0;
            const isCompleted = totalQuestions > 0 && answeredQuestionsList.length >= totalQuestions;

            if (parseInt(serverUnitStatus, 10) === 2) {
                // 状态=2：直接显示统计态
                showQuizStatistics();
                return;
            }

            if (isCompleted) {
                // 已完成：进入复习题目页
                showQuestion(0);
            } else {
                // 未完成：显示开始测验
                renderQuizStart();
            }
        };

        // 公开：右侧面板展开时，如果还没加载过测验，就加载并展示开始页
        window.ensureQuizLoaded = function ({autoStart = false} = {}) {
            const totalQuestions = quizData && Array.isArray(quizData.questions) ? quizData.questions.length : 0;
            const isCompleted = totalQuestions > 0 && answeredQuestionsList.length >= totalQuestions;

            if (parseInt(serverUnitStatus, 10) === 2) {
                showQuizStatistics();
                return;
            }

            if (isCompleted) {
                showQuestion(0);
                return;
            }

            if (autoStart) {
                showQuestion(findFirstUnansweredIndex());
                return;
            }

            renderQuizStart();
        };

        const handlePrevQuestion = _.debounce(function () {
            if (currentQuestionIndex <= 0) return;
            showQuestion(currentQuestionIndex - 1);
        }, 180, {leading: true, trailing: false});

        const handleNextQuestion = _.debounce(function () {
            if (!quizData || !Array.isArray(quizData.questions)) return;
            if (!isAnswered) {
                showToast('warning', '{{__('请先回答当前题目')}}');
                return;
            }

            const isLast = currentQuestionIndex === quizData.questions.length - 1;
            if (isLast) {
                showQuizStatistics();
            } else {
                showQuestion(currentQuestionIndex + 1);
            }
        }, 180, {leading: true, trailing: false});

        if ($quizPrevBtn.length) $quizPrevBtn.off('click').on('click', handlePrevQuestion);
        if ($quizNextBtn.length) $quizNextBtn.off('click').on('click', handleNextQuestion);

        // 状态=2：直接显示统计；否则根据已答题情况显示复习或开始
        if (parseInt(serverUnitStatus, 10) === 2) {
            showQuizStatistics();
        } else {
            const initialTotal = quizData && Array.isArray(quizData.questions) ? quizData.questions.length : 0;
            const initialCompleted = initialTotal > 0 && answeredQuestionsList.length >= initialTotal;
            if (initialCompleted) {
                showQuestion(0);
            } else {
                renderQuizStart();
            }
        }
        clearFeedback();
        if ($quizStatisticsView.length) hideEl($quizStatisticsView);

        $('.close-unit-btn .btn').click(function () {
            window.close();
        })
    });
</script>
