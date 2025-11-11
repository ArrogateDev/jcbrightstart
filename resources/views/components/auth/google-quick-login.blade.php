<a href="javascript:void(0);" id="googleSignInBtn" class="btn btn-light me-2">
    <img src="{{web_resource_url('assets/img/icons/google.svg')}}" alt="img" class="me-2">Google
</a>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    let googleCodeClient = null;
    let googleAuthInitialized = false;

    function initGoogleAuth() {
        if (googleAuthInitialized) {
            return;
        }

        if (!(window.google && google.accounts && google.accounts.oauth2 && google.accounts.oauth2.initCodeClient)) {
            setTimeout(initGoogleAuth, 300);
            return;
        }

        try {
            googleCodeClient = google.accounts.oauth2.initCodeClient({
                client_id: '{{ env('GOOGLE_CLIENT_ID') }}',
                scope: 'openid email profile',
                ux_mode: 'popup',
                redirect_uri: '{{ env('GOOGLE_REDIRECT_URI') }}',
                state: '{{ csrf_token() }}',
                callback: handleGoogleCodeResponse,
                error_callback: handleGoogleSignInError,
            });
            googleAuthInitialized = true;
            attachGoogleSignIn();
        } catch (error) {
            console.error('Google Sign-In init error', error);
            showToast('error', 'Google 登录初始化失败，请稍后重试');
        }
    }

    function attachGoogleSignIn() {
        const googleBtn = document.getElementById('googleSignInBtn');
        if (!googleBtn || googleBtn.dataset.googleAuthAttached === 'true') {
            return;
        }

        const debouncedSignIn = _.debounce(() => {
            if (!googleCodeClient) {
                showToast('error', 'Google 登录初始化中，请稍后重试');
                return;
            }

            googleCodeClient.requestCode();
        }, 500, { leading: true, trailing: false });

        googleBtn.dataset.googleAuthAttached = 'true';
        googleBtn.addEventListener('click', (event) => {
            event.preventDefault();
            debouncedSignIn();
        });
    }

    function handleGoogleCodeResponse(response) {
        if (!response || !response.code) {
            showToast('error', '未获取到 Google 授权码，请重试');
            return;
        }

        console.log('Google auth code:', response.code);
        console.log('Google auth scope:', response.scope);

        // TODO: 将授权码发送到后端完成登录/注册逻辑
    }

    function handleGoogleSignInError(error) {
        console.error('Google Sign-In error', error);
        if (error && error.type === 'popup_closed_by_user') {
            showToast('info', '您已取消 Google 登录');
            return;
        }
        showToast('error', 'Google 登录失败，请稍后重试');
    }

    initGoogleAuth();
</script>
