<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/select2/css/select2.min.css')}}">
<x-admin.head/>
<script src="{{web_resource_url('assets/admin/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/validation.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{web_resource_url('assets/js/md5.js') }}"></script>
<style>
    .email {
        width: 200px;
    }

    .full-name {
        width: 60px;
    }
</style>
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

                        <div>
                            <a href="javascript:void(0);" id="export" class="btn btn-secondary">{{__('导出')}}</a>
                        </div>
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
                            <tr id="field-list">
                                <th data-field="email">{{__('邮箱')}}</th>
                                <th data-field="full_name">{{__('姓名')}}</th>
                                <th>{{__('性别')}}</th>
                                <th data-field="created_at" data-sort="desc">{{__('注册时间')}}</th>
                                <th>{{__('课程')}}</th>
                                <th data-field="status">{{__('状态')}}</th>
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

    @include('admin.user.new')

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
                    <td><p class="fs-14 email text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="${item.email}">${item.email}</p></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);"
                               class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                <img src="${item.avatar}" alt="${item.full_name}">
                            </a>
                            <a href="javascript:void(0);">
                                <p class="fs-14 full-name text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="${item.full_name}">${item.full_name}</p>
                            </a>
                        </div>
                    </td>
                    <td>${item.gender_text}</td>
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
                            <a href="javascript:void(0);"
                               class="d-inline-flex fs-14 action-icon text-danger"
                               onclick="handleDelete(${item.id}, '${item.full_name}')"
                               title="{{__('删除')}}">
                                <i class="isax isax-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });

        tbody.find('[data-bs-toggle="tooltip"]').each(function () {
            const el = this;
            const title = el.getAttribute('data-bs-title');
            if (title == null || title === '') return;
            const existing = bootstrap.Tooltip.getInstance(el);
            if (existing) existing.dispose();
            new bootstrap.Tooltip(el);
        });
    }

    function handleDelete(id, name) {
        const deleteMessage = '{{__('确定要删除用户:name吗？')}}'.replace(':name', `"${name}"`);
        confirm_alert(deleteMessage, "{{__('此操作不可恢复！')}}", 'Yes!')
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();

                    let url = `/admin/parent/${id}.html`
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

        $('#form-modal').on('hidden.bs.modal', function () {
            const uploaded = $(this).data('uploaded');
            if (uploaded) {
                getData(currentPage, {keyword: searchKeyword});
            }
        });

        $('#export').click(function () {
            showLoading()

            $.ajax({
                url: "{{route('admin.parent.export.html')}}",
                data: {keyword: searchKeyword},
                dataType: "json",
                success: function (response) {
                    if (response.code !== 0) {
                        showToast('error', response.msg);
                        return;
                    }

                    window.open(response.data.url);
                },
                error: function () {
                    showToast('error', '{{__('加载失败，请稍后重试！')}}');
                },
                complete: function () {
                    hideLoading();
                }
            });
        })

    })
</script>
</html>
