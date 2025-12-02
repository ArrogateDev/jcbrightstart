<!DOCTYPE html>
<html lang="en">

<x-admin.head/>
<script src="{{web_resource_url('assets/js/fabric.min.js')}}" type="text/javascript"></script>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('证书管理')}}"/>

    <div class="content">
        <div class="container">
            <div class="row">

                <x-admin.sidebar active="certificate"/>

                <div class="col-lg-9">
                    <div class="certificate">
                        <div class="page-title d-flex align-items-center justify-content-between">
                            <h5>{{__('证书管理')}}</h5>
                            <div>
                                <a href="#" class="btn btn-secondary d-flex align-items-center"
                                   data-bs-toggle="modal" data-bs-target="#form-modal">
                                    <i class="isax isax-add-circle me-1"></i>{{ __('新增证书')}}
                                </a>
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="row" id="table-body"></div>

                            <x-admin.table-data url="{{route('admin.certificate.list.html')}}"/>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

    @include('admin.certificate.new')

    @include('admin.certificate.show')

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
            const row = `
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#view_certificate">
                                    <img class="img-fluid rounded" src="${item.path}" alt="img" style="height: 200px;">
                                </a>
                            </div>
                            <div class="d-flex align-items-center flex-wrap justify-content-between gap-2">
                                <h6>${item.name}</h6>
                                <ul class="edit-delete-icon d-flex align-items-center">
                                    <li>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#show-modal"
                                           data-item='${JSON.stringify(item)}'>
                                            <i class="isax isax-eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#form-modal"
                                           data-item='${JSON.stringify(item)}'>
                                            <i class="isax isax-edit-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="handleDelete(${item.id}, '${item.name}')"
                                           title="{{__('删除')}}">
                                            <i class="isax isax-trash"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            tbody.append(row);
        });
    }

    function handleDelete(id, name) {
        const deleteMessage = '{{__('确定要删除证书模板:name吗？')}}'.replace(':name', `"${name}"`);
        confirm_alert(deleteMessage, "{{__('此操作不可恢复！')}}", 'Yes!')
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();

                    $.ajax({
                        url: `/admin/certificate/${id}.html`,
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
    });
</script>

<style>
    #table-body tr, #table-body td {
        display: block;
        width: 100%;
    }
</style>

</html>
