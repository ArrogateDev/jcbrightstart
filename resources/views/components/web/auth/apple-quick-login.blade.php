@props(['type' => 'signin'])

<div href="javascript:void(0);" id="apple-quick-login-btn" class="flex items-center border-1 border-[#999] rounded-full p-[8px_42px]">
    <img src="{{web_resource_url('assets/admin/img/icons/apple.svg')}}" alt="img">
    <div class="text-[10px] text-[#999999]">{{__('使用 Apple 账号',['type'=>$type==='signin'? __('登录') : __('注册')])}}</div>
</div>

{{-- 苹果登录：未找到账号时选择绑定或新建 --}}
<div class="modal fade" id="apple-choice-modal" tabindex="-1" aria-labelledby="apple-choice-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="apple-choice-label">{{ __('未找到关联账号') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="isax isax-close-circle5"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-3">{{ __('当前 Apple 账号尚未关联本站账号，请选择：') }}</p>
                <div class="d-flex flex-column gap-2">
                    <button type="button" class="btn btn-outline-primary btn-lg" id="apple-choice-bind-btn">
                        {{ __('绑定已有账号') }}
                    </button>
                    <button type="button" class="btn btn-primary btn-lg" id="apple-choice-create-btn">
                        {{ __('新建账号') }}
                    </button>
                </div>
                <div id="apple-bind-form" class="mt-4 d-none">
                    <hr>
                    <p class="mb-2">{{ __('请输入您在本站注册的邮箱，我们将发送验证码完成绑定：') }}</p>
                    <div class="form-group mb-3">
                        <label for="apple-bind-email">{{ __('邮箱') }}</label>
                        <input type="email" class="form-control" id="apple-bind-email" placeholder="{{ __('邮箱') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="apple-bind-code">{{ __('验证码') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="apple-bind-code" placeholder="{{ __('验证码') }}" maxlength="6" autocomplete="one-time-code">
                            <div class="input-group-text" id="apple-bind-get-code" role="button">
                                {{ __('获取验证码') }}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-secondary" id="apple-bind-cancel">{{ __('取消') }}</button>
                        <button type="button" class="btn btn-primary" id="apple-bind-submit">{{ __('确认绑定并登录') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://appleid.cdn-apple.com/appleauth/static/jsapi/appleid/1/en_US/appleid.auth.js" async defer></script>
<script>
    let appleAuthInitialized = false;
    let applePendingToken = null;

    function initAppleAuth() {
        if (appleAuthInitialized) {
            return;
        }

        if (!(window.AppleID && AppleID.auth && AppleID.auth.init)) {
            setTimeout(initAppleAuth, 300);
            return;
        }

        try {
            AppleID.auth.init({
                clientId: '{{ env('APPLE_CLIENT_ID') }}',
                scope: 'name email',
                redirectURI: '{{ env('APPLE_REDIRECT_URI') }}',
                state: '{{ csrf_token() }}',
                usePopup: true,
            });
            appleAuthInitialized = true;
            attachAppleSignIn();
        } catch (error) {
            console.error('Apple Sign-In init error', error);
            document.getElementById('apple-quick-login-btn').classList.add('disabled');
        }
    }

    function attachAppleSignIn() {
        const appleBtn = document.getElementById('apple-quick-login-btn');
        if (!appleBtn || appleBtn.dataset.appleAuthAttached === 'true') {
            return;
        }

        const debouncedSignIn = _.debounce(async () => {
            try {
                const response = await AppleID.auth.signIn();
                handleAppleSignInSuccess(response);
            } catch (error) {
                handleAppleSignInError(error);
            }
        }, 500, {leading: true, trailing: false});

        appleBtn.dataset.appleAuthAttached = 'true';
        appleBtn.addEventListener('click', (event) => {
            event.preventDefault();

            if (!appleAuthInitialized) {
                showToast('error', 'Apple 登录初始化中，请稍后重试');
                return;
            }

            debouncedSignIn();
        });
    }

    function handleAppleSignInSuccess(response) {
        const {authorization = {}, user = {}} = response || {};
        const {code, id_token} = authorization;

        if (!code && !id_token) {
            showToast('error', '未获取到 Apple 登录凭据，请重试');
            return;
        }

        const payload = {
            code: code ?? '',
            id_token: id_token ?? '',
            user: user,
            state: '{{ csrf_token() }}',
            _token: '{{ csrf_token() }}'
        };

        showLoading();
        $.ajax({
            type: 'post',
            url: '{{ route('apple-quick-login.html') }}',
            data: payload,
            dataType: 'json',
            success: function (data) {
                if (data.code !== 0) {
                    showToast('error', data.msg);
                    return;
                }
                const d = data.data || {};
                if (d.need_choice && d.apple_pending_token) {
                    applePendingToken = d.apple_pending_token;
                    $('#apple-bind-email').val(d.email || '');
                    $('#apple-bind-form').addClass('d-none');
                    $('#apple-choice-modal').modal('show');
                    return;
                }
                showToast('success', '{{ $type === 'signup' ? __('注册成功') : __('登录成功') }}');
                setTimeout(function () {
                    window.location.href = d.redirect || '/';
                }, 800);
            },
            error: function (xhr) {
                const msg = (xhr.responseJSON && xhr.responseJSON.msg) ? xhr.responseJSON.msg : '{{ $type === 'signup' ? __('注册失败，请稍后重试') : __('登录失败，请稍后重试') }}';
                showToast('error', msg);
            },
            complete: function () {
                hideLoading();
            }
        });
    }

    function handleAppleSignInError(error) {
        if (error && error.error === 'popup_closed_by_user') {
            showToast('info', '您已取消 Apple 登录');
            return;
        }

        showToast('error', 'Apple 登录失败，请稍后重试');
    }

    $(function () {
        $('#apple-choice-create-btn').on('click', function () {
            if (!applePendingToken) {
                showToast('error', '{{ __('链接已过期，请重新使用 Apple 登录') }}');
                $('#apple-choice-modal').modal('hide');
                return;
            }
            showLoading();
            $.ajax({
                type: 'post',
                url: '{{ route('apple-quick-login.html') }}',
                data: {
                    action: 'create',
                    apple_pending_token: applePendingToken,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (data) {
                    if (data.code !== 0) {
                        showToast('error', data.msg);
                        return;
                    }
                    showToast('success', '{{ __('注册成功') }}');
                    $('#apple-choice-modal').modal('hide');
                    setTimeout(function () {
                        window.location.href = (data.data && data.data.redirect) ? data.data.redirect : '/';
                    }, 800);
                },
                error: function (xhr) {
                    const msg = (xhr.responseJSON && xhr.responseJSON.msg) ? xhr.responseJSON.msg : '{{ __('操作失败，请稍后重试') }}';
                    showToast('error', msg);
                },
                complete: function () {
                    hideLoading();
                }
            });
        });

        $('#apple-choice-bind-btn').on('click', function () {
            $('#apple-bind-form').removeClass('d-none');
        });

        $('#apple-bind-cancel').on('click', function () {
            $('#apple-bind-form').addClass('d-none');
        });

        var appleBindCodeCountdown = 0;

        function resetAppleBindCodeBtn() {
            appleBindCodeCountdown = 0;
            $('#apple-bind-get-code').prop('disabled', false).text('{{ __('获取验证码') }}');
        }

        $('#apple-bind-get-code').on('click', function () {
            var $btn = $(this);
            if ($btn.prop('disabled')) return;
            var email = $('#apple-bind-email').val().trim();
            if (!email) {
                showToast('error', '{{ __('请输入邮箱') }}');
                return;
            }
            $btn.prop('disabled', true).text('{{ __('发送中...') }}');
            $.ajax({
                type: 'post',
                url: '{{ route('get-code') }}',
                data: {email: email, scene: 'bind', _token: '{{ csrf_token() }}'},
                dataType: 'json',
                success: function (data) {
                    if (data.code !== 0) {
                        showToast('error', data.msg || '{{ __('发送失败') }}');
                        resetAppleBindCodeBtn();
                        return;
                    }
                    showToast('success', data.msg || '{{ __('发送成功') }}');
                    appleBindCodeCountdown = 60;
                    var t = setInterval(function () {
                        appleBindCodeCountdown -= 1;
                        if (appleBindCodeCountdown <= 0) {
                            clearInterval(t);
                            resetAppleBindCodeBtn();
                            return;
                        }
                        $btn.text(appleBindCodeCountdown + 's');
                    }, 1000);
                },
                error: function (xhr) {
                    var msg = (xhr.responseJSON && xhr.responseJSON.msg) ? xhr.responseJSON.msg : '{{ __('发送失败') }}';
                    showToast('error', msg);
                    resetAppleBindCodeBtn();
                }
            });
        });

        $('#apple-bind-submit').on('click', function () {
            var email = $('#apple-bind-email').val().trim();
            var code = $('#apple-bind-code').val().trim();
            if (!email) {
                showToast('error', '{{ __('请输入邮箱') }}');
                return;
            }
            if (!code) {
                showToast('error', '{{ __('请输入验证码') }}');
                return;
            }
            if (!applePendingToken) {
                showToast('error', '{{ __('链接已过期，请重新使用 Apple 登录') }}');
                $('#apple-choice-modal').modal('hide');
                return;
            }
            showLoading();
            $.ajax({
                type: 'post',
                url: '{{ route('apple-quick-login.html') }}',
                data: {
                    action: 'bind',
                    apple_pending_token: applePendingToken,
                    email: email,
                    code: code,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (data) {
                    if (data.code !== 0) {
                        showToast('error', data.msg);
                        return;
                    }
                    showToast('success', '{{ __('绑定成功') }}');
                    $('#apple-choice-modal').modal('hide');
                    setTimeout(function () {
                        window.location.href = (data.data && data.data.redirect) ? data.data.redirect : '/';
                    }, 800);
                },
                error: function (xhr) {
                    const msg = (xhr.responseJSON && xhr.responseJSON.msg) ? xhr.responseJSON.msg : '{{ __('绑定失败，请稍后重试') }}';
                    showToast('error', msg);
                },
                complete: function () {
                    hideLoading();
                }
            });
        });
    });

    initAppleAuth();
</script>

