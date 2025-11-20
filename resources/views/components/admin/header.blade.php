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
                <div class="navbar-logo" style="padding: 15px 0;">
                    <a class="logo-white header-logo" href="{{route('index.html')}}">
                        <img src="{{web_resource_url('assets/img/logo.png')}}" class="logo" alt="Logo" style="height: 50px;">
                    </a>
                    <a class="logo-dark header-logo" href="{{route('index.html')}}">
                        <img src="{{web_resource_url('assets/img/logo-black.png')}}" class="logo" alt="Logo" style="height: 45px;">
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
                @if(isset($menus) && !empty($menus))
                    <ul class="main-nav d-md-none">
                        @foreach($menus as $menu)
                            <li class="has-submenu">
                                <a href="#">{{__($menu['name'])}} <i class="isax isax-add"></i></a>
                                <ul class="submenu">
                                    @foreach($menu['children'] as $item)
                                        <li>
                                            <a href="{{$item['url']}}">
                                                {{__($item['name'])}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if(isset($user) && !empty($user))
                    <div class="header-btn d-flex align-items-center">
                        <div class="dropdown profile-dropdown">
                            <a href="javascript:void(0);" class="d-flex align-items-center" data-bs-toggle="dropdown">
								<span class="avatar">
									<img src="{{$user->avatar}}" alt="Img" class="img-fluid rounded-circle avatar-img">
								</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="profile-header d-flex align-items-center">
                                    <div class="avatar">
                                        <img src="{{$user->avatar}}" alt="Img"
                                             class="img-fluid rounded-circle avatar-img">
                                    </div>
                                    <div>
                                        <h6>{{$user->name}}</h6>
                                        <p><a href="/cdn-cgi/l/email-protection"
                                              class="__cf_email__">{{$user->account}}</a>
                                        </p>
                                    </div>
                                </div>
                                <ul class="profile-body">
                                    <li>
                                        <a class="dropdown-item d-inline-flex align-items-center rounded fw-medium"
                                           href="{{route('admin.settings.html')}}">
                                            <i class="isax isax-setting-2 me-2"></i>{{__('设置')}}
                                        </a>
                                    </li>
                                </ul>
                                <div class="profile-footer">
                                    <a href="javascript:void(0);"
                                       class="btn btn-secondary d-inline-flex align-items-center justify-content-center w-100 logout">
                                        <i class="isax isax-logout me-2"></i>{{__('退出登录')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>
</header>
