<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/css/user.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<x-web.user.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="pt-[60px]">
            <x-web.user.profile :user="$user"/>
        </div>

        <div class="grid grid-cols-12 gap-x-12">

            <x-web.user.sidebar active="settings"/>

            <div class="lg:col-span-9">

                <x-web.user.breadcrumb title="{{__('设置')}}"/>

                <div class="mb-5 flex flex-col gap-4 border-b border-[#998675] pb-5 lg:flex-row lg:items-center lg:justify-between">
                    <h5 class="text-xl font-semibold text-slate-900">{{__('设置')}}</h5>
                </div>

                <ul class="settings-nav flex items-center flex-wrap border bg-light-900 rounded j-user-box mb-5">
                    <li class="ms-4"><a href="{{route('user.settings.html')}}" class="inline-flex px-[18px] py-[15px] text-[#6d6d6d]">{{__('修改资料')}}</a></li>
                    <li><a class="active inline-flex px-[18px] py-[15px]" href="{{route('user.change-password.html')}}">{{__('修改密码')}}</a></li>
                </ul>

                <div class="j-user-box rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="p-6">
                        <div class="mb-4 border-b border-slate-200 pb-4">

                            <x-web.user.change-password module="web"/>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-web.footer/>
</body>

</html>
