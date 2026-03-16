@props(['type' => 'signin'])

<div href="javascript:void(0);" id="google-quick-login-btn" class="apple-quick-login">
    <img src="{{web_resource_url('assets/admin/img/icons/google.svg')}}" alt="img">
    <div class="flex-grow-1">{{__('使用 Google 账号',['type'=>$type==='signin'? __('登录') : __('注册')])}}</div>
</div>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    let googleAuthInitialized = false;

    function initGoogleAuth() {
        if (googleAuthInitialized) {
            return;
        }

        if (!(window.google && window.google.accounts)) {
            setTimeout(initGoogleAuth, 300);
            return;
        }

        try {
            google.accounts.id.initialize({
                client_id: '{{ env('GOOGLE_CLIENT_ID') }}',
                callback: handleGoogleCredentialResponse,
                auto_select: false,
            });
            googleAuthInitialized = true;
            attachGoogleSignIn();
        } catch (error) {
            console.error('Google Sign-In init error', error);
            document.getElementById('google-quick-login-btn').classList.add('disabled');
        }
    }

    function attachGoogleSignIn() {
        const googleBtn = document.getElementById('google-quick-login-btn');
        if (!googleBtn || googleBtn.dataset.googleAuthAttached === 'true') {
            return;
        }

        googleBtn.dataset.googleAuthAttached = 'true';
        googleBtn.addEventListener('click', (event) => {
            event.preventDefault();

            if (!googleAuthInitialized) {
                showToast('error', 'Google 登录初始化中，请稍后重试');
                return;
            }

            google.accounts.id.prompt((notification) => {
                if (notification.isNotDisplayed() || notification.isSkippedMoment()) {
                    console.log('Google prompt not displayed:', notification.getNotDisplayedReason());
                }
            }, { parentComponent: document.getElementById('google-quick-login-btn') });
        });
    }

    function handleGoogleCredentialResponse(response) {
        if (!response || !response.credential) {
            showToast('error', '未获取到 Google 登录凭据，请重试');
            return;
        }

        showLoading()

        let form = {
            credential: response.credential,
            _token: '{{ csrf_token() }}'
        }

        $.ajax({
            type: "post",
            url: '{{ route('google-quick-login.html') }}',
            data: form,
            dataType: "json",
            success: function (data) {
                if (data.code !== 0) {
                    showToast('error', data.msg);
                    return;
                }

                showToast('success', '{{ $type === 'signup' ? __('注册成功') : __('登录成功') }}');
                setTimeout(function () {
                    window.location.href = data.data.redirect ?? '/';
                }, 800)
            }, error: function () {
                showToast('error', '{{ $type === 'signup' ? __('注册失败，请稍后重试') : __('登录失败，请稍后重试') }}')
            }, complete: function () {
                hideLoading()
            }
        });
    }

    $(function () {
        initGoogleAuth();
    });
</script>
