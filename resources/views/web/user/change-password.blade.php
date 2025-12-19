<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>

<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <x-web.user.breadcrumb title="Settings"/>

    <div class="content">
        <div class="container">

            <x-web.user.profile :user="$user"/>

            <div class="row">

                <x-web.user.sidebar active="settings"/>

                <div class="col-lg-9">
                    <div class="mb-3">
                        <h5>Settings</h5>
                    </div>

                    <ul class="settings-nav d-flex align-items-center flex-wrap border bg-light-900 rounded">
                        <li><a href="{{route('user.settings.html')}}">Edit Profile</a></li>
                        <li><a href="{{route('user.change-password.html')}}" class="active">Security</a></li>
                    </ul>
                    <div class="card mb-0">
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
