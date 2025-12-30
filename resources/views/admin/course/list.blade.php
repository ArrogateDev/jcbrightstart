<!DOCTYPE html>
<html lang="en">

<x-admin.head/>
<style>
    .status-tag {
        cursor: pointer;
    }
</style>
<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('课程管理')}}"/>

    <div class="content">
        <div class="container">

            <div class="row">

                <x-admin.sidebar active="course"/>

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-xxl col-lg-4 col-md-6">
                            <div class="card bg-success">
                                <div class="card-body">
                                    <h6 class="fw-medium mb-1 text-white">Published Courses</h6>
                                    <h4 class="fw-bold text-white">{{$courses[2]??0}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl col-lg-4 col-md-6">
                            <div class="card bg-secondary">
                                <div class="card-body">
                                    <h6 class="fw-medium mb-1 text-white">Suspensed Courses</h6>
                                    <h4 class="fw-bold text-white">{{$courses[1]??0}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl col-lg-4 col-md-6">
                            <div class="card bg-info">
                                <div class="card-body">
                                    <h6 class="fw-medium mb-1 text-white">Draft Courses</h6>
                                    <h4 class="fw-bold text-white">{{$courses[0]??0}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold">Courses</h5>

                        <div>
                            <a href="{{route('admin.course.store.view.html')}}" class="btn btn-secondary">{{__('添加课程')}}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <div class="dropdown">
                                    <a href="javascript:void(0);"
                                       class="dropdown-toggle text-gray-6 btn rounded border d-inline-flex align-items-center"
                                       data-bs-toggle="dropdown" aria-expanded="false" id="statusDropdown">
                                        <span id="selected-status-text">All Status</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end p-3">
                                        <li>
                                            <a href="javascript:void(0);"
                                               class="dropdown-item rounded-1 status-option" data-status="-1">All Status</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);"
                                               class="dropdown-item rounded-1 status-option" data-status="2">Published</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);"
                                               class="dropdown-item rounded-1 status-option" data-status="1">Suspensed</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);"
                                               class="dropdown-item rounded-1 status-option" data-status="0">Draft</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
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
                                <th data-field="id">ID</th>
                                <th data-field="name">Name</th>
                                <th>Students</th>
                                <th>Ratings</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="table-body"></tbody>
                        </table>
                    </div>

                    <x-admin.table-data url="{{route('admin.course.list.html')}}"/>

                </div>
            </div>
        </div>
    </div>

    <x-admin.footer/>

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
                ? `<span data-id="${item.id}" data-status="${item.status}" class="status-tag badge badge-sm bg-info d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>Draft</span>`
                : item.status === 1
                    ? `<span data-id="${item.id}" data-status="${item.status}" class="status-tag badge badge-sm bg-secondary d-inline-flex align-items-center me-1""><i class="fa-solid fa-circle fs-5 me-1"></i>Suspensed</span>`
                    : `<span data-id="${item.id}" data-status="${item.status}" class="status-tag badge badge-sm bg-success d-inline-flex align-items-center me-1""><i class="fa-solid fa-circle fs-5 me-1"></i>Published</span>`;

            const row = `
                    <tr>
                        <td><span class="text-primary">#${item.id}</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar avatar-lg me-2"><img
                                        class="img-fluid object-fit-cover"
                                        src="${item.thumbnail}" alt=""></a>
                                <div>
                                    <h6 class="fw-medium mb-2"><a href="javascript:void(0);">${item.title}</a></h6>
                                    <div class="d-flex align-items-center">
                                        <span class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end">
                                            <i class="isax isax-video-circle me-1 text-gray-9 fw-bold"></i>
                                            11 Lessons
                                        </span>
                                        <span class="d-inline-flex fs-12 align-items-center me-2 pe-2 border-end">
                                            <i class="isax isax-message-question me-1 text-gray-9 fw-bold"></i>
                                            2 Quizzes
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>0</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-star fs-12 filled text-warning me-1"></i>
                                <span>5.0 (0)</span>
                            </div>
                        </td>
                        <td>${statusBadge}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="${item.url}" class="d-inline-flex fs-14 me-1 action-icon">
                                    <i class="isax isax-edit-2"></i>
                                </a>
                                <a href="#" class="d-inline-flex fs-14 action-icon" onclick="handleDelete(${item.id}, '${item.title}')" title="{{__('删除')}}">
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
        const deleteMessage = '{{__('确定要删除课程:name吗？')}}'.replace(':name', `"${name}"`);
        confirm_alert(deleteMessage, "{{__('此操作不可恢复！')}}", 'Yes!')
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();

                    $.ajax({
                        url: '{{route('admin.course.destroy.html', ['course' => ':id'])}}'.replace(':id', id),
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

        $('.status-option').on('click', function () {
            const status = parseInt($(this).data('status'));
            const text = $(this).text();

            $('#selected-status-text').text(text);

            currentStatus = status;

            getData(1, {
                keyword: searchKeyword,
                status: status !== -1 ? status : undefined
            });
        });

        $(document).on('click', '.status-tag', function () {
            const id = parseInt($(this).data('id'));
            const status = parseInt($(this).data('status'));
            const statusMaps = {
                0: 2,
                1: 2,
                2: 1,
            };
            const statusTextMaps = {
                0: 'Publish',
                1: 'Publish',
                2: 'Suspend',
            };

            const message = '{{__('确定将课程改为: :status？')}}'.replace(':status', `"${statusTextMaps[status]}"`);
            confirm_alert(message, "{{__('此操作不可恢复！')}}", 'Yes!')
                .then((result) => {
                    if (result.isConfirmed) {
                        showLoading();

                        $.ajax({
                            url: '{{route('admin.course.status.html', ['course' => ':id'])}}'.replace(':id', id),
                            type: 'PUT',
                            data: {
                                status: statusMaps[status] || 0
                            },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.code !== 0) {
                                    showToast('error', response.msg);
                                    return;
                                }
                                showToast('success', '{{__('更新成功')}}');
                                getData(1, {keyword: searchKeyword});
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
        })
    })
</script>
</html>
