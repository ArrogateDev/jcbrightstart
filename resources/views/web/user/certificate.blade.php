<!DOCTYPE html>
<html lang="en">

<x-head/>

<body>

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Header Topbar-->
    <div class="header-topbar text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center ">
                        <p class="d-flex align-items-center fw-medium fs-14 mb-2 me-3"><i
                                class="isax isax-location me-2"></i>Fanling, Hong Kong</p>
                        <p class="d-flex align-items-center fw-medium fs-14 mb-2"><i
                                class="isax isax-call-calling5 me-2"></i>+852 xxxx xxxx</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="dropdown flag-dropdown mb-2 me-3">
                            <a href="javascript:void(0);" class="dropdown-toggle d-inline-flex align-items-center"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{web_resource_url('assets/img/flags/us-flag.svg')}}" class="me-2" alt="flag">ENG
                            </a>
                            <ul class="dropdown-menu p-2 mt-2" style="">
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
                        <div class="dropdown mb-2 me-3">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                USD
                            </a>
                            <ul class="dropdown-menu p-2 mt-2" style="">
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
                        <a class="logo-white header-logo" href="index.html">
                            <img src="{{web_resource_url('assets/img/logo.png')}}" class="logo" alt="Logo">
                        </a>
                        <a class="logo-dark header-logo" href="index.html">
                            <img src="{{web_resource_url('assets/img/logo-black.png')}}" class="logo" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="main-menu-wrapper">
                    <div class="menu-header">
                        <a href="index.html" class="menu-logo">
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
                                                        <a href="index.html" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-01.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="index.html" class="inner-demo-img">Home 1</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="single-demo">
                                                    <div class="demo-img">
                                                        <a href="index-2.html" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-02.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="index-2.html" class="inner-demo-img">Home 2</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="single-demo">
                                                    <div class="demo-img">
                                                        <a href="index-3.html" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-03.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="index-3.html" class="inner-demo-img">Home 3</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="single-demo">
                                                    <div class="demo-img">
                                                        <a href="index-4.html" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-04.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="index-4.html" class="inner-demo-img">Home 4</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="single-demo">
                                                    <div class="demo-img">
                                                        <a href="index-5.html" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-05.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="index-5.html" class="inner-demo-img">Home 5</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="single-demo">
                                                    <div class="demo-img">
                                                        <a href="index-6.html" class="inner-demo-img"><img
                                                                src="{{web_resource_url('assets/img/home/home-06.jpg')}}" class="img-fluid "
                                                                alt="img"></a>
                                                    </div>
                                                    <div class="demo-info">
                                                        <a href="index-6.html" class="inner-demo-img">Home 6</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="has-submenu">
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
                        <li class="has-submenu active">
                            <a href="javascript:void(0);">Dashboard <i class="isax isax-add"></i></a>
                            <ul class="submenu">
                                <li class="has-submenu">
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
                                        <li><a href="instructor-settings.html">Settings</a></li>
                                    </ul>
                                </li>
                                <li class="has-submenu active">
                                    <a href="javascript:void(0);">Student Dashboard</a>
                                    <ul class="submenu">
                                        <li><a href="student-dashboard.html">Student Dashboard</a></li>
                                        <li><a href="student-profile.html">My Profile</a></li>
                                        <li><a href="student-courses.html">Enrolled Courses</a></li>
                                        <li class="active"><a href="student-certificates.html">My Certificates</a>
                                        </li>
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
                        <li class="has-submenu">
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
                        <li class="has-submenu">
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
                    <div class="icon-btn me-2">
                        <a href="javascript:void(0);" id="dark-mode-toggle" class="theme-toggle activate">
                            <i class="isax isax-sun-15"></i>
                        </a>
                        <a href="javascript:void(0);" id="light-mode-toggle" class="theme-toggle">
                            <i class="isax isax-moon"></i>
                        </a>
                    </div>
                    <div class="icon-btn me-3">
                        <a href="cart.html" class="position-relative">
                            <i class="isax isax-shopping-cart5"></i>
                            <span class="count-icon bg-success p-1 rounded-pill text-white fs-10 fw-bold">1</span>
                        </a>
                    </div>
                    <div class="dropdown profile-dropdown">
                        <a href="javascript:void(0);" class="d-flex align-items-center" data-bs-toggle="dropdown">
								<span class="avatar">
									<img src="{{web_resource_url('assets/img/user/user-02.jpg')}}" alt="Img" class="img-fluid rounded-circle">
								</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="profile-header d-flex align-items-center">
                                <div class="avatar">
                                    <img src="{{web_resource_url('assets/img/user/user-02.jpg')}}" alt="Img"
                                         class="img-fluid rounded-circle">
                                </div>
                                <div>
                                    <h6>Ronald Richard</h6>
                                    <p><a href="/cdn-cgi/l/email-protection"
                                          class="__cf_email__">eric@arrogatemaker.com</a>
                                    </p>
                                </div>
                            </div>
                            <ul class="profile-body">
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                       href="student-profile.html"><i class="isax isax-security-user me-2"></i>My
                                        Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                       href="student-quiz.html"><i class="isax isax-award me-2"></i>Quiz
                                        Attempts</a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium2"
                                       href="student-order-history.html"><i
                                            class="isax isax-shopping-cart me-2"></i>Order History</a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                       href="student-messages.html"><i
                                            class="isax isax-messages-3 me-2"></i>Messages<span
                                            class="message-count">2</span></a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                       href="student-settings.html"><i
                                            class="isax isax-setting-2 me-2"></i>Settings</a>
                                </li>
                            </ul>
                            <div class="profile-footer">
                                <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                   href="login.html"><i class="isax isax-arrow-2 me-2"></i>Log in as Instructor</a>
                                <a href="index.html"
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

    <x-user.breadcrumb title="My Certificates"/>

    <div class="content">
        <div class="container">

            <!-- Profile -->
            <div class="profile-card overflow-hidden bg-blue-gradient2 mb-5 p-5">
                <div class="profile-card-bg">
                    <img src="{{web_resource_url('assets/img/bg/card-bg-01.png')}}" class="profile-card-bg-1" alt="">
                </div>
                <div class="row align-items-center row-gap-3">
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center">
								<span
                                    class="avatar avatar-xxl avatar-rounded me-3 border border-white border-2 position-relative">
									<img src="{{web_resource_url('assets/img/user/user-02.jpg')}}" alt="">
									<span class="verify-tick"><i class="isax isax-verify5"></i></span>
								</span>
                            <div>
                                <h5 class="mb-1 text-white d-inline-flex align-items-center">Ronald Richard<a
                                        href="student-profile.html" class="link-light fs-16 ms-2"><i
                                            class="isax isax-edit-2"></i></a></h5>
                                <p class="text-light">Student</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center justify-content-lg-end flex-wrap gap-2">
                            <a href="become-an-instructor.html" class="btn btn-white rounded-pill me-3">Become an
                                Instructor</a>
                            <a href="instructor-dashboard.html" class="btn btn-secondary rounded-pill">Instructor
                                Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Profile -->

            <div class="row">

                <x-user.sidebar active="certificate"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5>My Certificates</h5>
                    </div>
                    <div class="table-responsive custom-table">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Certificate Name</th>
                                <th>Date</th>
                                <th>Marks</th>
                                <th>Out of</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>01</td>
                                <td><a href="#" class="fw-semibold">UI/UX Design Certificate</a></td>
                                <td>22 Aug 2025</td>
                                <td>20</td>
                                <td>20</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#view_certificate"><i
                                                class="isax isax-eye"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"><i
                                                class="isax isax-import"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td><a href="#" class="fw-semibold">Wordpress Certificate</a></td>
                                <td>10 Aug 2025</td>
                                <td>18</td>
                                <td>20</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#view_certificate"><i
                                                class="isax isax-eye"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"><i
                                                class="isax isax-import"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>03</td>
                                <td><a href="#" class="fw-semibold">HTML CSS Certificate</a></td>
                                <td>26 Jul 2025</td>
                                <td>25</td>
                                <td>30</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#view_certificate"><i
                                                class="isax isax-eye"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"><i
                                                class="isax isax-import"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>04</td>
                                <td><a href="#" class="fw-semibold">JavaScript Certificate</a></td>
                                <td>14 Jul 2025</td>
                                <td>15</td>
                                <td>20</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#view_certificate"><i
                                                class="isax isax-eye"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"><i
                                                class="isax isax-import"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>05</td>
                                <td><a href="#" class="fw-semibold">Photoshop Certificate</a></td>
                                <td>19 Jun 2025</td>
                                <td>20</td>
                                <td>30</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#view_certificate"><i
                                                class="isax isax-eye"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"><i
                                                class="isax isax-import"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>06</td>
                                <td><a href="#" class="fw-semibold">Python Certificate</a></td>
                                <td>12 Jun 2025</td>
                                <td>20</td>
                                <td>20</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="#" class="d-inline-flex fs-14 me-1 action-icon"
                                           data-bs-toggle="modal" data-bs-target="#view_certificate"><i
                                                class="isax isax-eye"></i></a>
                                        <a href="#" class="d-inline-flex fs-14 action-icon"><i
                                                class="isax isax-import"></i></a>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer/>

    <!-- View Certificate -->
    <div class="modal fade" id="view_certificate">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>View Certificate</h5>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                        <i class="isax isax-close-circle5"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div><img src="{{web_resource_url('assets/img/icon/certificate.svg')}}" class="img-fluid" alt=""></div>
                    <div class="text-end mt-4">
                        <a href="#" class="btn btn-secondary rounded-pill"><i
                                class="isax isax-import me-2"></i>Download</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /View Certificate -->

</div>

</body>

</html>
