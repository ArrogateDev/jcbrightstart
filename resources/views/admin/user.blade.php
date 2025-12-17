<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/select2/css/select2.min.css')}}">
<x-admin.head/>
<script src="{{web_resource_url('assets/admin/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/admin/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/admin/js/validation.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/admin/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{web_resource_url('assets/admin/js/md5.js') }}"></script>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{$active === 'users' ?__('老师管理') : __('家长管理')}}"/>

    <div class="content">
        <div class="container">
            <div class="row">

                <x-admin.sidebar active="{{$active}}"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold">{{$active === 'users' ?__('老师管理') : __('家长管理')}}</h5>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <div class="input-icon mb-3">
									<span class="input-icon-addon">
										<i class="isax isax-search-normal-14"></i>
									</span>
                                <input type="email" class="form-control form-control-md" placeholder="Search">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive custom-table">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>{{__('邮箱')}}</th>
                                <th>{{__('姓名')}}</th>
                                <th>{{__('性别')}}</th>
                                <th>{{__('年龄')}}</th>
                                <th>{{__('注册时间')}}</th>
                                <th>{{__('课程')}}</th>
                                <th>{{__('状态')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="table-body"></tbody>
                        </table>
                    </div>

                    <x-admin.table-data url="{{route($active === 'teacher' ? 'admin.teacher.list.html' : 'admin.parent.list.html')}}"/>

                </div>

            </div>
        </div>
    </div>

    <x-admin.footer/>

    <x-layouts.modal id="form-modal" title="{{$active === 'users' ?__('编辑老师') : __('编辑家长')}}" class="modal-lg" form="true" form-id="form">

        <div class="mb-3">
            <label class="form-label" for="first-name">
                {{__('姓')}}
                <span class="text-danger ms-1">*</span>
                <span class="error-container" id="error-container-first-name"></span>
            </label>
            <input id="first-name" type="text" class="form-control" name="first_name" placeholder="{{__('姓')}}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="last-name">
                {{__('名')}}
                <span class="text-danger ms-1">*</span>
                <span class="error-container" id="error-container-last-name"></span>
            </label>
            <input id="last-name" type="text" class="form-control" name="last_name" placeholder="{{__('名')}}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">
                {{__('邮箱')}}
                <span class="text-danger ms-1">*</span>
                <span class="error-container" id="error-container-email"></span>
            </label>
            <input id="email" type="text" class="form-control" name="email" placeholder="{{__('邮箱')}}">
        </div>
        <div class="mb-3 position-relative">
            <label class="form-label">Gender
                <span class="text-danger ms-1">*</span>
                <span class="error-container" id="error-container-gender"></span>
            </label>
            <select id="gender" class="select" name="gender">
                <option value="1">Male</option>
                <option value="0">Female</option>
            </select>
        </div>
        <div class="mb-3 position-relative">
            <label class="form-label">Age
                <span class="text-danger ms-1">*</span>
                <span class="error-container" id="error-container-age"></span>
            </label>
            <select id="age" class="select" name="age">
                @foreach($ages as $age=>$value)
                    <option @selected($user->age === $age) value="{{$age}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 position-relative">
            <label class="form-label">New Password
                <span class="text-danger ms-1">*</span>
                <span class="error-container" id="error-container-password"></span>
            </label>
            <div class="position-relative" id="passwordInput">
                <input id="password" type="password" name="password" class="pass-inputs form-control">
                <span class="isax toggle-passwords isax-eye-slash text-gray-7 fs-14"></span>
            </div>
            <div class="password-strength" id="passwordStrength">
                <span id="poor"></span>
                <span id="weak"></span>
                <span id="strong"></span>
                <span id="heavy"></span>
            </div>
            <div class="mt-2 fs-14" id="passwordInfo">
                Use upper & lower case letters, numbers, symbols and 8+ characters.
            </div>
        </div>
        <div class="mb-3 position-relative">
            <label class="form-label">Confirm Password
                <span class="text-danger ms-1">*</span>
                <span class="error-container" id="error-container-password-confirmation"></span>
            </label>
            <div class="position-relative">
                <input id="password-confirmation" type="password" name="password_confirmation" class="pass-inputa form-control form-control-lg">
                <span class="isax toggle-passworda isax-eye-slash text-gray-7 fs-14"></span>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label mb-1">
                {{__('状态')}}
                <span class="text-danger ms-1">*</span>
            </label>
            <div class="d-flex align-items-center ">
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="status"
                           id="status-normal" value="0" checked>
                    <label class="form-check-label" for="status-normal">
                        {{__('正常')}}
                    </label>
                </div>
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="status"
                           id="status-disabled" value="1">
                    <label class="form-check-label" for="status-disabled">
                        {{__('禁用')}}
                    </label>
                </div>
            </div>
            <div id="error-container-status" class="mt-1"></div>
        </div>

        <x-slot:footer>
            <button class="btn bg-gray-100 rounded-pill me-2" type="button"
                    data-bs-dismiss="modal">{{__('取消')}}
            </button>
            <button class="btn btn-secondary rounded-pill" type="submit">{{__('提交')}}</button>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="edit-id">
        </x-slot:footer>
    </x-layouts.modal>

</div>

</body>

<script>
    let currentPage = 1;
    let searchKeyword = '';

    function renderTable(list) {
        const tbody = $('#table-body');
        tbody.empty();
        if (!list || list.length === 0) return;

        list.forEach(function (item) {
            const statusBadge = item.status === 0
                ? '<span class="badge bg-success-transparent">{{__('启用')}}</span>'
                : '<span class="badge bg-danger-transparent">{{__('禁用')}}</span>';

            const row = `
                <tr>
                    <td><span class="text-primary">#${item.id}</span></td>
                    <td>${item.email}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);"
                               class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                <img src="${item.avatar}" alt="${item.full_name}">
                            </a>
                            <a href="javascript:void(0);">
                                <p class="fs-14">${item.full_name}</p>
                            </a>
                        </div>
                    </td>
                    <td>${item.gender_text}</td>
                    <td>${item.age_text}</td>
                    <td>${item.created_at}</td>
                    <td>0</td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);"
                               class="d-inline-flex fs-14 me-2 action-icon text-primary"
                               data-bs-toggle="modal"
                               data-bs-target="#form-modal"
                               data-item='${JSON.stringify(item)}'
                               title="{{__('编辑')}}">
                                <i class="isax isax-edit"></i>
                            </a>
                            ${item.id !== 1 ? `
                            <a href="javascript:void(0);"
                               class="d-inline-flex fs-14 action-icon text-danger"
                               onclick="handleDelete(${item.id}, '${item.full_name}')"
                               title="{{__('删除')}}">
                                <i class="isax isax-trash"></i>
                            </a>
                            ` : ''}
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    function handleDelete(id, name) {
        const deleteMessage = '{{__('确定要删除用户:name吗？')}}'.replace(':name', `"${name}"`);
        confirm_alert(deleteMessage, "{{__('此操作不可恢复！')}}", 'Yes!')
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();

                    let url = $active === 'teacher' ? `/admin/teacher/${id}.html` : `/admin/parent/${id}.html`
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.code !== 0) {
                                showToast('error', response.msg);
                                return;
                            }
                            showToast('success', '{{__('删除成功')}}');
                            getData(currentPage, {keyword: searchKeyword});
                        },
                        error: function () {
                            showToast('error', '{{__('操作失败，请稍后再试！')}}');
                        },
                        complete: function () {
                            hideLoading();
                        }
                    });
                }
            })
    }

    $(function () {

        getData(1);

        let searchInput = $('#search-input');
        searchInput.on('input', _.debounce(function () {
            const keyword = $(this).val().trim();
            searchKeyword = keyword;
            getData(1, {keyword});
        }, 150));

        searchInput.on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                getData(1, {keyword: searchKeyword});
            }
        });

        const validator = new window.JustValidate('#form', {
            errorLabelCssClass: 'd-inline',
        });
        validator
            .addField('#first-name', [
                {
                    rule: 'required',
                    errorMessage: '{{__('姓不能为空')}}'
                }
            ], {
                errorsContainer: '#error-container-first-name'
            })
            .addField('#last-name', [
                {
                    rule: 'required',
                    errorMessage: '{{__('名不能为空')}}'
                }
            ], {
                errorsContainer: '#error-container-last-name'
            })
            .addField('#email', [
                {
                    rule: 'required',
                    errorMessage: '{{__('邮箱不能为空')}}'
                }
            ], {
                errorsContainer: '#error-container-email'
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
            .addField('#password', [
                {
                    validator: (value, fields) => {
                        const editId = $('#edit-id').val();
                        if (editId) {
                            if (value && value.trim() !== '') {
                                return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.#?!@$%^&*-]).{8,}$/.test(value);
                            }
                            return true;
                        } else {
                            return value && value.trim() !== '';
                        }
                    },
                    errorMessage: '{{__('密码不能为空')}}'
                },
                {
                    validator: (value, fields) => {
                        if (value && value.trim() !== '') {
                            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.#?!@$%^&*-]).{8,}$/.test(value);
                        }
                        return true;
                    },
                    errorMessage: 'Use uppercase, lowercase, numbers, symbols and 8+ characters.'
                }
            ], {
                errorsContainer: '#error-container-password'
            })
            .addField('#password-confirmation', [
                {
                    validator: (value, fields) => {
                        const editId = $('#edit-id').val();
                        const password = fields['#password'] && fields['#password'].elem ? fields['#password'].elem.value : '';

                        if (editId) {
                            if (!password || password.trim() === '') {
                                return true;
                            }
                            return value === password;
                        } else {
                            if (!value || value.trim() === '') {
                                return false;
                            }
                            return value === password;
                        }
                    },
                    errorMessage: 'Password does not match',
                }
            ], {
                errorsContainer: '#error-container-password-confirmation'
            })
            .addField('input[name="status"]', [
                {
                    rule: 'required',
                    errorMessage: '{{__('请选择状态')}}'
                }
            ], {
                errorsContainer: '#error-container-status'
            })
            .onSuccess(() => {
                handleSubmit();
            });

        let $modal = $('#form-modal');

        $modal.on('show.bs.modal', function (event) {
            const button = event.relatedTarget
            const params = JSON.parse(button.getAttribute('data-item'))
            if (!params) return

            $('#edit-id').val(params.id || '');
            $('#first-name').val(params.first_name || '');
            $('#last-name').val(params.last_name || '');
            $('#email').val(params.email || '');

            if (params.gender !== undefined) {
                $('#gender').val(params.gender).trigger('change');
            }

            if (params.age !== undefined) {
                $('#age').val(params.age).trigger('change');
            }

            if (params.status !== undefined) {
                $(`input[name="status"][value="${params.status}"]`).prop('checked', true);
            }
        });

        $modal.on('hidden.bs.modal', function () {
            resetForm();
        });

        function resetForm() {
            $('#form')[0].reset();
            $('#edit-id').val('');

            $('.error-container').empty();
            $('#form .is-invalid, #form .is-valid').removeClass('is-invalid is-valid');

            $('#gender').val('').trigger('change');
            $('#age').val('').trigger('change');

            if (validator) {
                validator.refresh();
            }
        }

        function handleSubmit() {
            showLoading()

            let form = $('#form').serializeArray()
            const editId = $('#edit-id').val();
            form = form.map(item => {
                if (item.value !== '' && (item.name === 'password' || item.name === 'password_confirmation')) {
                    item.value = md5(md5(item.value))
                }
                return item
            })

            let url;
            @if($active === 'teacher')
                url = '{{route('admin.teacher.update.html', ['user' => ':id'])}}'.replace(':id', editId);
            @else
                url = '{{route('admin.parent.update.html', ['user' => ':id'])}}'.replace(':id', editId);
            @endif
            let method = 'PUT';

            $.ajax({
                url: url,
                type: method,
                data: form,
                dataType: "json",
                success: function (data) {
                    if (data.code !== 0) {
                        showToast('error', data.msg);
                        return;
                    }

                    showToast('success', editId ? '{{__('更新成功')}}' : '{{__('创建成功')}}');
                    $('#form-modal').modal('hide');
                    getData(currentPage, {keyword: searchKeyword});
                }, error: function () {
                    showToast('error', '{{__('操作失败，请稍后再试！')}}')
                }, complete: function () {
                    hideLoading()
                }
            });
        }
    })
</script>
</html>
