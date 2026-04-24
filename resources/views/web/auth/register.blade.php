<!DOCTYPE html>
<html lang="en">

<x-web.auth.head/>
<script type="text/javascript" src="{{web_resource_url('assets/js/lodash.js') }}"></script>
<script src="{{web_resource_url('assets/js/validation.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{web_resource_url('assets/js/wait-me/waitMe.min.css')}}">
<link href="{{web_resource_url('assets/js/toastr/toastr.min.css')}}" rel="stylesheet"/>
<script src="{{web_resource_url('assets/js/toastr/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/js/utils.js') }}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/js/md5.js') }}"></script>
<style>
    .loading {
        position: relative;
        width: 30px;
        height: 30px;
        border: 2px solid #0003;
        border-left-color: #000;
        border-radius: 100%;
        animation: loading infinite 0.75s linear;
    }

    @keyframes loading {
        0% {
            transform: rotate(0);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
<body>

<div class="main-wrapper">
    <div class="login-content">
        <div class="row">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="login-banner vh-100 position-relative">
                    <img src="{{web_resource_url('assets/img/login-bg.jpg')}}" class="img-fluid" alt="Logo">
                    <div class="d-flex align-items-center justify-content-between login-header mb-3 position-absolute" style="top: 30px;right: 30px;width: 200px;">
                        <a href="{{route('index.html')}}">
                            <img src="{{web_resource_url('assets/admin/img/logo.png')}}" class="img-fluid logo-max-160" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 login-wrap-bg">
                <div class="login-wrapper">
                    <div class="container loginbox">
                        <div class="w-100">
                            <div class="d-flex d-lg-none align-items-center justify-content-between login-header mb-3">
                                <a href="{{route('index.html')}}">
                                    <img src="{{web_resource_url('assets/admin/img/logo.png')}}" class="img-fluid logo-max-160" alt="Logo">
                                </a>
                            </div>
                            <h4 class="mt-4 mb-3">{{__('赛马会')}}<span>{{__('幼儿“喜步”计划')}}</span></h4>
                            <h1 class="fs-32 fw-bold topic px-md-5">{{__('注册')}}</h1>
                            <form id="form" class="pb-3 px-md-5" novalidate="novalidate">
                                <div class="row m-0">
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="mb-2 position-relative pe-md-1">
                                            <label class="form-label">
                                                {{__('名字')}}
                                                <span class="text-danger ms-1">*</span>
                                                <span id="error-container-first-name"></span>
                                            </label>
                                            <div class="position-relative">
                                                <input id="first_name" type="text" name="first_name" class="form-control form-control-lg">
                                                <span><i class="isax isax-user input-icon text-gray-7 fs-14"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="mb-2 position-relative ps-md-1">
                                            <label class="form-label">
                                                {{__('姓氏')}}
                                                <span class="text-danger ms-1">*</span>
                                                <span id="error-container-last-name"></span>
                                            </label>
                                            <div class="position-relative">
                                                <input id="last_name" type="text" name="last_name" class="form-control form-control-lg">
                                                <span><i class="isax isax-user input-icon text-gray-7 fs-14"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-0">
                                    <div class="col-12 col-md-8 p-0">
                                        <div class="mb-2 position-relative pe-md-1">
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
                                    </div>
                                    <div class="col-12 col-md-4 p-0">
                                        <div class="mb-2 position-relative ps-md-1">
                                            <label class="form-label">
                                                {{__('验证码')}}
                                                <span class="text-danger ms-1">*</span>
                                                <span id="error-container-code"></span>
                                            </label>
                                            <div class="input-group mb-2">
                                                <input id="code" type="text" name="code" class="form-control form-control-lg">
                                                <button type="button" class="btn border" id="get-code"
                                                        style="border-radius: 0 var(--bs-border-radius-lg) var(--bs-border-radius-lg) 0;">{{__('获取')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 position-relative">
                                    <label class="form-label">
                                        {{__('新密码')}}
                                        <span class="text-danger">*</span>
                                        <span id="error-container-password"></span>
                                    </label>
                                    <div class="position-relative" id="passwordInput">
                                        <input id="password" type="password" name="password" class="pass-inputs form-control form-control-lg">
                                        <span class="isax toggle-passwords isax-eye-slash text-gray-7 fs-14"></span>
                                    </div>
                                    <div class="password-strength" id="passwordStrength">
                                        <span id="poor"></span>
                                        <span id="weak"></span>
                                        <span id="strong"></span>
                                        <span id="heavy"></span>
                                    </div>
                                    <div class="mt-2" id="passwordInfo"></div>
                                </div>
                                <div class="mb-2 position-relative">
                                    <label class="form-label">
                                        {{__('确认密码')}}
                                        <span class="text-danger">*</span>
                                        <span id="error-container-password-confirmation"></span>
                                    </label>
                                    <div class="position-relative">
                                        <input id="password-confirmation" type="password" name="password_confirmation" class="pass-inputa form-control form-control-lg">
                                        <span class="isax toggle-passworda isax-eye-slash text-gray-7 fs-14"></span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="remember-me d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="agree" name="agree">
                                        <label class="form-check-label mb-0 d-inline remember-me fs-14" for="agree">
                                            {!! __('同意隐私政策', ['terms_of_service'=>route('page',['page'=>'terms-and-conditions.html']), 'privacy_policy'=>route('page',['page'=>'privacy-policy.html'])]) !!}
                                        </label>
                                    </div>
                                    <div class="form-label" id="error-container-agree" style="height: 21px;"></div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-lg" type="submit">{{__('注册')}} <i
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
                                {{__('你已经有账户了吗？')}}<a href="{{route('login.html')}}" class="link-2 ms-1"> {{__('登录')}}</a>
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
        .addField('#first_name', [
            {
                rule: 'required',
                errorMessage: '{{__('请输入您的名字。')}}',
            }
        ], {
            errorsContainer: '#error-container-first-name'
        })
        .addField('#last_name', [
            {
                rule: 'required',
                errorMessage: '{{__('请输入您的姓氏。')}}'
            }
        ], {
            errorsContainer: '#error-container-last-name'
        })
        .addField('#email', [
            {
                rule: 'required',
                errorMessage: '{{__('请输入您的电子邮件。')}}'
            },
            {
                rule: 'email',
                errorMessage: '{{__('请输入正确的电子邮件地址。')}}'
            },
        ], {
            errorsContainer: '#error-container-email'
        })
        .addField('#code', [
            {
                rule: 'required',
                errorMessage: '{{__('请输入验证码。')}}'
            },
            {
                rule: 'number',
                errorMessage: '{{__('请输入验证码。')}}'
            },
        ], {
            errorsContainer: '#error-container-code'
        })
        .addField('#password', [
            {
                rule: 'required',
            },
            {
                rule: 'customRegexp',
                value: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.#?!@$%^&*-]).{8,}$/,
                errorMessage: '{{__('使用大小写字母、数字、符号组合且8个以上字符。')}}'
            }
        ], {
            errorsContainer: '#error-container-password'
        })
        .addField('#password-confirmation', [
            {
                rule: 'required',
            },
            {
                validator: (value, fields) => {
                    if (fields['#password'] && fields['#password'].elem) {
                        const password =
                            fields['#password'].elem.value;

                        return value === password;
                    }
                },
                errorMessage: '{{__('密码不匹配')}}',
            }
        ], {
            errorsContainer: '#error-container-password-confirmation'
        })
        .addField('#agree', [
            {
                rule: 'required',
                errorMessage: '{{__('请阅读并同意服务条款和隐私政策')}}',
            }
        ], {
            errorsContainer: '#error-container-agree'
        })
        .onSuccess(() => {
            handleRegister();
        });

    function handleRegister() {
        showLoading()

        let form = $('#form').serializeArray()
        form = form.map(item => {
            if (item.name === 'password' || item.name === 'password_confirmation') {
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

                showToast('success', 'Register successful');
                setTimeout(function () {
                    let redirect = data.data.redirect;
                    window.location.href = redirect.length > 0 ? redirect : '{{route('user.dashboard.html')}}';
                }, 800)
            }, error: function () {
                showToast('error', 'Register failed, please try again later')
            }, complete: function () {
                hideLoading()
            }
        });
    }

    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    $(function () {
        const $getCodeBtn = $('#get-code');
        const COUNTDOWN_SECONDS = 300;
        let countdownTimer = null;

        function resetButton() {
            if (countdownTimer) {
                clearInterval(countdownTimer);
                countdownTimer = null;
            }
            $getCodeBtn.prop('disabled', false).text('{{__('获取')}}');
        }

        function startCountdown() {
            let remaining = COUNTDOWN_SECONDS;
            $getCodeBtn.prop('disabled', true).text(`(${remaining}s)`);
            countdownTimer = setInterval(() => {
                remaining -= 1;
                if (remaining <= 0) {
                    resetButton();
                    return;
                }
                $getCodeBtn.text(`(${remaining}s)`);
            }, 1000);
        }

        $getCodeBtn.on('click', function () {
            if ($getCodeBtn.prop('disabled')) {
                return;
            }

            const email = $('#email').val().trim();
            if (!email) {
                showToast('error', 'Please enter your email.');
                return;
            }

            if (!validateEmail(email)) {
                showToast('error', 'Please enter the correct email address.');
                return;
            }

            const form = {
                email,
                scene: 'register',
                _token: '{{ csrf_token() }}'
            };

            $getCodeBtn.prop('disabled', true).html('<div class="loading"></div>');

            $.ajax({
                type: "post",
                url: '{{route('get-code')}}',
                data: form,
                dataType: "json",
                success: function (data) {
                    if (data.code !== 0) {
                        showToast('error', data.msg);
                        resetButton();
                        return;
                    }

                    showToast('success', 'Verification code sent successfully.');
                    startCountdown();
                }, error: function () {
                    showToast('error', 'Failed to send verification code.')
                    resetButton();
                }
            });
        });
    });
</script>
</body>

</html>
