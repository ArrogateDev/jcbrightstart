<!DOCTYPE html>
<html lang="en">

<x-admin.head/>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('课程管理')}}"/>

    <div class="content">
        <div class="container">

            <div class="row">

                <x-admin.sidebar active="course"/>

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-xxl col-lg-4 col-md-6">
                            <div class="card bg-success">
                                <div class="card-body">
                                    <h6 class="fw-medium mb-1 text-white">Active Courses</h6>
                                    <h4 class="fw-bold text-white">45</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl col-lg-4 col-md-6">
                            <div class="card bg-secondary">
                                <div class="card-body">
                                    <h6 class="fw-medium mb-1 text-white">Pending Courses</h6>
                                    <h4 class="fw-bold text-white">21</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl col-lg-4 col-md-6">
                            <div class="card bg-info">
                                <div class="card-body">
                                    <h6 class="fw-medium mb-1 text-white">Draft Courses</h6>
                                    <h4 class="fw-bold text-white">15</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold">Courses</h5>

                        <div>
                            <a href="{{route('admin.course.store.view.html')}}" class="btn btn-secondary">{{__('添加课程')}}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <div class="dropdown">
                                    <a href="javascript:void(0);"
                                       class="dropdown-toggle text-gray-6 btn  rounded border d-inline-flex align-items-center"
                                       data-bs-toggle="dropdown" aria-expanded="false">
                                        Status
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end p-3">
                                        <li>
                                            <a href="javascript:void(0);"
                                               class="dropdown-item rounded-1">Published</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);"
                                               class="dropdown-item rounded-1">Pending</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1">Draft</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon mb-3">
									<span class="input-icon-addon">
										<i class="isax isax-search-normal-14"></i>
									</span>
                                <input type="email" class="form-control form-control-md" placeholder="Search">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive custom-table">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>Course Name</th>
                                <th>Students</th>
                                <th>Ratings</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">

                                        <a href="course-details.html"
                                           class="avatar avatar-lg me-2 flex-shrink-0"><img
                                                class="img-fluid object-fit-cover"
                                                src="{{web_resource_url('assets/img/course/course-01.jpg')}}" alt=""></a>

                                        <div>
                                            <h6 class="fw-medium mb-2"><a href="course-details.html">Information
                                                    About UI/UX Design Degree</a></h6>
                                            <div class="d-flex align-items-center">
														<span
                                                            class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                                class="isax isax-video-circle me-1 text-gray-9 fw-bold"></i>11
															Lessons</span>
                                                <span
                                                    class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                        class="isax isax-message-question me-1 text-gray-9 fw-bold"></i>2
															Quizzes</span>
                                                <span class="d-inline-flex fs-12 align-items-center"><i
                                                        class="isax isax-clock me-1 text-gray-9 fw-bold"></i>03:15:00
															Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>600</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-star fs-12 filled text-warning me-1"></i>
                                        <span>4.5 (300)</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge badge-sm bg-success d-inline-flex align-items-center me-1"><i
                                            class="fa-solid fa-circle fs-5 me-1"></i>Published</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"><i
                                                class="isax isax-edit-2"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="isax isax-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="course-details.html" class="avatar avatar-lg me-2"><img
                                                class="img-fluid object-fit-cover"
                                                src="{{web_resource_url('assets/img/course/course-02.jpg')}}" alt=""></a>
                                        <div>
                                            <h6 class="fw-medium mb-2"><a href="course-details.html">Wordpress
                                                    for Beginners - Master Wordpress Quickly</a></h6>
                                            <div class="d-flex align-items-center">
														<span
                                                            class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                                class="isax isax-video-circle me-1 text-gray-9 fw-bold"></i>11
															Lessons</span>
                                                <span
                                                    class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                        class="isax isax-message-question me-1 text-gray-9 fw-bold"></i>2
															Quizzes</span>
                                                <span class="d-inline-flex fs-12 align-items-center"><i
                                                        class="isax isax-clock me-1 text-gray-9 fw-bold"></i>03:15:00
															Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>500</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-star fs-12 filled text-warning me-1"></i>
                                        <span>4.2 (430)</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge badge-sm bg-secondary d-inline-flex align-items-center me-1"><i
                                            class="fa-solid fa-circle fs-5 me-1"></i>Pending</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"><i
                                                class="isax isax-edit-2"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="isax isax-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="course-details.html" class="avatar avatar-lg me-2"><img
                                                class="img-fluid object-fit-cover"
                                                src="{{web_resource_url('assets/img/course/course-03.jpg')}}" alt=""></a>
                                        <div>
                                            <h6 class="fw-medium mb-2"><a href="course-details.html">Sketch from
                                                    A to Z (2024): Become an app designer</a></h6>
                                            <div class="d-flex align-items-center">
														<span
                                                            class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                                class="isax isax-video-circle me-1 text-gray-9 fw-bold"></i>11
															Lessons</span>
                                                <span
                                                    class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                        class="isax isax-message-question me-1 text-gray-9 fw-bold"></i>2
															Quizzes</span>
                                                <span class="d-inline-flex fs-12 align-items-center"><i
                                                        class="isax isax-clock me-1 text-gray-9 fw-bold"></i>03:15:00
															Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>300</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-star fs-12 filled text-warning me-1"></i>
                                        <span>4.7 (140)</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge badge-sm bg-info d-inline-flex align-items-center me-1"><i
                                            class="fa-solid fa-circle fs-5 me-1"></i>Draft</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"><i
                                                class="isax isax-edit-2"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="isax isax-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="course-details.html" class="avatar avatar-lg me-2"><img
                                                class="img-fluid object-fit-cover"
                                                src="{{web_resource_url('assets/img/course/course-04.jpg')}}" alt=""></a>
                                        <div>
                                            <h6 class="fw-medium mb-2"><a href="course-details.html">Build
                                                    Responsive Real World Websites with Crash Course</a></h6>
                                            <div class="d-flex align-items-center">
														<span
                                                            class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                                class="isax isax-video-circle me-1 text-gray-9 fw-bold"></i>11
															Lessons</span>
                                                <span
                                                    class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                        class="isax isax-message-question me-1 text-gray-9 fw-bold"></i>2
															Quizzes</span>
                                                <span class="d-inline-flex fs-12 align-items-center"><i
                                                        class="isax isax-clock me-1 text-gray-9 fw-bold"></i>03:15:00
															Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>400</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-star fs-12 filled text-warning me-1"></i>
                                        <span>4.4 (260)</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge badge-sm bg-success d-inline-flex align-items-center me-1"><i
                                            class="fa-solid fa-circle fs-5 me-1"></i>Published</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"><i
                                                class="isax isax-edit-2"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="isax isax-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="course-details.html" class="avatar avatar-lg me-2"><img
                                                class="img-fluid object-fit-cover"
                                                src="{{web_resource_url('assets/img/course/course-05.jpg')}}" alt=""></a>
                                        <div>
                                            <h6 class="fw-medium mb-2"><a href="course-details.html">Learn
                                                    JavaScript and Express to become a Expert</a></h6>
                                            <div class="d-flex align-items-center">
														<span
                                                            class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                                class="isax isax-video-circle me-1 text-gray-9 fw-bold"></i>11
															Lessons</span>
                                                <span
                                                    class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                        class="isax isax-message-question me-1 text-gray-9 fw-bold"></i>2
															Quizzes</span>
                                                <span class="d-inline-flex fs-12 align-items-center"><i
                                                        class="isax isax-clock me-1 text-gray-9 fw-bold"></i>03:15:00
															Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>700</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-star fs-12 filled text-warning me-1"></i>
                                        <span>4.8 (180)</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge badge-sm bg-success d-inline-flex align-items-center me-1"><i
                                            class="fa-solid fa-circle fs-5 me-1"></i>Published</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"><i
                                                class="isax isax-edit-2"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="isax isax-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="course-details.html" class="avatar avatar-lg me-2"><img
                                                class="img-fluid object-fit-cover"
                                                src="{{web_resource_url('assets/img/course/course-06.jpg')}}" alt=""></a>
                                        <div>
                                            <h6 class="fw-medium mb-2"><a
                                                    href="course-details.html">Introduction to Python
                                                    Programming</a></h6>
                                            <div class="d-flex align-items-center">
														<span
                                                            class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                                class="isax isax-video-circle me-1 text-gray-9 fw-bold"></i>11
															Lessons</span>
                                                <span
                                                    class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                        class="isax isax-message-question me-1 text-gray-9 fw-bold"></i>2
															Quizzes</span>
                                                <span class="d-inline-flex fs-12 align-items-center"><i
                                                        class="isax isax-clock me-1 text-gray-9 fw-bold"></i>03:15:00
															Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>450</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-star fs-12 filled text-warning me-1"></i>
                                        <span>4.8 (180)</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge badge-sm bg-success d-inline-flex align-items-center me-1"><i
                                            class="fa-solid fa-circle fs-5 me-1"></i>Published</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"><i
                                                class="isax isax-edit-2"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="isax isax-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="course-details.html" class="avatar avatar-lg me-2"><img
                                                class="img-fluid object-fit-cover"
                                                src="{{web_resource_url('assets/img/course/course-07.jpg')}}" alt=""></a>
                                        <div>
                                            <h6 class="fw-medium mb-2"><a href="course-details.html">Build
                                                    Responsive Websites with HTML5 and CSS3</a></h6>
                                            <div class="d-flex align-items-center">
														<span
                                                            class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                                class="isax isax-video-circle me-1 text-gray-9 fw-bold"></i>11
															Lessons</span>
                                                <span
                                                    class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                        class="isax isax-message-question me-1 text-gray-9 fw-bold"></i>2
															Quizzes</span>
                                                <span class="d-inline-flex fs-12 align-items-center"><i
                                                        class="isax isax-clock me-1 text-gray-9 fw-bold"></i>03:15:00
															Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>620</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-star fs-12 filled text-warning me-1"></i>
                                        <span>4.9 (510)</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge badge-sm bg-success d-inline-flex align-items-center me-1"><i
                                            class="fa-solid fa-circle fs-5 me-1"></i>Published</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"><i
                                                class="isax isax-edit-2"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="isax isax-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="course-details.html" class="avatar avatar-lg me-2"><img
                                                class="img-fluid object-fit-cover"
                                                src="{{web_resource_url('assets/img/course/course-08.jpg')}}" alt=""></a>
                                        <div>
                                            <h6 class="fw-medium mb-2"><a href="course-details.html">Information
                                                    About Photoshop Design Degree</a></h6>
                                            <div class="d-flex align-items-center">
														<span
                                                            class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                                class="isax isax-video-circle me-1 text-gray-9 fw-bold"></i>11
															Lessons</span>
                                                <span
                                                    class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                        class="isax isax-message-question me-1 text-gray-9 fw-bold"></i>2
															Quizzes</span>
                                                <span class="d-inline-flex fs-12 align-items-center"><i
                                                        class="isax isax-clock me-1 text-gray-9 fw-bold"></i>03:15:00
															Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>550</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-star fs-12 filled text-warning me-1"></i>
                                        <span>4.6 (400)</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge badge-sm bg-success d-inline-flex align-items-center me-1"><i
                                            class="fa-solid fa-circle fs-5 me-1"></i>Published</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"><i
                                                class="isax isax-edit-2"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="isax isax-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="course-details.html" class="avatar avatar-lg me-2"><img
                                                class="img-fluid object-fit-cover"
                                                src="{{web_resource_url('assets/img/course/course-09.jpg')}}" alt=""></a>
                                        <div>
                                            <h6 class="fw-medium mb-2"><a href="course-details.html">C#
                                                    Developers Double Your Coding with Visual Studio</a></h6>
                                            <div class="d-flex align-items-center">
														<span
                                                            class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                                class="isax isax-video-circle me-1 text-gray-9 fw-bold"></i>11
															Lessons</span>
                                                <span
                                                    class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                        class="isax isax-message-question me-1 text-gray-9 fw-bold"></i>2
															Quizzes</span>
                                                <span class="d-inline-flex fs-12 align-items-center"><i
                                                        class="isax isax-clock me-1 text-gray-9 fw-bold"></i>03:15:00
															Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>240</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-star fs-12 filled text-warning me-1"></i>
                                        <span>4.1 (180)</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge badge-sm bg-success d-inline-flex align-items-center me-1"><i
                                            class="fa-solid fa-circle fs-5 me-1"></i>Published</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"><i
                                                class="isax isax-edit-2"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="isax isax-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="course-details.html" class="avatar avatar-lg me-2"><img
                                                class="img-fluid object-fit-cover"
                                                src="{{web_resource_url('assets/img/course/course-01.jpg')}}" alt=""></a>
                                        <div>
                                            <h6 class="fw-medium mb-2"><a href="course-details.html">Complete
                                                    HTML, CSS and Javascript Course</a></h6>
                                            <div class="d-flex align-items-center">
														<span
                                                            class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                                class="isax isax-video-circle me-1 text-gray-9 fw-bold"></i>11
															Lessons</span>
                                                <span
                                                    class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end"><i
                                                        class="isax isax-message-question me-1 text-gray-9 fw-bold"></i>2
															Quizzes</span>
                                                <span class="d-inline-flex fs-12 align-items-center"><i
                                                        class="isax isax-clock me-1 text-gray-9 fw-bold"></i>03:15:00
															Hours</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>380</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-star fs-12 filled text-warning me-1"></i>
                                        <span>4.3 (200)</span>
                                    </div>
                                </td>
                                <td><span
                                        class="badge badge-sm bg-success d-inline-flex align-items-center me-1"><i
                                            class="fa-solid fa-circle fs-5 me-1"></i>Published</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"><i
                                                class="isax isax-edit-2"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="isax isax-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /pagination -->
                    <div class="row align-items-center mt-4">
                        <div class="col-md-2">
                            <p class="fs-14 fw-500 text-center text-md-start">Page 1 of 2</p>
                        </div>
                        <div class="col-md-10">
                            <ul
                                class="pagination lms-page justify-content-center justify-content-md-end mt-2 mt-md-0">
                                <li class="page-item prev">
                                    <a class="page-link" href="javascript:void(0)" tabindex="-1"><i
                                            class="fas fa-angle-left"></i></a>
                                </li>
                                <li class="page-item first-page active">
                                    <a class="page-link" href="javascript:void(0)">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)">3</a>
                                </li>
                                <li class="page-item next">
                                    <a class="page-link" href="javascript:void(0)"><i
                                            class="fas fa-angle-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /pagination -->
                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

</div>

</body>

</html>
