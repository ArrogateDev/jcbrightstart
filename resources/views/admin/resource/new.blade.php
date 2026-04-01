<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/select2/css/select2.min.css')}}">
<x-admin.head/>
<script src="{{web_resource_url('assets/admin/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/summernote/summernote-lite.min.css')}}">
<script src="{{web_resource_url('assets/admin/plugins/summernote/summernote-lite.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/validation.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/admin/js/moment.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{web_resource_url('assets/admin/css/bootstrap-datetimepicker.min.css')}}">
<script src="{{web_resource_url('assets/admin/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('专业学习社群')}}"/>

    <div class="content">
        <div class="container">

            <div class="row">

                <x-admin.sidebar active="resource"/>

                <div class="col-lg-9">

                    <form id="news-form" novalidate="novalidate">
                        <div class="add-course-item">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-block">
                                        <label class="form-label mb-1">
                                            {{__('类型')}}
                                            <span class="text-danger ms-1">*</span>
                                            <span id="error-container-type"></span>
                                        </label>
                                        <div class="d-flex align-items-center ">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" name="type"
                                                       id="type-normal" value="0" @checked($resource->type == 0) @disabled($resource->id > 0)>
                                                <label class="form-check-label" for="type-normal">
                                                    {{__('文章')}}
                                                </label>
                                            </div>
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="radio" name="type"
                                                       id="type-disabled" value="1" @checked($resource->type == 1) @disabled($resource->id > 0)>
                                                <label class="form-check-label" for="type-disabled">
                                                    {{__('视频')}}
                                                </label>
                                            </div>
                                            @if($resource->id > 0)
                                                <input type="hidden" name="type" value="{{$resource->type}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-block">
                                        <label class="form-label">{{__('标题')}}<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="text" id="title" name="title" class="form-control" value="{{$resource->title??''}}">
                                    </div>
                                </div>
                                <div class="col-md-12 type-video">
                                    <div class="input-block">
                                        <label class="form-label">{{__('视频')}}<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="text" id="video" name="video" class="form-control" value="{{$resource->short??''}}">
                                    </div>
                                </div>
                                <div class="col-md-12 type-article">
                                    <div class="input-block">
                                        <div class="row align-items-center">
                                            <div class="col-md-12">
                                                <label class="form-label">{{__('封面图')}}<span
                                                        class="text-danger ms-1">*</span></label>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="upload-img-section d-flex align-items-center justify-content-center"
                                                     id="news-upload-img-section">
                                                    <input type="file" id="upload-img-input" style="display: none;"
                                                           accept="image/jpeg, image/png, image/gif, image/webp">
                                                    <div class="upload-content" id="upload-content">
                                                        @if($resource->id > 0 && !empty($raw_thumbnail = $resource->getRawOriginal('thumbnail')))
                                                            <img src="{{asset($resource->thumbnail)}}"
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
                                <div class="col-md-4 type-article">
                                    <div class="input-block">
                                        <label class="form-label">{{__('分类')}}<span
                                                class="text-danger ms-1">*</span></label>
                                        <select id="category" name="category_id" class="select form-control"></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-block">
                                        <label class="form-label">{{__('权重')}}<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="number" id="sort" name="sort" class="form-control" value="{{$resource->sort??0}}" min="0" max="99" maxlength="6">
                                    </div>
                                </div>
                                <div class="col-md-12 type-article">
                                    <div class="input-block">
                                        <label class="form-label">{{__('简介')}}<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="text" id="short" name="short" class="form-control" value="{{$resource->short??''}}">
                                    </div>
                                </div>
                                <div class="col-md-12 type-article">
                                    <div class="input-block">
                                        <label class="form-label">{{__('PDF')}}</label>
                                        <div class="input-group">
                                            <input type="file" name="pdf"
                                                   id="pdf-file-input"
                                                   class="form-control form-control-sm pdf-file-input"
                                                   accept="application/pdf"
                                                   style="display: none;">
                                            <button type="button" class="btn btn-sm btn-outline-primary pdf-select-btn"
                                                    id="pdf-select-btn">
                                                <i class="fa-solid fa-file-pdf me-1"></i>{{__('选择 PDF 文件')}}
                                            </button>
                                            <input type="text" class="form-control form-control-sm pdf-file-name"
                                                   placeholder="{{__('未选择文件')}}"
                                                   readonly>
                                            <button type="button" class="btn btn-sm btn-outline-danger pdf-clear-btn"
                                                    id="pdf-clear-btn" style="display: none;">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="pdf-existing-file mt-2" style="display: none;">
                                            <a href="#" target="_blank" class="btn btn-sm btn-outline-primary pdf-view-btn me-2">
                                                <i class="fa-solid fa-file-pdf me-1"></i>{{__('查看当前 PDF')}}
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger pdf-remove-btn">
                                                <i class="fa-solid fa-trash me-1"></i>{{__('删除 PDF')}}
                                            </button>
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            <i class="fa-solid fa-info-circle me-1"></i>{{__('仅支持 PDF 格式，最大 15MB')}}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-block">
                                        <label class="form-label">{{__('內容')}}<span
                                                class="text-danger ms-1">*</span></label>
                                        <div class="summernote">{!! $resource->description??'' !!}</div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="add-form-btn widget-next-btn submit-btn d-flex justify-content-end mb-0">
                                <div class="btn-left">
                                    <a href="javascript:void(0);" data-status="0" data-keep="1" class="btn main-btn btn-submit text-white"
                                       style="background: #00b050;border-color: #00b050;">{{__('储存')}}
                                    </a>
                                    <a href="javascript:void(0);" data-status="0" data-keep="0" class="btn main-btn btn-submit text-white"
                                       style="background: #0070c0;border-color: #0070c0;">{{__('储存及离开')}}
                                    </a>
                                    <a href="javascript:void(0);" data-status="2" data-keep="0" class="btn btn-secondary btn-submit">{{__('发布')}}</a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" id="status" value="{{$resource->status??0}}">
                        <input type="hidden" id="edit-id" value="{{$resource->id??''}}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

