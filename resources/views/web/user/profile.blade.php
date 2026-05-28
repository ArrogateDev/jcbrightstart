<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/css/user.scss', 'resources/js/app.js', 'resources/css/font-awesome/all.min.css'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
</head>
<body>
<x-web.user.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="pt-[60px]">
            <x-web.user.profile :user="$user"/>
        </div>

        <div class="grid grid-cols-12 lg:gap-x-12">

            <x-web.user.sidebar active="profile"/>

            <div class="col-span-12 lg:col-span-10">

                <x-web.user.breadcrumb title="{{__('我的资料')}}"/>

                <div class="flex items-center justify-between pb-5 mb-5 border-b border-[#998675]">
                    <h5 class="text-xl font-bold">{{__('我的资料')}}</h5>
                    <a href="{{route('user.settings.html')}}" class="edit-profile-icon">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </div>
                <div class="card j-user-box">
                    <div class="card-body">
                        <h5 class="text-lg font-bold pb-3 border-b border-[#e7e7e7] mb-3">{{__('基本信息')}}</h5>
                        <div class="grid grid-cols-12">
                            <div class="col-span-4">
                                <div class="mb-3">
                                    <h6 class="font-semibold">{{__('姓')}}</h6>
                                    <span>{{$user->first_name}}</span>
                                </div>
                            </div>
                            <div class="col-span-4">
                                <div class="mb-3">
                                    <h6 class="font-semibold">{{__('名')}}</h6>
                                    <span>{{$user->last_name}}</span>
                                </div>
                            </div>
                            <div class="col-span-4">
                                <div class="mb-3">
                                    <h6 class="font-semibold">{{__('注册时间')}}</h6>
                                    <span>{{$user->registration_date}}</span>
                                </div>
                            </div>
                            <div class="col-span-4">
                                <div class="mb-3">
                                    <h6 class="font-semibold">{{__('邮箱')}}</h6>
                                    <span>
                                            <a href="#" class="__cf_email__">{{$user->email}}</a>
                                        </span>
                                </div>
                            </div>
                            <div class="col-span-4">
                                <div class="mb-3">
                                    <h6 class="font-semibold">{{__('性别')}}</h6>
                                    <span>{{$user->gender_text}}</span>
                                </div>
                            </div>
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
