@php
    $currentLocale = app()->getLocale();
    $locales = [
        'en' => 'EN',
        'zh_CN' => '简体',
        'zh_HK' => '繁體'
    ];
    $currentLang = $locales[$currentLocale] ?? '繁體';
@endphp
@props([
    'user' => null
])
<div class="header-topbar text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="dropdown flag-dropdown mb-2 me-3">
                        <a href="javascript:void(0);" class="dropdown-toggle d-inline-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe me-2"></i>{{ $currentLang }}
                        </a>
                        <ul class="dropdown-menu p-2 mt-2" style="">
                            @foreach($locales as $locale => $label)
                                <li>
                                    <a class="dropdown-item rounded d-flex align-items-center" href="{{ route('language.switch', ['locale' => $locale]) }}">
                                        {{ $label }}
                                        @if($currentLocale === $locale)
                                            <i class="fas fa-check ms-2"></i>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
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
                    @foreach($user_menus as $menu)
                        <li class="has-submenu megamenu">
                            <a href="#">{{$menu['title']}} <i class="isax isax-add"></i></a>
                            <ul class="submenu mega-submenu">
                                @foreach($menu['children'] as $item)
                                    <li>
                                        <a href="{{$item['url']??'javascript:void(0);'}}" class="{{$item['class']??''}}">
                                            {{$item['title']}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
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
                                @foreach($avatar_menus as $menu)
                                    <li>
                                        <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium" href="{{$menu['url']??'javascript:void(0);'}}">
                                            <i class="{{$menu['icon']}} me-2"></i>
                                            {{$menu['title']}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="profile-footer">
                                <a href="#"
                                   class="btn btn-secondary d-inline-flex align-items-center justify-content-center w-100 logout">
                                    <i class="isax isax-logout me-2"></i>{{__('退出登录')}}</a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>
