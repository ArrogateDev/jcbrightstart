<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/select2/css/select2.min.css')}}">
<x-admin.head/>
<script src="{{web_resource_url('assets/admin/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('测验管理')}}"/>

    <div class="content">
        <div class="container">
            <div class="row">

                <x-admin.sidebar active="quiz"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold">{{__('测验管理')}}</h5>
                        <div>
                            <a href="#" class="btn btn-secondary" data-bs-toggle="modal"
                               data-bs-target="#form-modal">{{ __('新增测验')}}</a>
                        </div>
                    </div>
                    <div class="p-0">
                        <div id="table-body"></div>
                        <x-admin.table-data url="{{route('admin.quiz.list.html')}}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

    @include('admin.quiz.new')

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
                <div class="border rounded-2 p-3 mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div>
                                <h6 class="mb-2"><a href="javascript:void(0);">${item.title}</a></h6>
                                <div class="question-info d-flex align-items-center">
                                    <p class="d-flex align-items-center fs-14 me-2 pe-2 mb-0">
                                        <i class="isax isax-message-question5 text-primary-soft me-2"></i>
                                        ${item.question_num} {{__('问题')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-end mt-2 mt-md-0">
                                <a href="${item.result_url}" class="text-info text-decoration-underline fs-12 fw-medium me-3">
                                    View Results
                                </a>
                                <a href="#" class="d-inline-flex fs-14 me-1 action-icon" data-bs-toggle="modal" data-bs-target="#form-modal"
                                   data-item='${JSON.stringify(item)}'><i class="isax isax-edit-2"></i></a>
                                <a href="#" class="d-inline-flex fs-14 action-icon" onclick="handleDelete(${item.id}, '${item.title}')"
                                   title="{{__('删除')}}"><i class="isax isax-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            tbody.append(row);
        });
    }

    function handleDelete(id, name) {
        const deleteMessage = '{{__('确定要删除测验:name吗？')}}'.replace(':name', `"${name}"`);
        confirm_alert(deleteMessage, "{{__('此操作不可恢复！')}}", 'Yes!')
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();

                    $.ajax({
                        url: `/admin/quiz/${id}.html`,
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

<style>
    #table-body tr, #table-body td {
        display: block;
        width: 100%;
    }
</style>

</html>
