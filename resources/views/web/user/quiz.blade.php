<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>

<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <x-web.user.breadcrumb title="{{__('我的测验')}}"/>

    <div class="content">
        <div class="container">

            <x-web.user.profile :user="$user"/>

            <div class="row">

                <x-web.user.sidebar active="quiz"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5>{{__('我的测验')}}</h5>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border p-3 mb-3 rounded-2">
                        <div>
                            <h6 class="mb-1"><a href="student-quiz-questions.html">Information About UI/UX Design
                                    Degree</a></h6>
                            <p class="fs-14">Number of Questions : 05</p>
                        </div>
                        <div>
                            <a href="student-quiz-questions.html" class="arrow-next"><i
                                    class="isax isax-arrow-right-1"></i></a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border p-3 pb-3 mb-3 rounded-2">
                        <div>
                            <h6 class="mb-1"><a href="student-quiz-questions.html">Learn JavaScript and Express to
                                    become a Expert</a></h6>
                            <p class="fs-14">Number of Questions : 10</p>
                        </div>
                        <div>
                            <a href="student-quiz-questions.html" class="arrow-next"><i
                                    class="isax isax-arrow-right-1"></i></a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border p-3 pb-3 mb-3 rounded-2">
                        <div>
                            <h6 class="mb-1"><a href="student-quiz-questions.html">Introduction to Python
                                    Programming</a></h6>
                            <p class="fs-14">Number of Questions : 08</p>
                        </div>
                        <div>
                            <a href="student-quiz-questions.html" class="arrow-next"><i
                                    class="isax isax-arrow-right-1"></i></a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border p-3 pb-3 mb-3 rounded-2">
                        <div>
                            <h6 class="mb-1"><a href="student-quiz-questions.html">Build Responsive Websites with
                                    HTML5 and CSS3</a></h6>
                            <p class="fs-14">Number of Questions : 05</p>
                        </div>
                        <div>
                            <a href="student-quiz-questions.html" class="arrow-next"><i
                                    class="isax isax-arrow-right-1"></i></a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border p-3 pb-3 mb-3 rounded-2">
                        <div>
                            <h6 class="mb-1"><a href="student-quiz-questions.html">Information About Photoshop
                                    Design Degree</a></h6>
                            <p class="fs-14">Number of Questions : 10</p>
                        </div>
                        <div>
                            <a href="student-quiz-questions.html" class="arrow-next"><i
                                    class="isax isax-arrow-right-1"></i></a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border p-3 rounded-2">
                        <div>
                            <h6 class="mb-1"><a href="student-quiz-questions.html">C# Developers Double Your Coding
                                    with Visual Studio</a></h6>
                            <p class="fs-14">Number of Questions : 07</p>
                        </div>
                        <div>
                            <a href="student-quiz-questions.html" class="arrow-next"><i
                                    class="isax isax-arrow-right-1"></i></a>
                        </div>
                    </div>
                    <!-- /pagination -->
                    <div class="row align-items-center mt-3">
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


    <x-web.user.footer/>

    <!-- Edit Review -->
    <div class="modal fade" id="edit_review">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit Review</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        <i class="isax isax-close-circle5"></i>
                    </button>
                </div>
                <div class="modal-body pb-0">
                    <div class="mb-3">
                        <label class="form-label fs-14">Your Rating <span class="text-danger">*</span></label>
                        <div class="selection-wrap">
                            <div class="d-inline-block">
                                <div class="rating-selction">
                                    <input type="radio" name="rating" value="5" id="rating5" checked="">
                                    <label for="rating5"><i class="fa-solid fa-star"></i></label>
                                    <input type="radio" name="rating" value="4" id="rating4" checked="">
                                    <label for="rating4"><i class="fa-solid fa-star"></i></label>
                                    <input type="radio" name="rating" value="3" id="rating3" checked="">
                                    <label for="rating3"><i class="fa-solid fa-star"></i></label>
                                    <input type="radio" name="rating" value="2" id="rating2">
                                    <label for="rating2"><i class="fa-solid fa-star"></i></label>
                                    <input type="radio" name="rating" value="1" id="rating1">
                                    <label for="rating1"><i class="fa-solid fa-star"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-14">Write Your Review <span class="text-danger">*</span></label>
                        <textarea class="form-control"
                                  rows="3">This is the second Photoshop course I have completed with Nancy Duarte. Worth every penny and recommend it highly. To get the most out of this course, its best to to take the Beginner to Advanced course first. The sound and video quality is of a good standard. Thank you Nancy Duarte.</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn bg-gray-100 btn-light rounded-pill me-2"
                       data-bs-dismiss="modal">Cancel</a>
                    <button type="submit" class="btn btn-md btn-secondary rounded-pill">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Review -->

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center custom-modal-body">
						<span class="avatar avatar-lg bg-secondary-transparent rounded-circle mb-2">
							<i class="isax isax-trash fs-24 text-danger"></i>
						</span>
                    <div>
                        <h4 class="mb-2">Delete Review</h4>
                        <p class="mb-3">Are you sure you want to delete review?</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="#" class="btn bg-gray-100 rounded-pill me-2" data-bs-dismiss="modal">Cancel</a>
                            <a href="#" class="btn btn-secondary rounded-pill">Yes, Remove All</a>
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
