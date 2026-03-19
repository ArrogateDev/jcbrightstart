<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>

<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <div class="content">
        <div class="container">

            <x-web.user.profile :user="$user"/>

            <div class="row">

                <x-web.user.sidebar active="settings"/>

                <div class="col-lg-9">

                    <x-web.user.breadcrumb title="{{__('设置')}}"/>

                    <div class="mb-3">
                        <h5>{{__('设置')}}</h5>
                    </div>

                    <ul class="settings-nav d-flex align-items-center flex-wrap border bg-light-900 rounded j-user-box">
                        <li class="ms-3"><a href="{{route('user.settings.html')}}">{{__('修改资料')}}</a></li>
                        <li><a href="{{route('user.change-password.html')}}" class="active">{{__('修改密码')}}</a></li>
                    </ul>
                    <div class="card mb-0 j-user-box">
                        <div class="card-body">
                            <div class="border-bottom mb-4 pb-4">

                                <x-change-password module="web"/>

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
