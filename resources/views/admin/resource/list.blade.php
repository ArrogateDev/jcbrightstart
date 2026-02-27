<!DOCTYPE html>
<html lang="en">

<x-admin.head/>
<style>
    .status-tag {
        cursor: pointer;
    }

    .title {
        width: 200px;
    }
</style>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('专业学习社群')}}"/>

    <div class="content">
        <div class="container">
            <div class="row">

                <x-admin.sidebar active="resource"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold">{{__('专业学习社群')}}</h5>

                        <div>
                            <a href="{{route('admin.resource.store.view.html')}}" class="btn btn-secondary">{{__('新增资源')}}</a>
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
                                <th data-field="title">{{__('标题')}}</th>
                                <th>{{__('分类')}}</th>
                                <th data-field="status">{{__('状态')}}</th>
                                <th data-field="created_at" data-sort="desc">{{__('创建时间')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="table-body"></tbody>
                        </table>
                    </div>

                    <x-admin.table-data url="{{route('admin.resource.list.html')}}"/>

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
                ? `<span data-bs-toggle="dropdown" aria-expanded="false" class="status-tag badge badge-sm bg-info d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>{{__('草稿')}}</span>`
                : item.status === 1
                    ? `<span data-bs-toggle="dropdown" aria-expanded="false" class="status-tag badge badge-sm bg-secondary d-inline-flex align-items-center me-1""><i class="fa-solid fa-circle fs-5 me-1"></i>{{__('暂停')}}</span>`
                    : `<span data-bs-toggle="dropdown" aria-expanded="false" class="status-tag badge badge-sm bg-success d-inline-flex align-items-center me-1""><i class="fa-solid fa-circle fs-5 me-1"></i>{{__('发表')}}</span>`;

            const statusOptions = [
                { value: 0, label: '{{__('草稿')}}' },
                { value: 1, label: '{{__('暂停')}}' },
                { value: 2, label: '{{__('发表')}}' }
            ];

            const statusMenuItems = statusOptions
                .filter(option => option.value !== item.status)
                .map(option => `<li><a class="dropdown-item" data-id="${item.id}" data-o-status="${item.status}" data-status="${option.value}" href="#">${option.label}</a></li>`)
                .join('');

            const statusMenu = `<div class="dropdown dropend">
                ${statusBadge}
                <ul class="dropdown-menu">
                    ${statusMenuItems}
                </ul>
            </div>`

            const row = `
                <tr>
                    <td><p class="fs-14 title text-truncate" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="${item.title}">${item.title}</p></td>
                    <td>${item.category_text}</td>
                    <td>${statusMenu}</td>
                    <td>${item.created_at}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="${item.url}" class="d-inline-flex fs-14 me-1 action-icon">
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
        const deleteMessage = '{{__('确定要删除资源:name吗？')}}'.replace(':name', `"${name}"`);
        confirm_alert(deleteMessage, "{{__('此操作不可恢复！')}}", 'Yes!')
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();

                    let url = `/admin/resource/${id}.html`
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

        $(document).on('click', '#table-body .dropdown-item', function () {
            const id = parseInt($(this).data('id'));
            const status = parseInt($(this).data('status'));
            const statusText = $(this).text();

            const message = '{{__('确定将资源改为: :status？')}}'.replace(':status', `"${statusText}"`);
            confirm_alert(message, "{{__('此操作不可恢复！')}}", 'Yes!')
                .then((result) => {
                    if (result.isConfirmed) {
                        showLoading();

                        $.ajax({
                            url: '{{route('admin.resource.status.html', ['resource' => ':id'])}}'.replace(':id', id),
                            type: 'PUT',
                            data: {
                                status: status || 0
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
