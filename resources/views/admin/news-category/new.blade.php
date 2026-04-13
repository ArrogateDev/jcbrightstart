<x-layouts.modal id="form-modal" title="{{ __('新增消息分类')}}" class="modal-lg" form="true" form-id="form">

    <div class="modal-body pb-0">
        <div class="mb-3">
            <label class="form-label" for="title">
                {{__('名称')}}
                <span class="text-danger"> *</span>
                <span id="error-title-status"></span>
            </label>
            <input type="text" id="title" name="title" class="form-control" placeholder="{{__('请输入名称')}}">
        </div>

        <div class="mb-3">
            <label class="form-label mb-1">
                {{__('是否为导航菜单')}}
                <span class="text-danger ms-1">*</span>
                <span id="error-container-is-nav"></span>
            </label>
            <div class="d-flex align-items-center ">
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="is_nav"
                           id="is-nav-normal" value="0">
                    <label class="form-check-label" for="is-nav-normal">
                        {{__('是')}}
                    </label>
                </div>
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="is_nav"
                           id="is-nav-disabled" value="1" checked>
                    <label class="form-check-label" for="is-nav-disabled">
                        {{__('否')}}
                    </label>
                </div>
            </div>
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
    </div>

    <x-slot:footer>
        <button class="btn bg-gray-100 rounded-pill me-2" type="button"
                data-bs-dismiss="modal">{{__('取消')}}
        </button>
        <button class="btn btn-secondary rounded-pill submit" type="submit">{{__('提交')}}</button>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="edit-id">
    </x-slot:footer>

</x-layouts.modal>

<script>
    $(function () {
        const validator = new window.JustValidate('#form', {
            errorLabelCssClass: 'd-inline',
        });
        validator
            .addField('#title', [
                {
                    rule: 'required',
                    errorMessage: '{{__('名称不能为空')}}'
                }
            ], {
                errorsContainer: '#error-container-title'
            })
            .addField('input[name="is_nav"]', [
                {
                    rule: 'required',
                    errorMessage: '{{__('请选择是否为导航菜单')}}'
                }
            ], {
                errorsContainer: '#error-container-is-nav'
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

            $modal.find('.modal-header h5').text('{{__('编辑消息分类')}}');
            $('#edit-id').val(params.id || '');
            $('#title').val(params.title || '');

            if (params.status !== undefined) {
                $(`input[name="status"][value="${params.status}"]`).prop('checked', true);
            }
        });

        $modal.on('hidden.bs.modal', function () {
            resetForm();
        });

        function resetForm() {
            $modal.find('.modal-header h5').text('{{__('新增消息分类')}}');

            $('#form')[0].reset();
            $('#edit-id').val('');

            $('#error-container-title, #error-container-status').empty();
            $('#form .is-invalid, #form .is-valid').removeClass('is-invalid is-valid');

            if (validator) {
                validator.refresh();
            }
        }

        function handleSubmit() {
            showLoading()

            let form = $('#form').serializeArray()
            const editId = $('#edit-id').val();

            let url, method;
            if (editId) {
                url = '{{route('admin.news-category.update.html', ['category' => ':id'])}}'.replace(':id', editId);
                method = 'PUT';
            } else {
                url = '{{route('admin.news-category.store.html')}}';
                method = 'POST';
            }

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
                    $modal.data('uploaded', true);
                    $modal.modal('hide');
                }, error: function () {
                    showToast('error', '{{__('操作失败，请稍后再试！')}}')
                }, complete: function () {
                    hideLoading()
                }
            });
        }
    });
</script>
