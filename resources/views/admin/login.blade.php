<!DOCTYPE html>
<html lang="en">

<x-admin.head/>

<!-- Slick CSS -->
<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/slick/slick.css')}}">
<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/slick/slick-theme.css')}}">
<!-- Slick Slider -->
<script src="{{web_resource_url('assets/admin/plugins/slick/slick.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
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
                    <div class="loginbox">
                        <div class="w-100">
                            <div class="d-flex align-items-center justify-content-between login-header">
                                <img src="{{web_resource_url('assets/admin/img/logo.png')}}" class="img-fluid logo-max-200" alt="Logo">
                            </div>
                            <h4 class="mt-3 mb-5">Welcome to <br><span class="text-secondary">Jockey Club Bright Start Project</span></h4>
                            <h1 class="fs-32 fw-bold topic">Management Portal</h1>
                            <form id="form" class="mb-3 pb-3" novalidate="novalidate">
                                <div class="mb-3 position-relative">
                                    <label class="form-label">
                                        Account
                                        <span class="text-danger ms-1">*</span>
                                        <span id="error-container-account"></span>
                                    </label>
                                    <div class="position-relative">
                                        <input id="account" type="text" name="account" class="form-control form-control-lg">
                                        <span><i class="isax isax-user input-icon text-gray-7 fs-14"></i></span>
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
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-lg" type="submit">Login <i
                                            class="isax isax-arrow-right-3 ms-1"></i></button>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>
                        </div>
                    </div>

                    <div class="text-center p-3" style="color: #666;">
                        <p class="fw-normal p-0 m-0" style="font-size: 14px;">版權所有 © {{date('Y')}} 香港賽馬會慈善信託基金</p>
                        <p class="fw-normal p-0 m-0" style="font-size: 12px;">Powered by Arrogate Maker Limited.</p>
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
        .addField('#account', [
            {
                rule: 'required',
            }
        ], {
            errorsContainer: '#error-container-account'
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
                    window.location.href = data.data.redirect;
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
