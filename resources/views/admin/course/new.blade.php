<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="{{web_resource_url('assets/plugins/select2/css/select2.min.css')}}">
<x-admin.head/>
<script src="{{web_resource_url('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{web_resource_url('assets/plugins/summernote/summernote-lite.min.css')}}">
<script src="{{web_resource_url('assets/plugins/summernote/summernote-lite.min.js')}}" type="text/javascript"></script>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('课程管理')}}"/>

    <div class="content">
        <div class="container">

            <div class="row">

                <x-admin.sidebar active="course"/>

                <div class="col-lg-9">

                    <form id="form" novalidate="novalidate">
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
                                                <p>{{__('测验')}}{{__('和')}}{{__('证书')}}</p>
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
                                                <label class="form-label">{{__('描述')}}<span
                                                        class="text-danger ms-1">*</span></label>
                                                <div class="summernote">{!! $course->description??'' !!}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-block">
                                                <label class="form-label">{{__('状态')}}<span
                                                        class="text-danger ms-1">*</span></label>
                                                <div class="d-flex align-items-center ">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="status"
                                                               id="status-0" value="0" @checked(($course->status??0) == 0)>
                                                        <label class="form-check-label" for="status-0">
                                                            Draft
                                                        </label>
                                                    </div>
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="status"
                                                               id="status-1" value="1" @checked(($course->status??0) == 1)>
                                                        <label class="form-check-label" for="status-1">
                                                            Pending
                                                        </label>
                                                    </div>
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="status"
                                                               id="status-2" value="2" @checked(($course->status??0) == 2)>
                                                        <label class="form-check-label" for="status-2">
                                                            Published
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="add-form-btn widget-next-btn submit-btn d-flex justify-content-end mb-0">
                                        <div class="btn-left">
                                            <a href="javascript:void(0);" class="btn main-btn next_btns">{{__('下一步')}} <i
                                                    class="isax isax-arrow-right-3 ms-1"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-secondary btn-submit">{{__('提交')}}</a>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-inner wizard-form-card">
                                    <div class="title">
                                        <h5>{{__('课程媒体')}}</h5>
                                        <p>Intro Course overview provider type. (YouTube.)</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-block">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <label class="form-label">Thumbnail<span
                                                                class="text-danger ms-1">*</span></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="upload-img-section d-flex align-items-center justify-content-center"
                                                             id="course-upload-img-section">
                                                            <input type="file" id="upload-img-input" style="display: none;"
                                                                   accept="image/jpeg, image/png, image/gif, image/webp">
                                                            <div class="upload-content" id="upload-content">
                                                                @if($course->thumbnail)
                                                                    <img src="{{asset($course->thumbnail)}}"
                                                                         class="img-fluid h-100" alt="" style="max-height: 120px;">
                                                                @else
                                                                    <span class="d-flex align-items-center justify-content-center mb-1">
                                                                        <i class="isax isax-image5 text-secondary fs-24 text-center"></i>
                                                                    </span>
                                                                    <p class="text-center fw-medium mb-1">Upload Image</p>
                                                                    <span class="text-center">JPEG, PNG, GIF, and WebP formats, up to 2
														MB</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr class="mt-4 mb-4">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-block-link">
                                                <label class="form-label">Youtube URL</label>
                                                <input type="text" id="video_url" name="video_url" class="form-control"
                                                       placeholder="Youtube URL Link" value="{{$course->video_url??''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="position-relative">
                                                <a href="javascript:void(0);" id="openVideoBtn"
                                                   target="_blank">
                                                    <img class="img-fluid rounded"
                                                         src="{{web_resource_url('assets/img/course/add-course-1.jpg')}}" alt="img">
                                                    <div class="play-icon">
                                                        <i class="fa-solid fa-play"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <div id="videoModal">
                                                <div class="modal-content1">
                                                    <span class="close-btn" id="closeModal">&times;</span>
                                                    <iframe id="youtubeIframe" allowfullscreen=""></iframe>
                                                </div>
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
                                            <a href="javascript:void(0);" class="btn main-btn next_btns">{{__('下一步')}} <i
                                                    class="isax isax-arrow-right-3 ms-1"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-secondary btn-submit">{{__('提交')}}</a>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-inner wizard-form-card">
                                    <div>
                                        <div class="input-block mb-2">
                                            <label class="form-label">Course Quiz<span
                                                    class="text-danger ms-1">*</span></label>
                                            <select class="select">
                                                <option value="1">Quiz 1</option>
                                                <option value="2">Quiz 2</option>
                                                <option value="3">Quiz 3</option>
                                                <option value="4">Quiz 4</option>
                                            </select>
                                        </div>
                                        <div class="input-block mb-2">
                                            <label class="form-label">Course Certificate<span
                                                    class="text-danger ms-1">*</span></label>
                                            <select class="select">
                                                <option value="1">Certificate 1</option>
                                                <option value="2">Certificate 2</option>
                                                <option value="3">Certificate 3</option>
                                                <option value="4">Certificate 4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="add-form-btn widget-next-btn submit-btn">
                                        <div class="btn-left">
                                            <a href="javascript:void(0);" class="btn btn-light main-btn prev_btns"><i
                                                    class="isax isax-arrow-left-2 me-1"></i>{{__('上一步')}}</a>
                                        </div>
                                        <div class="btn-left">
                                            <a href="javascript:void(0);" class="btn btn-secondary btn-submit">{{__('提交')}}</a>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" id="edit-id" value="{{$course->id??''}}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

</div>

</body>
<script>
    let originalImageFile = null;
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
                if (file && file.size <= 2 * 1024 * 1024) {
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
                    originalImageFile = file;
                } else {
                    showToast('error', "File size exceeds 2 MB or invalid format.");
                }
            }
        }
    })();

    $(function () {
        const $form = $('#form');
        $('.btn-submit').click(function () {
            const form = $form.serializeArray();
            let editId = $('#edit-id').val();
            let formData = new FormData();

            _.each(form, (value) => {
                formData.append(value.name, value.value);
            });
            formData.append('description', $('.summernote').eq(0).summernote('code'));
            if (originalImageFile) {
                formData.append('thumbnail', originalImageFile);
            }
            console.log(form);
            console.log(formData);

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
                    editId = data.data.id;
                    window.location.href = '{{route('admin.course.update.view.html', ['course' => ':id'])}}'.replace(':id', editId);
                }, error: function () {
                    showToast('error', '{{__('操作失败，请稍后再试！')}}')
                }, complete: function () {
                    hideLoading()
                }
            });
        })
    })
</script>
</html>
