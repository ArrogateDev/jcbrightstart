<div id="certificate-content" class="text-center" style="display: none">
    <img class="h-100 gallery-img" id="certificate-img" src="{{ $course->certificate_url ?? null }}" alt="Certificate">
</div>
<div id="certificate-loading" class="d-flex justify-content-center align-items-center" style="height: 100%;">
    <div class="spinner-border" role="status">
        <span class="sr-only">{{__('加载中...')}}</span>
    </div>
</div>
<script>
    // 使用事件委托处理动态添加的证书标签页
    $(document).ready(function() {
        // 处理证书标签页显示事件（支持动态添加的元素）
        $(document).on('shown.bs.tab', '#learn-certificate-tab', function (e) {
            // 防止重复初始化
            if ($(this).data('initialized')) {
                return;
            }

            var img = document.getElementById('certificate-img');
            var $loading = $("#certificate-loading");
            var $content = $("#certificate-content");
            const $learnModal = $('#learn-box');
            const $downloadBtn = $learnModal.find('.download-btn');

            function hideLoading() {
                $loading.removeClass('d-flex').addClass('d-none');
                $content.show();
                // 证书加载完成后再显示 footer 和下载按钮
                if (typeof window.updateFooterButtons === 'function') {
                    window.updateFooterButtons({
                        showFooter: true,
                        showDownloadBtn: true,
                        justifyEnd: true
                    });
                } else {
                    // 兼容旧代码
                    $learnModal.find('.modal-footer').show();
                    $downloadBtn.show().removeClass('disabled').prop('disabled', false).attr('data-url', '{!! $course->certificate_download_url ?? '' !!}');
                }
            }

            // 如果图片已经加载完成或者没有有效src，则直接隐藏loading
            if (!img || !img.src || img.src === '' || img.src === '{{ $course->certificate_url ?? null }}') {
                hideLoading();
                // 标记已初始化
                $(this).data('initialized', true);
                return;
            }

            // 图片未加载完成，等待加载或错误事件
            if (img.complete) {
                hideLoading();
            } else {
                img.addEventListener('load', function() {
                    hideLoading();
                });
                img.addEventListener('error', function() {
                    hideLoading();
                });
            }

            // 绑定下载按钮点击事件
            $downloadBtn.off('click').on('click', function () {
                let url = $(this).attr('data-url');
                if (!url) return;
                window.open(url, '_blank');
            });

            // 标记已初始化
            $(this).data('initialized', true);
        });

        // 监听自定义事件，用于处理动态更新证书图片的情况
        $(document).on('certificate:updated', function(e, imageUrl, downloadUrl) {
            var img = document.getElementById('certificate-img');
            var $loading = $("#certificate-loading");
            var $content = $("#certificate-content");
            const $learnModal = $('#learn-box');
            const $downloadBtn = $learnModal.find('.download-btn');

            if (img && imageUrl) {
                // 显示loading
                $loading.addClass('d-flex').removeClass('d-none');
                $content.hide();

                // 更新图片源
                img.src = imageUrl;

                // 更新下载链接
                if (downloadUrl) {
                    $downloadBtn.attr('data-url', downloadUrl);
                }

                // 移除已初始化标记，允许重新初始化
                $('#learn-certificate-tab').removeData('initialized');
            }
        });
    });
</script>
