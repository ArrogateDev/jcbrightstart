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
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-block">
                                            <label class="form-label">{{__('分类')}}<span
                                                    class="text-danger ms-1">*</span></label>
                                            <select class="select form-control">
                                                <option>Select</option>
                                                <option>Management</option>
                                                <option>IT & Softwares</option>
                                                <option>Marketing</option>
                                                <option>Finance</option>
                                                <option>Productivity</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-block">
                                            <label class="form-label">{{__('等级')}}<span
                                                    class="text-danger ms-1">*</span></label>
                                            <select class="select form-control">
                                                <option>Select</option>
                                                <option>Beginner</option>
                                                <option>Intermediate</option>
                                                <option>Advanced</option>
                                                <option>Expert</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-block">
                                            <label class="form-label">{{__('语言')}}<span
                                                    class="text-danger ms-1">*</span></label>
                                            <select class="select form-control">
                                                <option>Select</option>
                                                <option>French</option>
                                                <option>German</option>
                                                <option>Arabic</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-block">
                                            <label class="form-label">{{__('简介')}}<span
                                                    class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-block">
                                            <label class="form-label">{{__('描述')}}<span
                                                    class="text-danger ms-1">*</span></label>
                                            <div class="summernote"></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="add-form-btn widget-next-btn submit-btn d-flex justify-content-end mb-0">
                                    <div class="btn-left">
                                        <a href="javascript:void(0);" class="btn main-btn next_btns">{{__('下一步')}} <i
                                                class="isax isax-arrow-right-3 ms-1"></i></a>
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
                                                    <label class="form-label">Course Thumbnail<span
                                                            class="text-danger ms-1">*</span></label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control"
                                                           placeholder="No File Selected">
                                                </div>
                                                <div class="col-md-2 d-grid">
                                                    <label for="file-upload"
                                                           class="file-upload-btn text-center">Upload File</label>
                                                    <input type="file" id="file-upload" name="file">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="upload-img-section d-flex align-items-center justify-content-center"
                                             id="upload-img-section">
                                            <input type="file" id="upload-img-input" style="display: none;"
                                                   accept="image/jpeg, image/png, image/gif, image/webp">
                                            <div class="upload-content">
													<span class="d-flex align-items-center justify-content-center mb-1">
														<i
                                                            class="isax isax-image5 text-secondary fs-24 text-center"></i>
													</span>
                                                <p class="text-center fw-medium mb-1">Upload Image</p>
                                                <span class="text-center">JPEG, PNG, GIF, and WebP formats, up to 2
														MB</span>
                                            </div>
                                        </div>
                                        <hr class="mt-4 mb-4">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-block-link">
                                            <label class="form-label">Youtube URL</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Youtube URL Link">
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
                                                class="isax isax-arrow-left-2 me-1"></i>Prev</a>
                                    </div>
                                    <div class="btn-left">
                                        <a href="javascript:void(0);"
                                           class="btn btn-secondary main-btn next_btns d-flex align-items-center">Next
                                            <i class="isax isax-arrow-right-3 ms-1"></i></a>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-inner wizard-form-card">
                                <div>
                                    <div class="input-block mb-2">
                                        <label class="form-label">Course Quiz<span
                                                class="text-danger ms-1">*</span></label>
                                        <select class="select">
                                            <option>Quiz 1</option>
                                            <option>Quiz 2</option>
                                            <option>Quiz 3</option>
                                            <option>Quiz 4</option>
                                        </select>
                                    </div>
                                    <div class="input-block mb-2">
                                        <label class="form-label">Course Certificate<span
                                                class="text-danger ms-1">*</span></label>
                                        <select class="select">
                                            <option>Certificate 1</option>
                                            <option>Certificate 2</option>
                                            <option>Certificate 3</option>
                                            <option>Certificate 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="add-form-btn widget-next-btn submit-btn">
                                    <div class="btn-left">
                                        <a href="javascript:void(0);" class="btn btn-light main-btn prev_btns"><i
                                                class="isax isax-arrow-left-2 me-1"></i>Prev</a>
                                    </div>
                                    <div class="btn-left">
                                        <a href="javascript:void(0);" class="btn btn-secondary main-btn next_btns"
                                           data-bs-toggle="modal" data-bs-target="#success">Submit Course</a>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

</div>

</body>

</html>
