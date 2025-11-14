<!DOCTYPE html>
<html lang="en">

<x-admin.head/>

<body>

<!-- Main Wrapper -->
<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('测验结果管理')}}"/>

    <div class="content">
        <div class="container">
            <div class="row">

                <x-admin.sidebar active="quiz-results"/>

                <div class="col-lg-9">
                    <h5 class="page-title">{{__('测验结果管理')}}</h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex align-items-center">
                                <div class="quiz-img me-3 mb-2 mb-sm-0">
                                    <img src="{{web_resource_url('assets/img/students/quiz.jpg')}}" alt="">
                                </div>
                                <div>
                                    <h5 class="mb-2"><a href="#">Information About UI/UX Design Degree</a></h5>
                                    <div class="question-info d-flex align-items-center">
                                        <p class="d-flex align-items-center fs-14 me-2 pe-2 border-end mb-0"><i
                                                class="isax isax-message-question5 text-primary-soft me-2"></i>25
                                            Questions</p>
                                        <p class="d-flex align-items-center fs-14 mb-0"><i
                                                class="isax isax-clock5 text-secondary-soft me-2"></i>30 Minutes</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-secondary-transparent border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1 fw-normal text-gray-5">Total Particpants</h6>
                                            <span class="fs-20 fw-bold mb-1 d-block text-gray-9">30</span>
                                        </div>
                                        <div class="icon-box bg-soft-secondary">
                                            <img src="{{web_resource_url('assets/img/icon/user-tick.svg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-info-transparent border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1 fw-normal text-gray-5">Scores</h6>
                                            <span class="fs-20 fw-bold mb-1 d-block text-gray-9">03</span>
                                        </div>
                                        <div class="icon-box  bg-soft-info">
                                            <img src="{{web_resource_url('assets/img/icon/document.svg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-purple-transparent border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="mb-1 fw-normal text-gray-5">Average Time</h6>
                                            <span class="fs-20 fw-bold mb-1 d-block text-gray-9">00:00:55</span>
                                        </div>
                                        <div class="icon-box  bg-soft-purple">
                                            <img src="{{web_resource_url('assets/img/icon/clock.svg')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive custom-table">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>Student Name</th>
                                <th>Score</th>
                                <th>Attemplts</th>
                                <th>Finish Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="student-details.html"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/img/user/user-01.jpg')}}" alt="">
                                        </a>
                                        <a href="student-details.html" class="fs-14">Thompson Hicks</a>
                                    </div>
                                </td>
                                <td>75</td>
                                <td>04</td>
                                <td>22 Aug 2025, 09:00 AM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="student-details.html"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/img/user/user-06.jpg')}}" alt="">
                                        </a>
                                        <a href="student-details.html" class="fs-14">Jennifer Tovar</a>
                                    </div>
                                </td>
                                <td>50</td>
                                <td>03</td>
                                <td>10 Aug 2025, 09:15 AM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="student-details.html"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/img/user/user-09.jpg')}}" alt="">
                                        </a>
                                        <a href="student-details.html" class="fs-14">James Schulte</a>
                                    </div>
                                </td>
                                <td>60</td>
                                <td>02</td>
                                <td>26 Jul 2025, 02:20 PM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="student-details.html"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/img/user/user-20.jpg')}}" alt="">
                                        </a>
                                        <a href="student-details.html" class="fs-14">Kristy Cardona</a>
                                    </div>
                                </td>
                                <td>55</td>
                                <td>02</td>
                                <td>12 Jul 2025, 11:40 AM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="student-details.html"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/img/user/user-27.jpg')}}" alt="">
                                        </a>
                                        <a href="student-details.html" class="fs-14">William Aragon</a>
                                    </div>
                                </td>
                                <td>45</td>
                                <td>04</td>
                                <td>02 Jul 2025, 04:30 PM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="student-details.html"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/img/user/user-30.jpg')}}" alt="">
                                        </a>
                                        <a href="student-details.html" class="fs-14">Shirley Lis</a>
                                    </div>
                                </td>
                                <td>60</td>
                                <td>01</td>
                                <td>25 Jun 2025, 08:10 AM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="student-details.html"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/img/user/user-17.jpg')}}" alt="">
                                        </a>
                                        <a href="student-details.html" class="fs-14">John Brewer</a>
                                    </div>
                                </td>
                                <td>45</td>
                                <td>02</td>
                                <td>17 Jun 2025, 06:30 PM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="student-details.html"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/img/user/user-37.jpg')}}" alt="">
                                        </a>
                                        <a href="student-details.html" class="fs-14">Doris Hughes</a>
                                    </div>
                                </td>
                                <td>65</td>
                                <td>03</td>
                                <td>04 Jun 2025, 05:00 PM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="student-details.html"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/img/user/user-04.jpg')}}" alt="">
                                        </a>
                                        <a href="student-details.html" class="fs-14">Sarah Martinez</a>
                                    </div>
                                </td>
                                <td>70</td>
                                <td>04</td>
                                <td>20 May 2025, 06:30 PM</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="student-details.html"
                                           class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{web_resource_url('assets/img/user/user-18.jpg')}}" alt="">
                                        </a>
                                        <a href="student-details.html" class="fs-14">Sarah Martinez</a>
                                    </div>
                                </td>
                                <td>40</td>
                                <td>03</td>
                                <td>15 May 2025, 01:40 PM</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /pagination -->
                    <div class="row align-items-center mt-4">
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

    <!-- Add Question -->
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
                                <option>Multiple choice</option>
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
    <!-- /Add Question -->

    <!-- Edit Question -->
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
    <!-- /Edit Question -->

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center custom-modal-body">
						<span class="avatar avatar-lg bg-secondary-transparent rounded-circle mb-2">
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
    <!-- /Delete Modal -->

</div>

</body>

</html>
