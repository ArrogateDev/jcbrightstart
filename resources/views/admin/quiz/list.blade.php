<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="{{web_resource_url('assets/plugins/select2/css/select2.min.css')}}">
<x-admin.head/>
<script src="{{web_resource_url('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('测验')}}"/>

    <div class="content">
        <div class="container">
            <div class="row">

                <x-admin.sidebar active="quiz"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold">Quiz</h5>
                        <div>
                            <a href="#" class="btn btn-secondary" data-bs-toggle="modal"
                               data-bs-target="#form-modal">Add Quiz</a>
                        </div>
                    </div>
                    <div class="border rounded-2 p-3 mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div>
                                    <h6 class="mb-2"><a href="instructor-quiz-questions.html">Information About
                                            UI/UX Design Degree</a></h6>
                                    <div class="question-info d-flex align-items-center">
                                        <p class="d-flex align-items-center fs-14 me-2 pe-2 border-end mb-0"><i
                                                class="isax isax-message-question5 text-primary-soft me-2"></i>25
                                            Questions</p>
                                        <p class="d-flex align-items-center fs-14 mb-0"><i
                                                class="isax isax-clock5 text-secondary-soft me-2"></i>30 Minutes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-end mt-2 mt-md-0">
                                    <a href="instructor-quiz-results.html"
                                       class="text-info text-decoration-underline fs-12 fw-medium me-3">View
                                        Results</a>
                                    <a href="#" class="d-inline-flex fs-14 me-1 action-icon" data-bs-toggle="modal"
                                       data-bs-target="#edit_quiz"><i class="isax isax-edit-2"></i></a>
                                    <a href="#" class="d-inline-flex fs-14 action-icon" data-bs-toggle="modal"
                                       data-bs-target="#delete_modal"><i class="isax isax-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded-2 p-3 mb-3">
                        <div class="row align-items-center gy-3">
                            <div class="col-md-8">
                                <div>
                                    <h6 class="mb-2"><a href="instructor-quiz-questions.html">Learn JavaScript and
                                            Express to become a Expert</a></h6>
                                    <div class="question-info d-flex align-items-center">
                                        <p class="d-flex align-items-center fs-14 me-2 pe-2 border-end mb-0"><i
                                                class="isax isax-message-question5 text-primary-soft me-2"></i>15
                                            Questions</p>
                                        <p class="d-flex align-items-center fs-14 mb-0"><i
                                                class="isax isax-clock5 text-secondary-soft me-2"></i>25 Minutes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-end mt-2 mt-md-0">
                                    <a href="instructor-quiz-results.html"
                                       class="text-info text-decoration-underline fs-12 fw-medium me-3">View
                                        Results</a>
                                    <a href="#" class="d-inline-flex fs-14 me-1 action-icon" data-bs-toggle="modal"
                                       data-bs-target="#edit_quiz"><i class="isax isax-edit-2"></i></a>
                                    <a href="#" class="d-inline-flex fs-14 action-icon" data-bs-toggle="modal"
                                       data-bs-target="#delete_modal"><i class="isax isax-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded-2 p-3 mb-3">
                        <div class="row align-items-center gy-3">
                            <div class="col-md-8">
                                <div>
                                    <h6 class="mb-2"><a href="instructor-quiz-questions.html">Introduction to Python
                                            Programming</a></h6>
                                    <div class="question-info d-flex align-items-center">
                                        <p class="d-flex align-items-center fs-14 me-2 pe-2 border-end mb-0"><i
                                                class="isax isax-message-question5 text-primary-soft me-2"></i>22
                                            Questions</p>
                                        <p class="d-flex align-items-center fs-14 mb-0"><i
                                                class="isax isax-clock5 text-secondary-soft me-2"></i>15 Minutes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-end mt-2 mt-md-0">
                                    <a href="instructor-quiz-results.html"
                                       class="text-info text-decoration-underline fs-12 fw-medium me-3">View
                                        Results</a>
                                    <a href="#" class="d-inline-flex fs-14 me-1 action-icon" data-bs-toggle="modal"
                                       data-bs-target="#edit_quiz"><i class="isax isax-edit-2"></i></a>
                                    <a href="#" class="d-inline-flex fs-14 action-icon" data-bs-toggle="modal"
                                       data-bs-target="#delete_modal"><i class="isax isax-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded-2 p-3 mb-3">
                        <div class="row align-items-center gy-3">
                            <div class="col-md-8">
                                <div>
                                    <h6 class="mb-2"><a href="instructor-quiz-questions.html">Build Responsive
                                            Websites with HTML5 and CSS3</a></h6>
                                    <div class="question-info d-flex align-items-center">
                                        <p class="d-flex align-items-center fs-14 me-2 pe-2 border-end mb-0"><i
                                                class="isax isax-message-question5 text-primary-soft me-2"></i>30
                                            Questions</p>
                                        <p class="d-flex align-items-center fs-14 mb-0"><i
                                                class="isax isax-clock5 text-secondary-soft me-2"></i>50 Minutes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-end mt-2 mt-md-0">
                                    <a href="instructor-quiz-results.html"
                                       class="text-info text-decoration-underline fs-12 fw-medium me-3">View
                                        Results</a>
                                    <a href="#" class="d-inline-flex fs-14 me-1 action-icon"><i
                                            class="isax isax-edit-2"></i></a>
                                    <a href="#" class="d-inline-flex fs-14 action-icon"><i
                                            class="isax isax-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded-2 p-3 mb-3 mb-0">
                        <div class="row align-items-center gy-3">
                            <div class="col-md-8">
                                <div>
                                    <h6 class="mb-2"><a href="instructor-quiz-questions.html">Information About
                                            Photoshop Design Degree</a></h6>
                                    <div class="question-info d-flex align-items-center">
                                        <p class="d-flex align-items-center fs-14 me-2 pe-2 border-end mb-0"><i
                                                class="isax isax-message-question5 text-primary-soft me-2"></i>20
                                            Questions</p>
                                        <p class="d-flex align-items-center fs-14 mb-0"><i
                                                class="isax isax-clock5 text-secondary-soft me-2"></i>20 Minutes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-end mt-2 mt-md-0">
                                    <a href="instructor-quiz-results.html"
                                       class="text-info text-decoration-underline fs-12 fw-medium me-3">View
                                        Results</a>
                                    <a href="#" class="d-inline-flex fs-14 me-1 action-icon" data-bs-toggle="modal"
                                       data-bs-target="#edit_quiz"><i class="isax isax-edit-2"></i></a>
                                    <a href="#" class="d-inline-flex fs-14 action-icon" data-bs-toggle="modal"
                                       data-bs-target="#delete_modal"><i class="isax isax-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

    @include('admin.quiz.new')

</div>

</body>

</html>
