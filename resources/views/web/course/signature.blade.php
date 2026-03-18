<div class="modal fade" id="course-complete-box" tabindex="-1" aria-labelledby="course-complete-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="course-complete-label">{{__('確定證書姓名及下載')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="quiz-content" style="display: none">
                    <div class="quiz-statistics w-100">
                        <div class="quiz-statistics-icon">🎉</div>
                        <h4 class="quiz-statistics-title">{{__('证书完成')}}</h4>
                        <div class="quiz-statistics-btn">
                            <button class="btn btn-warning w-100 p-3 mb-4" data-toggle="modal" data-target="#look-certificate-box">{{__('查看证书')}}</button>
                            <button class="btn btn-warning w-100 p-3 mb-4 btn-main-action">{{__('下载证书')}}</button>
                        </div>
                    </div>
                </div>
                <div class="course-complete-form">
                    <div class="form-group">
                        <label for="certificate-name">{{__('请输入您的姓名')}}</label>
                        <input type="text" class="form-control" id="certificate-name" placeholder="{{__('请输入姓名')}}" value="{{$user->full_name??''}}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="course-certificate">
                <button type="button" class="btn btn-primary" id="submit-certificate-btn">{{__('提交')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="look-certificate-box" tabindex="-1" aria-labelledby="look-certificate-label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="course-complete-label">{{__('查看证书')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img class="h-100 gallery-img" id="look-certificate-img" alt="Certificate">
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        const $courseCompleteModal = $('#course-complete-box');
        const $certificateNameInput = $('#certificate-name');
        const $submitCertificateBtn = $('#submit-certificate-btn');
        let pollTimer = null;
        let pollStartTime = null;
        const POLL_TIMEOUT = 60000; // 60秒超时

        // 轮询检查证书状态
        function checkCertificateStatus(courseId) {
            // 检查超时
            if (pollStartTime && Date.now() - pollStartTime > POLL_TIMEOUT) {
                if (pollTimer) {
                    clearInterval(pollTimer);
                    pollTimer = null;
                }
                hideLoading($courseCompleteModal.find('.modal-content'));
                showToast('error', "{{__('证书生成超时，请稍后刷新页面查看')}}");
                $submitCertificateBtn.prop('disabled', false).text("{{__('提交')}}").show();
                return;
            }

            $.ajax({
                url: `/course/${courseId}/certificate-status.html`,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.code !== 0) {
                        return;
                    }

                    const data = response.data || {};
                    // 如果证书已生成
                    if (data.status === 1 && data.download_url) {
                        // 停止轮询
                        if (pollTimer) {
                            clearInterval(pollTimer);
                            pollTimer = null;
                        }

                        // 隐藏 loading
                        hideLoading($courseCompleteModal.find('.modal-content'));
                        
                        $courseCompleteModal.find('.course-complete-form').hide();
                        $courseCompleteModal.find('.modal-footer').hide();
                        $courseCompleteModal.find('#quiz-content').show();
                        $courseCompleteModal.find('.btn-main-action').attr('data-file', data.download_url);
                        $('#look-certificate-img').attr('src', data.file);
                                                
                        // 更新主学习窗口的 footer 状态（如果证书 tab 存在）
                        if (typeof window.updateFooterButtons === 'function') {
                            window.updateFooterButtons({
                                showFooter: true,
                                showDownloadBtn: true,
                                justifyEnd: true
                            });
                        }

                        // 确保查看证书按钮能正常工作
                        $courseCompleteModal.find('[data-toggle="modal"][data-target="#look-certificate-box"]').off('click').on('click', function(e) {
                            e.preventDefault();
                            $('#look-certificate-box').modal('show');
                        });

                        let tabs = $('#learn-tabs');
                        let certificateTabExists = tabs.find('#learn-certificate-tab').length > 0;
                        $('#download-btn').attr('data-url', data.file);

                        if (!certificateTabExists) {
                            let certificateTab = '<li class="nav-item" role="presentation"><a class="nav-link" id="learn-certificate-tab" data-toggle="tab" href="#learn-certificate" role="tab" aria-controls="learn-certificate" aria-selected="false">🏅 ' + "{{__('证书')}}" + '</a></li>';
                            tabs.append(certificateTab);
                            $('#learn-tabs a[data-toggle="tab"]').tab();

                            // 触发自定义事件来更新证书图片和下载链接
                            $(document).trigger('certificate:updated', [data.file, data.download_url]);
                        } else {
                            // 如果标签页已存在，也更新证书信息
                            $(document).trigger('certificate:updated', [data.file, data.download_url]);
                        }

                        showToast('success', "{{__('证书生成成功')}}");
                    }
                },
                error: function () {
                    // 轮询失败不影响继续轮询
                }
            });
        }

        $submitCertificateBtn.on('click', function () {
            const name = $certificateNameInput.val().trim();
            if (!name) {
                showToast('error', "{{__('请输入姓名')}}");
                $certificateNameInput.focus();
                return;
            }

            const currentCourseId = $('#course-certificate').val();
            $submitCertificateBtn.prop('disabled', true).text("{{__('提交中...')}}");
            showLoading($courseCompleteModal.find('.modal-content'));

            $.ajax({
                url: `/course/${currentCourseId}/certificate.html`,
                type: 'POST',
                data: {
                    name: name,
                    _token: "{{csrf_token()}}"
                },
                dataType: 'json',
                success: function (response) {
                    if (response.code !== 0) {
                        hideLoading($courseCompleteModal.find('.modal-content'));
                        showToast('error', response.msg || "{{__('提交失败')}}");
                        $submitCertificateBtn.prop('disabled', false).text("{{__('提交')}}");
                        return;
                    }

                    // 提交成功，不关闭模态框，继续显示loading
                    showToast('success', "{{__('提交成功，正在生成证书...')}}");

                    // 隐藏提交按钮
                    $submitCertificateBtn.hide();

                    // 记录轮询开始时间
                    pollStartTime = Date.now();

                    // 开始轮询检查证书状态（每2秒检查一次）
                    if (pollTimer) {
                        clearInterval(pollTimer);
                    }
                    pollTimer = setInterval(function () {
                        checkCertificateStatus(currentCourseId);
                    }, 2000);

                    // 立即检查一次
                    checkCertificateStatus(currentCourseId);
                },
                error: function () {
                    hideLoading($courseCompleteModal.find('.modal-content'));
                    showToast('error', "{{__('提交失败，请重试')}}");
                    $submitCertificateBtn.prop('disabled', false).text("{{__('提交')}}");
                }
            });
        });

        $courseCompleteModal.on('hidden.bs.modal', function () {
            // 停止轮询
            if (pollTimer) {
                clearInterval(pollTimer);
                pollTimer = null;
            }

            // 重置状态
            pollStartTime = null;
            $certificateNameInput.val('');
            $submitCertificateBtn.prop('disabled', false).text("{{__('提交')}}").show();
            $courseCompleteModal.find('.course-complete-form').show();
            $courseCompleteModal.find('.modal-footer').show();
            $courseCompleteModal.find('#quiz-content').hide();
        });


        // 使用事件委托来处理动态添加的按钮
        $(document).off('click', '.btn-main-action').on('click', '.btn-main-action', function (e) {
            e.preventDefault();
            const file = $(this).data('file');
            if (file) {
                window.open(file, '_blank');
            } else {
                showToast('error', "{{__('证书文件不存在')}}");
            }
        });
    })
</script>
