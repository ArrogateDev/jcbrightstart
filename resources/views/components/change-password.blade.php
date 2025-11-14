@props([
    'module' => 'admin'
])
<script src="{{web_resource_url('assets/js/validation.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{ web_resource_url('assets/js/md5.js') }}"></script>
<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <h5 class="mb-1 fs-18">Change Password</h5>
            @if($module === 'web')
                <p>
                    Can't remember your current password?
                    <a href="#" class="text-decoration-underline rest-password">Reset your password via email</a>
                </p>
            @endif
        </div>
        <form id="form" novalidate="novalidate">
            <div class="mb-3 position-relative">
                <label class="form-label">
                    Current Password
                    <span class="text-danger ms-1">*</span>
                    <span id="error-container-current-password"></span>
                </label>
                <div class="position-relative">
                    <input id="current-password" type="password" name="current_password" class="pass-input form-control">
                    <span class="isax toggle-password isax-eye-slash text-gray-7 fs-14"></span>
                </div>
            </div>
            <div class="mb-3 position-relative">
                <label class="form-label">New Password
                    <span class="text-danger ms-1">*</span>
                    <span id="error-container-password"></span>
                </label>
                <div class="position-relative" id="passwordInput">
                    <input id="password" type="password" name="password" class="pass-inputs form-control">
                    <span class="isax toggle-passwords isax-eye-slash text-gray-7 fs-14"></span>
                </div>
                <div class="password-strength">
                    <span id="poor"></span>
                    <span id="weak"></span>
                    <span id="strong"></span>
                    <span id="heavy"></span>
                </div>
                <div class="mt-2 fs-14" id="passwordInfo">
                    Use upper & lower case letters, numbers, symbols and 8+ characters.
                </div>
            </div>
            <div class="mb-3 position-relative">
                <label class="form-label">Confirm Password
                    <span class="text-danger ms-1">*</span>
                    <span id="error-container-password-confirmation"></span>
                </label>
                <div class="position-relative">
                    <input id="password-confirmation" type="password" name="password_confirmation" class="pass-inputa form-control form-control-lg">
                    <span class="isax toggle-passworda isax-eye-slash text-gray-7 fs-14"></span>
                </div>
            </div>
            <div>
                <button class="btn btn-secondary" type="submit">
                    Change Password
                </button>
            </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </form>
    </div>
</div>

<script>
    const validator = new window.JustValidate('#form', {
        errorLabelCssClass: 'd-inline',
    });
    validator
        .addField('#current-password', [
            {
                rule: 'required',
                errorMessage: 'Please enter your Current Password.',
            }
        ], {
            errorsContainer: '#error-container-current-password'
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
        .onSuccess(() => {
            handleChangePassword();
        });

    function handleChangePassword() {
        showLoading()

        let form = $('#form').serializeArray()
        form = form.map(item => {
            if (item.name !== '_token') {
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

                showToast('success', 'Successful');

                document.getElementById('form').reset();
                $('.password-strength').children().removeClass('active');
            }, error: function () {
                showToast('error', 'Failed, please try again later')
            }, complete: function () {
                hideLoading()
            }
        });
    }

    @if($module === 'web')
    $(function () {
        $('.rest-password').click(function () {
            confirm_alert('Are you sure?', "You won't be able to revert this!", 'Yes, Rest Password!!').then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                showLoading();

                $.ajax({
                    type: "delete",
                    url: "{{route($module.'.reset-password.html')}}",
                    data: {
                        _token: '{{csrf_token()}}'
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.code !== 0) {
                            showToast('error', data.msg);
                            return;
                        }

                        showToast('success', 'Successful');
                        $('.avatar-img').attr('src', '{{web_resource_url('assets/img/avatar.png')}}')
                    },
                    error: function () {
                        showToast('error', 'Failed, please try again later');
                    },
                    complete: function () {
                        hideLoading();
                    }
                });
            });
        });
    })
    @endif
</script>
