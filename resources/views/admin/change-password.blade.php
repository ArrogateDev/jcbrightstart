<!DOCTYPE html>
<html lang="en">

<x-admin.head/>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="Settings"/>

    <div class="content">
        <div class="container">

            <div class="row">

                <x-admin.sidebar active="settings"/>

                <div class="col-lg-9">
                    <div class="mb-3">
                        <h5>Settings</h5>
                    </div>

                    <ul class="settings-nav d-flex align-items-center flex-wrap border bg-light-900 rounded">
                        <li><a href="{{route('admin.settings.html')}}">Profile</a></li>
                        <li><a href="{{route('admin.change-password.html')}}" class="active">Security</a></li>
                    </ul>
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="border-bottom mb-4 pb-4">

                                <x-change-password active="Settings"/>

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
