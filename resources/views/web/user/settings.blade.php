<!DOCTYPE html>
<html lang="en">

<x-web.head/>
<!-- Cropper JS -->
<script src="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.js"></script>

<!-- Cropper CSS -->
<link rel="stylesheet" href="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.css">

<body>

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Header Topbar-->
    <div class="header-topbar text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
                        <p class="d-flex align-items-center fw-medium fs-14 mb-2 me-3"><i
                                class="isax isax-location5 me-2"></i>Fanling, Hong Kong</p>
                        <p class="d-flex align-items-center fw-medium fs-14 mb-2"><i
                                class="isax isax-call-calling5 me-2"></i>+852 xxxx xxxx</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                        <div class="dropdown flag-dropdown mb-2 me-3 d-none">
                            <a href="javascript:void(0);" class="dropdown-toggle d-inline-flex align-items-center"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{web_resource_url('assets/img/flags/us-flag.svg')}}" class="me-2" alt="flag">ENG
                            </a>
                            <ul class="dropdown-menu p-2 mt-2">
                                <li>
                                    <a class="dropdown-item rounded d-flex align-items-center"
                                       href="javascript:void(0);">
                                        <img src="{{web_resource_url('assets/img/flags/us-flag.svg')}}" class="me-2" alt="flag">ENG
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded d-flex align-items-center"
                                       href="javascript:void(0);">
                                        <img src="{{web_resource_url('assets/img/flags/arab-flag.svg')}}" class="me-2" alt="flag">ARA
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded d-flex align-items-center"
                                       href="javascript:void(0);">
                                        <img src="{{web_resource_url('assets/img/flags/france-flag.svg')}}" class="me-2" alt="flag">FRE
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown mb-2 me-3 d-none">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                USD
                            </a>
                            <ul class="dropdown-menu p-2 mt-2">
                                <li><a class="dropdown-item rounded" href="javascript:void(0);">USD</a></li>
                                <li><a class="dropdown-item rounded" href="javascript:void(0);">YEN</a></li>
                                <li><a class="dropdown-item rounded" href="javascript:void(0);">EURO</a></li>
                            </ul>
                        </div>
                        <ul class="social-icon d-flex align-items-center mb-2">
                            <li class="me-2">
                                <a href="javascript:void(0);"><i class="fa-brands fa-facebook-f"></i></a>
                            </li>
                            <li class="me-2">
                                <a href="javascript:void(0);"><i class="fa-brands fa-instagram"></i></a>
                            </li>
                            <li class="me-2">
                                <a href="javascript:void(0);"><i class="fa-brands fa-x-twitter"></i></a>
                            </li>
                            <li class="me-2">
                                <a href="javascript:void(0);"><i class="fa-brands fa-youtube"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><i class="fa-brands fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Header Topbar-->

    <!-- Header -->
    <header class="header-two">
        <div class="container">
            <div class="header-nav">
                <div class="navbar-header">
                    <a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
                    </a>
                    <div class="navbar-logo">
                        <a class="logo-white header-logo" href="{{route('index.html')}}">
                            <img src="{{web_resource_url('assets/img/logo.png')}}" class="logo" alt="Logo">
                        </a>
                        <a class="logo-dark header-logo" href="{{route('index.html')}}">
                            <img src="{{web_resource_url('assets/img/logo-black.png')}}" class="logo" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="main-menu-wrapper">
                    <div class="menu-header">
                        <a href="{{route('index.html')}}" class="menu-logo">
                            <img src="{{web_resource_url('assets/img/logo.png')}}" class="img-fluid" alt="Logo">
                        </a>
                        <a id="menu_close" class="menu-close" href="javascript:void(0);">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <ul class="main-nav">
                        <li class="has-submenu megamenu">
                            <a href="#">Home <i class="isax isax-add"></i></a>
                            <ul class="submenu mega-submenu">
                                <li>
                                    <div class="megamenu-wrapper">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="single-demo">
                                                    <div class="demo-img">
                                                        <a href="{{route('index.html')}}" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-01.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="{{route('index.html')}}" class="inner-demo-img">Home 1</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="single-demo">
                                                    <div class="demo-img">
                                                        <a href="{{route('index-other.html',['no'=>2])}}" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-02.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="{{route('index-other.html',['no'=>2])}}" class="inner-demo-img">Home 2</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="single-demo">
                                                    <div class="demo-img">
                                                        <a href="{{route('index-other.html',['no'=>3])}}" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-03.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="{{route('index-other.html',['no'=>3])}}" class="inner-demo-img">Home 3</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="single-demo">
                                                    <div class="demo-img">
                                                        <a href="{{route('index-other.html',['no'=>4])}}" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-04.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="{{route('index-other.html',['no'=>4])}}" class="inner-demo-img">Home 4</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="single-demo">
                                                    <div class="demo-img">
                                                        <a href="{{route('index-other.html',['no'=>5])}}" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-05.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="{{route('index-other.html',['no'=>5])}}" class="inner-demo-img">Home 5</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="single-demo">
                                                    <div class="demo-img">
                                                        <a href="{{route('index-other.html',['no'=>6])}}" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-06.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="{{route('index-other.html',['no'=>6])}}" class="inner-demo-img">Home 6</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu d-none">
                            <a href="#">Courses <i class="isax isax-add"></i></a>
                            <ul class="submenu">
                                <li class="has-submenu">
                                    <a href="javascript:void(0);">Courses</a>
                                    <ul class="submenu">
                                        <li><a href="course-grid.html">Course Grid</a></li>
                                        <li><a href="course-list.html">Course List</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="javascript:void(0);">Course Category</a>
                                    <ul class="submenu">
                                        <li><a href="course-category.html">Course Category</a></li>
                                        <li><a href="course-category-2.html">Course Category 2</a></li>
                                        <li><a href="course-category-3.html">Course Category 3</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="javascript:void(0);">Course Details</a>
                                    <ul class="submenu">
                                        <li><a href="course-details.html">Course Details</a></li>
                                        <li><a href="course-details-2.html">Course Details 2</a></li>
                                    </ul>
                                </li>
                                <li><a href="course-resume.html">Course Resume</a></li>
                                <li><a href="course-watch.html">Course Watch</a></li>
                                <li><a href="cart.html">Course Cart</a></li>
                                <li><a href="checkout.html">Course Checkout</a></li>
                                <li><a href="add-course.html">Add New Course</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu active d-none">
                            <a href="javascript:void(0);">Dashboard <i class="isax isax-add"></i></a>
                            <ul class="submenu">
                                <li class="has-submenu active">
                                    <a href="javascript:void(0);">Instructor Dashboard</a>
                                    <ul class="submenu">
                                        <li><a href="instructor-dashboard.html">Dashboard</a></li>
                                        <li><a href="instructor-profile.html">My Profile</a></li>
                                        <li><a href="instructor-course.html">Course</a></li>
                                        <li><a href="instructor-announcements.html">Announcements</a></li>
                                        <li><a href="instructor-assignment.html">Assignments</a></li>
                                        <li class="has-submenu">
                                            <a href="javascript:void(0);">Student</a>
                                            <ul class="submenu">
                                                <li><a href="students.html">Student Grid</a></li>
                                                <li><a href="student-list.html">Student List</a></li>
                                                <li><a href="student-details.html">Student Details</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="instructor-quiz.html">Quiz</a></li>
                                        <li><a href="instructor-quiz-results.html">Quiz Results</a></li>
                                        <li><a href="instructor-certificate.html">Certificates</a></li>
                                        <li><a href="instructor-earnings.html">Earning</a></li>
                                        <li><a href="instructor-payout.html">Payout</a></li>
                                        <li><a href="instructor-statements.html">Statement</a></li>
                                        <li><a href="instructor-tickets.html">Support Tickets</a></li>
                                        <li class="active"><a href="instructor-settings.html">Settings</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="javascript:void(0);">Student Dashboard</a>
                                    <ul class="submenu">
                                        <li><a href="student-dashboard.html">Student Dashboard</a></li>
                                        <li><a href="student-profile.html">My Profile</a></li>
                                        <li><a href="student-courses.html">Enrolled Courses</a></li>
                                        <li><a href="student-certificates.html">My Certificates</a></li>
                                        <li><a href="student-wishlist.html">Wishlist</a></li>
                                        <li><a href="student-reviews.html">Reviews</a></li>
                                        <li><a href="student-quiz.html">My Quiz Attempts</a></li>
                                        <li><a href="student-order-history.html">Order History</a></li>
                                        <li><a href="student-referral.html">Referrals</a></li>
                                        <li><a href="student-messages.html">Messages</a></li>
                                        <li><a href="student-tickets.html">Support Ticket</a></li>
                                        <li><a href="student-settings.html">Settings</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu d-none">
                            <a href="#">Pages <i class="isax isax-add"></i></a>
                            <ul class="submenu">
                                <li class="has-submenu">
                                    <a href="#">Instructors</a>
                                    <ul class="submenu">
                                        <li><a href="instructor-grid.html">Instructor Grid</a></li>
                                        <li><a href="instructor-list.html">Instructor List</a></li>
                                        <li><a href="instructor-details.html">Instructor Details</a></li>
                                    </ul>
                                </li>
                                <li><a href="about-us.html">About Us</a></li>
                                <li><a href="contact-us.html">Contact us</a></li>
                                <li><a href="notifications.html">Notifications</a></li>
                                <li><a href="become-an-instructor.html">Become an Instructor</a></li>
                                <li><a href="testimonials.html">Testimonials</a></li>
                                <li class="has-submenu">
                                    <a href="#">Authentication</a>
                                    <ul class="submenu">
                                        <li><a href="login.html">Login</a></li>
                                        <li><a href="register.html">Register</a></li>
                                        <li><a href="forgot-password.html">Forgot Password</a></li>
                                        <li><a href="reset-password.html">Reset Password</a></li>
                                        <li><a href="set-password.html">Set Password</a></li>
                                        <li><a href="otp.html">OTP</a></li>
                                        <li><a href="lock-screen.html">Lock Screen</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="#">Error</a>
                                    <ul class="submenu">
                                        <li><a href="error-404.html">404 Error</a></li>
                                        <li><a href="error-500.html">500 Error</a></li>
                                    </ul>
                                </li>
                                <li><a href="pricing-plan.html">Pricing Plan</a></li>
                                <li><a href="faq.html">FAQ</a></li>
                                <li><a href="coming-soon.html">Coming Soon</a></li>
                                <li><a href="under-construction.html">Under Construction</a></li>
                                <li><a href="terms-and-conditions.html">Terms & Conditions</a></li>
                                <li><a href="privacy-policy.html">Privacy Policy</a></li>
                                <li><a href="index-rtl.html">RTL</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu d-none">
                            <a href="#">Blog <i class="isax isax-add"></i></a>
                            <ul class="submenu">
                                <li class="has-submenu">
                                    <a href="#">Blog Layouts</a>
                                    <ul class="submenu">
                                        <li><a href="blog-grid.html">Blog 1 Grid</a></li>
                                        <li><a href="blog-2-grid.html">Blog 2 Grid</a></li>
                                        <li><a href="blog-3-grid.html">Blog 3 Grid</a></li>
                                        <li><a href="blog-carousal.html">Blog Carousal</a></li>
                                        <li><a href="blog-masonry.html">Blog Mansory</a></li>
                                        <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                                        <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="#">Blog Details</a>
                                    <ul class="submenu">
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                        <li><a href="blog-details-left-sidebar.html">Blog Details Left Sidebar</a>
                                        </li>
                                        <li><a href="blog-details-right-sidebar.html">Blog Details Right Sidebar</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="header-btn d-flex align-items-center">
                    <div class="icon-btn me-2 d-none">
                        <a href="javascript:void(0);" id="dark-mode-toggle" class="theme-toggle activate">
                            <i class="isax isax-sun-15"></i>
                        </a>
                        <a href="javascript:void(0);" id="light-mode-toggle" class="theme-toggle">
                            <i class="isax isax-moon"></i>
                        </a>
                    </div>
                    <div class="icon-btn me-3 d-none">
                        <a href="cart.html" class="position-relative">
                            <i class="isax isax-shopping-cart5"></i>
                            <span class="count-icon bg-success p-1 rounded-pill text-white fs-10 fw-bold">1</span>
                        </a>
                    </div>
                    <div class="dropdown profile-dropdown">
                        <a href="javascript:void(0);" class="d-flex align-items-center" data-bs-toggle="dropdown">
								<span class="avatar">
									<img src="{{web_resource_url('assets/img/user/user-01.jpg')}}" alt="Img" class="img-fluid rounded-circle">
								</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="profile-header d-flex align-items-center">
                                <div class="avatar">
                                    <img src="{{web_resource_url('assets/img/user/user-01.jpg')}}" alt="Img"
                                         class="img-fluid rounded-circle">
                                </div>
                                <div>
                                    <h6>Eugene Andre</h6>
                                    <p><a href="/cdn-cgi/l/email-protection"
                                          class="__cf_email__">eric@arrogatemaker.com</a>
                                    </p>
                                </div>
                            </div>
                            <ul class="profile-body">
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                       href="instructor-profile.html"><i
                                            class="isax isax-security-user me-2"></i>My Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                       href="instructor-course.html"><i
                                            class="isax isax-teacher me-2"></i>Courses</a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium2"
                                       href="instructor-earnings.html"><i
                                            class="isax isax-dollar-circle me-2"></i>Earnings</a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                       href="instructor-payout.html"><i class="isax isax-coin me-2"></i>Payouts</a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                       href="instructor-message.html"><i
                                            class="isax isax-messages-3 me-2"></i>Messages<span
                                            class="message-count">2</span></a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                       href="instructor-settings.html"><i
                                            class="isax isax-setting-2 me-2"></i>Settings</a>
                                </li>
                            </ul>
                            <div class="profile-footer">
                                <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                   href="login.html"><i class="isax isax-arrow-2 me-2"></i>Log in as Student</a>
                                <a href="{{route('index.html')}}"
                                   class="btn btn-secondary d-inline-flex align-items-center justify-content-center w-100"><i
                                        class="isax isax-logout me-2"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- /Header -->

    <x-web.user.breadcrumb title="Settings"/>

    <div class="content">
        <div class="container">
            <div class="instructor-profile">
                <div class="instructor-profile-bg">
                    <img src="{{web_resource_url('assets/img/bg/card-bg-01.png')}}" class="instructor-profile-bg-1" alt="">
                </div>
                <div class="row align-items-center row-gap-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
								<span
                                    class="avatar flex-shrink-0 avatar-xxl avatar-rounded me-3 border border-white border-3 position-relative">
									<img src="{{web_resource_url('assets/img/user/user-01.jpg')}}" alt="img">
									<span class="verify-tick"><i class="isax isax-verify5"></i></span>
								</span>
                            <div>
                                <h5 class="mb-1 text-white d-inline-flex align-items-center">Eugene Andre<a
                                        href="instructor-profile.html" class="link-light fs-16 ms-2"><i
                                            class="isax isax-edit-2"></i></a></h5>
                                <p class="text-light">Instructor</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center flex-wrap gap-3 justify-content-md-end">
                            <a href="add-course.html" class="btn btn-white rounded-pill">Add New Course</a>
                            <a href="student-dashboard.html" class="btn btn-secondary rounded-pill">Student
                                Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <x-web.user.sidebar active="settings"/>

                <div class="col-lg-9">
                    <div class="mb-3">
                        <h5>Settings</h5>
                    </div>
                    <ul class="settings-nav d-flex align-items-center flex-wrap border bg-light-900 rounded">
                        <li><a href="{{route('user.settings.html')}}" class="active">Edit Profile</a></li>
                        <li><a href="{{route('user.change-password.html')}}">Security</a></li>
                    </ul>
                    <form>
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-upload-group">
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0);"
                                           class="avatar flex-shrink-0 avatar-xxxl avatar-rounded border me-3"
                                           data-avatar-trigger="true">
                                            <img
                                                id="currentAvatarImage"
                                                src="{{web_resource_url('assets/img/user/user-01.jpg')}}" alt="Img" class="img-fluid">
                                        </a>
                                        <div class="profile-upload-head">
                                            <h6><a href="javascript:void(0);">Your Avatar</a></h6>
                                            <p class="fs-14 mb-0">PNG or JPG no bigger than 800px width and height
                                            </p>
                                            <div class="new-employee-field">
                                                <div class="d-flex align-items-center mt-2">
                                                    <div class="image-upload position-relative mb-0 me-2">
                                                        <input type="file" id="avatarFileInput" accept="image/*">
                                                        <input type="hidden" name="avatar" id="avatarCroppedInput">
                                                        <a href="#"
                                                           class="btn bg-gray-100 btn-sm rounded-pill image-uploads"
                                                           data-avatar-trigger="true">Upload</a>
                                                    </div>
                                                    <div class="img-delete ms-1">
                                                        <a href="#"
                                                           class="btn btn-secondary btn-sm rounded-pill">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="edit-profile-info mb-3">
                                        <h5 class="mb-1 fs-18">Personal Details</h5>
                                        <p>Edit your personal information</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">First Name <span class="text-danger">
															*</span></label>
                                                <input type="text" class="form-control" value="Eugene">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Last Name <span class="text-danger">
															*</span></label>
                                                <input type="text" class="form-control" value="Andre">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">User Name <span class="text-danger">
															*</span></label>
                                                <input type="text" class="form-control" value="instructordemo">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Phone Number <span class="text-danger">
															*</span></label>
                                                <input type="text" class="form-control" value="90154-91036">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Gender <span class="text-danger">
															*</span></label>
                                                <select class="select">
                                                    <option>Select</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Age <span class="text-danger">
															*</span></label>
                                                <select class="select">
                                                    <option>Under 18 / < 18</option>
                                                    <option>18-24</option>
                                                    <option>25-34</option>
                                                    <option>35-44</option>
                                                    <option>45-54</option>
                                                    <option>55-64</option>
                                                    <option>65+</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-secondary rounded-pill" type="submit">Update
                                                Profile
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>

    <x-web.footer/>

    <!-- Avatar Crop Modal -->
    <div class="modal fade" id="avatarCropModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">裁剪头像</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <div class="ratio ratio-1x1 bg-light border rounded d-flex align-items-center justify-content-center">
                                <img id="avatarCropperImage" src="" alt="Avatar Crop" class="img-fluid d-none">
                                <span id="avatarCropperPlaceholder" class="text-muted">请选择一张图片</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="avatar-crop-preview shadow-sm mx-auto cropper-preview"></div>
                            <p class="text-muted text-center mt-3 fs-14">预览区域为最终圆形头像效果</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-secondary" id="avatarCropConfirm">保存头像</button>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

