<!DOCTYPE html>
<html lang="en">

<x-admin.head/>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('用户管理')}}"/>

    <div class="content">
        <div class="container">
            <div class="row">

                <x-admin.sidebar active="{{__('user')}}"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold">Students</h5>
                        <div class="d-flex align-items-center list-icons">
                            <a href="student-list.html" class="me-2"><i class="isax isax-task"></i></a>
                            <a href="students.html" class="active"><i class="isax isax-element-3"></i></a>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <div class="input-icon mb-3">
									<span class="input-icon-addon">
										<i class="isax isax-search-normal-14"></i>
									</span>
                                <input type="email" class="form-control form-control-md" placeholder="Search">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="student-details.html"><img src="{{web_resource_url('assets/img/students/student-01.jpg')}}"
                                                                            class="rounded-3" alt=""></a>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-bottom mb-3 pb-3">
                                        <div>
                                            <h5 class="mb-2 fw-bold"><a href="student-details.html">Ronald
                                                    Richard</a></h5>
                                            <span class="text-info d-inline-flex align-items-center"><i
                                                    class="isax isax-location me-1"></i><a href="#"
                                                                                           class="text-info text-decoration-underline stu-loc">Newyork</a></span>
                                        </div>
                                        <a href="#" class="avatar avatar-md avatar-rounded border"><i
                                                class="isax isax-messages text-gray-9 fs-14"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between fs-14">
											<span class="d-inline-flex align-items-center"><i
                                                    class="isax isax-calendar-add5 text-primary me-1"></i>22 Aug
												2025</span>
                                        <span class="d-inline-flex align-items-center"><i
                                                class="isax isax-teacher5 text-secondary me-1"></i>10 Courses</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="student-details.html"><img src="{{web_resource_url('assets/img/students/student-02.jpg')}}"
                                                                            class="rounded-3" alt=""></a>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-bottom mb-3 pb-3">
                                        <div>
                                            <h5 class="mb-2 fw-bold"><a href="student-details.html">Mona Nancy</a>
                                            </h5>
                                            <span class="text-info d-inline-flex align-items-center"><i
                                                    class="isax isax-location me-1"></i><a href="#"
                                                                                           class="text-info text-decoration-underline stu-loc">Los
														Angels</a></span>
                                        </div>
                                        <a href="#" class="avatar avatar-md avatar-rounded border"><i
                                                class="isax isax-messages text-gray-9 fs-14"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between fs-14">
											<span class="d-inline-flex align-items-center"><i
                                                    class="isax isax-calendar-add5 text-primary me-1"></i>15 Jul
												2025</span>
                                        <span class="d-inline-flex align-items-center"><i
                                                class="isax isax-teacher5 text-secondary me-1"></i>08 Courses</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="student-details.html"><img src="{{web_resource_url('assets/img/students/student-03.jpg')}}"
                                                                            class="rounded-3" alt=""></a>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-bottom mb-3 pb-3">
                                        <div>
                                            <h5 class="mb-2 fw-bold"><a href="student-details.html">Patrick
                                                    Alleman</a></h5>
                                            <span class="text-info d-inline-flex align-items-center"><i
                                                    class="isax isax-location me-1"></i><a href="#"
                                                                                           class="text-info text-decoration-underline stu-loc">Alabama</a></span>
                                        </div>
                                        <a href="#" class="avatar avatar-md avatar-rounded border"><i
                                                class="isax isax-messages text-gray-9 fs-14"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between fs-14">
											<span class="d-inline-flex align-items-center"><i
                                                    class="isax isax-calendar-add5 text-primary me-1"></i>18 Jun
												2025</span>
                                        <span class="d-inline-flex align-items-center"><i
                                                class="isax isax-teacher5 text-secondary me-1"></i>12 Courses</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="student-details.html"><img src="{{web_resource_url('assets/img/students/student-04.jpg')}}"
                                                                            class="rounded-3" alt=""></a>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-bottom mb-3 pb-3">
                                        <div>
                                            <h5 class="mb-2 fw-bold"><a href="student-details.html">Olive Paxson</a>
                                            </h5>
                                            <span class="text-info d-inline-flex align-items-center"><i
                                                    class="isax isax-location me-1"></i><a href="#"
                                                                                           class="text-info text-decoration-underline stu-loc">Brisbane</a></span>
                                        </div>
                                        <a href="#" class="avatar avatar-md avatar-rounded border"><i
                                                class="isax isax-messages text-gray-9 fs-14"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between fs-14">
											<span class="d-inline-flex align-items-center"><i
                                                    class="isax isax-calendar-add5 text-primary me-1"></i>03 May
												2025</span>
                                        <span class="d-inline-flex align-items-center"><i
                                                class="isax isax-teacher5 text-secondary me-1"></i>07 Courses</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="student-details.html"><img src="{{web_resource_url('assets/img/students/student-05.jpg')}}"
                                                                            class="rounded-3" alt=""></a>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-bottom mb-3 pb-3">
                                        <div>
                                            <h5 class="mb-2 fw-bold"><a href="student-details.html">Chris Thomas</a>
                                            </h5>
                                            <span class="text-info d-inline-flex align-items-center"><i
                                                    class="isax isax-location me-1"></i><a href="#"
                                                                                           class="text-info text-decoration-underline stu-loc">Newyork</a></span>
                                        </div>
                                        <a href="#" class="avatar avatar-md avatar-rounded border"><i
                                                class="isax isax-messages text-gray-9 fs-14"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between fs-14">
											<span class="d-inline-flex align-items-center"><i
                                                    class="isax isax-calendar-add5 text-primary me-1"></i>14 Apr
												2025</span>
                                        <span class="d-inline-flex align-items-center"><i
                                                class="isax isax-teacher5 text-secondary me-1"></i>04 Courses</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <a href="student-details.html"><img src="{{web_resource_url('assets/img/students/student-06.jpg')}}"
                                                                            class="rounded-3" alt=""></a>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-bottom mb-3 pb-3">
                                        <div>
                                            <h5 class="mb-2 fw-bold"><a href="student-details.html">Joyce Perron</a>
                                            </h5>
                                            <span class="text-info d-inline-flex align-items-center"><i
                                                    class="isax isax-location me-1"></i><a href="#"
                                                                                           class="text-info text-decoration-underline stu-loc">Ontoro</a></span>
                                        </div>
                                        <a href="#" class="avatar avatar-md avatar-rounded border"><i
                                                class="isax isax-messages text-gray-9 fs-14"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between fs-14">
											<span class="d-inline-flex align-items-center"><i
                                                    class="isax isax-calendar-add5 text-primary me-1"></i>17 Mar
												2025</span>
                                        <span class="d-inline-flex align-items-center"><i
                                                class="isax isax-teacher5 text-secondary me-1"></i>06 Courses</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /pagination -->
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <p class="pagination-text">Page 1 of 2</p>
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

    <div class="modal fade" id="delete_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center custom-modal-body">
						<span class="avatar avatar-lg bg-danger-transparent rounded-circle mb-2">
							<i class="isax isax-trash fs-24 text-danger"></i>
						</span>
                    <div>
                        <h4 class="mb-2">Delete Course</h4>
                        <p class="mb-3">Are you sure you want to delete course?</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="javascript:void(0);" class="btn bg-gray-100 rounded-pill me-2"
                               data-bs-dismiss="modal">Cancel</a>
                            <a href="javascript:void(0);" class="btn btn-secondary rounded-pill">Yes, Remove All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</body>

</html>
