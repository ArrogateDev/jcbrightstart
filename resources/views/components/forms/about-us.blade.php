<form id="message-form" class="js-contact-form" novalidate="novalidate">
    <div class="row">
        <div class="col-md-6 p-r-10 p-md-r-15">
            <input class="input-border" id="name" type="text" name="name" required="" placeholder="Your name">
        </div>
        <div class="col-md-6 p-l-10 p-md-l-15">
            <input class="input-border" id="email" type="email" name="email" required="" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" placeholder="Your e-mail">
        </div>
    </div>
    <textarea class="textarea-border" id="message" name="message" placeholder="Your message..." required=""></textarea>
    <div class="text-center">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <button class="au-btn au-btn--blue" type="submit">
            {{__('提交')}}
            <i class="zmdi zmdi-chevron-right"></i>
            <i class="zmdi zmdi-chevron-right"></i>
        </button>
    </div>
</form>

<script>
    const validator = new window.JustValidate('#message-form', {
        errorLabelCssClass: 'd-inline',
    });
    validator
        .addField('#name', [
            {
                rule: 'required',
            }
        ])
        .addField('#email', [
            {
                rule: 'required',
            },
            {
                rule: 'email',
            },
        ])
        .addField('#message', [
            {
                rule: 'required',
            }
        ])
        .onSuccess(() => {
            handleMessage();
        });

    function handleMessage() {
        showLoading()

        let form = $('#message-form').serializeArray()

        $.ajax({
            type: "post",
            url: "{{route('message.html')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: form,
            dataType: "json",
            success: function (data) {
                if (data.code !== 0) {
                    showToast('error', data.msg);
                    return;
                }

                showToast('success', 'Successful');
                $('#message-form').trigger("reset");
            }, error: function () {
                showToast('error', 'Failed, please try again later')
            }, complete: function () {
                hideLoading()
            }
        });
    }
</script>
