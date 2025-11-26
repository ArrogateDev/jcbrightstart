<x-layouts.modal id="show-modal" title="" class="modal-lg">

    <div class="card">
        <div class="card-body">
            <div class="canvas-container" style="border: 1px solid #ddd; background: #f5f5f5; position: relative;">
                <canvas id="canvas-show"></canvas>
            </div>
        </div>
    </div>

</x-layouts.modal>

<script>
    let showCanvas = null;

    function initShowCanvas() {
        const canvasEl = document.getElementById('canvas-show');
        if (!canvasEl || typeof fabric === 'undefined') return;

        const container = canvasEl.parentElement;
        if (!container) return;

        // 获取容器的实际尺寸
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

        // 创建canvas，禁用所有交互
        if (!showCanvas) {
            showCanvas = new fabric.Canvas('canvas-show', {
                width: canvasWidth,
                height: canvasHeight,
                backgroundColor: '#ffffff',
                containerClass: 'canvas-wrapper',
                selection: false, // 禁用选择
                interactive: false // 禁用交互
            });

            // 禁用所有对象的选择和交互
            showCanvas.on('object:added', function (e) {
                if (e.target) {
                    e.target.selectable = false;
                    e.target.evented = false;
                    e.target.hoverCursor = 'default';
                    e.target.moveCursor = 'default';
                }
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
                    wrapper.style.top = '100';
                    wrapper.style.left = '0';
                }
            }, 10);
        } else {
            showCanvas.setDimensions({
                width: canvasWidth,
                height: canvasHeight
            });
        }
    }

    // 加载图片到显示canvas
    function loadImageToShowCanvas(imgUrl, callback) {
        if (!showCanvas) {
            if (callback) callback();
            return;
        }

        fabric.Image.fromURL(imgUrl, function (img) {
            // 清空canvas但保留背景色
            const objects = showCanvas.getObjects();
            objects.forEach(function (obj) {
                showCanvas.remove(obj);
            });
            showCanvas.setBackgroundColor('#ffffff', showCanvas.renderAll.bind(showCanvas));

            const canvasWidth = showCanvas.width;
            const canvasHeight = showCanvas.height;
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

            // 设置图片的缩放和位置，禁用交互
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
            showCanvas.add(img);
            showCanvas.sendToBack(img);

            // 同时设置为背景图片
            showCanvas.setBackgroundImage(img, showCanvas.renderAll.bind(showCanvas));

            // 强制重新渲染
            showCanvas.renderAll();

            // 执行回调函数（如果提供）
            if (callback) {
                setTimeout(callback, 100);
            }
        });
    }

    // 加载文本到显示canvas
    function loadTextToShowCanvas(type, config) {
        if (!showCanvas || !config) return;

        // 将标准800x600的坐标转换为当前canvas尺寸的坐标
        const standardWidth = 800;
        const standardHeight = 600;
        const scaleX = showCanvas.width / standardWidth;
        const scaleY = showCanvas.height / standardHeight;

        // 使用配置中的文本，如果没有则使用默认值
        const text = config.text || (type === 'name' ? '{{__("姓名")}}' : '{{date('Y-m-d')}}');

        const textObj = new fabric.Text(text, {
            left: (config.left || 400) * scaleX,
            top: (config.top || 300) * scaleY,
            fontSize: parseInt((config.font_size || 24) * scaleX),
            fill: config.fill || '#000000',
            originX: config.origin_x || config.originX || 'center',
            originY: config.origin_y || config.originY || 'center',
            textAlign: config.text_align || config.textAlign || 'center',
            selectable: false, // 禁用选择
            evented: false, // 禁用交互
            hoverCursor: 'default',
            moveCursor: 'default'
        });

        showCanvas.add(textObj);
        showCanvas.renderAll();
    }

    // 加载证书数据用于显示
    function loadCertificateForShow(data) {
        if (!data) return;

        // 确保canvas已初始化
        if (!showCanvas) {
            initShowCanvas();
        }

        setTimeout(function () {
            if (!showCanvas) return;

            // 清空画布
            showCanvas.clear();
            showCanvas.setBackgroundColor('#ffffff', showCanvas.renderAll.bind(showCanvas));

            // 存储待加载的文本配置
            const textConfigs = {
                name: data.name_config,
                date: data.date_config
            };

            // 加载图片，并在图片加载完成后加载文本
            if (data.path) {
                loadImageToShowCanvas(data.path, function () {
                    // 图片加载完成后，加载文本
                    setTimeout(function () {
                        if (!showCanvas) return;

                        // 加载姓名文本
                        if (textConfigs.name) {
                            loadTextToShowCanvas('name', textConfigs.name);
                        }

                        // 加载日期文本
                        if (textConfigs.date) {
                            loadTextToShowCanvas('date', textConfigs.date);
                        }
                    }, 100);
                });
            } else {
                // 如果没有图片，直接加载文本
                setTimeout(function () {
                    if (!showCanvas) return;

                    if (textConfigs.name) {
                        loadTextToShowCanvas('name', textConfigs.name);
                    }

                    if (textConfigs.date) {
                        loadTextToShowCanvas('date', textConfigs.date);
                    }
                }, 100);
            }
        }, 200);
    }

    // 清空显示canvas
    function clearShowCanvas() {
        if (!showCanvas) return;
        showCanvas.clear();
        showCanvas.setBackgroundColor('#ffffff', showCanvas.renderAll.bind(showCanvas));
    }

    $(function () {
        const $modal = $('#show-modal');
        if (!$modal.length) return;

        // 存储待加载的证书数据
        let pendingCertificateData = null;

        // 模态框显示时
        $modal.on('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const params = JSON.parse(button.getAttribute('data-item'))
            if (!params) return

            $modal.find('.modal-header h5').text(params.name);
            pendingCertificateData = params;
        });

        // 模态框完全显示后
        $modal.on('shown.bs.modal', function () {
            // 初始化或调整canvas尺寸
            setTimeout(function () {
                if (!showCanvas) {
                    initShowCanvas();
                } else {
                    // 重新计算canvas尺寸以填满容器
                    const canvasEl = document.getElementById('canvas-show');
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

                        showCanvas.setDimensions({
                            width: Math.floor(canvasWidth),
                            height: Math.floor(canvasHeight)
                        });
                        showCanvas.renderAll();
                    }
                }

                // Canvas尺寸调整完成后，加载证书数据
                if (pendingCertificateData && typeof loadCertificateForShow === 'function') {
                    setTimeout(function () {
                        loadCertificateForShow(pendingCertificateData);
                        pendingCertificateData = null; // 清除待加载数据
                    }, 200);
                }
            }, 100);
        });

        // 模态框关闭时
        $modal.on('hidden.bs.modal', function () {
            clearShowCanvas();
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
        padding: 0 !important;
        cursor: default !important;
        right: 0;
        bottom: 0;
        margin: auto !important;
    }

    #canvas-show {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background: white;
        right: 0;
        bottom: 0;
        margin: auto !important;
    }
</style>
