<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="{{web_resource_url('assets/plugins/select2/css/select2.min.css')}}">
<x-admin.head/>
<script src="{{web_resource_url('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{web_resource_url('assets/plugins/jstree/themes/default/style.min.css')}}"/>
<script src="{{web_resource_url('assets/plugins/jstree/jstree.min.js')}}"></script>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>

<body>

<div class="main-wrapper">

    <x-admin.header/>

    <x-admin.breadcrumb title="{{__('角色管理')}}"/>

    <div class="content">
        <div class="container">
            <div class="row">

                <x-admin.sidebar active="role"/>

                <div class="col-lg-9">
                    <div class="page-title d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold">{{__('角色管理')}}</h5>

                        <div>
                            <a href="#" class="btn btn-secondary" data-bs-toggle="modal"
                               data-bs-target="#form-modal">{{__('添加角色')}}</a>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <i class="isax isax-search-normal-14"></i>
                                </span>
                                <input type="text" id="search-input" class="form-control form-control-md" placeholder="{{__('搜索角色名称')}}">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive custom-table">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>{{__('角色名称')}}</th>
                                <th>{{__('级别')}}</th>
                                <th>{{__('上级')}}</th>
                                <th>{{__('状态')}}</th>
                                <th>{{__('创建时间')}}</th>
                                <th>{{__('操作')}}</th>
                            </tr>
                            </thead>
                            <tbody id="table-body"></tbody>
                        </table>
                    </div>

                    <x-admin.table-data url="{{route('admin.role.list.html')}}"/>

                </div>

            </div>
        </div>
    </div>

    <x-admin.footer/>

    <x-layouts.modal id="form-modal" title="{{__('添加角色')}}" class="modal-lg" form="true" form-id="form">
        <div class="mb-3">
            <label class="form-label" for="name">
                {{__('名称')}}
                <span class="text-danger ms-1">*</span>
                <span id="error-container-name"></span>
            </label>
            <input id="name" type="text" class="form-control" name="name" placeholder="{{__('名称')}}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="pid">
                {{__('上级')}}
                <span class="text-danger ms-1">*</span>
                <span id="error-container-pid"></span>
            </label>
            <select id="pid" class="select" name="pid">
                <option value="">{{__('请选择上级')}}</option>
                @foreach($superiors as $superior)
                    <option value="{{$superior->value}}">{{$superior->label}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="nodes">
                {{__('权限')}}
                <span class="text-danger ms-1">*</span>
                <span id="error-container-nodes"></span>
            </label>
            <div class="tree-container overflow-auto" id="node-tree" style="max-height: 300px;"></div>
        </div>
        <div class="mb-3">
            <label class="form-label mb-1">
                {{__('状态')}}
                <span class="text-danger ms-1">*</span>
                <span id="error-container-status"></span>
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
        </div>

        <x-slot:footer>
            <button class="btn bg-gray-100 rounded-pill me-2" type="button"
                    data-bs-dismiss="modal">{{__('取消')}}
            </button>
            <button class="btn btn-secondary rounded-pill" type="submit" id="submit-btn">{{__('提交')}}</button>
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
                    <td>
                        <p class="fs-14 mb-0 fw-semibold">${item.name}</p>
                    </td>
                    <td>${item.level || '-'}</td>
                    <td>${item.superior_name}</td>
                    <td>${statusBadge}</td>
                    <td>${item.created_at}</td>
                    <td>
                        <div class="d-flex align-items-center">
                           ${item.id !== 1 ? `
                            <a href="javascript:void(0);"
                               class="d-inline-flex fs-14 me-2 action-icon text-primary edit-btn"
                               data-bs-toggle="modal"
                               data-bs-target="#form-modal"
                               data-item='${JSON.stringify(item)}'
                               title="{{__('编辑')}}">
                                <i class="isax isax-edit"></i>
                            </a>` : ''}
                            ${item.id !== 1 ? `
                            <a href="javascript:void(0);"
                               class="d-inline-flex fs-14 action-icon text-danger"
                               onclick="handleDelete(${item.id}, '${item.name}')"
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
        const deleteMessage = '{{__('确定要删除角色:name吗？')}}'.replace(':name', `"${name}"`);
        confirm_alert(deleteMessage, "{{__('此操作不可恢复！')}}", 'Yes!')
            .then((result) => {
                if (result.isConfirmed) {
                    showLoading();

                    $.ajax({
                        url: `/admin/system/role/${id}.html`,
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

        let $nodeTree = $('#node-tree');
        $nodeTree.jstree({
            'core': {
                'data': {!! $nodes !!},
                'themes': {
                    'responsive': true,
                    'variant': 'large',
                    'icons': false
                }
            },
            'plugins': ['checkbox'],
            'checkbox': {
                'keep_selected_style': false,
                'three_state': true,
                'whole_node': false,
                'tie_selection': false
            }
        });

        let isUpdating = false;

        $nodeTree.on('check_node.jstree', function (e, data) {
            if (isUpdating) return;

            isUpdating = true;
            var instance = data.instance;
            var node = data.node;

            if (node.children && node.children.length > 0) {
                instance.check_node(node.children);
            }

            isUpdating = false;
        });

        $nodeTree.on('uncheck_node.jstree', function (e, data) {
            if (isUpdating) return;

            isUpdating = true;
            var instance = data.instance;
            var node = data.node;

            if (node.children && node.children.length > 0) {
                instance.uncheck_node(node.children);
            }

            checkParentState(instance, node);

            isUpdating = false;
        });

        function checkParentState(instance, node) {
            if (isUpdating) {
                return;
            }

            var parent = instance.get_node(node.parent);

            if (parent && parent.id !== '#') {
                var allChildrenSelected = true;
                var someChildrenSelected = false;

                $.each(parent.children, function (index, childId) {
                    var childNode = instance.get_node(childId);
                    if (instance.is_checked(childId)) {
                        someChildrenSelected = true;
                    } else {
                        allChildrenSelected = false;
                    }
                });

                isUpdating = true;

                if (allChildrenSelected) {
                    instance.check_node(parent);
                } else if (someChildrenSelected) {
                    instance.set_undetermined(parent, true);
                } else {
                    instance.uncheck_node(parent);
                }

                isUpdating = false;

                checkParentState(instance, parent);
            }
        }

        const validator = new window.JustValidate('#form', {
            errorLabelCssClass: 'd-inline',
        });
        validator
            .addField('#name', [
                {
                    rule: 'required',
                    errorMessage: '{{__('名称不能为空')}}'
                }
            ], {
                errorsContainer: '#error-container-name'
            })
            .addField('#pid', [
                {
                    rule: 'required',
                    errorMessage: '{{__('请选择上级')}}'
                }
            ], {
                errorsContainer: '#error-container-pid'
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
                const instance = $nodeTree.jstree(true);
                const $nodeError = $('#error-container-nodes');
                if (!instance) {
                    $nodeError.html('<span class="text-danger small">{{__('权限树未初始化')}}</span>');
                    return;
                }

                const selected = instance.get_checked(true);

                if (!selected || selected.length === 0) {
                    $nodeError.html('<span class="text-danger small">{{__('请至少选择一个权限')}}</span>');
                    const $modal = $('#form-modal');
                    $modal.animate({
                        scrollTop: $('#node-tree').offset().top - 100
                    }, 300);
                    return;
                }

                $nodeError.empty();
                handleSubmit(selected);
            });


        let $modal = $('#form-modal');

        $modal.on('show.bs.modal', function (event) {
            const button = event.relatedTarget
            const params = JSON.parse(button.getAttribute('data-item'))
            if (!params) return

            $modal.find('.modal-header h5').text('{{__('编辑角色')}}');
            $('#edit-id').val(params.id || '');
            $('#name').val(params.name || '');

            if (params.pid !== undefined) {
                $('#pid').val(params.pid).trigger('change');
            }

            if (params.status !== undefined) {
                $(`input[name="status"][value="${params.status}"]`).prop('checked', true);
            }

            const nodes = params.nodes || [];
            if (Array.isArray(nodes) && nodes.length > 0) {
                setTimeout(() => {
                    const instance = $nodeTree.jstree(true);
                    if (instance) {
                        instance.uncheck_all();
                        const nodeIds = nodes.map(id => String(id));
                        instance.check_node(nodeIds);
                    }
                }, 200);
            } else {
                const instance = $nodeTree.jstree(true);
                if (instance) {
                    instance.uncheck_all();
                }
            }
        });

        $modal.on('hidden.bs.modal', function () {
            resetForm();
        });

        function resetForm() {
            $modal.find('.modal-header h5').text('{{__('添加角色')}}');

            $('#form')[0].reset();
            $('#edit-id').val('');

            $('#error-container-name, #error-container-pid, #error-container-status, #error-container-nodes').empty();
            $('#form .is-invalid, #form .is-valid').removeClass('is-invalid is-valid');

            const instance = $nodeTree.jstree(true);
            if (instance) {
                instance.uncheck_all();
            }

            $('#pid').val('').trigger('change');

            if (validator) {
                validator.refresh();
            }
        }

        function handleSubmit(selectedNodes) {
            showLoading()

            let form = $('#form').serializeArray();

            const nodeIds = selectedNodes.map(node => node.id);
            nodeIds.forEach(nodeId => {
                form.push({
                    name: 'nodes[]',
                    value: nodeId
                });
            });

            const editId = $('#edit-id').val();
            let url, method;
            if (editId) {
                url = '{{route('admin.role.update.html', ['role' => ':id'])}}'.replace(':id', editId);
                method = 'PUT';
            } else {
                url = '{{route('admin.role.store.html')}}';
                method = 'POST';
            }

            $.ajax({
                url: url,
                type: method,
                data: form,
                dataType: "json",
                success: function (response) {
                    if (response.code !== 0) {
                        showToast('error', response.msg);
                        return;
                    }

                    showToast('success', editId ? '{{__('更新成功')}}' : '{{__('创建成功')}}');
                    $('#form-modal').modal('hide');
                    getData(currentPage, {keyword: searchKeyword});
                },
                error: function () {
                    showToast('error', '{{__('操作失败，请稍后再试！')}}')
                },
                complete: function () {
                    hideLoading()
                }
            });
        }
    })
</script>
</html>
