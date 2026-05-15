@props([
    'module' => 'admin'
])
<script src="{{web_resource_url('assets/js/validation.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{web_resource_url('assets/js/md5.js') }}"></script>
<div class="grid grid-cols-1 lg:grid-cols-12">
    <div class="lg:col-span-8">
        <div class="mb-3">
            <h5 class="mb-1 text-lg font-semibold text-slate-900">{{__('更改密码')}}</h5>
            @if($module === 'web')
                <p class="text-sm text-slate-600">
                    {{__('不记得您当前的密码？')}}
                    <a href="#" class="rest-password underline decoration-slate-400 decoration-1 underline-offset-4 transition hover:text-slate-900">{{__('通过电子邮件重置密码')}}</a>
                </p>
            @endif
        </div>
        <form id="form" novalidate="novalidate">
            <div class="mb-3">
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    {{__('当前密码')}}
                    <span class="ml-1 text-rose-500">*</span>
                    <span id="error-container-current-password"></span>
                </label>
                <div class="relative">
                    <input id="current-password" type="password" name="current_password" class="pass-input w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                    <span class="isax toggle-password isax-eye-slash absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></span>
                </div>
            </div>
            <div class="mb-3">
                <label class="mb-2 block text-sm font-medium text-slate-700">{{__('新密码')}}
                    <span class="ml-1 text-rose-500">*</span>
                    <span id="error-container-password"></span>
                </label>
                <div class="relative" id="passwordInput">
                    <input id="password" type="password" name="password" class="pass-inputs w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                    <span class="isax toggle-passwords isax-eye-slash absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></span>
                </div>
                <div class="password-strength mt-3 flex gap-2" id="passwordStrength">
                    <span id="poor" class="h-1 flex-1 rounded-full bg-slate-200"></span>
                    <span id="weak" class="h-1 flex-1 rounded-full bg-slate-200"></span>
                    <span id="strong" class="h-1 flex-1 rounded-full bg-slate-200"></span>
                    <span id="heavy" class="h-1 flex-1 rounded-full bg-slate-200"></span>
                </div>
                <div class="mt-2 text-sm text-slate-500" id="passwordInfo">
                    {{__('使用大小写字母、数字、符号组合且8个以上字符。')}}
                </div>
            </div>
            <div class="mb-3">
                <label class="mb-2 block text-sm font-medium text-slate-700">{{__('确认密码')}}
                    <span class="ml-1 text-rose-500">*</span>
                    <span id="error-container-password-confirmation"></span>
                </label>
                <div class="relative">
                    <input id="password-confirmation" type="password" name="password_confirmation" class="pass-inputa w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                    <span class="isax toggle-passworda isax-eye-slash absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></span>
                </div>
            </div>
            <div>
                <button class="inline-flex items-center rounded-full bg-slate-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800" type="submit">
                    {{__('更改密码')}}
                </button>
            </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </form>
    </div>
</div>

<script>
    const validator = new window.JustValidate('#form', {
        errorLabelCssClass: 'inline-block mt-2 text-sm text-rose-600',
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
