<div class="modal fade" id="course-complete-box" tabindex="-1" aria-labelledby="course-complete-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="course-complete-label">{{__('填写证书信息')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="course-complete-form">
                    <div class="form-group">
                        <label for="certificate-name">{{__('请输入您的姓名')}}</label>
                        <input type="text" class="form-control" id="certificate-name" placeholder="{{__('请输入姓名')}}">
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
<script>
    $(function () {
        const $courseCompleteModal = $('#course-complete-box');
        const $certificateNameInput = $('#certificate-name');
        const $submitCertificateBtn = $('#submit-certificate-btn');

        $submitCertificateBtn.on('click', function () {
            const name = $certificateNameInput.val().trim();
            if (!name) {
                showToast('error', '{{__('请输入姓名')}}');
                $certificateNameInput.focus();
                return;
            }

            const currentCourseId = $('#course-certificate').val()
            $submitCertificateBtn.prop('disabled', true).text('{{__('提交中...')}}');
            showLoading($courseCompleteModal.find('.modal-content'));

            $.ajax({
                url: `/course/${currentCourseId}/certificate.html`,
                type: 'POST',
                data: {
                    name: name,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (response) {
                    hideLoading($courseCompleteModal.find('.modal-content'));
                    if (response.code !== 0) {
                        showToast('error', response.msg || '{{__('提交失败')}}');
                        $submitCertificateBtn.prop('disabled', false).text('{{__('提交')}}');
                        return;
                    }

                    showToast('success', '{{__('提交成功')}}');
                    $courseCompleteModal.modal('hide');
                },
                error: function () {
                    hideLoading($courseCompleteModal.find('.modal-content'));
                    showToast('error', '{{__('提交失败，请重试')}}');
                    $submitCertificateBtn.prop('disabled', false).text('{{__('提交')}}');
                }
            });
        });

        $courseCompleteModal.on('hidden.bs.modal', function () {
            $certificateNameInput.val('');
            $submitCertificateBtn.prop('disabled', false).text('{{__('提交')}}');
        });
    })
</script>
