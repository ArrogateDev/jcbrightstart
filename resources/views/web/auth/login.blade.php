<!DOCTYPE html>
<html lang="en">

<x-web.auth.head/>

<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{web_resource_url('assets/js/md5.js') }}"></script>
<body>

<div class="main-wrapper">
    <div class="login-content">
        <div class="row">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="login-banner vh-100">
                    <img src="{{web_resource_url('assets/img/login-bg.jpg')}}" class="img-fluid" alt="Logo">
                </div>
            </div>

            <div class="col-lg-6 login-wrap-bg">
                <div class="login-wrapper">
                    <div class="container loginbox p-0">
                        <div class="w-100">
                            <div class="d-flex align-items-center justify-content-between login-header mb-3">
                                <a href="{{route('index.html')}}">
                                    <img src="{{web_resource_url('assets/admin/img/logo.png')}}" class="img-fluid logo-max-160" alt="Logo">
                                </a>
                                <h1 class="fs-32 fw-bold">{{__('登录')}}</h1>
                            </div>
                            <form id="form" class="mb-3 pb-3" novalidate="novalidate" style="padding: 0 55px;">
                                <div class="mb-3 position-relative">
                                    <label class="form-label">
                                        {{__('电子邮件')}}
                                        <span class="text-danger ms-1">*</span>
                                        <span id="error-container-email"></span>
                                    </label>
                                    <div class="position-relative">
                                        <input id="email" type="email" name="email" class="form-control form-control-lg">
                                        <span><i class="isax isax-sms input-icon text-gray-7 fs-14"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label class="form-label">
                                        {{__('密码')}}
                                        <span class="text-danger">*</span>
                                        <span id="error-container-password"></span>
                                    </label>
                                    <div class="position-relative" id="passwordInput">
                                        <input id="password" type="password" name="password" class="pass-inputs form-control form-control-lg">
                                        <span class="isax toggle-passwords isax-eye-slash fs-14"></span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="remember-me d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" name="remember_me" id="remember-me">
                                        <label class="form-check-label ms-2" for="remember-me">
                                            {{__('记住密码')}}
                                        </label>
                                    </div>
                                    <div class="">
                                        <a href="{{route('forgot-password.html')}}" class="link-2">
                                            {{__('忘记密码？')}}
                                        </a>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-lg" type="submit">{{__('登录')}} <i
                                                class="isax isax-arrow-right-3 ms-1"></i></button>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>

                            <div class="d-flex align-items-center justify-content-center or fs-14 mb-3">
                                {{__('或')}}
                            </div>

                            <div class="row m-0 mb-1">
                                <div class="col-12 col-md-6 mb-2 mb-md-0">
                                    <x-web.auth.google-quick-login type="signin"/>
                                </div>
                                <div class="col-12 col-md-6">
                                    <x-web.auth.apple-quick-login type="signin"/>
                                </div>
                            </div>

                            <div class="fs-14 fw-normal d-flex align-items-center justify-content-center">
                                {{__('你没有账户吗？')}}<a href="{{route('register.html')}}" class="link-2 ms-1"> {{__('注册')}}</a>
                            </div>
                        </div>
                    </div>

                    <x-auth-organization/>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const validator = new window.JustValidate('#form', {
        errorLabelCssClass: 'd-inline',
    });
    validator
        .addField('#email', [
            {
                rule: 'required',
            },
            {
                rule: 'email',
            },
        ], {
            errorsContainer: '#error-container-email'
        })
        .addField('#password', [
            {
                rule: 'required',
            },
            {
                rule: 'password',
            },
            {
                rule: 'minLength',
                value: 8,
            },
            {
                rule: 'strongPassword',
            }
        ], {
            errorsContainer: '#error-container-password'
        })
        .onSuccess(() => {
            handleLogin();
        });

    function handleLogin() {
        showLoading()

        let form = $('#form').serializeArray()
        form = form.map(item => {
            if (item.name === 'password') {
                item.value = md5(md5(item.value))
            }
            return item
        })

        $.ajax({
            type: "post",
            data: form,
            dataType: "json",
            success: function (data) {
                if (data.code !== 0) {
                    showToast('error', data.msg);
                    return;
                }

                showToast('success', 'Login successful');
                setTimeout(function () {
                    let redirect = data.data.redirect;
                    window.location.href = redirect.length > 0 ? redirect : '{{route('user.dashboard.html')}}';
                }, 800)
            }, error: function () {
                showToast('error', 'Login failed, please try again later')
            }, complete: function () {
                hideLoading()
            }
        });
    }
</script>
</body>

</html>
