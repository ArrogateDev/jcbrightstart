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
                <div class="login-wrapper flex-md-column justify-content-between">
                    <div class="container loginbox mt-md-5">
                        <div class="w-100">
                            <div class="d-flex align-items-center justify-content-between login-header">
                                <a href="{{route('home')}}">
                                    <img src="{{web_resource_url('assets/admin/img/logo.png')}}" class="img-fluid logo-max-160" alt="Logo">
                                </a>
                            </div>
                            <h4 class="mt-4 mb-3">{{__('赛马会')}}<span>{{__('幼儿“喜步”计划')}}</span></h4>
                            <h1 class="fs-32 fw-bold topic px-md-5">{{__('重设密码')}}</h1>
                            <form id="form" class="mb-3 pb-3 px-md-5" novalidate="novalidate">
                                <div class="mb-3 position-relative">
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
                                <div class="mb-3 position-relative">
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
                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-lg" type="submit">{{__('重设密码')}}<i
                                            class="isax isax-arrow-right-3 ms-1"></i></button>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>
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
