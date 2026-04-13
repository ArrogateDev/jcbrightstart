<!DOCTYPE html>
<html lang="en">

<x-admin.head/>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('设置')}}"/>

    <div class="content">
        <div class="container">

            <div class="row">

                <x-admin.sidebar active="settings"/>

                <div class="col-lg-9">
                    <div class="mb-3">
                        <h5>{{__('设置')}}</h5>
                    </div>

                    <ul class="settings-nav d-flex align-items-center flex-wrap border bg-light-900 rounded">
                        <li><a href="{{route('admin.settings.html')}}">{{__('修改资料')}}</a></li>
                        <li><a href="{{route('admin.change-password.html')}}" class="active">{{__('修改密码')}}</a></li>
                    </ul>
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="border-bottom mb-4 pb-4">

                                <x-change-password module="admin"/>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

</div>

</body>

</html>
