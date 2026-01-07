<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>

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
                        <li><a href="{{route('user.settings.html')}}" class="active">Edit Profile</a></li>
                        <li><a href="{{route('user.change-password.html')}}">Security</a></li>
                    </ul>
                    <form id="form" novalidate="novalidate">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-upload-group">
                                    <div class="d-flex align-items-center">

                                        <x-avatar :user="$user" module="user"/>

                                    </div>
                                </div>
                                <div>
                                    <div class="edit-profile-info mb-3">
                                        <h5 class="mb-1 fs-18">Personal Details</h5>
                                        <p>Edit your personal information</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    First Name
                                                    <span class="text-danger ms-1">*</span>
                                                    <span id="error-container-first-name"></span>
                                                </label>
                                                <input id="first-name" type="text" name="first_name" class="form-control" value="{{$user->first_name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Last Name
                                                    <span class="text-danger ms-1">*</span>
                                                    <span id="error-container-last-name"></span>
                                                </label>
                                                <input id="last-name" type="text" name="last_name" class="form-control" value="{{$user->last_name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">User Name
                                                    <span class="text-danger ms-1">*</span>
                                                    <span id="error-container-name"></span>
                                                </label>
                                                <input type="text" class="form-control" value="instructordemo">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Phone Number
                                                    <span class="text-danger ms-1">*</span>
                                                    <span id="error-container-name"></span>
                                                </label>
                                                <input type="text" class="form-control" value="90154-91036">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Gender
                                                    <span class="text-danger ms-1">*</span>
                                                    <span id="error-container-gender"></span>
                                                </label>
                                                <select id="gender" class="select" name="gender">
                                                    <option @selected($user->gender === 1) value="1">Male</option>
                                                    <option @selected($user->gender === 0) value="0">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-secondary rounded-pill" type="submit">Update
                                                Profile
                                            </button>
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
    </div>

    <x-web.user.footer/>

</div>

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
        .addField('#age', [
            {
                rule: 'required',
            }
        ], {
            errorsContainer: '#error-container-age'
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
