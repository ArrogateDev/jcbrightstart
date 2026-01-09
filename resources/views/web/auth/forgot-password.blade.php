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
                <div class="login-wrapper flex-md-column justify-content-between">
                    <div class="container loginbox mt-md-5">
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
