<!DOCTYPE html>
<html lang="en">

<x-head/>
<script type="text/javascript" src="{{ web_resource_url('assets/js/lodash.js') }}"></script>
<script src="{{web_resource_url('assets/js/validation.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/plugins/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{web_resource_url('assets/plugins/wait-me/waitMe.min.css')}}">
<link href="{{web_resource_url('assets/plugins/toastr/toastr.min.css')}}" rel="stylesheet"/>
<script src="{{web_resource_url('assets/plugins/toastr/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{ web_resource_url('assets/js/utils.js') }}"></script>
<script type="text/javascript" src="{{ web_resource_url('assets/js/md5.js') }}"></script>

<body>

<div class="main-wrapper">
    <div class="login-content">
        <div class="row">
            <div class="col-lg-6 login-bg d-none d-lg-flex">
                <div class="login-carousel">
                    @for($i = 1; $i <= 3; $i++)
                        <div>
                            <div class="login-carousel-section mb-3">
                                <div class="login-banner">
                                    <img src="{{web_resource_url('assets/img/auth/auth-1.svg')}}" class="img-fluid" alt="Logo">
                                </div>
                                <div class="mentor-course text-center">
                                    <h3 class="mb-2">Welcome to <br>Dreams<span class="text-secondary">LMS</span>
                                        Courses.</h3>
                                    <p>Platform designed to help organizations, educators, and learners manage, deliver,
                                        and track learning and training activities.</p>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="col-lg-6 login-wrap-bg">
                <div class="login-wrapper">
                    <div class="loginbox">
                        <div class="w-100">
                            <div class="d-flex align-items-center justify-content-between login-header">
                                <img src="{{web_resource_url('assets/img/logo.png')}}" class="img-fluid" alt="Logo">
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
                                        <span id="error-container-confirm-password"></span>
                                    </label>
                                    <div class="position-relative">
                                        <input id="password_confirmation" type="password" name="password_confirmation" class="pass-inputa form-control form-control-lg">
                                        <span class="isax toggle-passworda isax-eye-slash text-gray-7 fs-14"></span>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="remember-me d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="agree" name="agree">
                                        <label class="form-check-label mb-0 d-inline-flex remember-me fs-14"
                                               for="agree">
                                            I agree with <a href="javascript:void(0);" class="link-2 mx-2">Terms of
                                                Service</a> and <a href="javascript:void(0);"
                                                                   class="link-2 mx-2">Privacy Policy
                                            </a>
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

                            <div class="d-flex align-items-center justify-content-center mb-3">

                                <x-auth.google-quick-login type="signup"/>

                                <x-auth.apple-quick-login type="signup"/>

                            </div>

                            <div class="fs-14 fw-normal d-flex align-items-center justify-content-center">
                                Already you have an account?<a href="{{route('login.html')}}" class="link-2 ms-1"> Login</a>
                            </div>
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
        .addField('#password', [
            {
                rule: 'required',
                errorMessage: 'Use upper & lower case letters, numbers, symbols and 8+ characters.'
            },
            {
                rule: 'password',
                errorMessage: 'Use upper & lower case letters, numbers, symbols and 8+ characters.'
            },
            {
                rule: 'minLength',
                value: 8,
                errorMessage: 'Use upper & lower case letters, numbers, symbols and 8+ characters.'
            },
            {
                rule: 'strongPassword',
                errorMessage: 'Use upper & lower case letters, numbers, symbols and 8+ characters.'
            }
        ], {
            errorsContainer: '#error-container-password'
        })
        .addField('#password_confirmation', [
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
            errorsContainer: '#error-container-confirm-password'
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
                    window.location.href = data.data.redirect ?? '{{route('user.dashboard.html')}}';
                }, 800)
            }, error: function () {
                showToast('error', 'Register failed, please try again later')
            }, complete: function () {
                hideLoading()
            }
        });
    }

</script>
</body>

</html>
