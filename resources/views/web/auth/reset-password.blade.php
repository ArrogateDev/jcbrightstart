<!DOCTYPE html>
<html lang="en">

<x-web.auth.head/>
<script src="{{web_resource_url('assets/admin/js/validation.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/admin/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/admin/plugins/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/wait-me/waitMe.min.css')}}">
<link href="{{web_resource_url('assets/admin/plugins/toastr/toastr.min.css')}}" rel="stylesheet"/>
<script src="{{web_resource_url('assets/admin/plugins/toastr/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/admin/js/utils.js') }}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/admin/js/md5.js') }}"></script>

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
                                    <img src="{{web_resource_url('assets/img/LoginPage.png')}}" class="img-fluid" alt="Logo">
                                </div>
                                <div class="mentor-course text-center">
                                    <h3 class="mb-2">Welcome to <br><span class="text-secondary">Jockey Club Bright Start Project</span>.</h3>
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
                                <img src="{{web_resource_url('assets/admin/img/logo.png')}}" class="img-fluid" alt="Logo">
                                <a href="{{route('index.html')}}" class="link-1">Back to Home</a>
                            </div>
                            <div class="topic">
                                <h1 class="fs-32 fw-bold mb-3">Forgot Password</h1>
                                <p class="fs-14 fw-normal mb-0">Enter your email to reset your password.</p>
                            </div>
                            <form id="form" class="mb-3 pb-3" novalidate="novalidate">
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
                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-lg" type="submit">Reset Password<i
                                            class="isax isax-arrow-right-3 ms-1"></i></button>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>
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
                }
            }
        ], {
            errorsContainer: '#error-container-password-confirmation'
        })
        .onSuccess(() => {
            handleRestPassword();
        });

    function handleRestPassword() {
        showLoading()

        let form = $('#form').serializeArray()

        $.ajax({
            type: "post",
            data: form,
            dataType: "json",
            success: function (data) {
                if (data.code !== 0) {
                    showToast('error', data.msg);
                    return;
                }
                showToast('success', 'Reset successful!');

                setTimeout(function () {
                    window.location.href = '{{route('login.html')}}';
                }, 800)
            }, error: function () {
                showToast('error', 'Failed, please try again later')
            }, complete: function () {
                hideLoading()
            }
        });
    }
</script>
</body>

</html>
