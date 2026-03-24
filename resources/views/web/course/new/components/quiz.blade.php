<div class="quiz-card" id="quizCard">
    <div class="quiz-header">
        <div class="quiz-title">
            <div class="quiz-icon">✏️</div>
            <span class="quiz-label">隨堂測驗：{{$quiz->title}}</span>
        </div>
        <button class="collapse-btn" onclick="toggleQuiz()" title="摺疊測驗區">
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

        <div class="quiz-feedback show" id="quizStatisticsView" style="display: none;">
            <div class="feedback-title correct">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>{{__('测验完成')}}</span>
            </div>
            <div class="feedback-text">
                <p style="margin-bottom: .25rem;">
                    <span id="quizStatsAnswered">0</span>
                </p>
                <p>
                    <span id="quizStatsCorrectRate">0%</span>
                </p>
            </div>
        </div>
    </div>

    <div class="quiz-actions d-none" id="quizActions">
        <button class="btn btn-outline" id="quizPrevBtn" type="button" disabled>{{__('上一题')}}</button>
        <button class="btn btn-primary" id="quizNextBtn" type="button" disabled>{{__('下一题')}}</button>
    </div>
</div>
<script>
    // Quiz Panel Toggle
    function toggleQuiz() {
        const rightCol = document.getElementById('rightColumn');

        const isHidden = rightCol && rightCol.classList.contains('hidden');
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
        const rightCol = document.getElementById('rightColumn');
        const mainLayout = document.getElementById('mainLayout');
        const expandHintWrapper = document.getElementById('btn-quiz');

        if (!rightCol) return;
        rightCol.classList.remove('hidden');
        if (mainLayout) mainLayout.classList.remove('quiz-hidden');
        if (expandHintWrapper) expandHintWrapper.classList.remove('show');

        if (typeof window.ensureQuizLoaded === 'function') {
            window.ensureQuizLoaded({autoStart: false});
        }
    }

    function hideQuizPanel() {
        const rightCol = document.getElementById('rightColumn');
        const mainLayout = document.getElementById('mainLayout');
        const expandHintWrapper = document.getElementById('btn-quiz');

        if (!rightCol) return;
        rightCol.classList.add('hidden');
        if (mainLayout) mainLayout.classList.add('quiz-hidden');
        if (expandHintWrapper) expandHintWrapper.classList.add('show');
    }

    window.showQuizPanel = showQuizPanel;
    window.hideQuizPanel = hideQuizPanel;
</script>

