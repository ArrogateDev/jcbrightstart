<x-layouts.modal id="form-modal" title="{{ __('新增领域')}}" class="modal-lg" form="true" form-id="form">

    <div class="modal-body pb-0">
        <div class="mb-3">
            <label class="form-label" for="title">
                {{__('名称')}}
                <span class="text-danger"> *</span>
                <span id="error-container-title"></span>
            </label>
            <input type="text" id="title" name="title" class="form-control" placeholder="{{__('请输入名称')}}">
        </div>

        <div class="mb-3">
            <label class="form-label" for="pid">
                {{__('上级')}}
                <span class="text-danger"> *</span>
                <span id="error-container-pid"></span>
            </label>
            <select id="pid" name="pid" class="select form-control"></select>
        </div>

        <div class="mb-3">
            <label class="form-label" for="color">
                {{__('颜色')}}
                <span class="text-danger"> *</span>
                <span id="error-container-color"></span>
            </label>
            <input id="color" name="color" value="#ffb900">
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
        $('#pid').select2({
            placeholder: '{{__('请选择或搜索分类')}}',
            data: @json($category)
        });

        const input = document.querySelector('#color')
        const picker = new ColorPicker(input, {
            toggleStyle: 'input',
            swatches: ['#d95d5d', '#db8525', '#e8c43c', '#bed649', '#9ecbdb', '#6399a5', '#c771a1'],
            showClearButton: true,
            dismissOnOutsideClick: false,
        })

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
            .addField('#pid', [
                {
                    rule: 'required',
                    errorMessage: '{{__('上级不能为空')}}'
                }
            ], {
                errorsContainer: '#error-container-pid'
            })
            .addField('#color', [
                {
                    rule: 'required',
                    errorMessage: '{{__('颜色不能为空')}}'
                }
            ], {
                errorsContainer: '#error-container-color'
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

            $modal.find('.modal-header h5').text('{{__('编辑领域')}}');
            $('#edit-id').val(params.id || '');
            $('#title').val(params.title || '');

            if (params.status !== undefined) {
                $(`input[name="status"][value="${params.status}"]`).prop('checked', true);
            }
        });

        $modal.on('hidden.bs.modal', function () {
            picker.close()
            resetForm();
        });

        function resetForm() {
            $modal.find('.modal-header h5').text('{{__('新增领域')}}');

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
                url = '{{route('admin.resource-category.update.html', ['category' => ':id'])}}'.replace(':id', editId);
                method = 'PUT';
            } else {
                url = '{{route('admin.resource-category.store.html')}}';
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
