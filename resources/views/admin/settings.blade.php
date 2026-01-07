<!DOCTYPE html>
<html lang="en">

<x-admin.head/>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>

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
                        <li><a href="{{route('admin.settings.html')}}" class="active">Profile</a></li>
                        <li><a href="{{route('admin.change-password.html')}}">Security</a></li>
                    </ul>
                    <form id="form" novalidate="novalidate">
                        <div class="card">
                            <div class="card-body">
                                <div class="profile-upload-group">
                                    <div class="d-flex align-items-center">

                                        <x-avatar :user="$user" module="admin"/>

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
                                                <label class="form-label">Account</label>
                                                <input type="text" class="form-control" value="{{$user->account}}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                <input type="text" class="form-control" value="{{$user->role->name}}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Name
                                                    <span class="text-danger ms-1">*</span>
                                                    <span id="error-container-name"></span>
                                                </label>
                                                <input id="name" type="text" name="name" class="form-control" value="{{$user->name}}">
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

    <x-admin.footer/>

</div>

<script>
    const validator = new window.JustValidate('#form', {
        errorLabelCssClass: 'd-inline',
    });
    validator
        .addField('#name', [
            {
                rule: 'required',
            }
        ], {
            errorsContainer: '#error-container-name'
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

</body>

</html>
