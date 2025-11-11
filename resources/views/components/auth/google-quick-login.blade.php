<div id="g_id_onload"
     data-client_id="{{ env('GOOGLE_CLIENT_ID') }}"
     data-context="{{ $type }}"
     data-ux_mode="popup"
     data-callback="handleGoogleCredentialResponse"
     data-itp_support="true">
</div>

<div class="g_id_signin me-2"
     data-type="standard"
     data-shape="pill"
     data-theme="outline"
     data-text="{{ $type }}_with"
     data-size="medium"
     data-logo_alignment="left">
</div>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    function handleGoogleCredentialResponse(response) {
        console.log('Google encoded credential:', response);
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

                // showToast('success', 'Register successful');
                // setTimeout(function () {
                //     window.location.href = data.data.redirect ?? '/';
                // }, 800)
            }, error: function () {
                showToast('error', 'Register failed, please try again later')
            }, complete: function () {
                hideLoading()
            }
        });
    }
</script>
