<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/lodash.js') }}"></script>
    <script src="{{web_resource_url('assets/js/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{web_resource_url('assets/js/wait-me/waitMe.min.css')}}">
    <link href="{{web_resource_url('assets/js/toastr/toastr.min.css')}}" rel="stylesheet"/>
    <script src="{{web_resource_url('assets/js/toastr/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/utils.js') }}"></script>
    <script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{web_resource_url('assets/js/md5.js') }}"></script>
</head>
<body>
<div class="w-full h-screen auth-page flex justify-center items-center">
    <div class="w-[593px] max-w-full flex flex-col items-center form-bg p-[45px] rounded-md shadow-xl">
        <div>
            <div>
                <img class="w-[129px] h-[57px]" src="{{web_resource_url('assets/web/images/logo.png')}}" alt="">
            </div>
        </div>
        <div class="w-full flex justify-center items-center gap-1 text-[19px] text-[#998675] mt-[21px] px-[48px]">
            <div class="solid-line"></div>
            <div>賽馬會幼兒「喜步」計劃</div>
            <div class="solid-line"></div>
        </div>
        <div class="text-[33px] text-[#534741] mt-[15px]">登入</div>
        <form class="w-full" id="form" novalidate="novalidate">
            <fieldset class="fieldset w-full mt-[15px] px-[48px]">
                <label for="email" class="label text-[12px] text-[#998675]">Email</label>
                <input id="email" type="email" name="email" class="input w-full h-[46px]" placeholder="Email"/>
                <span id="error-container-email"></span>

                <label for="password" class="label text-[12px] text-[#998675] mt-[14px]">Password</label>
                <input id="password" type="password" name="password" class="input w-full h-[46px]" placeholder="Password"/>
                <span id="error-container-password"></span>

                <div class="w-full flex justify-between mt-[14px]">
                    <label class="label text-[10px] text-[#998675]">
                        <input type="checkbox" checked="checked" class="checkbox"/>
                        記住密碼?
                    </label>
                    <a class="text-[10px] text-[#EC6D74]" href="">忘記密碼？</a>
                </div>

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button class="btn mt-[25px] bg-[#ee87b4] rounded-full text-[17px] text-white">登入 ></button>
            </fieldset>
        </form>

        <div class="w-full flex justify-center items-center gap-1 text-[12px] text-[#998675] my-[22px] px-[48px]">
            <div class="solid-line"></div>
            <div>或</div>
            <div class="solid-line"></div>
        </div>

        <div class="flex gap-[32px] mt-[22px]">
            <x-web.auth.google-quick-login type="signin"/>
            <x-web.auth.apple-quick-login type="signin"/>
        </div>
        <div class="text-[10px] text-[#998675] flex justify-center items-center mt-[18px] mb-[20px]">
            {{__('你没有账户吗？')}}<a href="{{route('register.html')}}" class="text-[#EC6D74]"> {{__('注册')}}</a>
        </div>

        <x-web.partner/>
    </div>
</div>

<script>
    const validator = new window.JustValidate('#form', {
        errorLabelCssClass: 'd-inline',
    });
    validator
        .addField('#email', [
            {
                rule: 'required',
            },
            {
                rule: 'email',
            },
        ], {
            errorsContainer: '#error-container-email'
        })
        .addField('#password', [
            {
                rule: 'required',
            },
            {
                rule: 'password',
            },
            {
                rule: 'minLength',
                value: 8,
            },
            {
                rule: 'strongPassword',
            }
        ], {
            errorsContainer: '#error-container-password'
        })
        .onSuccess(() => {
            handleLogin();
        });

    function handleLogin() {
        showLoading()

        let form = $('#form').serializeArray()
        form = form.map(item => {
            if (item.name === 'password') {
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

                showToast('success', 'Login successful');
                setTimeout(function () {
                    let redirect = data.data.redirect;
                    window.location.href = redirect.length > 0 ? redirect : '{{route('user.dashboard.html')}}';
                }, 800)
            }, error: function () {
                showToast('error', 'Login failed, please try again later')
            }, complete: function () {
                hideLoading()
            }
        });
    }
</script>
</body>

</html>
