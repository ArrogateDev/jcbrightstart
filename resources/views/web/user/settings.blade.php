<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/css/user.scss', 'resources/js/app.js', 'resources/css/font-awesome/all.min.css'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/lodash.js') }}"></script>
    <script src="{{web_resource_url('assets/js/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{web_resource_url('assets/js/wait-me/waitMe.min.css')}}">
    <link href="{{web_resource_url('assets/js/toastr/toastr.min.css')}}" rel="stylesheet"/>
    <script src="{{web_resource_url('assets/js/toastr/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/utils.js') }}"></script>
    <script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
</head>
<body>
<x-web.user.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="pt-[60px]">
            <x-web.user.profile :user="$user"/>
        </div>

        <div class="grid grid-cols-12 lg:gap-x-12">
            <x-web.user.sidebar active="settings"/>

            <div class="col-span-12 lg:col-span-10">

                <x-web.user.breadcrumb title="{{__('设置')}}"/>

                <div class="mb-5 flex flex-col gap-4 border-b border-[#998675] pb-5 lg:flex-row lg:items-center lg:justify-between">
                    <h5 class="text-xl font-bold">{{__('设置')}}</h5>
                </div>
                <ul class="settings-nav flex items-center flex-wrap border bg-light-900 rounded j-user-box mb-5">
                    <li class="ms-4"><a href="{{route('user.settings.html')}}" class="active inline-flex px-[18px] py-[15px]">{{__('修改资料')}}</a></li>
                    <li><a class="inline-flex px-[18px] py-[15px] text-[#6d6d6d]" href="{{route('user.change-password.html')}}">{{__('修改密码')}}</a></li>
                </ul>
                <form id="form" novalidate="novalidate">
                    <div class="card j-user-box">
                        <div class="card-body">
                            <div class="profile-upload-group">
                                <div class="flex items-center">
                                    <x-web.user.avatar :user="$user" module="user"/>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4">
                                    <h5 class="mb-1 text-lg">{{__('个人资料')}}</h5>
                                    <p class="text-sm text-[#6d6d6d]">{{__('编辑您的个人信息')}}</p>
                                </div>
                                <div class="grid grid-cols-12">
                                    <div class="col-span-12 md:col-span-6">
                                        <fieldset class="fieldset mb-3">
                                            <legend class="fieldset-legend">
                                                {{__('名字')}}
                                                <span class="text-red-600 ms-1">*</span>
                                            </legend>
                                            <input id="first-name" type="text" name="first_name" class="input rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" value="{{$user->first_name}}">
                                            <p class="label error-container-first-name"></p>
                                        </fieldset>
                                    </div>
                                    <div class="col-span-12 md:col-span-6">
                                        <fieldset class="fieldset mb-3">
                                            <legend class="fieldset-legend">
                                                {{__('姓氏')}}
                                                <span class="text-red-600 ms-1">*</span>
                                            </legend>
                                            <input id="last-name" type="text" name="last_name" class="input rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" value="{{$user->last_name}}">
                                            <p class="label error-container-last-name"></p>
                                        </fieldset>
                                    </div>
                                    <div class="col-span-12 md:col-span-6">
                                        <fieldset class="fieldset mb-3">
                                            <legend class="fieldset-legend">
                                                {{__('性别')}}
                                                <span class="text-red-600 ms-1">*</span>
                                            </legend>
                                            <select id="gender" class="select rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" name="gender">
                                                <option @selected($user->gender === 1) value="1">{{__('男性')}}</option>
                                                <option @selected($user->gender === 0) value="0">{{__('女性')}}</option>
                                                <option @selected($user->gender === 2) value="2">{{__('沒有提供')}}</option>
                                            </select>
                                            <p class="label error-container-gender"></p>
                                        </fieldset>
                                    </div>
                                    <div class="col-span-12">
                                        <button class="btn bg-[#ff4667] rounded-full text-white" type="submit">{{__('更新资料')}}</button>
                                    </div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
</section>

<x-web.footer/>
</body>

<script>
    const validator = new window.JustValidate('#form', {
        errorLabelCssClass: 'd-inline',
    });
    validator
        .addField('#first-name', [
            {
                rule: 'required',
            }
        ], {
            errorsContainer: '#error-container-first-name'
        })
        .addField('#last-name', [
            {
                rule: 'required',
            }
        ], {
            errorsContainer: '#error-container-last-name'
        })
        .addField('#gender', [
            {
                rule: 'required',
            }
        ], {
            errorsContainer: '#error-container-gender'
        })
        .onSuccess(() => {
            handleSetting();
        });

    function handleSetting() {
        showLoading()

        let form = $('#form').serializeArray()

        $.ajax({
            type: "post",
            data: form,
            dataType: "json",
            success: function (data) {
                if (data.code !== 0) {
                    showToast('error', data.msg);
                    return;
                }

                showToast('success', 'Successful');
                setTimeout(function () {
                    window.location.href = data.data.redirect;
                }, 800)
            },
            error: function () {
                showToast('error', 'Failed, please try again later')
            },
            complete: function () {
                hideLoading()
            }
        });
    }
</script>

</html>
