<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/select2/css/select2.min.css')}}">
<x-admin.head/>
<script src="{{web_resource_url('assets/admin/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('storage/assets/js/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/admin/js/fabric.min.js')}}" type="text/javascript"></script>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('课程管理')}}"/>

    <div class="content">
        <div class="container">

            <div class="row">

                <x-admin.sidebar active="course"/>

                <div class="col-lg-9">

                    <form id="course-form" novalidate="novalidate">
                        <div class="add-course-item">
                            <div class="wizard">
                                <ul class="form-wizard-steps" id="progressbar2">
                                    <li class="progress-active">
                                        <div class="profile-step">
											<span class="dot-active mb-2">
												<span class="number">01</span>
												<span class="tickmark"><i class="fa-solid fa-check"></i></span>
											</span>
                                            <div class="step-section">
                                                <p>{{__('课程信息')}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="profile-step">
											<span class="dot-active mb-2">
												<span class="number">02</span>
												<span class="tickmark"><i class="fa-solid fa-check"></i></span>
											</span>
                                            <div class="step-section">
                                                <p>{{__('课程媒体')}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="profile-step">
											<span class="dot-active mb-2">
												<span class="number">03</span>
												<span class="tickmark"><i class="fa-solid fa-check"></i></span>
											</span>
                                            <div class="step-section">
                                                <p>{{__('证书')}}</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="initialization-form-set">
                                <fieldset class="form-inner wizard-form-card" id="first">
                                    <div class="title">
                                        <h5>{{__('课程信息')}}</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-block">
                                                <label class="form-label">{{__('标题')}}<span
                                                        class="text-danger ms-1">*</span></label>
                                                <input type="text" id="title" name="title" class="form-control" value="{{$course->title??''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label class="form-label">{{__('分类')}}<span
                                                        class="text-danger ms-1">*</span></label>
                                                <select id="category" name="category_id" class="select form-control">
                                                    @for($i = 0; $i < 10; $i++)
                                                        <option value="{{$i}}" @selected($i == $course->category_id??0)>{{__('分类')}}{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label class="form-label">{{__('等级')}}<span
                                                        class="text-danger ms-1">*</span></label>
                                                <select id="level" name="level" class="select form-control">
                                                    @for($i = 0; $i < 10; $i++)
                                                        <option value="{{$i}}" @selected($i == $course->level??0)>{{__('等级')}}{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label class="form-label">{{__('语言')}}<span
                                                        class="text-danger ms-1">*</span></label>
                                                <select id="language" name="language" class="select form-control">
                                                    <option value="0">Select</option>
                                                    <option value="1" @selected($course->language??0 == 1)>{{__('中文简体')}}</option>
                                                    <option value="2" @selected($course->language??0 == 2)>{{__('中文繁體')}}</option>
                                                    <option value="3" @selected($course->language??0 == 3)>{{__('英文')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-block">
                                                <label class="form-label">{{__('简介')}}<span
                                                        class="text-danger ms-1">*</span></label>
                                                <input type="text" id="short" name="short" class="form-control" value="{{$course->short??''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-block">
                                                <label class="form-label">{{__('內容')}}<span
                                                        class="text-danger ms-1">*</span></label>
                                                <textarea id="description" name="description" class="form-control tinymce-editor">{!! $course->description??'' !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="add-form-btn widget-next-btn submit-btn d-flex justify-content-end mb-0">
                                        <div class="btn-left">
                                            <a href="javascript:void(0);" data-status="0" data-keep="1" class="btn main-btn btn-submit" style="background: #00b050;border-color: #00b050;">{{__('储存')}}
                                            </a>
                                            <a href="javascript:void(0);" data-status="0" data-keep="0" class="btn main-btn btn-submit"
                                               style="background: #0070c0;border-color: #0070c0;">{{__('储存及离开')}}
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-secondary next_btns">{{__('下一步')}}</a>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-inner wizard-form-card">
                                    <div class="title">
                                        <h5>{{__('课程媒体')}}</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-block">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <label class="form-label">{{__('封面图')}}<span
                                                                class="text-danger ms-1">*</span></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="upload-img-section d-flex align-items-center justify-content-center"
                                                             id="course-upload-img-section">
                                                            <input type="file" id="upload-img-input" style="display: none;"
                                                                   accept="image/jpeg, image/png, image/gif, image/webp">
                                                            <div class="upload-content" id="upload-content">
                                                                @if($course->id > 0 && !empty($raw_thumbnail = $course->getRawOriginal('thumbnail')))
                                                                    <img src="{{asset($course->thumbnail)}}"
                                                                         class="img-fluid h-100" alt="" style="max-height: 120px;">
                                                                    <input type="hidden" name="thumbnail_url" value="{{$raw_thumbnail}}">
                                                                @else
                                                                    <span class="d-flex align-items-center justify-content-center mb-1">
                                                                        <i class="isax isax-image5 text-secondary fs-24 text-center"></i>
                                                                    </span>
                                                                    <p class="text-center fw-medium mb-1">{{__('上传图片')}}</p>
                                                                    <span class="text-center">JPEG, PNG, GIF, and WebP formats, up to 5 MB</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr class="mt-4 mb-4">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                            <div class="input-block">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <label class="form-label mb-0">{{__('课程章节')}}<span class="text-danger ms-1">*</span></label>
                                                    <button type="button" class="btn btn-primary btn-sm" id="add-chapter-btn">
                                                        <i class="fa-solid fa-plus me-1"></i>{{__('新增章节')}}
                                                    </button>
                                                </div>
                                                @include('admin.course.components.chapters-container')
                                            </div>
                                        </div>
                                        <div id="videoModal" style="display: none;">
                                            <div class="modal-content1">
                                                <span class="close-btn" id="closeModal">&times;</span>
                                                <iframe id="youtubeIframe" allowfullscreen=""></iframe>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="add-form-btn widget-next-btn submit-btn">
                                        <div class="btn-left">
                                            <a href="javascript:void(0);"
                                               class="btn btn-light main-btn prev_btns d-flex align-items-center"><i
                                                    class="isax isax-arrow-left-2 me-1"></i>{{__('上一步')}}</a>
                                        </div>
                                        <div class="btn-left">
                                            <a href="javascript:void(0);" data-status="0" data-keep="1" class="btn main-btn btn-submit" style="background: #00b050;border-color: #00b050;">{{__('储存')}}
                                            </a>
                                            <a href="javascript:void(0);" data-status="0" data-keep="0" class="btn main-btn btn-submit"
                                               style="background: #0070c0;border-color: #0070c0;">{{__('储存及离开')}}
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-secondary next_btns">{{__('下一步')}}</a>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-inner wizard-form-card">
                                    <div>
                                        <div class="input-block mb-2">
                                            <label class="form-label">
                                                {{__('证书')}}
                                                <span class="text-danger ms-1">*</span>
                                            </label>
                                            <select id="certificate-id" name="certificate_id" class="select"></select>
                                        </div>
                                    </div>
                                    <div class="add-form-btn widget-next-btn submit-btn">
                                        <div class="btn-left">
                                            <a href="javascript:void(0);" class="btn btn-light main-btn prev_btns"><i
                                                    class="isax isax-arrow-left-2 me-1"></i>{{__('上一步')}}</a>
                                        </div>
                                        <div class="btn-left">
                                            <a href="javascript:void(0);" data-status="0" data-keep="1" class="btn main-btn btn-submit" style="background: #00b050;border-color: #00b050;">{{__('储存')}}
                                            </a>
                                            <a href="javascript:void(0);" data-status="0" data-keep="0" class="btn main-btn btn-submit"
                                               style="background: #0070c0;border-color: #0070c0;">{{__('储存及离开')}}
                                            </a>
                                            <a href="javascript:void(0);" data-status="2" data-keep="0" class="btn btn-secondary btn-submit">{{__('发布')}}</a>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" id="status" value="{{$course->status??0}}">
                        <input type="hidden" id="edit-id" value="{{$course->id??''}}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

</div>

@include('admin.course.components.chapter-template')
@include('admin.course.components.unit-template')
@include('admin.quiz.new')
@include('admin.certificate.new')

</body>
<script>
    let thumbnailImageFile = null;
    // upload img
    (function () {
        const uploadSection = document.getElementById("course-upload-img-section");
        const fileInput = document.getElementById("upload-img-input");

        if (uploadSection && fileInput) {
            // Open file input when clicking the section
            uploadSection.addEventListener("click", function () {
                fileInput.click();
            });

            // Handle file input change
            fileInput.addEventListener("change", function () {
                handleFileUpload(fileInput.files[0]);
            });

            // Drag and drop functionality
            uploadSection.addEventListener("dragover", function (event) {
                event.preventDefault();
                uploadSection.classList.add("drag-over");
            });

            uploadSection.addEventListener("dragleave", function () {
                uploadSection.classList.remove("drag-over");
            });

            uploadSection.addEventListener("drop", function (event) {
                event.preventDefault();
                uploadSection.classList.remove("drag-over");
                const file = event.dataTransfer.files[0];
                if (file) {
                    handleFileUpload(file);
                }
            });

            // Function to handle file upload (basic example)
            function handleFileUpload(file) {
                if (file && file.size <= 5 * 1024 * 1024) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = document.createElement('img');
                        preview.src = e.target.result;
                        preview.style.maxHeight = '120px';
                        preview.classList.add('img-fluid', 'h-100');

                        // 添加到上传区域
                        const uploadSection = document.getElementById('upload-content');
                        if (uploadSection) {
                            uploadSection.innerHTML = '';
                            uploadSection.appendChild(preview);
                        }
                    };
                    reader.readAsDataURL(file);
                    thumbnailImageFile = file;
                } else {
                    showToast('error', "File size exceeds 5 MB or invalid format.");
                }
            }
        }
    })();

    $(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const step = (urlParams.get('step') || 1) - 1;
        $('#progressbar2 li').map(function (index, item) {
            if (index < step) {
                $(item).attr('class', 'progress-activated');
            } else if (index === step) {
                $(item).attr('class', 'progress-active');
            }
        })
        const $set = $('.initialization-form-set fieldset');
        $set.hide()
        $set.eq(step).show()

        const $certificateSelect = $('#certificate-id');

        // 初始化单元测验选择器
        function initUnitQuizSelect($select) {
            if ($select.length && !$select.data('select2')) {
                $select.select2({
                    placeholder: '{{__('请选择或搜索测验')}}',
                    ajax: {
                        url: '{{route('admin.get-quiz-list.html')}}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                keyword: params.term,
                                page: params.page || 1,
                                limit: 15
                            };
                        },
                        processResults: function ({code, data}) {
                            const results = [];
                            if (data.current_page === 1) {
                                results.push({
                                    id: 'add_new',
                                    text: '{{__('新增测验')}}',
                                    isAddButton: true,
                                    disabled: true
                                });
                            }

                            if (code === 0 && data && data.data) {
                                const list = data.data.map(function (item) {
                                    return {
                                        id: item.id,
                                        text: item.title
                                    };
                                });
                                results.push.apply(results, list);
                            }

                            return {
                                results: results,
                                pagination: {
                                    more: code === 0 && data && data.current_page < data.last_page
                                }
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 0,
                    templateResult: function (data) {
                        if (data.loading) {
                            return data.text;
                        }
                        if (data.id === 'add_new' || data.isAddButton) {
                            return $('<div class="select2-add-new-option" style="padding: 8px;"><button type="button" class="btn btn-primary w-100" style="pointer-events: auto; border: none;" data-bs-toggle="modal" data-bs-target="#form-modal"><i class="fa fa-plus me-1"></i>{{__('新增测验')}}</button></div>');
                        }
                        return $('<div style="padding: 8px;">' + data.text + '</div>');
                    },
                    templateSelection: function (data) {
                        if (data.id === 'add_new' || data.isAddButton) {
                            return '';
                        }
                        return data.text;
                    }
                });

                const $modal = $('#form-modal');
                $modal.on('show.bs.modal', function () {
                    $select.select2('close');
                });
            }
        }

        // 初始化所有现有的单元测验选择器（排除模板中的）
        $('#chapters-container .unit-quiz-select').each(function () {
            initUnitQuizSelect($(this));
        });

        $certificateSelect.select2({
            placeholder: '{{__('请选择或搜索证书')}}',
            ajax: {
                url: '{{route('admin.get-certificate-list.html')}}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        keyword: params.term,
                        page: params.page || 1,
                        limit: 15
                    };
                },
                processResults: function ({code, data}) {
                    const results = [];
                    if (data.current_page === 1) {
                        results.push({
                            id: 'add_new',
                            text: '{{__('新增证书')}}',
                            isAddButton: true,
                            disabled: true
                        });
                    }

                    if (code === 0 && data && data.data) {
                        const list = data.data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.title
                            };
                        });
                        results.push.apply(results, list);
                    }

                    return {
                        results: results,
                        pagination: {
                            more: code === 0 && data && data.current_page < data.last_page
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: function (data) {
                if (data.loading) {
                    return data.text;
                }
                if (data.id === 'add_new' || data.isAddButton) {
                    return $('<div class="select2-add-new-option" style="padding: 8px;"><button type="button" class="btn btn-primary w-100" style="pointer-events: auto; border: none;" data-bs-toggle="modal" data-bs-target="#certificate-form-modal"><i class="fa fa-plus me-1"></i>{{__('新增证书')}}</button></div>');
                }
                return $('<div style="padding: 8px;">' + data.text + '</div>');
            },
            templateSelection: function (data) {
                if (data.id === 'add_new' || data.isAddButton) {
                    return '';
                }
                return data.text;
            }
        });

        @if($course && $course->certificate)
        const option = new Option('{{$course->certificate->name??''}}', {{$course->certificate->id??0}}, true, true);
        $certificateSelect.append(option).trigger('change');
        @endif

        const $modal = $('#form-modal');
        const $certificateModal = $('#certificate-form-modal');

        $certificateModal.on('show.bs.modal', function () {
            $certificateSelect.select2('close');
        });

        $modal.on('hidden.bs.modal', function () {
            const uploaded = $(this).data('uploaded');
            const data = $(this).data('data');
            if (uploaded && data) {
                // 将新创建的测验添加到所有单元测验选择器中
                $('.unit-quiz-select').each(function () {
                    const $select = $(this);
                    if (!$select.find('option[value="' + data.id + '"]').length) {
                        const option = new Option(data.title, data.id, true, true);
                        $select.append(option).trigger('change');
                    }
                });
            }
        });

        $certificateModal.on('hidden.bs.modal', function () {
            const uploaded = $(this).data('uploaded');
            const data = $(this).data('data');
            if (uploaded && data) {
                const option = new Option(data.title, data.id, true, true);
                $certificateSelect.append(option).trigger('change');
            }
        });

        // 章节和单元管理
        const $chapterTemplate = $('#chapter-template .chapter-item').first();
        const $unitTemplate = $('#unit-template .unit-item').first();
        let chapterIndex = $('#chapters-container .chapter-item').length;

        // 更新所有章节编号
        function updateChapterNumbers() {
            $('#chapters-container .chapter-item').each(function (index) {
                $(this).find('.chapter-index-number').text(index + 1);
            });
            chapterIndex = $('#chapters-container .chapter-item').length;
        }

        // 初始化章节操作栏的显示状态
        function initChapterActionsVisibility() {
            $('#chapters-container .chapter-item').each(function () {
                const $collapse = $(this).find('.accordion-collapse');
                const $actions = $(this).find('.chapter-actions');
                if ($collapse.hasClass('show')) {
                    $actions.removeClass('hidden');
                } else {
                    $actions.addClass('hidden');
                }
            });
        }

        // 页面加载时初始化
        initChapterActionsVisibility();

        // 添加章节
        $(document).on('click', '#add-chapter-btn', function () {
            const template = $chapterTemplate.clone();
            const accordionId = `chapter-accordion-${chapterIndex}`;
            const collapseId = `chapter-collapse-${chapterIndex}`;

            // 更新属性
            template.attr('data-chapter-index', chapterIndex);
            template.find('.accordion').attr('id', accordionId);
            template.find('.accordion-button').attr('data-bs-target', '#' + collapseId);
            template.find('.accordion-collapse').attr('id', collapseId).attr('data-bs-parent', '#' + accordionId);
            template.find('.add-unit-btn').attr('data-chapter-index', chapterIndex);
            template.find('.units-container').attr('data-chapter-index', chapterIndex);
            template.find('.chapter-title-input').attr('name', `chapters[${chapterIndex}][title]`).prop('disabled', false);
            template.find('input[name*="[id]"]').attr('name', `chapters[${chapterIndex}][id]`).prop('disabled', false);
            template.find('.chapter-index-number').text(chapterIndex + 1);

            template.css('display', 'block');
            $('#chapters-container').append(template);
            updateChapterNumbers()
            chapterIndex++;
        });

        // 删除章节
        $(document).on('click', '.remove-chapter-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (confirm('{{__('确定要删除这个章节吗？这将删除该章节下的所有单元。')}}')) {
                $(this).closest('.chapter-item').remove();
                updateChapterNumbers();
            }
        });

        // 添加单元
        let unitIndexMap = {};
        $(document).on('click', '.add-unit-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const chapterIndex = $(this).data('chapter-index');
            if (!chapterIndex && chapterIndex !== 0) {
                console.error('Chapter index not found');
                return;
            }
            if (!unitIndexMap[chapterIndex]) {
                unitIndexMap[chapterIndex] = $(this).closest('.chapter-item').find('.unit-item').length;
            }
            const unitIndex = unitIndexMap[chapterIndex];

            const template = $unitTemplate.clone();
            const youtubeRadioId = `unit_type_youtube_${chapterIndex}_${unitIndex}`;
            const pdfRadioId = `unit_type_pdf_${chapterIndex}_${unitIndex}`;
            const htmlRadioId = `unit_type_html_${chapterIndex}_${unitIndex}`;

            // 更新属性
            template.attr('data-unit-index', unitIndex);
            template.find('input[name*="[title]"]').attr('name', `chapters[${chapterIndex}][units][${unitIndex}][title]`).prop('disabled', false);

            // 更新单选按钮
            const $youtubeRadio = template.find('input[value="0"]');
            $youtubeRadio.attr('name', `chapters[${chapterIndex}][units][${unitIndex}][type]`)
                .attr('id', youtubeRadioId)
                .prop('disabled', false);
            $youtubeRadio.closest('.form-check').find('label').attr('for', youtubeRadioId);

            const $pdfRadio = template.find('input[value="1"]');
            $pdfRadio.attr('name', `chapters[${chapterIndex}][units][${unitIndex}][type]`)
                .attr('id', pdfRadioId)
                .prop('disabled', false);
            $pdfRadio.closest('.form-check').find('label').attr('for', pdfRadioId);

            const $htmlRadio = template.find('input[value="2"]');
            $htmlRadio.attr('name', `chapters[${chapterIndex}][units][${unitIndex}][type]`)
                .attr('id', htmlRadioId)
                .prop('disabled', false);
            $htmlRadio.closest('.form-check').find('label').attr('for', htmlRadioId);

            // 更新视频URL输入
            template.find('input[name*="[video_url]"]').attr('name', `chapters[${chapterIndex}][units][${unitIndex}][video_url]`).prop('disabled', false);

            // 更新HTML内容输入
            template.find('textarea[name*="[content]"]').attr('name', `chapters[${chapterIndex}][units][${unitIndex}][content]`).prop('disabled', false);

            // 更新PDF文件输入
            template.find('.unit-pdf-file-input').attr('name', `chapters[${chapterIndex}][units][${unitIndex}][pdf]`).prop('disabled', false);

            // 更新测验选择器
            const $quizSelect = template.find('.unit-quiz-select');
            $quizSelect.attr('name', `chapters[${chapterIndex}][units][${unitIndex}][quiz_id]`)
                .attr('data-chapter-index', chapterIndex)
                .attr('data-unit-index', unitIndex);

            // 更新隐藏的ID字段
            template.find('input[name*="[id]"]').attr('name', `chapters[${chapterIndex}][units][${unitIndex}][id]`).prop('disabled', false);

            template.css('display', 'block');
            $(this).closest('.chapter-item').find('.units-container').append(template);

            // 初始化新增单元中的 TinyMCE
            const $newUnit = $(this).closest('.chapter-item').find('.units-container .unit-item').last();
            const $newDescriptionEditor = $newUnit.find('textarea[name*="[description]"]').first();
            if ($newDescriptionEditor.length && typeof initSingleTinyMCE === 'function') {
                if (!$newDescriptionEditor.attr('id')) {
                    $newDescriptionEditor.attr('id', 'tinymce-unit-description-' + chapterIndex + '-' + unitIndex + '-' + Date.now());
                }
                initSingleTinyMCE('#' + $newDescriptionEditor.attr('id'));
            }
            $newUnit.find('.unit-content-html').hide();

            // 初始化测验选择器（确保是新添加的元素，不是模板中的）
            const $newQuizSelect = $newUnit.find('.unit-quiz-select').last();
            // 如果已经被初始化，先销毁
            if ($newQuizSelect.data('select2')) {
                $newQuizSelect.select2('destroy');
            }
            initUnitQuizSelect($newQuizSelect);

            unitIndexMap[chapterIndex]++;
        });

        // 删除单元
        $(document).on('click', '.remove-unit-btn', function () {
            if (confirm('{{__('确定要删除这个单元吗？')}}')) {
                $(this).closest('.unit-item').remove();
            }
        });

        function getEditorValue($textarea) {
            if (typeof tinymce !== 'undefined' && $textarea.attr('id')) {
                const editor = tinymce.get($textarea.attr('id'));
                if (editor) {
                    return editor.getContent();
                }
            }

            return $textarea.val();
        }

        function setEditorValue($textarea, value) {
            if (typeof tinymce !== 'undefined' && $textarea.attr('id')) {
                const editor = tinymce.get($textarea.attr('id'));
                if (editor) {
                    editor.setContent(value || '');
                }
            }

            $textarea.val(value || '');
        }

        function clearUnitContentFields($unitItem, unitType) {
            const $contentEditor = $unitItem.find('textarea[name*="[content]"]');

            if (unitType !== 0) {
                $unitItem.find('input[name*="[video_url]"]').val('');
            }
            if (unitType !== 1) {
                const $pdfInput = $unitItem.find('.unit-pdf-file-input');
                $pdfInput.val('');
                $unitItem.find('.unit-pdf-file-name').val('');
                $unitItem.find('.unit-pdf-existing-file').hide();
            }
            if (unitType !== 2) {
                setEditorValue($contentEditor, '');
            }
        }

        function syncHtmlEditor($unitItem) {
            const $contentTextarea = $unitItem.find('textarea[name*="[content]"]');
            const $contentBlock = $unitItem.find('.unit-content-html');
            if (!$contentTextarea.length || !$contentBlock.length) {
                return;
            }

            if (!$contentTextarea.attr('id')) {
                const chapterIndex = $unitItem.closest('.chapter-item').data('chapter-index');
                const unitIndex = $unitItem.data('unit-index');
                if (chapterIndex !== undefined && unitIndex !== undefined) {
                    $contentTextarea.attr('id', `unit-content-${chapterIndex}-${unitIndex}-${Date.now()}`);
                }
            }

            if (typeof initSingleTinyMCE === 'function') {
                initSingleTinyMCE('#' + $contentTextarea.attr('id'));
            }
        }

        function updateUnitTypeVisibility($unitItem, shouldClear = false) {
            const unitType = parseInt($unitItem.find('.unit-type-radio:checked').val() || '0');
            const $youtubeContent = $unitItem.find('.unit-content-youtube');
            const $pdfContent = $unitItem.find('.unit-content-pdf');
            const $htmlContent = $unitItem.find('.unit-content-html');
            const $descriptionBlock = $unitItem.find('textarea[name*="[description]"]').closest('.mb-4').first();

            $youtubeContent.toggle(unitType === 0);
            $pdfContent.toggle(unitType === 1);
            $descriptionBlock.toggle(true);

            if (unitType === 2) {
                $htmlContent.show();
                syncHtmlEditor($unitItem);
            } else {
                $htmlContent.hide();
            }

            if (shouldClear) {
                clearUnitContentFields($unitItem, unitType);
            }
        }

        // 切换单元类型
        $(document).on('change', '.unit-type-radio', function () {
            updateUnitTypeVisibility($(this).closest('.unit-item'), true);
        });

        $('#chapters-container .unit-item').each(function () {
            updateUnitTypeVisibility($(this), false);
        });

        // PDF文件选择按钮点击事件
        $(document).on('click', '.unit-pdf-select-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const $fileInput = $(this).siblings('.unit-pdf-file-input');
            $fileInput.click();
        });

        // PDF文件选择变化事件
        $(document).on('change', '.unit-pdf-file-input', function () {
            const $fileNameInput = $(this).siblings('.unit-pdf-file-name');
            const $existingFile = $(this).closest('.unit-content-pdf').find('.unit-pdf-existing-file');
            const file = this.files[0];

            if (file) {
                $fileNameInput.val(file.name);
                // 如果选择了新文件，隐藏现有文件链接
                $existingFile.hide();
            } else {
                $fileNameInput.val('');
            }
        });

        // 视频预览
        $(document).on('click', '.preview-video-btn', function () {
            const videoUrl = $(this).data('video-url');
            if (videoUrl) {
                // 提取YouTube视频ID
                let videoId = '';
                const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
                const match = videoUrl.match(regExp);
                if (match && match[2].length === 11) {
                    videoId = match[2];
                }

                if (videoId) {
                    $('#youtubeIframe').attr('src', 'https://www.youtube.com/embed/' + videoId);
                    $('#videoModal').css('display', 'flex').fadeIn();
                } else {
                    showToast('error', '{{__('无效的Youtube URL')}}');
                }
            }
        });

        // 关闭视频模态框
        $(document).on('click', '#closeModal', function () {
            $('#videoModal').fadeOut();
            $('#youtubeIframe').attr('src', '');
        });

        // 点击模态框外部关闭
        $(document).on('click', '#videoModal', function (e) {
            if ($(e.target).is('#videoModal')) {
                $(this).fadeOut();
                $('#youtubeIframe').attr('src', '');
            }
        });

        const $form = $('#course-form');
        $('.btn-submit').click(function () {
            showLoading();
            if (window.tinymce) {
                tinymce.triggerSave();
            }
            const form = $form.serializeArray();
            let editId = $('#edit-id').val();
            let formData = new FormData();
            let status = parseInt($(this).data('status'));
            let $status = $('#status').val();
            let keep = $(this).data('keep');

            formData.append('status', status === 2 ? status : $status)

            // 处理普通表单字段
            _.each(form, (value) => {
                // 跳过单元和课程相关的字段，稍后单独处理
                if (value.name === 'description' || value.name.startsWith('units[')) {
                    return;
                }
                formData.append(value.name, value.value);
            });

            const editor = window.tinymce ? tinymce.get('description') : null;
            const description = editor ? editor.getContent() : ($('#description').val() || '');
            formData.append('description', description);

            if (thumbnailImageFile) {
                formData.append('thumbnail', thumbnailImageFile);
            }

            // 处理章节和单元数据
            $('#course-form .chapter-item').each(function (chapterIdx) {
                const $chapter = $(this);
                const chapterIndex = $chapter.data('chapter-index') !== undefined ? $chapter.data('chapter-index') : chapterIdx;
                const chapterTitle = $chapter.find('input[name*="[title]"]').val();

                if (chapterTitle) {
                    formData.append(`chapters[${chapterIndex}][title]`, chapterTitle);

                    // 处理章节ID（如果存在）
                    const chapterId = $chapter.find('input[name*="[id]"]').val();
                    if (chapterId) {
                        formData.append(`chapters[${chapterIndex}][id]`, chapterId);
                    }

                    // 处理单元
                    $chapter.find('.unit-item').each(function (unitIdx) {
                        const $unit = $(this);
                        const unitIndex = $unit.data('unit-index') !== undefined ? $unit.data('unit-index') : unitIdx;
                        const unitTitle = $unit.find('input[name*="[title]"]').val();
                        const unitType = $unit.find('.unit-type-radio:checked').val();

                        if (unitTitle) {
                            formData.append(`chapters[${chapterIndex}][units][${unitIndex}][title]`, unitTitle);
                            formData.append(`chapters[${chapterIndex}][units][${unitIndex}][type]`, unitType);

                            // 处理单元ID（如果存在）
                            const unitId = $unit.find('input[name*="[id]"]').val();
                            if (unitId) {
                                formData.append(`chapters[${chapterIndex}][units][${unitIndex}][id]`, unitId);
                            }

                            // 处理测验绑定
                            const quizId = $unit.find('.unit-quiz-select').val();
                            if (quizId) {
                                formData.append(`chapters[${chapterIndex}][units][${unitIndex}][quiz_id]`, quizId);
                            }

                            // 处理单元描述（TinyMCE 已通过 triggerSave 同步到 textarea）
                            const unitDescription = $unit.find('textarea[name*="[description]"]').val() || '';
                            formData.append(`chapters[${chapterIndex}][units][${unitIndex}][description]`, unitDescription);

                            if (unitType == 0) {
                                const videoUrl = $unit.find('input[name*="[video_url]"]').val();
                                if (videoUrl) {
                                    formData.append(`chapters[${chapterIndex}][units][${unitIndex}][video_url]`, videoUrl);
                                }
                            } else if (unitType == 1) {
                                const pdfFile = $unit.find('input[type="file"]')[0];
                                if (pdfFile && pdfFile.files.length > 0) {
                                    formData.append(`chapters[${chapterIndex}][units][${unitIndex}][pdf]`, pdfFile.files[0]);
                                }
                            }
                        }
                    });
                }
            });

            let url, method;
            if (editId) {
                formData.append('id', editId);
                formData.append('_method', 'PUT');
                url = '{{route('admin.course.update.html', ['course' => ':id'])}}'.replace(':id', editId);
                method = 'POST';
            } else {
                url = '{{route('admin.course.store.html')}}';
                method = 'POST';
            }

            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (data) {
                    if (data.code !== 0) {
                        showToast('error', data.msg);
                        return;
                    }

                    showToast('success', editId ? '{{__('更新成功')}}' : '{{__('创建成功')}}');
                    let url;
                    editId = data.data.id;
                    if (keep) {
                        const step = ($('.progress-activated').length || 0) + ($('.progress-active').length || 0);
                        url = '{{route('admin.course.update.view.html', ['course' => ':id'])}}'.replace(':id', editId) + '?step=' + step;
                    } else {
                        url = '{{route('admin.course.html')}}';
                    }
                    window.location.href = url;
                }, error: function () {
                    showToast('error', '{{__('操作失败，请稍后再试！')}}')
                }, complete: function () {
                    hideLoading()
                }
            });
        })
    })
</script>

<x-admin.tinymce-editor :height="600" type="course"/>

</html>
