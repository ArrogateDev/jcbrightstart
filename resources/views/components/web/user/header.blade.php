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
<div class="header-topbar text-center bg-transparent">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-end">
                    <ul class="social-icon d-flex align-items-center mb-2">
                        <li style="padding: 0 9px;">
                            <a class="ic-fb" href="https://www.facebook.com/JCBrightStartProject">
                                <i class="zmdi zmdi-facebook-box" style="color: #00c8d4;font-size: 26px;"></i>
                            </a>
                        </li>
                        <li style="padding: 0 9px;">
                            <a class="ic-insta" href="https://www.instagram.com/JCBrightStartProject/">
                                <i class="zmdi zmdi-instagram" style="color: #00c8d4;font-size: 26px;"></i>
                            </a>
                        </li>
                        <li class="seprator" style="padding: 0 9px;">
                            <span></span>
                        </li>
                        <li style="padding: 0 9px;">
                            <a href="#" data-toggle="modal" data-target="#modal-search">
                                <i class="fas fa-search" style="color: #00c8d4;font-size: 26px;"></i>
                            </a>
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
            <div class="navbar-header" style="padding: 4px 0;">
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
                <div class="dropdown flag-dropdown">
                    <a style="color:#666;font-size: 15px;" href="javascript:void(0);" class="dropdown-toggle d-inline-flex align-items-center me-3 d-none" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="fas fa-globe me-1"></i>{{ $currentLang }}
                    </a>
                    <ul class="dropdown-menu p-2 mt-2 d-none" style="">
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
                                            <span class="me-1">{{$menu['icon']}}</span>
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
@if(($user->is_private_email ?? null) === 0 || ($user->is_first_login ?? null) === 0)

    <div class="modal fade" id="info-modal" tabindex="-1" aria-labelledby="info-form"
         aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="fw-bold">{{ __('确认信息')}}</h5>
                </div>

                <form id="info-form" novalidate="novalidate">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="first_name">
                                {{__('姓')}}
                                <span class="text-danger"> *</span>
                                <span id="error-container-first-name"></span>
                            </label>
                            <input type="text" id="first-name" name="first_name" class="form-control" placeholder="{{__('请输入姓')}}" value="{{$user->first_name}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="last-name">
                                {{__('名')}}
                                <span class="text-danger"> *</span>
                                <span id="error-container-last-name"></span>
                            </label>
                            <input type="text" id="last-name" name="last_name" class="form-control" placeholder="{{__('请输入名')}}" value="{{$user->last_name}}">
                        </div>
                        @if($user->is_private_email === 0)
                            <div class="mb-3">
                                <label class="form-label" for="email">
                                    {{__('邮箱')}}
                                    <span class="text-danger"> * {{__('请输入正确的邮箱，填写后无法修改！')}}</span>
                                    <span id="error-container-email"></span>
                                </label>
                                <input type="text" id="email" name="email" class="form-control" placeholder="{{__('请输入邮箱')}}" value="{{$user->email}}">
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary rounded-pill submit" type="submit">{{__('提交')}}</button>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script src="{{web_resource_url('assets/js/validation.js')}}" type="text/javascript"></script>
    <script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
    <script>
        $(function () {
            let $modal = $('#info-modal');

            $modal.modal('show')
            const validator = new window.JustValidate('#info-form', {
                errorLabelCssClass: 'd-inline',
            });
            validator
                .addField('#first-name', [
                    {
                        rule: 'required',
                        errorMessage: '{{__('请输入姓')}}'
                    }
                ], {
                    errorsContainer: '#error-container-first-name'
                })
                .addField('#last-name', [
                    {
                        rule: 'required',
                        errorMessage: '{{__('请输入名')}}'
                    }
                ], {
                    errorsContainer: '#error-container-last-name'
                })
                @if($user->is_private_email === 0)
                .addField('#email', [
                    {
                        rule: 'required',
                        errorMessage: '{{__('请输入邮箱')}}'
                    }
                ], {
                    errorsContainer: '#error-container-email'
                })
                @endif
                .onSuccess(() => {
                    handleSubmit();
                });

            function handleSubmit() {
                showLoading()

                let form = $('#info-form').serializeArray()

                $.ajax({
                    url: '{{route('user.info.confirm.html')}}',
                    type: 'POST',
                    data: form,
                    dataType: "json",
                    success: function (data) {
                        if (data.code !== 0) {
                            showToast('error', data.msg);
                            return;
                        }

                        showToast('success', '{{__('更新成功')}}');
                        $modal.modal('hide');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }, error: function () {
                        showToast('error', '{{__('操作失败，请稍后再试！')}}')
                    }, complete: function () {
                        hideLoading()
                    }
                });
            }
        });
    </script>

@endif
