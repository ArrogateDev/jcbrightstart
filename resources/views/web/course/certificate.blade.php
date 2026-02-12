<div id="certificate-content" class="text-center" style="display: none">
    <img class="h-100 gallery-img" id="certificate-img" src="{{ $course->certificate_url ?? null }}" alt="Certificate">
</div>
<div id="certificate-loading" class="d-flex justify-content-center align-items-center" style="height: 100%;">
    <div class="spinner-border" role="status">
        <span class="sr-only">{{__('加载中...')}}</span>
    </div>
</div>
<script>
    // 只有当证书标签页被激活时才执行初始化
    document.addEventListener('DOMContentLoaded', function() {
        $('#learn-certificate-tab').on('shown.bs.tab', function (e) {
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
                // 证书加载完成后再显示footer和下载按钮
                $learnModal.find('.modal-footer').show();
                $downloadBtn.show().removeClass('disabled').prop('disabled', false).attr('data-url', '{{ $course->certificate_download_url ?? '' }}');
            }

            if (!img || !img.src || img.src === '') {
                hideLoading();
                return;
            }

            if (img.complete) {
                hideLoading();
            } else {
                img.addEventListener('load', hideLoading);
                img.addEventListener('error', hideLoading);
            }

            $downloadBtn.off('click').on('click', function () {
                let url = $(this).attr('data-url');
                if (!url) return;
                window.open(url, '_blank');
            });
            
            // 标记已初始化
            $(this).data('initialized', true);
        });
    });
</script>
