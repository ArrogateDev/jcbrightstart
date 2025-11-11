<a href="javascript:void(0);" id="googleSignInBtn" class="btn btn-light me-2">
    <img src="{{web_resource_url('assets/img/icons/google.svg')}}" alt="img" class="me-2">Google
</a>

<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>
    let googleAuthInstance = null;
    let googleAuthInitialized = false;

    function initGoogleAuth() {
        if (googleAuthInitialized) {
            return;
        }

        if (!(window.gapi && gapi.load)) {
            setTimeout(initGoogleAuth, 300);
            return;
        }

        gapi.load('auth2', () => {
            googleAuthInstance = gapi.auth2.init({
                client_id: '{{env('GOOGLE_CLIENT_ID')}}',
                cookiepolicy: 'single_host_origin'
            });
            googleAuthInitialized = true;
            attachGoogleSignIn();
        });
    }

    function attachGoogleSignIn() {
        const googleBtn = document.getElementById('googleSignInBtn');
        if (!googleBtn || googleBtn.dataset.googleAuthAttached === 'true') {
            return;
        }

        const debouncedSignIn = _.debounce(() => {
            if (!googleAuthInstance) {
                showToast('error', 'Google 登录初始化中，请稍后重试');
                return;
            }

            googleAuthInstance.signIn()
                .then(handleGoogleSignInSuccess)
                .catch(handleGoogleSignInError);
        }, 500, { leading: true, trailing: false });

        googleBtn.dataset.googleAuthAttached = 'true';
        googleBtn.addEventListener('click', (event) => {
            event.preventDefault();
            debouncedSignIn();
        });
    }

    function handleGoogleSignInSuccess(googleUser) {
        const idToken = googleUser.getAuthResponse().id_token;
        console.log('Google ID Token:', idToken);
        // TODO: 将 idToken 发送到后端完成登录/注册逻辑
    }

    function handleGoogleSignInError(error) {
        console.error('Google Sign-In error', error);
        showToast('error', 'Google 登录失败，请稍后重试');
    }

    initGoogleAuth();
</script>
