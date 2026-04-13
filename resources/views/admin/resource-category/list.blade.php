<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/select2/css/select2.min.css')}}">
<x-admin.head/>
<script src="{{web_resource_url('assets/admin/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/validation.js')}}" type="text/javascript"></script>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('专业学习社群领域')}}"/>

    <div class="content">
        <div class="container">
            <div class="row">

                <x-admin.sidebar active="resource-category"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold">{{__('专业学习社群领域')}}</h5>
                        <div>
                            <a href="#" class="btn btn-secondary" data-bs-toggle="modal"
                               data-bs-target="#form-modal">{{ __('新增领域')}}</a>
                        </div>
                    </div>
                    <div class="p-0">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{__('名称')}}</th>
                                <th>{{__('上级')}}</th>
                                <th>{{__('状态')}}</th>
                                <th>{{__('创建时间')}}</th>
                                <th>{{__('操作')}}</th>
                            </tr>
                            </thead>
                            <tbody id="table-body"></tbody>
                        </table>
                        <x-admin.table-data url="{{route('admin.resource-category.list.html')}}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

    @include('admin.resource-category.new')

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
                    <td>
                        <p class="fs-14 mb-0 fw-semibold">${item.title}</p>
                    </td>
                    <td>${item.parent_text}</td>
                    <td>${statusBadge}</td>
                    <td>${item.created_at}</td>
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
                               onclick="handleDelete(${item.id}, '${item.title}')"
                               title="{{__('删除')}}">
                                <i class="isax isax-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    function handleDelete(id, name) {
        const deleteMessage = '{{__('确定要删除领域:name吗？')}}'.replace(':name', `"${name}"`);
        confirm_alert(deleteMessage, "{{__('此操作不可恢复！')}}", 'Yes!')
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();

                    $.ajax({
                        url: `/admin/resource/category/${id}.html`,
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
                            if (typeof getData === 'function') {
                                getData(currentPage, {keyword: searchKeyword});
                            } else {
                                location.reload();
                            }
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

        $('#form-modal').on('hidden.bs.modal', function () {
            const uploaded = $(this).data('uploaded');
            if (uploaded) {
                getData(currentPage, {keyword: searchKeyword});
            }
        });
    });
</script>

</html>
