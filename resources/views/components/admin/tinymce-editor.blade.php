@props(['height' => 600, 'type' => ''])

<script>
    function initSingleTinyMCE(editorSelector) {
        if (!window.tinymce || !document.querySelector(editorSelector)) {
            return;
        }

        if (tinymce.get(editorSelector.replace('#', ''))) {
            tinymce.get(editorSelector.replace('#', '')).remove();
        }

        tinymce.init({
            selector: editorSelector,
            height: {{ $height }},
            menubar: false,
            branding: false,
            toolbar_mode: 'wrap',
            plugins: 'preview searchreplace autolink autosave save directionality fullscreen image link media table charmap pagebreak nonbreaking advlist lists wordcount help quickbars code emoticons',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | link image media table charmap hr pagebreak emoticons | preview fullscreen | removeformat code',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px } img { max-width: 100%; height: auto; display: block; }',
            images_upload_handler: function (blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    const file = blobInfo.blob();

                    if (!file.type.match('image.*')) {
                        showToast('error', '{{__('请选择图片文件')}}');
                        reject('{{__('请选择图片文件')}}');
                        return;
                    }

                    if (file.size > 5 * 1024 * 1024) {
                        showToast('error', '{{__('图片大小不能超过5MB')}}');
                        reject('{{__('图片大小不能超过5MB')}}');
                        return;
                    }

                    showLoading();
                    const formData = new FormData();
                    formData.append('image', file, blobInfo.filename());
                    formData.append('type', '{{$type}}');
                    formData.append('_token', '{{csrf_token()}}');

                    $.ajax({
                        url: '{{route('admin.upload-image.html')}}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        xhr: function () {
                            const xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                    progress((e.loaded / e.total) * 100);
                                }
                            });
                            return xhr;
                        },
                        success: function (response) {
                            if (response.code === 0 && response.data && response.data.url) {
                                showToast('success', '{{__('图片上传成功')}}');
                                resolve(response.data.url);
                            } else {
                                const msg = response.msg || '{{__('图片上传失败')}}';
                                showToast('error', msg);
                                reject(msg);
                            }
                        },
                        error: function (xhr) {
                            let errorMsg = '{{__('图片上传失败，请稍后再试')}}';
                            if (xhr.responseJSON && xhr.responseJSON.msg) {
                                errorMsg = xhr.responseJSON.msg;
                            }
                            showToast('error', errorMsg);
                            reject(errorMsg);
                        },
                        complete: function () {
                            hideLoading();
                        }
                    });
                });
            }
        });
    }

    function initAllTinyMCE() {
        const editors = document.querySelectorAll('.tinymce-editor');
        editors.forEach((editor) => {
            // 跳过隐藏模板里的编辑器，避免模板被初始化后克隆出重复编辑框
            if (editor.closest('#unit-template') || editor.closest('#chapter-template')) {
                return;
            }

            if (!editor.id) {
                editor.id = 'tinymce-editor-' + Math.random().toString(36).slice(2, 10);
            }
            initSingleTinyMCE('#' + editor.id);
        });
    }

    $(document).ready(function () {
        setTimeout(function () {
            initAllTinyMCE();
        }, 100);
    });
</script>
