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

<body>

<div class="main-wrapper">
    <div class="login-content">
        <div class="row">
            <div class="col-lg-6 login-bg d-none d-lg-flex">
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
                            <h1 class="fs-32 fw-bold topic">Sign up</h1>
                            <form id="form" class="mb-3 pb-3" novalidate="novalidate">
                                <div class="mb-3 position-relative">
                                    <label class="form-label">
                                        First Name
                                        <span class="text-danger ms-1">*</span>
                                        <span id="error-container-first-name"></span>
                                    </label>
                                    <div class="position-relative">
                                        <input id="first_name" type="text" name="first_name" class="form-control form-control-lg">
                                        <span><i class="isax isax-user input-icon text-gray-7 fs-14"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label class="form-label">
                                        Last Name
                                        <span class="text-danger ms-1">*</span>
                                        <span id="error-container-last-name"></span>
                                    </label>
                                    <div class="position-relative">
                                        <input id="last_name" type="text" name="last_name" class="form-control form-control-lg">
                                        <span><i class="isax isax-user input-icon text-gray-7 fs-14"></i></span>
                                    </div>
                                </div>
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
                                        Verify Code
                                        <span class="text-danger ms-1">*</span>
                                        <span id="error-container-code"></span>
                                    </label>
                                    <div class="input-group mb-3">
                                        <input id="code" type="text" name="code" class="form-control form-control-lg">
                                        <button type="button" class="btn border" id="get-code">Get</button>
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label class="form-label">
                                        New Password
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
                                <div class="mb-3 position-relative">
                                    <label class="form-label">
                                        Confirm Password
                                        <span class="text-danger">*</span>
                                        <span id="error-container-password-confirmation"></span>
                                    </label>
                                    <div class="position-relative">
                                        <input id="password-confirmation" type="password" name="password_confirmation" class="pass-inputa form-control form-control-lg">
                                        <span class="isax toggle-passworda isax-eye-slash text-gray-7 fs-14"></span>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="remember-me d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="agree" name="agree">
                                        <label class="form-check-label mb-0 d-inline remember-me fs-14" for="agree">
                                            I agree with
                                            <a href="javascript:void(0);" class="link-2 mx-2">Terms of Service</a>
                                            and
                                            <a href="javascript:void(0);" class="link-2 mx-2">Privacy Policy</a>
                                        </label>
                                    </div>
                                    <div class="form-label" id="error-container-agree" style="height: 21px;"></div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-lg" type="submit">Sign Up <i
                                            class="isax isax-arrow-right-3 ms-1"></i></button>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>

                            <div class="d-flex align-items-center justify-content-center or fs-14 mb-3">
                                Or
                            </div>

                            <div class="row mb-1">
                                <div class="col-12 col-md-6 mb-2 mb-md-0">
                                    <x-web.auth.google-quick-login type="signup"/>
                                </div>
                                <div class="col-12 col-md-6">
                                    <x-web.auth.apple-quick-login type="signup"/>
                                </div>
                            </div>

                            <div class="fs-14 fw-normal d-flex align-items-center justify-content-center">
                                Already you have an account?<a href="{{route('login.html')}}" class="link-2 ms-1"> Login</a>
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
        .addField('#first_name', [
            {
                rule: 'required',
                errorMessage: 'Please enter your first name.',
            }
        ], {
            errorsContainer: '#error-container-first-name'
        })
        .addField('#last_name', [
            {
                rule: 'required',
                errorMessage: 'Please enter your last name.'
            }
        ], {
            errorsContainer: '#error-container-last-name'
        })
        .addField('#email', [
            {
                rule: 'required',
                errorMessage: 'Please enter your email.'
            },
            {
                rule: 'email',
                errorMessage: 'Please enter the correct email address.'
            },
        ], {
            errorsContainer: '#error-container-email'
        })
        .addField('#code', [
            {
                rule: 'required',
                errorMessage: 'Please enter Verify Code.'
            },
            {
                rule: 'number',
                errorMessage: 'Please enter Verify Code.'
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
                errorMessage: 'Use uppercase, lowercase, numbers, symbols and 8+ characters.'
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
                errorMessage: 'Password does not match',
            }
        ], {
            errorsContainer: '#error-container-password-confirmation'
        })
        .addField('#agree', [
            {
                rule: 'required',
                errorMessage: 'Please read and agree to the Terms of Service and Privacy Policy',
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
        const COUNTDOWN_SECONDS = 60;
        let countdownTimer = null;

        function resetButton() {
            if (countdownTimer) {
                clearInterval(countdownTimer);
                countdownTimer = null;
            }
            $getCodeBtn.prop('disabled', false).text('Get');
        }

        function startCountdown() {
            let remaining = COUNTDOWN_SECONDS;
            $getCodeBtn.prop('disabled', true).text(`Resend (${remaining}s)`);
            countdownTimer = setInterval(() => {
                remaining -= 1;
                if (remaining <= 0) {
                    resetButton();
                    return;
                }
                $getCodeBtn.text(`Resend (${remaining}s)`);
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

            $getCodeBtn.prop('disabled', true).text('Sending...');

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
