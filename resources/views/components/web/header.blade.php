@php
    $currentLocale = app()->getLocale();
    $locales = [
        'en' => 'EN',
        'zh_CN' => '简体',
        'zh_HK' => '繁體'
    ];
    $currentLang = $locales[$currentLocale] ?? '繁體';
@endphp
<header id="header">
    <section class="top-contact">
        <div class="container">
            <div class="top-contact-inner justify-content-end">
                <div class="top-contact__right">
                    <ul class="list-unstyled list-inline list-social">
                        <li class="list-inline-item">
                            <a class="ic-fb" href="https://www.facebook.com/JCBrightStartProject">
                                <i class="zmdi zmdi-facebook-box" style="color: #00c8d4;"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="ic-insta" href="https://www.instagram.com/JCBrightStartProject/">
                                <i class="zmdi zmdi-instagram" style="color: #00c8d4;"></i>
                            </a>
                        </li>
                        <li class="list-inline-item seprator">
                            <span></span>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" data-toggle="modal" data-target="#modal-search">
                                <i class="fas fa-search" style="color: #00c8d4;"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="header header-1 d-none d-lg-block js-header-1">
        <div class="header__bar">
            <div class="container">
                <div class="header__content">
                    <div class="logo py-2">
                        <a href="{{route('index.html')}}">
                            <img src="{{web_resource_url('assets/web/images/logo.png')}}" alt="Jockey Club Bright Start Project" style="height: 65px;">
                        </a>
                    </div>
                    @if(!empty($navs))
                        <nav class="header-navbar">
                            <ul class="list-unstyled">
                                @foreach($navs as $nav)
                                    <li @class(['header-navbar__item', 'has-sub' => !empty($nav['children']),'active' =>!empty( $nav['active'])])>
                                        <a href="{{$nav['url']}}">
                                            <span class="bg-link">{{$nav['title']}}</span>
                                        </a>
                                        @if(!empty($nav['children']))
                                            <ul class="list-unstyled header-navbar-child first">
                                                @foreach($nav['children'] as $child)
                                                    <li @class(['has-sub' => !empty($child['children'])])>
                                                        <a href="{{$child['url']}}">{{$child['title']}}</a>
                                                        @if(!empty($child['children']))
                                                            <ul class="list-unstyled header-navbar-child second">
                                                                @foreach($child['children'] as $item)
                                                                    <li>
                                                                        <a href="{{$item['url']}}" target="{{$item['target']??'_self'}}">{{$item['title']}}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    @endif
                    <div class="header-btn d-flex align-items-center">
                        <div class="dropdown mr-3 position-relative d-inline-block" id="language-box">
                            <a href="#" class="dropdown-toggle" id="language-dropdown" data-toggle="dropdown" aria-expanded="false" role="button">
                                <i class="fas fa-globe mr-1"></i>{{ $currentLang }}
                            </a>
                            <ul class="dropdown-menu p-2 mt-2" id="language-menu">
                                @foreach($locales as $locale => $label)
                                    <li>
                                        <a class="dropdown-item rounded {{ $currentLocale === $locale ? 'active' : '' }}"
                                           href="{{ route('language.switch', ['locale' => $locale]) }}">
                                            {{ $label }}
                                            @if($currentLocale === $locale)
                                                <i class="fas fa-check ml-2"></i>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @auth
                            <div class="dropdown profile-dropdown">
                                <a href="#" class="d-flex align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
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
                                                <a href="#" class="__cf_email__" style="color: #191919;">{{$user->email}}</a>
                                            </p>
                                        </div>
                                    </div>
                                    <ul class="profile-body">
                                        @foreach($avatar_menus as $menu)
                                            <li>
                                                <a class="dropdown-item d-inline-flex align-items-center rounded" href="{{$menu['url']??'javascript:void(0);'}}">
                                                    <i class="{{$menu['icon']}} mr-2"></i>
                                                    {{$menu['title']}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="profile-footer">
                                        <a href="#"
                                           class="btn btn-secondary d-inline-flex align-items-center justify-content-center w-100 logout">
                                            <i class="isax isax-logout mr-2"></i>Logout</a>
                                    </div>
                                </div>
                            </div>

                            <x-sweetalert/>

                            <script>
                                $(function () {
                                    $('.logout').click(function () {
                                        confirm_alert('{{__('确定退出吗')}}', '{{__('你将无法撤销这一操作！')}}', '{{__('确定')}}')
                                            .then((result) => {
                                                if (result.isConfirmed) {
                                                    showLoading()
                                                    $.ajax({
                                                        url: "{{ route('user.logout.html') }}",
                                                        type: 'DELETE',
                                                        data: {
                                                            _token: "{{ csrf_token() }}"
                                                        },
                                                        success: function (response) {
                                                            if (response.code !== 0) {
                                                                showToast('error', response.msg);
                                                                return;
                                                            }

                                                            showToast('success', 'Successful');
                                                            setTimeout(function () {
                                                                window.location.href = '{{route('home')}}';
                                                            }, 800)
                                                        },
                                                        error: function () {
                                                            showToast('error', 'Login failed, please try again later')
                                                        },
                                                        complete: function () {
                                                            hideLoading()
                                                        }
                                                    });
                                                }
                                            })
                                    })
                                })
                            </script>
                        @else
                            <a href="{{route('login.html')}}" class="au-btn-3 au-btn2--blue d-inline-flex align-items-center mr-2" style="line-height: 32px;">
                                {{__('家长登入')}}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-search" role="dialog">
        <button class="close" type="button" data-dismiss="modal">
            <i class="zmdi zmdi-close"></i>
        </button>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form--icon" method="POST">
                        <input type="text" name="search" placeholder="Search here...">
                        <button class="btn-submit-1" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="header-mobile js-header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid clearfix">
                <a class="logo" href="{{route('index.html')}}">
                    <img src="{{web_resource_url('assets/web/images/logo.png')}}" alt="Jooby" style="height: 55px;">
                </a>
                <button class="hamburger hamburger--slider float-right" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                </button>
            </div>
        </div>
        @if(!empty($navs))
            <nav class="navbar-mobile">
                <ul class="navbar-mobile__list list-unstyled">
                    <li class="language-selector-mobile">
                        <a href="javascript:void(0);" class="bg-link">
                            <i class="fas fa-globe mr-2"></i>{{ $currentLang }}
                        </a>
                        <ul class="navbar-mobile__child list-unstyled first">
                            @foreach($locales as $locale => $label)
                                <li>
                                    <a href="{{ route('language.switch', ['locale' => $locale]) }}"
                                       class="{{ $currentLocale === $locale ? 'active' : '' }}">
                                        {{ $label }}
                                        @if($currentLocale === $locale)
                                            <i class="fas fa-check ml-2"></i>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @foreach($navs as $nav)
                        <li @class(['has-sub' => !empty($nav['children'])])>
                            <a href="{{$nav['url']}}">
                                <span class="bg-link">{{$nav['title']}}</span>
                            </a>
                            @if(!empty($nav['children']))
                                <ul class="navbar-mobile__child list-unstyled first">
                                    @foreach($nav['children'] as $child)
                                        <li @class(['has-sub' => !empty($child['children'])])>
                                            <a href="{{$child['url']}}">{{$child['title']}}</a>
                                            @if(!empty($child['children']))
                                                <ul class="navbar-mobile__child list-unstyled second">
                                                    @foreach($child['children'] as $item)
                                                        <li>
                                                            <a href="{{$item['url']}}">{{$item['title']}}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif
    </div>
</header>
