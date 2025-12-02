<x-layouts.modal id="form-modal" title="{{ __('添加测验')}}" class="modal-lg">

    <div class="modal-body pb-0">
        <div class="mb-3">
            <label class="form-label">Quiz Title <span class="text-danger"> *</span></label>
            <input type="text" class="form-control">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">No of Questions <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="no_of_questions" readonly>
                </div>
            </div>
        </div>

        <!-- 问题列表容器 -->
        <div class="mb-3">
            <label class="form-label">Questions</label>
            <div id="questions-container" class="overflow-y-auto" style="max-height: 300px;">
                <!-- 动态问题项将在这里添加 -->
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-question-btn">
                <i class="isax isax-add"></i> Add Question
            </button>
        </div>
    </div>

    <!-- 替换现有的问题模板部分 -->
    <div id="question-template" style="display: none;">
        <div class="mb-3 question-item">
            <div class="accordion" id="questionAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <span class="accordion-button collapsed justify-content-between question-toggle"
                              data-bs-toggle="collapse"
                              data-bs-target="#collapseQuestionContent" aria-expanded="false" role="button">
                            <span class="fw-medium">Question <span class="question-number">1</span></span>
                            <i class="isax isax-close-circle text-danger remove-question ms-3"></i>
                        </span>
                    </h2>
                    <div id="collapseQuestionContent" class="accordion-collapse collapse" data-bs-parent="#questionAccordion">
                        <div class="accordion-body">
                            <!-- 问题标题 -->
                            <div class="mb-3">
                                <label class="form-label">Question Title</label>
                                <input type="text" class="form-control question-title" placeholder="Enter question title">
                            </div>

                            <!-- 选项 -->
                            <div class="mb-3">
                                <label class="form-label">Options</label>
                                <div class="option-item mb-2">
                                    <div class="input-group">
                                    <span class="input-group-text">
                                        <input class="form-check-input correct-answer" type="radio" checked name="correct_answer_1" value="a">
                                    </span>
                                        <span class="input-group-text">A</span>
                                        <input type="text" class="form-control option-text" placeholder="Option A">
                                    </div>
                                </div>
                                <div class="option-item mb-2">
                                    <div class="input-group">
                                    <span class="input-group-text">
                                        <input class="form-check-input correct-answer" type="radio" name="correct_answer_1" value="b">
                                    </span>
                                        <span class="input-group-text">B</span>
                                        <input type="text" class="form-control option-text" placeholder="Option B">
                                    </div>
                                </div>
                                <div class="option-item mb-2">
                                    <div class="input-group">
                                    <span class="input-group-text">
                                        <input class="form-check-input correct-answer" type="radio" name="correct_answer_1" value="c">
                                    </span>
                                        <span class="input-group-text">C</span>
                                        <input type="text" class="form-control option-text" placeholder="Option C">
                                    </div>
                                </div>
                                <div class="option-item mb-2">
                                    <div class="input-group">
                                    <span class="input-group-text">
                                        <input class="form-check-input correct-answer" type="radio" name="correct_answer_1" value="d">
                                    </span>
                                        <span class="input-group-text">D</span>
                                        <input type="text" class="form-control option-text" placeholder="Option D">
                                    </div>
                                </div>
                            </div>

                            <!-- 解释 -->
                            <div class="mb-3">
                                <label class="form-label">Explanation</label>
                                <textarea class="form-control explanation" rows="2" placeholder="Enter explanation for the answer"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            // 确保DOM完全加载后再执行
            const addButton = document.getElementById('add-question-btn');
            if (addButton) {
                addButton.addEventListener('click', function () {
                    addQuestion();
                });
            } else {
                console.error('Add question button not found');
            }
        })

        // 更新问题数量显示
        function updateNoOfQuestions() {
            const questions = document.querySelectorAll('.question-item');
            document.getElementById('no_of_questions').value = (questions.length || 1) - 1;
        }

        // 更新添加问题函数
        function addQuestion() {
            // let questionCount = document.querySelectorAll('.question-item').length || 0;
            const template = document.getElementById('question-template').firstElementChild.cloneNode(true);
            const container = document.getElementById('questions-container');

            // // 更新问题编号
            // template.querySelectorAll('.question-number').forEach(span => {
            //     span.textContent = questionCount;
            // });

            // 更新折叠面板ID以确保唯一性
            const collapseDiv = template.querySelector('[id^="collapseQuestionContent"]');
            const toggle = template.querySelector('.question-toggle');

            const collapseId = Date.now();
            const newCollapseId = 'collapseQuestionContent' + collapseId;
            collapseDiv.id = newCollapseId;
            if (toggle) {
                toggle.setAttribute('data-bs-target', '#' + newCollapseId);
            }
            collapseDiv.setAttribute('data-bs-parent', '#questionAccordion' + collapseId);

            // 更新单选按钮名称以确保唯一性
            const radioButtons = template.querySelectorAll('.correct-answer');
            radioButtons.forEach(radio => {
                radio.name = 'correct_answer_' + collapseId;
            });

            // 添加删除事件
            const removeButton = template.querySelector('.remove-question');
            if (removeButton) {
                removeButton.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    template.remove();
                    updateQuestionNumbers();
                });
            }

            container.appendChild(template);
            updateNoOfQuestions();
            updateQuestionNumbers();
        }

        // 更新问题编号函数
        function updateQuestionNumbers() {
            let questions = document.querySelectorAll('.question-item');
            questions.forEach((question, index) => {
                const number = index + 1;
                question.querySelectorAll('.question-number').forEach(span => {
                    span.textContent = number;
                });

                // 更新折叠面板相关属性
                const collapseDiv = question.querySelector('[id^="collapseQuestionContent"]');
                const toggle = question.querySelector('.question-toggle');

                const newCollapseId = 'collapseQuestionContent' + number;
                if (collapseDiv) collapseDiv.id = newCollapseId;
                if (toggle) toggle.setAttribute('data-bs-target', '#' + newCollapseId);

                // 更新单选按钮名称
                const radioButtons = question.querySelectorAll('.correct-answer');
                radioButtons.forEach(radio => {
                    radio.name = 'correct_answer_' + number;
                });
            });
            updateNoOfQuestions();
        }


    </script>

    <x-slot:footer>
        <button class="btn bg-gray-100 rounded-pill me-2" type="button"
                data-bs-dismiss="modal">{{__('取消')}}
        </button>
        <button class="btn btn-secondary rounded-pill" type="submit" onclick="handleSubmit()">{{__('提交')}}</button>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="edit-id">
    </x-slot:footer>
</x-layouts.modal>