<style>
    .avatar-crop-preview {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        overflow: hidden;
        background: #f5f5f5;
    }

    .avatar-crop-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cropper-container {
        max-width: 100%;
    }

    .cropper-view-box,
    .cropper-face {
        border-radius: 50%;
    }
</style>

<script>
    (function () {
        const fileInput = document.getElementById('avatarFileInput');
        const triggers = document.querySelectorAll('[data-avatar-trigger]');
        const modalElement = document.getElementById('avatarCropModal');
        const cropperImage = document.getElementById('avatarCropperImage');
        const placeholder = document.getElementById('avatarCropperPlaceholder');
        const confirmButton = document.getElementById('avatarCropConfirm');
        const avatarImage = document.getElementById('currentAvatarImage');
        const hiddenInput = document.getElementById('avatarCroppedInput');
        const previewSelector = '.cropper-preview';

        if (!fileInput || !modalElement || !avatarImage) {
            return;
        }

        const bootstrapModal = new bootstrap.Modal(modalElement);
        let cropperInstance = null;

        function destroyCropper() {
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }
        }

        triggers.forEach(trigger => {
            trigger.addEventListener('click', function (event) {
                event.preventDefault();
                fileInput.click();
            });
        });

        fileInput.addEventListener('change', function (event) {
            const [file] = event.target.files || [];
            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                showToast('error', '请选择图片文件');
                fileInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                placeholder.classList.add('d-none');
                cropperImage.classList.remove('d-none');
                cropperImage.src = e.target.result;

                modalElement.addEventListener('shown.bs.modal', function initCropper() {
                    modalElement.removeEventListener('shown.bs.modal', initCropper);
                    destroyCropper();
                    const CropperClass = window.Cropper;
                    if (typeof CropperClass !== 'function') {
                        showToast('error', '未加载裁剪组件');
                        return;
                    }
                    cropperInstance = new CropperClass(cropperImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                        background: false,
                        preview: previewSelector,
                        ready() {
                            bootstrapModal.handleUpdate();
                        }
                    });
                }, {once: true});

                bootstrapModal.show();
            };

            reader.readAsDataURL(file);
        });

        modalElement.addEventListener('hidden.bs.modal', function () {
            destroyCropper();
            cropperImage.src = '';
            cropperImage.classList.add('d-none');
            placeholder.classList.remove('d-none');
            fileInput.value = '';
        });

        confirmButton.addEventListener('click', function () {
            if (!cropperInstance) {
                showToast('error', '请先选择并裁剪图片');
                return;
            }

            const canvas = cropperInstance.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingQuality: 'high'
            });

            if (!canvas) {
                showToast('error', '裁剪失败，请重试');
                return;
            }

            const dataUrl = canvas.toDataURL('image/png');
            console.log(dataUrl);
            // avatarImage.src = dataUrl;
            // hiddenInput.value = dataUrl;
            // bootstrapModal.hide();
            // showToast('success', '头像已更新');
        });
    })();
</script>

</html>
