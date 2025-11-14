<!DOCTYPE html>
<html lang="en">

<x-web.head/>

<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <x-web.user.breadcrumb title="My Profile"/>

    <div class="content">
        <div class="container">

            <x-web.user.profile :user="$user"/>

            <div class="row">

                <x-web.user.sidebar active="profile"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold">My Profile</h5>
                        <a href="{{route('user.settings.html')}}" class="edit-profile-icon"><i class="isax isax-edit-2"></i></a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="fs-18 pb-3 border-bottom mb-3">Basic Information</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>First Name</h6>
                                        <span>{{$user->first_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>Last Name</h6>
                                        <span>{{$user->last_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>Registration Date</h6>
                                        <span>{{$user->registration_date}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>User Name</h6>
                                        <span>instructordemo</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>Phone Number</h6>
                                        <span>89104-71829</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>Email</h6>
                                        <span>
                                            <a href="#" class="__cf_email__">{{$user->email}}</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>Gender</h6>
                                        <span>{{$user->gender_text}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <h6>Age</h6>
                                        <span>{{$user->age_text}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-web.footer/>

</div>

</body>

</html>