<script>
    $(function () {
        const quizCard = document.getElementById('quizCard');
        const quizStartView = document.getElementById('quizStartView');
        const quizQuestionView = document.getElementById('quizQuestionView');
        const quizQuestionText = document.getElementById('quizQuestionText');
        const quizOptionsList = document.getElementById('quizOptionsList');
        const quizFeedback = document.getElementById('quizFeedback');
        const feedbackTitle = document.getElementById('feedbackTitle');
        const feedbackText = document.getElementById('feedbackText');
        const feedbackExplanation = document.getElementById('feedbackExplanation');
        const quizStatisticsView = document.getElementById('quizStatisticsView');

        const quizProgressFill = document.getElementById('quizProgressFill');
        const quizCurrentEl = document.getElementById('quizCurrent');
        const quizTotalEl = document.getElementById('quizTotal');

        const quizStartButton = document.getElementById('quizStartButton');
        const quizActions = document.getElementById('quizActions');
        const quizPrevBtn = document.getElementById('quizPrevBtn');
        const quizNextBtn = document.getElementById('quizNextBtn');

        const quizStatsAnswered = document.getElementById('quizStatsAnswered');
        const quizStatsCorrectRate = document.getElementById('quizStatsCorrectRate');

        if (!quizCard) return;

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
        let wrongAnswers = {}; // 记录用户本轮对某题的“错误选项”，用于保存请求兼容旧逻辑

        let currentCourseId = {{ $course->id }};
        let currentChapterId = {{ $unit->chapter_id }};
        let currentUnitId = {{ $unit->id }};
        let currentQuizId = {{ $unit->quiz_id ?? 0 }};

        function hideEl(el) {
            if (!el) return;
            el.classList.add('d-none');
            el.style.display = 'none';
        }

        function showEl(el) {
            if (!el) return;
            el.classList.remove('d-none');
            el.style.display = '';
        }

        function showQuizActions(show) {
            if (!quizActions) return;
            if (show) showEl(quizActions);
            else hideEl(quizActions);
        }

        function updateQuestionNavButtons() {
            if (!quizData || !Array.isArray(quizData.questions)) return;

            const isFirst = currentQuestionIndex <= 0;
            const isLast = currentQuestionIndex >= quizData.questions.length - 1;

            if (quizPrevBtn) {
                quizPrevBtn.disabled = isFirst;
            }
            if (quizNextBtn) {
                quizNextBtn.disabled = !isAnswered;
                quizNextBtn.textContent = isLast ? '{{__('提交答案')}}' : '{{__('下一题')}}';
            }
        }

        function setFeedback(type, titleText, explanationText) {
            if (!quizFeedback || !feedbackTitle || !feedbackText) return;

            quizFeedback.classList.remove('show', 'correct', 'incorrect');
            feedbackTitle.classList.remove('correct', 'incorrect');

            if (type === 'correct') {
                quizFeedback.classList.add('correct', 'show');
                feedbackTitle.classList.add('correct');
            } else if (type === 'incorrect') {
                quizFeedback.classList.add('incorrect', 'show');
                feedbackTitle.classList.add('incorrect');
            } else {
                quizFeedback.classList.add('show');
            }

            feedbackText.textContent = titleText || '';
            // 后端解析可能包含 HTML，这里保持与旧版一致用 innerHTML
            feedbackExplanation.innerHTML = explanationText || '';
        }

        function clearFeedback() {
            if (!quizFeedback) return;
            quizFeedback.classList.remove('show', 'correct', 'incorrect');
            if (feedbackTitle) {
                feedbackTitle.classList.remove('correct', 'incorrect');
            }
            if (feedbackText) feedbackText.textContent = '';
            if (feedbackExplanation) feedbackExplanation.textContent = '';
        }

        function updateProgress(index) {
            if (!quizData || !Array.isArray(quizData.questions)) return;
            const total = quizData.questions.length;
            const current = index + 1;
            if (quizTotalEl) quizTotalEl.textContent = String(total);
            if (quizCurrentEl) quizCurrentEl.textContent = String(current);
            if (quizProgressFill) {
                const progress = Math.floor((current / total) * 100);
                quizProgressFill.style.width = `${progress}%`;
            }
        }

        function resetQuizState() {
            // 保持题目内容无需额外请求
            quizData = {
                questions: Array.isArray(serverQuizQuestions) ? serverQuizQuestions : [],
                question_num: serverQuestionNum,
            };
            currentQuestionIndex = 0;
            isAnswered = false;
            wrongAnswers = {};

            answeredQuestionsList = Array.isArray(initialAnsweredQuestionsList)
                ? initialAnsweredQuestionsList.slice()
                : [];
            completedQuestionsList = Array.isArray(initialCompletedQuestionsList)
                ? initialCompletedQuestionsList.slice()
                : [];

            if (quizProgressFill) quizProgressFill.style.width = '0%';
            if (quizCurrentEl) quizCurrentEl.textContent = '0';
            if (quizTotalEl) quizTotalEl.textContent = '0';

            if (quizStatisticsView) hideEl(quizStatisticsView);
            if (quizQuestionView) hideEl(quizQuestionView);
            if (quizStartView) showEl(quizStartView);
            showQuizActions(false);

            clearFeedback();
            if (quizPrevBtn) {
                quizPrevBtn.disabled = true;
                quizPrevBtn.textContent = '{{__('上一题')}}';
            }
            if (quizNextBtn) {
                quizNextBtn.disabled = true;
                quizNextBtn.textContent = '{{__('下一题')}}';
            }

            if (quizOptionsList) quizOptionsList.innerHTML = '';
            if (quizQuestionText) quizQuestionText.textContent = '';
        }

        function renderQuizStart() {
            if (quizStartView) showEl(quizStartView);
            if (quizQuestionView) hideEl(quizQuestionView);
            if (quizStatisticsView) hideEl(quizStatisticsView);
            showQuizActions(false);
            clearFeedback();

            const totalQuestions = quizData && Array.isArray(quizData.questions) ? quizData.questions.length : 0;
            const isCompleted = totalQuestions > 0 && answeredQuestionsList.length >= totalQuestions;

            if (quizStartButton) {
                quizStartButton.textContent = isCompleted ? '{{__('复习答案')}}' : '🎯 {{__('开始测验')}}';
                quizStartButton.onclick = function () {
                    showQuestion(isCompleted ? 0 : findFirstUnansweredIndex());
                };
            }
        }

        function renderOptions(question) {
            if (!quizOptionsList) return;
            quizOptionsList.innerHTML = '';

            const options = Array.isArray(question.options) ? question.options : [];
            options.forEach((optText, optIndex) => {
                const optionEl = document.createElement('div');
                optionEl.className = 'option-item';
                optionEl.setAttribute('data-option-index', String(optIndex));

                const marker = document.createElement('div');
                marker.className = 'option-marker';
                marker.textContent = String.fromCharCode(65 + optIndex);

                const text = document.createElement('div');
                text.className = 'option-text';
                text.textContent = optText;

                optionEl.appendChild(marker);
                optionEl.appendChild(text);

                quizOptionsList.appendChild(optionEl);
            });
        }

        function markAnsweredQuestion(index) {
            const question = quizData.questions[index];
            const correctAnswer = parseInt(question.correct_answer, 10) || 0;

            isAnswered = true;
            showQuizActions(true);
            updateQuestionNavButtons();

            if (quizOptionsList) {
                const optionEls = quizOptionsList.querySelectorAll('.option-item');
                optionEls.forEach((el) => {
                    const optIdx = parseInt(el.getAttribute('data-option-index') || '0', 10);
                    el.classList.remove('selected', 'correct', 'incorrect');
                    if (optIdx === correctAnswer) {
                        el.classList.add('selected', 'correct');
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
            if (quizOptionsList) {
                quizOptionsList.querySelectorAll('.option-item').forEach((el) => {
                    el.onclick = null;
                });
            }

            const isLast = index === quizData.questions.length - 1;
            if (quizNextBtn) {
                quizNextBtn.textContent = isLast ? '{{__('提交答案')}}' : '{{__('下一题')}}';
            }
            updateQuestionNavButtons();
        }

        function bindOptionClick(index) {
            if (!quizOptionsList) return;
            const question = quizData.questions[index];
            const correctAnswer = parseInt(question.correct_answer, 10) || 0;

            quizOptionsList.querySelectorAll('.option-item').forEach((el) => {
                el.onclick = function () {
                    if (isAnswered) return;
                    const optIndex = parseInt(el.getAttribute('data-option-index') || '0', 10);

                    el.classList.add('selected');

                    if (optIndex === correctAnswer) {
                        handleCorrectAnswer(index, optIndex);
                    } else {
                        handleIncorrectAnswer(index, optIndex);
                    }
                };
            });
        }

        function handleIncorrectAnswer(questionIndex, optionIndex) {
            isAnswered = false;

            // 错误反馈不立即展示解析，仅把当前选项标红，并记录错误选项
            if (quizOptionsList) {
                const el = quizOptionsList.querySelector(`.option-item[data-option-index="${optionIndex}"]`);
                if (el) el.classList.add('incorrect');
            }

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
            if (quizOptionsList) {
                const el = quizOptionsList.querySelector(`.option-item[data-option-index="${correctAnswer}"]`);
                if (el) el.classList.add('correct');
            }

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
                    if (quizNextBtn) {
                        quizNextBtn.textContent = isLast ? '{{__('提交答案')}}' : '{{__('下一题')}}';
                    }

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

            if (quizStartView) hideEl(quizStartView);
            if (quizStatisticsView) hideEl(quizStatisticsView);
            if (quizQuestionView) showEl(quizQuestionView);
            showQuizActions(true);

            clearFeedback();

            if (quizQuestionText) {
                const title = question.title || '';
                quizQuestionText.textContent = title;
            }

            renderOptions(question);
            updateProgress(index);

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

            if (quizStartView) hideEl(quizStartView);
            if (quizQuestionView) hideEl(quizQuestionView);
            showQuizActions(false);
            clearFeedback();
            if (quizStatisticsView) showEl(quizStatisticsView);

            if (quizStatsAnswered) quizStatsAnswered.textContent = '{{__('加载中...')}}';
            if (quizStatsCorrectRate) quizStatsCorrectRate.textContent = '0%';

            if (quizPrevBtn) quizPrevBtn.onclick = null;
            if (quizNextBtn) quizNextBtn.onclick = null;

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
                    const nextUnit = stats.next_unit || null;

                    if (quizStatsAnswered) quizStatsAnswered.textContent = `${answered} / ${totalQuestions}`;
                    if (quizStatsCorrectRate) quizStatsCorrectRate.textContent = `${isNaN(correctRate) ? 0 : Math.round(correctRate)}%`;

                    // 统计态不显示题目导航按钮

                    // 标记单元完成测验（尽力而为：DOM 中不一定存在对应 unit 列表）
                    if (typeof window.updateUnitStatus === 'function') {
                        window.updateUnitStatus(currentUnitId, 2);
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
            wrongAnswers = {};

            clearFeedback();
            if (quizStatisticsView) hideEl(quizStatisticsView);

            const totalQuestions = quizData && Array.isArray(quizData.questions) ? quizData.questions.length : 0;
            if (quizTotalEl) quizTotalEl.textContent = String(totalQuestions);
            if (quizProgressFill) quizProgressFill.style.width = '0%';

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
            const rightCol = document.getElementById('rightColumn');
            const mainLayout = document.getElementById('mainLayout');
            const expandHintWrapper = document.getElementById('btn-quiz');
            if (rightCol) rightCol.classList.remove('hidden');
            if (mainLayout) mainLayout.classList.remove('quiz-hidden');
            if (expandHintWrapper) expandHintWrapper.classList.remove('show');

            resetQuizState();

            const totalQuestions = quizData && Array.isArray(quizData.questions) ? quizData.questions.length : 0;
            const isCompleted = totalQuestions > 0 && answeredQuestionsList.length >= totalQuestions;

            if (isCompleted) {
                // 已完成：显示复习（直接进入题目页，且选项已不可点击）
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

        if (quizPrevBtn) {
            quizPrevBtn.onclick = function () {
                if (currentQuestionIndex <= 0) return;
                showQuestion(currentQuestionIndex - 1);
            };
        }

        if (quizNextBtn) {
            quizNextBtn.onclick = function () {
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
            };
        }

        // 初始化：已完成显示复习，未完成显示开始测验
        const initialTotal = quizData && Array.isArray(quizData.questions) ? quizData.questions.length : 0;
        const initialCompleted = initialTotal > 0 && answeredQuestionsList.length >= initialTotal;
        if (initialCompleted) {
            showQuestion(0);
        } else {
            renderQuizStart();
        }
        clearFeedback();
        if (quizStatisticsView) hideEl(quizStatisticsView);
    });
</script>
