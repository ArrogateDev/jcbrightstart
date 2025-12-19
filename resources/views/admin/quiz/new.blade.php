<x-layouts.modal id="form-modal" title="{{ __('添加测验')}}" class="modal-lg" form="true" form-id="form">

    <div class="modal-body pb-0">
        <div class="mb-3">
            <label class="form-label" for="quiz-title">{{__('名称')}} <span class="text-danger"> *</span></label>
            <input type="text" id="quiz-title" name="title" class="form-control" placeholder="{{__('请输入名称')}}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('问题数量') }} ( <span id="no-of-questions">0</span> )</label>
            <div id="questions-container" class="overflow-y-auto" style="max-height: 300px;"></div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-question-btn">
                <i class="isax isax-add"></i> {{ __('添加问题') }}
            </button>
        </div>
    </div>

    <x-slot:footer>
        <button class="btn bg-gray-100 rounded-pill me-2" type="button"
                data-bs-dismiss="modal">{{__('取消')}}
        </button>
        <button class="btn btn-secondary rounded-pill submit" type="submit">{{__('提交')}}</button>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="edit-id">
    </x-slot:footer>

</x-layouts.modal>

<div id="question-template" style="display: none;">
    <div class="mb-3 question-item">
        <div class="accordion" id="question-accordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <span class="accordion-button collapsed justify-content-between question-toggle"
                          data-bs-toggle="collapse"
                          data-bs-target="#collapse-question-content" aria-expanded="false" role="button">
                        <span class="fw-medium">{{__('问题')}} <span class="question-number">1</span></span>
                        <i class="isax isax-close-circle text-danger remove-question ms-3" style="cursor: pointer;"></i>
                    </span>
                </h2>

                <div id="collapse-question-content" class="accordion-collapse collapse" data-bs-parent="#question-accordion">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <label class="form-label">{{__('标题')}} <span class="text-danger">*</span></label>
                            <input type="text" name="questions[][title]" class="form-control question-title" placeholder="{{__('请输入标题')}}" required>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">{{__('选项')}} <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-outline-primary add-option-btn">
                                    <i class="isax isax-add"></i> {{__('添加选项')}}
                                </button>
                            </div>
                            <div class="options-container">
                                <div class="option-item mb-2">
                                    <div class="input-group">
                                    <span class="input-group-text">
                                        <input class="form-check-input correct-answer" type="radio" checked name="correct_answer_1" value="0" required>
                                    </span>
                                        <span class="input-group-text option-label">A</span>
                                        <input type="text" name="questions[][options][]" class="form-control option-text" placeholder="Option A" required>
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-option-btn" disabled>
                                            <i class="isax isax-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="option-item mb-2">
                                    <div class="input-group">
                                    <span class="input-group-text">
                                            <input class="form-check-input correct-answer" type="radio" name="correct_answer_1" value="1" required>
                                    </span>
                                        <span class="input-group-text option-label">B</span>
                                        <input type="text" name="questions[][options][]" class="form-control option-text" placeholder="Option B" required>
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-option-btn">
                                            <i class="isax isax-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{__('解析')}}</label>
                            <textarea name="questions[][explanation]" class="form-control explanation" rows="2" placeholder="{{__('请输入答案解析')}}"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const quizLang = {
        addTitle: @json(__('添加测验')),
        editTitle: @json(__('编辑测验')),
        minQuestion: @json(__('请至少添加一个问题')),
        titleRequired: @json(__('问题 :number 的标题不能为空')),
        minOptions: @json(__('问题 :number 至少需要2个选项')),
        optionRequired: @json(__('问题 :number 的选项不能为空')),
        answerRequired: @json(__('问题 :number 请选择正确答案')),
        optionPlaceholder: @json(__('选项 :label'))
    };

    function formatMessage(template, number) {
        if (!template) return '';
        return template.replace(':number', number);
    }

    function formatOptionPlaceholder(label) {
        const template = quizLang.optionPlaceholder || 'Option :label';
        return template.replace(':label', label);
    }

    // 验证表单
    function validateForm() {
        const questions = $('#questions-container .question-item');

        if (questions.length === 0) {
            showToast('warning', quizLang.minQuestion);
            return false;
        }

        let isValid = true;
        questions.each(function (index) {
            const questionItem = $(this);
            const labelIndex = index + 1;
            const title = questionItem.find('input[name*="[title]"]').val().trim();
            const options = questionItem.find('.option-item');

            if (!title) {
                isValid = false;
                showToast('warning', formatMessage(quizLang.titleRequired, labelIndex));
                return false;
            }

            if (options.length < 2) {
                isValid = false;
                showToast('warning', formatMessage(quizLang.minOptions, labelIndex));
                return false;
            }

            let hasEmptyOption = false;
            options.each(function () {
                if (!$(this).find('.option-text').val().trim()) {
                    hasEmptyOption = true;
                    return false;
                }
            });

            if (hasEmptyOption) {
                isValid = false;
                showToast('warning', formatMessage(quizLang.optionRequired, labelIndex));
                return false;
            }

            if (questionItem.find('.correct-answer:checked').length === 0) {
                isValid = false;
                showToast('warning', formatMessage(quizLang.answerRequired, labelIndex));
                return false;
            }
        });

        return isValid;
    }

    $(function () {
        const $modal = $('#form-modal');
        const $form = $('#form');
        const $questionsContainer = $('#questions-container');
        const $questionTemplate = $('#question-template .question-item').first();

        $('#form-modal #add-question-btn').on('click', function () {
            addQuestion();
        });

        $(document).on('click', '.add-option-btn', function () {
            addOption($(this).closest('.question-item'));
        });

        $(document).on('click', '.remove-option-btn', function (event) {
            event.preventDefault();
            event.stopPropagation();

            if ($(this).prop('disabled')) {
                return false;
            }

            const questionItem = $(this).closest('.question-item');
            const optionsContainer = questionItem.find('.options-container');

            if (optionsContainer.find('.option-item').length > 2) {
                $(this).closest('.option-item').remove();
                updateOptionsInQuestion(questionItem);
            }
        });

        $(document).on('click', '.remove-question', function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).closest('.question-item').remove();
            updateAllQuestions();
        });

        $modal.on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const params = JSON.parse(button.getAttribute('data-item'))
            if (!params) return

            populateForm(params);
        });

        $modal.on('hidden.bs.modal', function () {
            resetForm();
        });

        $('.submit').on('click', function () {
            if (!validateForm()) {
                return false;
            }

            showLoading();
            const formData = $form.serializeArray();
            const editId = $('#edit-id').val();

            let url, method;
            if (editId) {
                url = '{{ route('admin.quiz.update.html', ['quiz' => ':id']) }}'.replace(':id', editId);
                method = 'PUT';
            } else {
                url = '{{ route('admin.quiz.store.html') }}';
                method = 'POST';
            }

            $.ajax({
                url: url,
                type: method,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    if (data.code !== 0) {
                        showToast('error', data.msg);
                        return;
                    }

                    showToast('success', editId ? '{{ __('更新成功') }}' : '{{ __('创建成功') }}');
                    $modal.data('uploaded', true);
                    $modal.data('data', data.data);
                    $modal.modal('hide');
                },
                error: function () {
                    showToast('error', '{{ __('操作失败，请稍后再试！') }}');
                },
                complete: function () {
                    hideLoading();
                }
            });

            return false;
        });

        function resetForm() {
            if ($form.length) {
                $form[0].reset();
            }
            $questionsContainer.empty();
            $('#edit-id').val('');
            $('#no-of-questions').text(0);
            $modal.find('.modal-header h5').text(quizLang.addTitle);
        }

        function populateForm(params) {
            $modal.find('.modal-header h5').text(quizLang.editTitle);
            $('#edit-id').val(params.id || '');
            $('#quiz-title').val(params.title || params.name || '');

            const questions = extractQuestionList(params);
            if (questions.length) {
                questions.forEach(question => addQuestion(question));
            } else {
                addQuestion();
            }
        }

        function extractQuestionList(payload) {
            if (!payload) return [];
            if (Array.isArray(payload.questions)) return payload.questions;
            if (Array.isArray(payload.question_items)) return payload.question_items;
            if (Array.isArray(payload.items)) return payload.items;
            return [];
        }

        function addQuestion(questionData = null) {
            const template = $questionTemplate.clone();
            template.css('display', 'block');
            $questionsContainer.append(template);

            updateAllQuestions();
            const newQuestion = $questionsContainer.find('.question-item').last();

            if (questionData) {
                fillQuestionWithData(newQuestion, questionData);
            }

            openQuestion(newQuestion);
        }

        function openQuestion(questionItem) {
            const collapseElement = questionItem.find('.accordion-collapse')[0];
            if (collapseElement && typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
                new bootstrap.Collapse(collapseElement, {
                    toggle: true
                });
            }
        }

        function fillQuestionWithData(questionItem, questionData) {
            const title = questionData.title ?? questionData.name ?? '';
            const explanation = questionData.explanation ?? questionData.analysis ?? questionData.description ?? '';

            questionItem.find('input[name*="[title]"]').val(title);
            questionItem.find('textarea[name*="[explanation]"]').val(explanation);

            renderOptionsFromData(questionItem, questionData);
        }

        function renderOptionsFromData(questionItem, questionData) {
            const {options, correctIndex} = normalizeQuestionOptions(questionData);
            const optionsContainer = questionItem.find('.options-container');
            optionsContainer.empty();

            options.forEach((option, index) => {
                addOption(questionItem, option.text, index === correctIndex, true);
            });

            updateOptionsInQuestion(questionItem);
        }

        function normalizeQuestionOptions(questionData) {
            const rawOptions = extractOptionArray(questionData);
            const normalized = rawOptions.map(option => ({
                text: extractOptionText(option),
                isCorrect: isOptionMarkedCorrect(option)
            }));

            while (normalized.length < 2) {
                normalized.push({text: '', isCorrect: false});
            }

            let correctIndex = normalized.findIndex(option => option.isCorrect);
            if (correctIndex < 0) {
                correctIndex = resolveCorrectIndex(questionData, normalized);
            }

            correctIndex = clampCorrectIndex(correctIndex, normalized.length);

            return {
                options: normalized,
                correctIndex
            };
        }

        function extractOptionArray(questionData) {
            if (!questionData) return [];
            const candidates = ['options', 'choices', 'answers'];
            for (const key of candidates) {
                const value = questionData[key];
                if (Array.isArray(value) && value.length) {
                    return value;
                }
                if (value && typeof value === 'object') {
                    return Object.values(value);
                }
            }
            return [];
        }

        function extractOptionText(option) {
            if (typeof option === 'string') return option;
            if (typeof option === 'number') return String(option);
            if (option && typeof option === 'object') {
                return option.text ?? option.title ?? option.value ?? option.label ?? '';
            }
            return '';
        }

        function isOptionMarkedCorrect(option) {
            if (option && typeof option === 'object') {
                if (typeof option.is_correct !== 'undefined') return !!option.is_correct;
                if (typeof option.isCorrect !== 'undefined') return !!option.isCorrect;
                if (typeof option.correct !== 'undefined') return !!option.correct;
            }
            return false;
        }

        function resolveCorrectIndex(questionData, normalizedOptions) {
            if (!questionData) return -1;

            const numericKeys = ['correct_answer', 'correct_option', 'answer_index', 'correct'];
            for (const key of numericKeys) {
                if (typeof questionData[key] === 'number') {
                    return questionData[key];
                }
            }

            const stringKeys = ['correct_answer', 'answer', 'correct_option_value'];
            for (const key of stringKeys) {
                if (typeof questionData[key] === 'string') {
                    const matchIndex = normalizedOptions.findIndex(option => option.text === questionData[key]);
                    if (matchIndex >= 0) {
                        return matchIndex;
                    }
                }
            }

            return -1;
        }

        function clampCorrectIndex(index, total) {
            if (typeof index !== 'number' || Number.isNaN(index) || index < 0) {
                return 0;
            }
            if (index >= total) {
                return total - 1;
            }
            return index;
        }

        function addOption(questionItem, optionValue = '', isCorrect = false, skipReindex = false) {
            const optionsContainer = questionItem.find('.options-container');
            const optionIndex = optionsContainer.find('.option-item').length;
            const optionLabel = String.fromCharCode(65 + optionIndex);
            const placeholder = formatOptionPlaceholder(optionLabel);

            const newOption = $(
                '<div class="option-item mb-2">' +
                '<div class="input-group">' +
                '<span class="input-group-text">' +
                '<input class="form-check-input correct-answer" type="radio" value="' + optionIndex + '" required>' +
                '</span>' +
                '<span class="input-group-text option-label">' + optionLabel + '</span>' +
                '<input type="text" class="form-control option-text" placeholder="' + placeholder + '" required>' +
                '<button type="button" class="btn btn-outline-danger btn-sm remove-option-btn">' +
                '<i class="isax isax-trash"></i>' +
                '</button>' +
                '</div>' +
                '</div>'
            );

            newOption.find('.option-text').val(optionValue || '');
            if (isCorrect) {
                newOption.find('.correct-answer').prop('checked', true);
            }

            optionsContainer.append(newOption);

            if (!skipReindex) {
                updateOptionsInQuestion(questionItem);
            }
        }

        function getQuestionIndex(questionItem) {
            return $questionsContainer.find('.question-item').index(questionItem);
        }

        function updateOptionsInQuestion(questionItem) {
            const questionNum = getQuestionIndex(questionItem);
            const optionsContainer = questionItem.find('.options-container');
            const optionItems = optionsContainer.find('.option-item');

            optionItems.each(function (index) {
                const optionLabel = String.fromCharCode(65 + index);
                const placeholder = formatOptionPlaceholder(optionLabel);

                $(this).find('.option-label').text(optionLabel);
                $(this).find('input.option-text')
                    .attr('placeholder', placeholder)
                    .attr('name', 'questions[' + questionNum + '][options][' + index + ']');
                $(this).find('.correct-answer')
                    .attr('name', 'questions[' + questionNum + '][correct_answer]')
                    .val(index);

                const removeBtn = $(this).find('.remove-option-btn');
                removeBtn.prop('disabled', optionItems.length <= 2);
            });
        }

        function updateAllQuestions() {
            $questionsContainer.find('.question-item').each(function (index) {
                const questionNum = index;
                const accordionId = 'question-accordion-' + questionNum;
                const collapseId = 'collapse-question-content-' + questionNum;

                $(this).find('.accordion').attr('id', accordionId);
                $(this).find('.accordion-collapse')
                    .attr('id', collapseId)
                    .attr('data-bs-parent', '#' + accordionId);
                $(this).find('.question-toggle').attr('data-bs-target', '#' + collapseId);

                $(this).find('.question-number').text(index + 1);

                $(this).find('input[name*="[title]"]').attr('name', 'questions[' + questionNum + '][title]');
                $(this).find('textarea[name*="[explanation]"]').attr('name', 'questions[' + questionNum + '][explanation]');

                updateOptionsInQuestion($(this));
            });

            updateNoOfQuestions();
        }

        function updateNoOfQuestions() {
            const count = $questionsContainer.find('.question-item').length;
            $('#no-of-questions').text(count);
        }
    });
</script>
