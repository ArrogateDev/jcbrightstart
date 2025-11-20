<!DOCTYPE html>
<html lang="en">

<x-admin.head/>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
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
                            </div>
                            <h1 class="fs-32 fw-bold topic">Sign into Your Account</h1>
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
