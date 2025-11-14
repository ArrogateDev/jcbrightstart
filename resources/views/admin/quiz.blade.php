<!DOCTYPE html>
<html lang="en">

<x-admin.head/>

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
                               data-bs-target="#add_quiz">Add Quiz</a>
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

    <div class="modal fade" id="add_quiz">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="fw-bold">Add New Quiz</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        <i class="isax isax-close-circle5"></i>
                    </button>
                </div>
                <form action="instructor-quiz-questions.html">
                    <div class="modal-body pb-0">
                        <div class="mb-3">
                            <label class="form-label">Course <span class="text-danger"> *</span></label>
                            <select class="select">
                                <option>Select</option>
                                <option>Information About UI/UX Design Degree</option>
                                <option>Learn JavaScript and Express to become a Expert</option>
                                <option>Introduction to Python Programming</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quiz Title <span class="text-danger"> *</span></label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No of Questions <span class="text-danger">
												*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Total Marks <span class="text-danger">
												*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Pass Mark <span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Duration <span class="text-danger"> *</span></label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control timepicker" placeholder="dd/mm/yyyy"
                                               value="02-05-2024">
                                        <span class="input-icon-addon">
												<i class="isax isax-clock"></i>
											</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn bg-gray-100 rounded-pill me-2" type="button"
                                data-bs-dismiss="modal">Cancel
                        </button>
                        <button class="btn btn-secondary rounded-pill" type="submit">Add Quiz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_quiz">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="fw-bold">Edit Quiz</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        <i class="isax isax-close-circle5"></i>
                    </button>
                </div>
                <form action="instructor-quiz-questions.html">
                    <div class="modal-body pb-0">
                        <div class="mb-3">
                            <label class="form-label">Course <span class="text-danger"> *</span></label>
                            <select class="select">
                                <option>Select</option>
                                <option selected="">Information About UI/UX Design Degree</option>
                                <option>Learn JavaScript and Express to become a Expert</option>
                                <option>Introduction to Python Programming</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quiz Title <span class="text-danger"> *</span></label>
                            <input type="text" class="form-control" value="Information About UI/UX Design Degree">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No of Questions <span class="text-danger">
												*</span></label>
                                    <input type="text" class="form-control" value="10">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Total Marks <span class="text-danger">
												*</span></label>
                                    <input type="text" class="form-control" value="100">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Pass Mark <span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control" value="50">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Duration <span class="text-danger"> *</span></label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control timepicker" placeholder="dd/mm/yyyy"
                                               value="02-05-2024">
                                        <span class="input-icon-addon">
												<i class="isax isax-clock"></i>
											</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn bg-gray-100 rounded-pill me-2" type="button"
                                data-bs-dismiss="modal">Cancel
                        </button>
                        <button class="btn btn-secondary rounded-pill" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center custom-modal-body">
						<span class="avatar avatar-lg bg-danger-transparent rounded-circle mb-2">
							<i class="isax isax-trash fs-24 text-danger"></i>
						</span>
                    <div>
                        <h4 class="mb-2">Delete Quiz</h4>
                        <p class="mb-3">Are you sure you want to delete Quiz?</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="javascript:void(0);" class="btn bg-gray-100 rounded-pill me-2"
                               data-bs-dismiss="modal">Cancel</a>
                            <a href="javascript:void(0);" class="btn btn-secondary rounded-pill">Yes, Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</body>

</html>
