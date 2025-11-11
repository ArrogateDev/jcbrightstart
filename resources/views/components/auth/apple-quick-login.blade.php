<a href="javascript:void(0);" id="appleSignInBtn" class="btn btn-light">
    <img src="{{web_resource_url('assets/img/icons/apple.svg')}}" alt="img" class="me-2">Apple
</a>

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
        const appleBtn = document.getElementById('appleSignInBtn');
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
        }, 500, { leading: true, trailing: false });

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
        const { authorization = {}, user } = response || {};
        const { code, id_token: idToken, state } = authorization;

        console.log('Apple Sign-In code:', code);
        console.log('Apple Sign-In id_token:', idToken);
        console.log('Apple Sign-In state:', state);
        console.log('Apple Sign-In user:', user);

        // TODO: 将 code / idToken 提交到后端，完成登录/注册逻辑
    }

    function handleAppleSignInError(error) {
        if (error && error.error === 'popup_closed_by_user') {
            showToast('info', '您已取消 Apple 登录');
            return;
        }

        console.error('Apple Sign-In error', error);
        showToast('error', 'Apple 登录失败，请稍后重试');
    }

    initAppleAuth();
</script>