</div>

@include('admin.resource-category.new')

</body>
<script>
    let thumbnailImageFile = null;
    // upload img
    (function () {
        const uploadSection = document.getElementById("news-upload-img-section");
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
        const $category = $('#category');
        $category.select2({
            placeholder: '{{__('请选择或搜索分类')}}',
            ajax: {
                url: '{{route('admin.get-resource-category-list.html')}}',
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
                            text: '{{__('新增分类')}}',
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
                    return $('<div class="select2-add-new-option" style="padding: 8px;"><button type="button" class="btn btn-primary w-100" style="pointer-events: auto; border: none;" data-bs-toggle="modal" data-bs-target="#form-modal"><i class="fa fa-plus me-1"></i>{{__('新增分类')}}</button></div>');
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

        @if($resource && $resource->category)
        const option = new Option('{{$resource->category->title??''}}', {{$resource->category->id??0}}, true, true);
        $category.append(option).trigger('change');
        @endif

        const $modal = $('#form-modal');
        $modal.on('show.bs.modal', function () {
            $category.select2('close');
        });

        @if($resource->type == 1)
        $('.type-article').hide()
        $('.type-video').show()
        @else
        $('.type-article').show()
        $('.type-video').hide()
        @endif

        $('input[name="type"]').change(function () {
            const type = parseInt($(this).val());
            if (type === 1) {
                $('.type-article').hide()
                $('.type-video').show()
            } else {
                $('.type-article').show()
                $('.type-video').hide()
            }
        })

        let pdfFile = null;
        // PDF 文件选择按钮点击事件
        $(document).on('click', '.pdf-select-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const $fileInput = $('#pdf-file-input');
            $fileInput.click();
        });

        // PDF 文件选择变化事件
        $(document).on('change', '.pdf-file-input', function () {
            const $fileNameInput = $('.pdf-file-name');
            const $clearBtn = $('#pdf-clear-btn');
            const file = this.files[0];

            if (file) {
                // 验证文件大小 (10MB)
                if (file.size > 15 * 1024 * 1024) {
                    showToast('error', '{{__('文件大小不能超过 15MB')}}');
                    this.value = '';
                    return;
                }

                // 验证文件类型
                if (file.type !== 'application/pdf') {
                    showToast('error', '{{__('只能选择 PDF 格式的文件')}}');
                    this.value = '';
                    return;
                }

                pdfFile = file;
                $fileNameInput.val(file.name);
                $clearBtn.show();

                // 隐藏现有文件链接
                $('.pdf-existing-file').hide();
            } else {
                pdfFile = null;
                $fileNameInput.val('');
                $clearBtn.hide();
            }
        });

        // PDF 清除按钮点击事件
        $(document).on('click', '#pdf-clear-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const $fileInput = $('#pdf-file-input');
            const $fileNameInput = $('.pdf-file-name');

            $fileInput.val('');
            $fileNameInput.val('');
            $(this).hide();
            pdfFile = null;
        });

        // PDF 删除按钮点击事件（删除已有文件）
        $(document).on('click', '.pdf-remove-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const $existingFile = $('.pdf-existing-file');
            const $fileNameInput = $('.pdf-file-name');
            const $clearBtn = $('#pdf-clear-btn');

            $existingFile.hide();
            $fileNameInput.val('');
            $clearBtn.hide();
            pdfFile = null;
        });

        // 初始化时检查是否有现有 PDF
        @if($resource->id > 0 && !empty($resource->pdf))
            const pdfUrl = '{{$resource->pdf}}';
            const pdfFileName = pdfUrl.substring(pdfUrl.lastIndexOf('/') + 1).split('?')[0];
            $('.pdf-file-name').val(pdfFileName);
            $('.pdf-existing-file').show();
            $('.pdf-view-btn').attr('href', '{{$resource->pdf}}');
            $('#pdf-clear-btn').hide();
        @endif

        const $form = $('#news-form');
        $('.btn-submit').click(function () {
            showLoading()

            const form = $form.serializeArray();
            let editId = $('#edit-id').val();
            let formData = new FormData();
            let status = parseInt($(this).data('status'));
            let $status = $('#status').val();
            let keep = $(this).data('keep');

            formData.append('status', status === 2 ? status : $status)

            _.each(form, (value) => {
                formData.append(value.name, value.value);
            });
            formData.append('description', $('.summernote').eq(0).summernote('code'));
            if (thumbnailImageFile) {
                formData.append('thumbnail', thumbnailImageFile);
            }

            if (pdfFile) {
                formData.append('pdf_file', pdfFile);
            }

            let url, method;
            if (editId) {
                formData.append('id', editId);
                formData.append('_method', 'PUT');
                url = '{{route('admin.resource.update.html', ['resource' => ':id'])}}'.replace(':id', editId);
                method = 'POST';
            } else {
                url = '{{route('admin.resource.store.html')}}';
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
                    editId = data.data.id;
                    let url;
                    if (keep) {
                        url = '{{route('admin.resource.update.view.html', ['resource' => ':id'])}}'.replace(':id', editId);
                    } else {
                        url = '{{route('admin.resource.html')}}';
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

<x-admin.summernote-editor :height="300" type="resource"/>

</html>
