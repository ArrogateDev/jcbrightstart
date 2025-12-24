@props([
    'user' => null
])
<div class="header-topbar text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="dropdown flag-dropdown mb-2 me-3 d-none">
                        <a href="javascript:void(0);" class="dropdown-toggle d-inline-flex align-items-center"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{web_resource_url('assets/admin/img/flags/us-flag.svg')}}" class="me-2" alt="flag">ENG
                        </a>
                        <ul class="dropdown-menu p-2 mt-2" style="">
                            <li>
                                <a class="dropdown-item rounded d-flex align-items-center"
                                   href="javascript:void(0);">
                                    <img src="{{web_resource_url('assets/admin/img/flags/us-flag.svg')}}" class="me-2" alt="flag">ENG
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded d-flex align-items-center"
                                   href="javascript:void(0);">
                                    <img src="{{web_resource_url('assets/admin/img/flags/arab-flag.svg')}}" class="me-2" alt="flag">ARA
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded d-flex align-items-center"
                                   href="javascript:void(0);">
                                    <img src="{{web_resource_url('assets/admin/img/flags/france-flag.svg')}}" class="me-2" alt="flag">FRE
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
                            <a href="https://www.facebook.com/JCBrightStartProject"><i class="fa-brands fa-facebook-f"></i></a>
                        </li>
                        <li class="me-2">
                            <a href="https://www.instagram.com/JCBrightStartProject/"><i class="fa-brands fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

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
                <div class="navbar-logo py-2">
                    <a class="logo-white header-logo" href="{{route('index.html')}}">
                        <img src="{{web_resource_url('assets/admin/img/logo.png')}}" class="logo logo-max-h-50" alt="Logo">
                    </a>
                    <a class="logo-dark header-logo" href="{{route('index.html')}}">
                        <img src="{{web_resource_url('assets/admin/img/logo-black.png')}}" class="logo logo-max-h-50" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <a href="{{route('index.html')}}" class="menu-logo">
                        <img src="{{web_resource_url('assets/admin/img/logo.png')}}" class="img-fluid logo-max-h-50" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="javascript:void(0);">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <ul class="main-nav d-md-none">
                    <li class="has-submenu megamenu">
                        <a href="#">Main Menu <i class="isax isax-add"></i></a>
                        <ul class="submenu mega-submenu">
                            <li>
                                <a href="{{route('user.dashboard.html')}}">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{route('user.profile.html')}}">
                                    My Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{route('user.course.html')}}">
                                    My Courses
                                </a>
                            </li>
                            <li>
                                <a href="{{route('user.certificate.html')}}">
                                    My Certificates
                                </a>
                            </li>
                            <li>
                                <a href="{{route('user.quiz.html')}}">
                                    My Quiz
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu megamenu">
                        <a href="#">Account Settings <i class="isax isax-add"></i></a>
                        <ul class="submenu mega-submenu">
                            <li>
                                <a href="{{route('user.settings.html')}}">
                                    Settings
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="logout">
                                    Logout
                                </a>
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
                @auth
                    <div class="dropdown profile-dropdown">
                        <a href="javascript:void(0);" class="d-flex align-items-center" data-bs-toggle="dropdown">
								<span class="avatar">
									<img src="{{$user->avatar}}" alt="Img" class="img-fluid rounded-circle">
								</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="profile-header d-flex align-items-center">
                                <div class="avatar">
                                    <img src="{{$user->avatar}}" alt="Img"
                                         class="img-fluid rounded-circle">
                                </div>
                                <div>
                                    <h6>{{$user->full_name}}</h6>
                                    <p>
                                        <a href="#" class="__cf_email__">{{$user->email}}</a>
                                    </p>
                                </div>
                            </div>
                            <ul class="profile-body">
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium" href="{{route('user.profile.html')}}">
                                        <i class="fa-solid fa-user me-2"></i>
                                        My Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium" href="{{route('user.course.html')}}">
                                        <i class="isax isax-teacher5 me-2"></i>
                                        My Courses
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium" href="{{route('user.certificate.html')}}">
                                        <i class="isax isax-note-215 me-2"></i>
                                        My Certificates
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium" href="{{route('user.quiz.html')}}">
                                        <i class="isax isax-medal-star5 me-2"></i>
                                        My Quiz
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium" href="{{route('user.settings.html')}}">
                                        <i class="isax isax-setting-25 me-2"></i>
                                        Settings
                                    </a>
                                </li>
                            </ul>
                            <div class="profile-footer">
                                <a href="#"
                                   class="btn btn-secondary d-inline-flex align-items-center justify-content-center w-100 logout">
                                    <i class="isax isax-logout me-2"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>
