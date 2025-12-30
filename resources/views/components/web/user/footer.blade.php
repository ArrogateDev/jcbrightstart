<footer class="footer footer-one">
    <div class="footer-top">
        <div class="container">
            <div class="row row-gap-4">
                <div class="col-lg-4">
                    <div class="footer-about">
                        <div class="footer-logo">
                            <img class="logo-max-200" src="{{web_resource_url('assets/admin/img/logo-black.png')}}" alt="">
                        </div>
                        <p>Platform designed to help organizations, educators, and learners manage, deliver, and
                            track learning and training activities.</p>
                        <div class="d-flex align-items-center d-none">
                            <a href="#" class="me-2"><img src="{{web_resource_url('assets/admin/img/icon/appstore.svg')}}" alt=""></a>
                            <a href="#"><img src="{{web_resource_url('assets/admin/img/icon/googleplay.svg')}}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row row-gap-4">
                        <div class="col-lg-4 col-md-4 d-none">
                            <div class="footer-widget footer-menu">
                                <h5 class="footer-title">Support</h5>
                                <ul>
                                    <li><a href="course-grid.html">Education</a></li>
                                    <li><a href="add-course.html">Enroll Course</a></li>
                                    <li><a href="javscript:void(0);">Orders</a></li>
                                    <li><a href="pricing-plan.html">Payments</a></li>
                                    <li><a href="blog-grid.html">Blogs</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="footer-widget footer-menu">
                                <h5 class="footer-title">About</h5>
                                <ul>
                                    <li class=" d-none"><a href="course-category.html">Categories</a></li>
                                    <li class=" d-none"><a href="course-list.html">Courses</a></li>
                                    <li><a href="{{route('page', ['page' => 'about-us.html'])}}">About Us</a></li>
                                    <li><a href="{{route('page', ['page' => 'faq.html'])}}"">Faq</a></li>
                                    <li><a href="{{route('page', ['page' => 'contact-us.html'])}}">Contacts</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 d-none">
                            <div class="footer-widget footer-menu">
                                <h5 class="footer-title">Useful Links</h5>
                                <ul>
                                    <li><a href="javascript:void(0);">Our values</a></li>
                                    <li><a href="javascript:void(0);">Our advisory board</a></li>
                                    <li><a href="javascript:void(0);">Our partners</a></li>
                                    <li><a href="javascript:void(0);">Become a partner</a></li>
                                    <li><a href="javascript:void(0);">Work at Future Learn</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 d-none">
                    <div class="footer-widget footer-contact">
                        <h5 class="footer-title">Subscribe Newsletter</h5>
                        <div class="footer-newsletter">
                            <p>Sign up to get updates & news.</p>
                            <form action="javascript:void(0);">
                                <div class="subscribe-form">
											<span>
												<i class="isax isax-message-text"></i>
											</span>
                                    <input type="email" class="form-control" placeholder="Email Address">
                                </div>
                                <button type="submit" class="btn btn-secondary btn-xl w-100">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row row-gap-2">
                <div class="col-lg-5">
                    <div class="text-center text-lg-start">
                        <p>Copyright {{date('Y')}} © <span class="text-secondary">Jockey Club Bright Start Project</span>. All
                            right reserved.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul class="d-flex align-items-center justify-content-center footer-link">
                        <li><a href="{{route('page', ['page' => 'terms-and-conditions.html'])}}">Terms & Conditions</a></li>
                        <li><a href="{{route('page', ['page' => 'privacy-policy.html'])}}">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <div class="social-icon">
                        <a href="javascript:void(0);"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="javascript:void(0);"><i class="fa-brands fa-instagram"></i></a>
                        <a href="javascript:void(0);"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="javascript:void(0);"><i class="fa-brands fa-youtube"></i></a>
                        <a href="javascript:void(0);"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
