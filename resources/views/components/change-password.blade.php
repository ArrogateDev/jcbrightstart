@props([
    'module' => 'admin'
])
<script src="{{web_resource_url('assets/js/validation.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{web_resource_url('assets/js/md5.js') }}"></script>
<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <h5 class="mb-1 fs-18">{{__('更改密码')}}</h5>
            @if($module === 'web')
                <p>
                    {{__('不记得您当前的密码？')}}
                    <a href="#" class="text-decoration-underline rest-password">{{__('通过电子邮件重置密码')}}</a>
                </p>
            @endif
        </div>
        <form id="form" novalidate="novalidate">
            <div class="mb-3 position-relative">
                <label class="form-label">
                    {{__('当前密码')}}
                    <span class="text-danger ms-1">*</span>
                    <span id="error-container-current-password"></span>
                </label>
                <div class="position-relative">
                    <input id="current-password" type="password" name="current_password" class="pass-input form-control">
                    <span class="isax toggle-password isax-eye-slash text-gray-7 fs-14"></span>
                </div>
            </div>
            <div class="mb-3 position-relative">
                <label class="form-label">{{__('新密码')}}
                    <span class="text-danger ms-1">*</span>
                    <span id="error-container-password"></span>
                </label>
                <div class="position-relative" id="passwordInput">
                    <input id="password" type="password" name="password" class="pass-inputs form-control">
                    <span class="isax toggle-passwords isax-eye-slash text-gray-7 fs-14"></span>
                </div>
                <div class="password-strength" id="passwordStrength">
                    <span id="poor"></span>
                    <span id="weak"></span>
                    <span id="strong"></span>
                    <span id="heavy"></span>
                </div>
                <div class="mt-2 fs-14" id="passwordInfo">
                    {{__('使用大小写字母、数字、符号组合且8个以上字符。')}}
                </div>
            </div>
            <div class="mb-3 position-relative">
                <label class="form-label">{{__('确认密码')}}
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
                    {{__('更改密码')}}
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
                errorMessage: '{{__('请输入您当前的密码。')}}',
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
            confirm_alert('{{__('你确定吗？')}}', "{{__('您将无法恢复此设置！')}}", '{{__('是的，重置密码')}}').then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                showLoading();

                $.ajax({
                    type: "post",
                    url: "{{route('forgot-password.html')}}",
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
                        $('.avatar-img').attr('src', '{{web_resource_url('assets/admin/img/avatar.png')}}')
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
