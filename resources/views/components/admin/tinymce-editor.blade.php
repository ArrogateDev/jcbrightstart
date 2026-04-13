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
            content_css: [
                '{{ web_resource_url("assets/web/vendor/bootstrap-4.1/bootstrap.min.css") }}',
                '{{ web_resource_url("assets/web/css/main.min.css") }}'
            ],
            content_style: 'ol{list-style: decimal; margin:0 0 1em; padding-left:2em;} ul{list-style: disc; margin:0 0 1em; padding-left:2em;} li{margin:.25em 0;} ol ol{list-style: lower-alpha;} ol ol ol{list-style: lower-roman;}',
            paste_as_text: false,
            paste_enable_default_filters: true,
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
