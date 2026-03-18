<div class="modal fade" id="learn-box" tabindex="-1" aria-labelledby="learn-label" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <h5 class="modal-title" id="learn-label">{{__('学习')}}</h5>
                    <ul class="nav nav-tabs ml-4" id="learn-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="learn-play-tab" data-toggle="tab" href="#learn-play" role="tab" aria-controls="learn-play" aria-selected="true">
                                📖 {{__('内容')}}
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="learn-quiz-tab" data-toggle="tab" href="#learn-quiz" role="tab" aria-controls="learn-quiz" aria-selected="false">
                                ❓ {{__('测验')}}
                            </a>
                        </li>
                        @if($course->certificate_url??null)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="learn-certificate-tab" data-toggle="tab" href="#learn-certificate" role="tab" aria-controls="learn-certificate" aria-selected="false">
                                    🏅 {{__('证书')}}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-0">
                <div class="tab-content" id="learn-tab-content">
                    <div class="tab-pane fade show active" id="learn-play" role="tabpanel" aria-labelledby="learn-play-tab">
                        @include('web.course.components.play')
                    </div>
                    <div class="tab-pane fade" id="learn-quiz" role="tabpanel" aria-labelledby="learn-quiz-tab">
                        @include('web.course.quiz')
                    </div>
                    <div class="tab-pane fade" id="learn-certificate" role="tabpanel" aria-labelledby="learn-certificate-tab">
                        @include('web.course.certificate')
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between" style="display: none;">
                <button class="per-btn" style="display: none;">← {{__('上一题')}}</button>
                <button class="next-btn" style="display: none;">{{__('下一题')}} →</button>
                <button class="download-btn" style="display: none;">{{__('下载')}}</button>
            </div>
            <script>
                $(function () {
                    const $modal = $('#learn-box');
                    const $footer = $modal.find('.modal-footer');
                    const $perBtn = $footer.find('.per-btn');
                    const $nextBtn = $footer.find('.next-btn');
                    const $downloadBtn = $footer.find('.download-btn');

                    // 统一的 Footer 控制函数
                    window.updateFooterButtons = function(config) {
                        const defaultConfig = {
                            showFooter: false,
                            showPerBtn: false,
                            showNextBtn: false,
                            showDownloadBtn: false,
                            nextBtnText: '{{__('下一题')}} →',
                            justifyEnd: false
                        };
                        
                        const settings = $.extend({}, defaultConfig, config);
                        
                        // 控制 footer 显示/隐藏
                        if (settings.showFooter) {
                            $footer.show();
                        } else {
                            $footer.hide();
                            return; // footer 隐藏时，不需要再处理按钮
                        }
                        
                        // 控制各个按钮显示/隐藏
                        $perBtn.toggle(settings.showPerBtn);
                        $nextBtn.toggle(settings.showNextBtn);
                        $downloadBtn.toggle(settings.showDownloadBtn);
                        
                        // 设置下一题按钮文本
                        if (settings.nextBtnText) {
                            $nextBtn.text(settings.nextBtnText);
                        }
                        
                        // 动态调整 justify-content 类
                        $footer.removeClass('justify-content-between').removeClass('justify-content-end');
                        
                        // 计算可见按钮数量
                        const visibleButtons = [
                            settings.showPerBtn,
                            settings.showNextBtn,
                            settings.showDownloadBtn
                        ].filter(Boolean).length;
                        
                        // 只有一个按钮时靠右显示
                        if (visibleButtons === 1 || settings.justifyEnd) {
                            $footer.addClass('justify-content-end');
                        } else {
                            $footer.addClass('justify-content-between');
                        }
                    };

                    // 标签页切换时的 footer 控制
                    $('#learn-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                        const target = $(e.target).attr('href');

                        if (target === '#learn-play') {
                            // 学习内容页面：隐藏 footer
                            window.updateFooterButtons({ showFooter: false });
                        } else if (target === '#learn-certificate') {
                            // 证书页面：显示 footer，只显示下载按钮
                            window.updateFooterButtons({
                                showFooter: true,
                                showDownloadBtn: true,
                                justifyEnd: true
                            });
                        }
                        // quiz 页面的 footer 由 quiz.blade.php 自己控制
                    });

                    // Modal 显示时根据当前激活的 tab 设置 footer
                    $modal.on('shown.bs.modal', function () {
                        const activeTab = $('#learn-tabs .nav-link.active').attr('href');
                        if (activeTab === '#learn-play') {
                            window.updateFooterButtons({ showFooter: false });
                        }
                    });

                    // 下载按钮点击事件
                    $downloadBtn.click(function () {
                        const file = $(this).data('url');
                        if (file) {
                            window.open(file, '_blank');
                        } else {
                            showToast('error', "{{__('证书文件不存在')}}");
                        }
                    })
                });
            </script>
        </div>
    </div>
</div>
