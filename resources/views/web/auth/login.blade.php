<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @csrfRefresh
</head>
<body>
<div class="w-full h-screen auth-page flex justify-center items-center">
    <div class="w-[593px] max-w-full flex flex-col items-center form-bg p-2 md:p-[45px] rounded-md shadow-xl">
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
            <fieldset class="fieldset w-full mt-[15px] md:px-[48px]">
                <label for="email" class="label text-[12px] text-[#998675]">Email</label>
                <input id="email" type="email" name="email" class="input w-full h-[46px] rounded-md" placeholder="Email"/>
                <span id="error-container-email"></span>

                <label for="password" class="label text-[12px] text-[#998675] mt-[14px]">Password</label>
                <div class="relative w-full">
                    <input id="password" type="password" name="password" class="input w-full h-[46px] rounded-md pr-11" placeholder="Password"/>
                    <button type="button" id="toggle-password" class="absolute right-3 top-1/2 right-0 -translate-y-1/2 pe-2 text-[#998675] cursor-pointer" aria-label="Show password">
                        <svg class="w-[20px] h-[20px]"  id="eye-show" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="200" height="200"><path d="M512 298.666667c-162.133333 0-285.866667 68.266667-375.466667 213.333333 89.6 145.066667 213.333333 213.333333 375.466667 213.333333s285.866667-68.266667 375.466667-213.333333c-89.6-145.066667-213.333333-213.333333-375.466667-213.333333z m0 469.333333c-183.466667 0-328.533333-85.333333-426.666667-256 98.133333-170.666667 243.2-256 426.666667-256s328.533333 85.333333 426.666667 256c-98.133333 170.666667-243.2 256-426.666667 256z m0-170.666667c46.933333 0 85.333333-38.4 85.333333-85.333333s-38.4-85.333333-85.333333-85.333333-85.333333 38.4-85.333333 85.333333 38.4 85.333333 85.333333 85.333333z m0 42.666667c-72.533333 0-128-55.466667-128-128s55.466667-128 128-128 128 55.466667 128 128-55.466667 128-128 128z" fill="#444444"></path></svg>

                        <svg class="w-[20px] h-[20px] hidden"  id="eye-hide"  viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="200" height="200"><path d="M332.8 729.6l34.133333-34.133333c42.666667 12.8 93.866667 21.333333 145.066667 21.333333 162.133333 0 285.866667-68.266667 375.466667-213.333333-46.933333-72.533333-102.4-128-166.4-162.133334l29.866666-29.866666c72.533333 42.666667 132.266667 106.666667 183.466667 192-98.133333 170.666667-243.2 256-426.666667 256-59.733333 4.266667-119.466667-8.533333-174.933333-29.866667z m-115.2-64c-51.2-38.4-93.866667-93.866667-132.266667-157.866667 98.133333-170.666667 243.2-256 426.666667-256 38.4 0 76.8 4.266667 110.933333 12.8l-34.133333 34.133334c-25.6-4.266667-46.933333-4.266667-76.8-4.266667-162.133333 0-285.866667 68.266667-375.466667 213.333333 34.133333 51.2 72.533333 93.866667 115.2 128l-34.133333 29.866667z m230.4-46.933333l29.866667-29.866667c8.533333 4.266667 21.333333 4.266667 29.866666 4.266667 46.933333 0 85.333333-38.4 85.333334-85.333334 0-12.8 0-21.333333-4.266667-29.866666l29.866667-29.866667c12.8 17.066667 17.066667 38.4 17.066666 64 0 72.533333-55.466667 128-128 128-17.066667-4.266667-38.4-12.8-59.733333-21.333333zM384 499.2c4.266667-68.266667 55.466667-119.466667 123.733333-123.733333 0 4.266667-123.733333 123.733333-123.733333 123.733333zM733.866667 213.333333l29.866666 29.866667-512 512-34.133333-29.866667L733.866667 213.333333z" fill="#444444" ></path></svg>
                    </button>
                </div>
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

        <div class="flex flex-col md:flex-row gap-[32px] mt-[22px]">
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
    $('#toggle-password').on('click', function () {
        const $input = $('#password');
        const isHidden = $input.attr('type') === 'password';
        $input.attr('type', isHidden ? 'text' : 'password');
        $('#eye-show').toggleClass('hidden', isHidden);
        $('#eye-hide').toggleClass('hidden', !isHidden);
        $(this).attr('aria-label', isHidden ? 'Hide password' : 'Show password');
    });

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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: form,
            dataType: "json",
            xhrFields: {
                withCredentials: true
            },
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
