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
                    <img src="{{web_resource_url('assets/img/login-page.png')}}" class="img-fluid" alt="Logo">
                </div>
            </div>

            <div class="col-lg-6 login-wrap-bg">
                <div class="login-wrapper">
                    <div class="container loginbox">
                        <div class="w-100">
                            <div class="d-flex align-items-center justify-content-between login-header">
                                <img src="{{web_resource_url('assets/admin/img/logo.png')}}" class="img-fluid logo-max-200" alt="Logo">
                                <a href="{{route('index.html')}}" class="link-1">Back to Home</a>
                            </div>
                            <h4 class="mt-3 mb-5">Welcome to <br><span class="text-secondary">Jockey Club Bright Start Project</span></h4>
                            <h1 class="fs-32 fw-bold topic">Sign into Your Account</h1>
                            <form id="form" class="mb-3 pb-3" novalidate="novalidate">
                                <div class="mb-3 position-relative">
                                    <label class="form-label">
                                        Email
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
                                        Password
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
                                            Remember Me
                                        </label>
                                    </div>
                                    <div class="">
                                        <a href="{{route('forgot-password.html')}}" class="link-2">
                                            Forgot Password ?
                                        </a>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-lg" type="submit">Login <i
                                            class="isax isax-arrow-right-3 ms-1"></i></button>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>

                            <div class="d-flex align-items-center justify-content-center or fs-14 mb-3">
                                Or
                            </div>

                            <div class="row mb-1">
                                <div class="col-12 col-md-6 mb-2 mb-md-0">
                                    <x-web.auth.google-quick-login type="signin"/>
                                </div>
                                <div class="col-12 col-md-6">
                                    <x-web.auth.apple-quick-login type="signin"/>
                                </div>
                            </div>

                            <div class="fs-14 fw-normal d-flex align-items-center justify-content-center">
                                Don't you have an account?<a href="{{route('register.html')}}" class="link-2 ms-1"> Sign up</a>
                            </div>
                        </div>
                    </div>

                    <div class="container organization">
                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-4 mb-md-2 organization-item">
                                <div class="mb-1">
                                    <h5 class="section-heading__title">{{__('Organised by 主办机构')}}</h5>
                                </div>
                                <div class="w-100 d-flex">
                                    <img src="{{web_resource_url('assets/img/organization/organization-01.png')}}" class="logo" alt="">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2 organization-item">
                                <div class="mb-1">
                                    <h5 class="section-heading__title">{{__('Funded by 捐助机构')}}</h5>
                                </div>
                                <div class="w-100 d-flex">
                                    <img src="{{web_resource_url('assets/img/organization/organization-02.png')}}" class="logo" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="text-center p-3" style="color: #666;">
                            <p class="fw-normal p-0 m-0" style="font-size: 14px;">{{__('版权所有', ['date'=>date('Y')])}}</p>
                            <p class="fw-normal p-0 m-0" style="font-size: 12px;">Powered by Arrogate Maker Limited.</p>
                        </div>
                    </div>
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
