<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>

<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <x-web.user.breadcrumb title="{{__('我的资料')}}"/>

    <div class="content">
        <div class="container">

            <x-web.user.profile :user="$user"/>

            <div class="row">

                <x-web.user.sidebar active="profile"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold">{{__('我的资料')}}</h5>
                        <a href="{{route('user.settings.html')}}" class="edit-profile-icon"><i class="isax isax-edit-2"></i></a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="fs-18 pb-3 border-bottom mb-3">{{__('基本信息')}}</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>{{__('姓')}}</h6>
                                        <span>{{$user->first_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>{{__('名')}}</h6>
                                        <span>{{$user->last_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>{{__('注册时间')}}</h6>
                                        <span>{{$user->registration_date}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>{{__('邮箱')}}</h6>
                                        <span>
                                            <a href="#" class="__cf_email__">{{$user->email}}</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>{{__('性别')}}</h6>
                                        <span>{{$user->gender_text}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-web.user.footer/>

</div>

</body>

</html>
