<x-layouts.modal id="form-modal" title="{{ __('新增证书')}}" class="modal-xl">

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">{{__('上传证书模板')}}</h6>
                    <div class="mb-3">
                        <label class="form-label">{{__('选择图片')}}</label>
                        <input type="file" id="certificate_image" accept="image/*" class="form-control">
                    </div>

                    <hr>

                    <h6 class="mb-3">{{__('添加文本')}}</h6>
                    <div class="mb-3">
                        <button type="button" id="btn_add_name" class="btn btn-sm btn-secondary mt-2 w-100" onclick="addText('name')" disabled>
                            <i class="isax isax-add-circle me-1"></i>{{__('添加姓名')}}
                        </button>
                    </div>

                    <div class="mb-3">
                        <button type="button" id="btn_add_date" class="btn btn-sm btn-secondary mt-2 w-100" onclick="addText('date')" disabled>
                            <i class="isax isax-add-circle me-1"></i>{{__('添加日期')}}
                        </button>
                    </div>

                    <hr>

                    <h6 class="mb-3">{{__('文本样式')}}</h6>
                    <div class="mb-3">
                        <label class="form-label">{{__('字体大小')}}</label>
                        <input type="number" id="font_size" class="form-control" value="24" min="12" max="72">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{__('字体颜色')}}</label>
                        <input type="color" id="font_color" class="form-control form-control-color" value="#000000">
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">{{__('证书名称')}}</label>
                        <input type="text" id="certificate_name" class="form-control" placeholder="{{__('输入证书模板名称')}}">
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-danger w-100" onclick="deleteSelected()">
                            <i class="isax isax-trash me-1"></i>{{__('删除选中')}}
                        </button>
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-light w-100" onclick="clearCanvas()">
                            <i class="isax isax-refresh me-1"></i>{{__('清空画布')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h6>{{__('证书预览')}}</h6>
                        <p class="text-muted small">{{__('点击文本可选中，拖拽可移动位置')}}</p>
                    </div>
                    <div class="canvas-container" style="border: 1px solid #ddd; background: #f5f5f5; position: relative;">
                        <canvas id="canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footer>
        <button class="btn bg-gray-100 rounded-pill me-2" type="button"
                data-bs-dismiss="modal">{{__('取消')}}
        </button>
        <button class="btn btn-secondary rounded-pill" type="submit" onclick="handleSubmit()">{{__('提交')}}</button>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" id="edit-id">
    </x-slot:footer>
</x-layouts.modal>

<script>
    let canvas;
    let $certificate = null;
    let originalImageFile = null;
    const controls = {
        mt: false,
        mb: false,
        ml: false,
        mr: false,
        tl: true,
        tr: true,
        bl: true,
        br: true,
        mtr: true
    }

    function initCanvas() {
        const canvasEl = document.getElementById('canvas');
        if (!canvasEl || typeof fabric === 'undefined') return;

        const container = canvasEl.parentElement;
        if (!container) return;

        // 获取容器的实际尺寸（无padding，完全填满）
        const containerRect = container.getBoundingClientRect();
        const containerWidth = containerRect.width;
        const containerHeight = containerRect.height;

        // 保持800:600的比例，计算canvas尺寸以填满容器
        const aspectRatio = 800 / 600;
        let canvasWidth = containerWidth;
        let canvasHeight = containerWidth / aspectRatio;

        // 如果按宽度计算的高度超出容器，则按高度计算
        if (canvasHeight > containerHeight) {
            canvasHeight = containerHeight;
            canvasWidth = containerHeight * aspectRatio;
        }

        // 确保尺寸至少为1
        canvasWidth = Math.max(1, Math.floor(canvasWidth));
        canvasHeight = Math.max(1, Math.floor(canvasHeight));

        // 创建或更新canvas，完全填满计算出的尺寸
        if (!canvas) {
            canvas = new fabric.Canvas('canvas', {
                width: canvasWidth,
                height: canvasHeight,
                backgroundColor: '#ffffff',
                containerClass: 'canvas-wrapper'
            });

            // 获取Fabric.js自动创建的wrapper容器，去除所有边距
            setTimeout(function () {
                const wrapper = canvasEl.parentElement;
                if (wrapper && wrapper.classList.contains('canvas-wrapper')) {
                    wrapper.style.margin = '0';
                    wrapper.style.padding = '0';
                    wrapper.style.width = '100%';
                    wrapper.style.height = '100%';
                    wrapper.style.position = 'absolute';
                    wrapper.style.top = '0';
                    wrapper.style.left = '0';
                }
            }, 10);
        } else {
            canvas.setDimensions({
                width: canvasWidth,
                height: canvasHeight
            });
        }

        canvas.on('selection:created', updateStyleControls);
        canvas.on('selection:updated', updateStyleControls);
        canvas.on('selection:cleared', function () {

        });

        canvas.on('mouse:down', function (e) {
            if (e.target && e.target.type === 'text') {
                setTimeout(updateStyleControls, 10);
            }
        });

        canvas.on('object:modified', function () {
            canvas.renderAll();
        });

        canvas.on('object:added', function (e) {
            if (e.target && e.target.type === 'text') {
                e.target.setControlsVisibility(controls);
            }
        });

        canvas.on('selection:created', function (e) {
            _.forEach(_.filter(e.selected, {type: 'text'}), function (obj) {
                obj.setControlsVisibility(controls);
            });
        });

        canvas.on('selection:updated', function (e) {
            _.forEach(_.filter(e.selected, {type: 'text'}), function (obj) {
                obj.setControlsVisibility(controls);
            });
        });
    }

    function initImageUpload() {
        const imageInput = document.getElementById('certificate_image');
        if (!imageInput) return
        imageInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) {
                originalImageFile = null;
                return;
            }

            // 保存原始文件
            originalImageFile = file;

            const reader = new FileReader();
            reader.onload = function (event) {
                const imgUrl = event.target.result;
                loadImageToCanvas(imgUrl);
            };
            reader.readAsDataURL(file);
        });
    }

    function loadImageToCanvas(imgUrl, callback) {
        if (!canvas) {
            if (callback) callback();
            return;
        }

        fabric.Image.fromURL(imgUrl, function (img) {
            // 清空canvas但保留背景色
            const objects = canvas.getObjects();
            objects.forEach(function (obj) {
                canvas.remove(obj);
            });
            canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));

            const canvasWidth = canvas.width;
            const canvasHeight = canvas.height;
            const imgWidth = img.width;
            const imgHeight = img.height;

            // 使用Math.min让图片完整显示（显示最大边，不裁剪）
            const scale = Math.min(canvasWidth / imgWidth, canvasHeight / imgHeight);

            // 计算缩放后的尺寸
            const scaledWidth = imgWidth * scale;
            const scaledHeight = imgHeight * scale;

            // 计算居中位置
            const left = (canvasWidth - scaledWidth) / 2;
            const top = (canvasHeight - scaledHeight) / 2;

            // 设置图片的缩放和位置
            img.set({
                scaleX: scale,
                scaleY: scale,
                left: left,
                top: top,
                selectable: false,
                evented: false,
                originX: 'left',
                originY: 'top',
                lockMovementX: true,
                lockMovementY: true
            });

            // 将图片添加到canvas最底层作为背景
            canvas.add(img);
            canvas.sendToBack(img);

            // 同时设置为背景图片（用于导出）
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));

            // 强制重新渲染
            canvas.renderAll();

            $certificate = img;
            enableTextButtons();

            // 执行回调函数（如果提供）
            if (callback) {
                setTimeout(callback, 100);
            }
        });
    }

    function enableTextButtons() {
        const btnAddName = document.getElementById('btn_add_name');
        const btnAddDate = document.getElementById('btn_add_date');
        if (btnAddName) {
            btnAddName.disabled = false;
        }
        if (btnAddDate) {
            btnAddDate.disabled = false;
        }
    }

    function disableTextButtons() {
        const btnAddName = document.getElementById('btn_add_name');
        const btnAddDate = document.getElementById('btn_add_date');
        if (btnAddName) {
            btnAddName.disabled = true;
        }
        if (btnAddDate) {
            btnAddDate.disabled = true;
        }
    }

    function addText(type) {
        if (!$certificate) return;
        if (!canvas) return;
        if (!type.includes('name') && !type.includes('date')) return;

        const $text = type === 'name' ? '{{__("姓")}}{{__("名")}}' : '{{date('m/d/y')}}';

        const objects = canvas.getObjects();
        const existingText = _.find(objects, obj => obj.type === 'text' && obj.data && obj.data.type === type);

        if (existingText) {
            existingText.set({
                text: $text,
                fontSize: parseInt(document.getElementById('font_size').value) || 24,
                fill: document.getElementById('font_color').value || '#000000'
            });
            existingText.setControlsVisibility(controls);
            canvas.setActiveObject(existingText);
        } else {
            const text = new fabric.Text($text, {
                left: canvas.width / 2,
                top: canvas.height / 2 - 50,
                fontSize: parseInt(document.getElementById('font_size').value) || 24,
                fill: document.getElementById('font_color').value || '#000000',
                originX: 'center',
                originY: 'center',
                textAlign: 'center',
                data: {type: type}
            });

            text.setControlsVisibility(controls);

            canvas.add(text);
            canvas.setActiveObject(text);
        }

        canvas.renderAll();
        updateStyleControls();
    }

    function updateStyleControls() {
        if (!canvas) return;

        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            document.getElementById('font_size').value = activeObject.fontSize || 24;
            document.getElementById('font_color').value = activeObject.fill || '#000000';
        }
    }

    function applyStyle() {
        if (!canvas) return;
        const activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'text') {
            activeObject.set({
                fontSize: parseInt(document.getElementById('font_size').value) || 24,
                fill: document.getElementById('font_color').value || '#000000'
            });
            canvas.renderAll();
        }
    }

    function initStyleControls() {
        const styleInputs = ['font_size', 'font_color'];
        styleInputs.forEach(function (id) {
            const input = document.getElementById(id);
            if (!input) return
            const newInput = input.cloneNode(true);
            input.parentNode.replaceChild(newInput, input);
            newInput.addEventListener('change', applyStyle);
            newInput.addEventListener('input', applyStyle);
        });
    }

    function deleteSelected() {
        if (!canvas) return;

        const activeObject = canvas.getActiveObject();
        if (!activeObject) {
            showToast('error', '{{__("请先选择一个对象")}}');
        }

        canvas.remove(activeObject);
        canvas.renderAll();
    }

    // 清空画布
    function clearCanvas() {
        if (!canvas) return;
        confirm_alert('{{__("确定要清空画布吗？")}}', '{{__("该操作无法撤回？")}}', '{{__("确定")}}')
            .then((result) => {
                if (result.isConfirmed) {
                    canvas.clear();
                    canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));
                    $certificate = null;
                    disableTextButtons();
                }
            })
    }

    // 获取文本配置
    function getTextConfig(type) {
        if (!canvas) return null;

        const objects = canvas.getObjects();
        let targetText = _.find(objects, obj => obj.type === 'text' && obj.data && obj.data.type === type);

        if (!targetText) {
            // 如果找不到，尝试通过位置判断（姓名在上，日期在下）
            const textObjects = objects.filter(obj => obj.type === 'text').sort((a, b) => a.top - b.top);
            if (textObjects.length >= 2) {
                targetText = type === 'name' ? textObjects[0] : textObjects[1];
            } else if (textObjects.length === 1) {
                // 只有一个文本对象，根据类型返回
                targetText = textObjects[0];
            }
        }

        if (!targetText) return null;

        // 计算比例，将当前canvas尺寸的坐标转换为标准800x600的坐标
        const standardWidth = 800;
        const standardHeight = 600;
        const scaleX = standardWidth / canvas.width;
        const scaleY = standardHeight / canvas.height;

        return {
            left: targetText.left * scaleX,
            top: targetText.top * scaleY,
            font_size: parseInt(targetText.fontSize * scaleX), // 字体大小也按比例缩放
            fill: targetText.fill,
            text_align: targetText.textAlign || 'center',
            origin_x: targetText.originX || 'center',
            origin_y: targetText.originY || 'center'
        };
    }

    // 加载证书数据（用于编辑回填）
    function loadCertificateData(data) {
        if (!data) return;

        // 确保canvas已初始化
        if (!canvas) {
            initCanvas();
        }

        setTimeout(function () {
            if (!canvas) return;

            // 清空画布
            canvas.clear();
            canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));
            $certificate = null;
            disableTextButtons();

            // 存储待加载的文本配置
            const textConfigs = {
                name: data.name_config,
                date: data.date_config
            };

            // 加载图片，并在图片加载完成后加载文本
            if (data.path) {
                loadImageToCanvas(data.path, function () {
                    // 图片加载完成后，加载文本
                    setTimeout(function () {
                        if (!canvas) return;

                        // 加载姓名文本
                        if (textConfigs.name) {
                            loadTextToCanvas('name', textConfigs.name);
                        }

                        // 加载日期文本
                        if (textConfigs.date) {
                            loadTextToCanvas('date', textConfigs.date);
                        }
                    }, 100);
                });
            } else {
                // 如果没有图片，直接加载文本
                setTimeout(function () {
                    if (!canvas) return;

                    if (textConfigs.name) {
                        loadTextToCanvas('name', textConfigs.name);
                    }

                    if (textConfigs.date) {
                        loadTextToCanvas('date', textConfigs.date);
                    }
                }, 100);
            }
        }, 200);
    }

    // 加载文本到canvas
    function loadTextToCanvas(type, config) {
        if (!canvas || !config) return;

        // 将标准800x600的坐标转换为当前canvas尺寸的坐标
        const standardWidth = 800;
        const standardHeight = 600;
        const scaleX = canvas.width / standardWidth;
        const scaleY = canvas.height / standardHeight;

        const text = type === 'name' ? '{{__("姓名")}}' : '{{date('Y-m-d')}}';

        const textObj = new fabric.Text(text, {
            left: (config.left || 400) * scaleX,
            top: (config.top || 300) * scaleY,
            fontSize: parseInt((config.font_size || 24) * scaleX),
            fill: config.fill || '#000000',
            originX: config.origin_x || config.originX || 'center',
            originY: config.origin_y || config.originY || 'center',
            textAlign: config.text_align || config.textAlign || 'center',
            data: {type: type}
        });

        textObj.setControlsVisibility(controls);
        canvas.add(textObj);
        canvas.renderAll();
    }

    // 清空画布（重置函数）
    function clearCanvasForReset() {
        if (!canvas) return;
        canvas.clear();
        canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));
        $certificate = null;
        originalImageFile = null; // 清空原始图片文件
        disableTextButtons();
    }

    function handleSubmit() {
        if (!canvas) {
            showToast('error', '{{__("画布未初始化")}}');
            return;
        }

        const name = document.getElementById('certificate_name').value.trim();
        if (!name) {
            showToast('error', '{{__("请输入证书模板名称")}}');
            document.getElementById('certificate_name').focus();
            return;
        }

        const nameTextConfig = getTextConfig('name');
        const dateTextConfig = getTextConfig('date');

        if (!nameTextConfig) {
            showToast('error', '{{__("请添加姓名文本")}}');
            return;
        }

        if (!dateTextConfig) {
            showToast('error', '{{__("请添加日期文本")}}');
            return;
        }
        showLoading()

        const editId = $('#edit-id').val();
        let formData = new FormData();

        formData.append('name', name);
        _.each(nameTextConfig, (value, key) => {
            formData.append(`name_config[${key}]`, value);
        });

        _.each(dateTextConfig, (value, key) => {
            formData.append(`date_config[${key}]`, value);
        });
        formData.append('width', 800);
        formData.append('height', 600);
        formData.append('_token', '{{ csrf_token() }}');

        let url, method;
        if (editId) {
            formData.append('id', editId);
            if (originalImageFile) {
                formData.append('image', originalImageFile);
            }

            formData.append('_method', 'PUT');
            url = '{{route('admin.certificate.update.html', ['certificate' => ':id'])}}'.replace(':id', editId);
            method = 'POST';
        } else {
            if (!originalImageFile) {
                showToast('error', '{{__("请上传证书模板图片")}}');
                hideLoading();
                return;
            }
            formData.append('image', originalImageFile);
            url = '{{route('admin.certificate.store.html')}}';
            method = 'POST';
        }

        $.ajax({
            url: url,
            type: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (data) {
                if (data.code !== 0) {
                    showToast('error', data.msg);
                    return;
                }

                showToast('success', editId ? '{{__('更新成功')}}' : '{{__('创建成功')}}');
                $('#form-modal').modal('hide');
                getData(1);
            }, error: function () {
                showToast('error', '{{__('操作失败，请稍后再试！')}}')
            }, complete: function () {
                hideLoading()
            }
        });
    }

    $(function () {
        initImageUpload();
        initStyleControls();
        disableTextButtons();

        const $modal = $('#form-modal');
        if (!$modal.length) return;

        // 存储待加载的证书数据
        let pendingCertificateData = null;

        // 模态框显示时
        $modal.on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const params = JSON.parse(button.getAttribute('data-item'))
            if (!params) return

            $modal.find('.modal-header h5').text('{{__('编辑证书')}}');
            $('#edit-id').val(params.id || '');
            $('#certificate_name').val(params.name || '');
            pendingCertificateData = params;
        });

        // 模态框完全显示后
        $modal.on('shown.bs.modal', function () {
            // 重新初始化样式控制
            initStyleControls();

            // 初始化或调整canvas尺寸
            setTimeout(function () {
                if (!canvas) {
                    initCanvas();
                } else {
                    // 重新计算canvas尺寸以填满容器
                    const canvasEl = document.getElementById('canvas');
                    const container = canvasEl.parentElement;
                    if (container) {
                        const containerRect = container.getBoundingClientRect();
                        const containerWidth = containerRect.width;
                        const containerHeight = containerRect.height;
                        const aspectRatio = 800 / 600;
                        let canvasWidth = containerWidth;
                        let canvasHeight = containerWidth / aspectRatio;

                        if (canvasHeight > containerHeight) {
                            canvasHeight = containerHeight;
                            canvasWidth = containerHeight * aspectRatio;
                        }

                        canvas.setDimensions({
                            width: Math.floor(canvasWidth),
                            height: Math.floor(canvasHeight)
                        });
                        canvas.renderAll();
                    }
                }

                // Canvas尺寸调整完成后，加载证书数据（如果是编辑模式）
                if (pendingCertificateData && typeof loadCertificateData === 'function') {
                    setTimeout(function () {
                        loadCertificateData(pendingCertificateData);
                        pendingCertificateData = null; // 清除待加载数据
                    }, 200);
                } else {
                    // 新增模式：检查是否有证书图片
                    if (!$certificate) {
                        disableTextButtons();
                    }
                }
            }, 100);
        });

        // 模态框关闭时
        $modal.on('hidden.bs.modal', function () {
            clearCanvasForReset();

            $modal.find('.modal-header h5').text('{{__('新增证书')}}');
            $('#edit-id').val('');
            $('#certificate_name').val('');
            $('#certificate_image').val('');
        });
    });
</script>

<style>
    .canvas-container {
        width: 100%;
        height: 100%;
        min-height: 500px;
        overflow: hidden;
        position: relative;
        margin: 0;
        padding: 0;
    }

    .canvas-container .canvas-wrapper {
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
    }

    .canvas-container .lower-canvas,
    .canvas-container .upper-canvas {
        margin: 0 !important;
        padding: 0 !important;
    }

    #canvas {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .form-control-color {
        height: 38px;
        cursor: pointer;
    }

    .col-md-9 .card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .col-md-9 .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .col-md-9 .card-body > div:first-child {
        flex-shrink: 0;
    }
</style>
