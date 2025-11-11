@props(['type' => 'signin'])

<div href="javascript:void(0);" id="apple-quick-login-btn" class="apple-quick-login">
    <img src="{{web_resource_url('assets/img/icons/apple.svg')}}" alt="img" class="me-2">使用 Apple 账号{{$type==='signin'? '登录' : '注册'}}
</div>

<script src="https://appleid.cdn-apple.com/appleauth/static/jsapi/appleid/1/en_US/appleid.auth.js" async defer></script>
<script>
    let appleAuthInitialized = false;

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
            showToast('error', 'Apple 登录初始化失败，请稍后重试');
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

                showToast('success', '{{ $type === 'signup' ? 'Register':'Login' }} successful');
                setTimeout(function () {
                    window.location.href = data.data.redirect ?? '/';
                }, 800);
            },
            error: function () {
                showToast('error', '{{ $type === 'signup' ? 'Register':'Login' }} failed, please try again later');
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

    initAppleAuth();
</script>

