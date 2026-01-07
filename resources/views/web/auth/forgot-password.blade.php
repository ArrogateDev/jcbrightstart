<!DOCTYPE html>
<html lang="en">

<x-web.auth.head/>
<script src="{{web_resource_url('assets/js/validation.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{web_resource_url('assets/js/wait-me/waitMe.min.css')}}">
<link href="{{web_resource_url('assets/js/toastr/toastr.min.css')}}" rel="stylesheet"/>
<script src="{{web_resource_url('assets/js/toastr/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/js/utils.js') }}"></script>

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
                <!-- Login -->
                <div class="login-wrapper">
                    <div class="loginbox">
                        <div class="w-100">
                            <div class="d-flex align-items-center justify-content-between login-header">
                                <img src="{{web_resource_url('assets/admin/img/logo.png')}}" class="img-fluid logo-max-200" alt="Logo">
                                <a href="{{route('index.html')}}" class="link-1">Back to Home</a>
                            </div>
                            <div class="topic">
                                <h1 class="fs-32 fw-bold mb-3">Forgot Password</h1>
                                <p class="fs-14 fw-normal mb-0">Enter your email to reset your password.</p>
                            </div>
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
                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-lg" type="submit">Submit<i
                                            class="isax isax-arrow-right-3 ms-1"></i></button>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>

                            <p class="fs-14 fw-normal d-flex align-items-center justify-content-center">
                                Remember Password?<a href="{{route('login.html')}}" class="link-2 ms-1"> Sign In</a>
                            </p>

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
        .onSuccess(() => {
            handleForgotPassword();
        });

    function handleForgotPassword() {
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
                showToast('success', 'Password reset link has been sent to your email');

                setTimeout(function () {
                    window.location.href = data.data.redirect ?? '/';
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
