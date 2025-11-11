<div id="googleSignInBtn" class="me-2"></div>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    let googleAuthInitialized = false;

    function decodeGoogleJwt(token) {
        try {
            const base64Url = token.split('.')[1];
            const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            const jsonPayload = decodeURIComponent(atob(base64).split('').map((c) => {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
            return JSON.parse(jsonPayload);
        } catch (error) {
            console.error('Decode Google JWT error', error);
            return null;
        }
    }

    function handleGoogleCredentialResponse(response) {
        if (!response || !response.credential) {
            showToast('error', '未获取到 Google 登录凭据，请重试');
            return;
        }

        console.log('Google encoded credential:', response.credential);
        const payload = decodeGoogleJwt(response.credential);
        if (payload) {
            console.log('Google credential payload:', payload);
            // TODO: 将 credential 发送到后端完成登录/注册逻辑
        }
    }

    function initGoogleAuth() {
        if (googleAuthInitialized) {
            return;
        }

        if (!(window.google && google.accounts && google.accounts.id)) {
            setTimeout(initGoogleAuth, 300);
            return;
        }

        try {
            google.accounts.id.initialize({
                client_id: '{{ env('GOOGLE_CLIENT_ID') }}',
                callback: handleGoogleCredentialResponse,
                auto_select: false,
                cancel_on_tap_outside: true,
            });

            const googleBtnContainer = document.getElementById('googleSignInBtn');
            if (!googleBtnContainer || googleBtnContainer.dataset.googleAuthAttached === 'true') {
                return;
            }

            google.accounts.id.renderButton(googleBtnContainer, {
                type: 'standard',
                theme: 'outline',
                size: 'large',
                shape: 'pill',
                text: 'continue_with',
                logo_alignment: 'left',
                width: 260,
            });

            googleBtnContainer.dataset.googleAuthAttached = 'true';
            googleAuthInitialized = true;

            google.accounts.id.prompt((notification) => {
                if (notification.isNotDisplayed() && notification.getNotDisplayedReason()) {
                    console.warn('Google prompt not displayed:', notification.getNotDisplayedReason());
                }
                if (notification.isSkippedMoment() && notification.getSkippedReason()) {
                    console.warn('Google prompt skipped:', notification.getSkippedReason());
                }
            });
        } catch (error) {
            console.error('Google Sign-In init error', error);
            showToast('error', 'Google 登录初始化失败，请稍后重试');
        }
    }

    window.handleGoogleCredentialResponse = handleGoogleCredentialResponse;

    initGoogleAuth();
</script>
