@props(['height' => 300, 'type' => ''])

{{-- 图片上传函数 --}}
<script>
    // 图片上传函数
    function uploadImageToServer(file, $editor) {
        // 验证文件类型和大小
        if (!file.type.match('image.*')) {
            showToast('error', '{{__('请选择图片文件')}}');
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            showToast('error', '{{__('图片大小不能超过5MB')}}');
            return;
        }

        showLoading()
        const formData = new FormData();
        formData.append('image', file);
        formData.append('type', '{{$type}}');
        formData.append('_token', '{{csrf_token()}}');

        const loadingText = '{{__('正在上传图片...')}}';

        $.ajax({
            url: '{{route('admin.upload-image.html')}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function () {
                $editor.summernote('insertText', loadingText);
            },
            success: function (response) {
                if (response.code === 0 && response.data && response.data.url) {
                    // 获取 summernote 的编辑区域
                    const $noteEditor = $editor.next('.note-editor');
                    const $noteEditable = $noteEditor.find('.note-editable');

                    // 移除上传提示文本
                    let editableContent = $noteEditable.html() || '';
                    editableContent = editableContent.replace(loadingText, '');

                    // 创建图片元素
                    const $img = $('<img>').attr('src', response.data.url)
                        .attr('alt', '')
                        .css({
                            'max-width': '100%',
                            'height': 'auto',
                            'display': 'block'
                        });

                    // 创建段落包裹图片
                    const $p = $('<p>').append($img);

                    // 如果编辑器为空或只有 <br>，直接设置内容
                    if (!editableContent || editableContent.trim() === '' || editableContent === '<br>' || editableContent === '<p><br></p>') {
                        $noteEditable.html($p[0].outerHTML);
                    } else {
                        // 追加图片到内容末尾
                        $noteEditable.append($p[0]);
                    }

                    // 触发 input 事件确保 summernote 知道内容已更改
                    $noteEditable.trigger('input');

                    // 也更新隐藏的 textarea
                    $editor.summernote('code', $noteEditable.html());

                    showToast('success', '{{__('图片上传成功')}}');
                } else {
                    // 移除上传提示文本
                    let content = $editor.summernote('code');
                    content = content.replace(loadingText, '');
                    $editor.summernote('code', content);
                    showToast('error', response.msg || '{{__('图片上传失败')}}');
                }
            },
            error: function (xhr) {
                // 移除上传提示文本
                let content = $editor.summernote('code');
                content = content.replace(loadingText, '');
                $editor.summernote('code', content);
                let errorMsg = '{{__('图片上传失败，请稍后再试')}}';
                if (xhr.responseJSON && xhr.responseJSON.msg) {
                    errorMsg = xhr.responseJSON.msg;
                }
                showToast('error', errorMsg);
            },
            complete: function () {
                hideLoading()
            }
        });
    }

    // 初始化 Summernote 编辑器，配置图片上传
    // 使用 setTimeout 确保在 script.js 初始化之后执行
    $(document).ready(function () {
        setTimeout(function () {
            if ($('.summernote').length > 0) {
                $('.summernote').each(function () {
                    const $editor = $(this);
                    // 如果已经初始化，先销毁
                    try {
                        if ($editor.summernote('code') !== undefined) {
                            $editor.summernote('destroy');
                        }
                    } catch (e) {
                        // 如果还没有初始化，忽略错误
                    }
                    // 重新初始化并配置图片上传
                    $editor.summernote({
                        height: {{ $height }},
                        minHeight: null,
                        maxHeight: null,
                        toolbar: [
                            ['fontsize', ['fontsize']],
                            ['font', ['bold', 'italic', 'underline', 'clear', 'strikethrough']],
                            ['insert', ['picture', 'link']],
                            ['para', ['ul', 'ol', 'paragraph']],
                        ],
                        callbacks: {
                            onImageUpload: function (files) {
                                // 当用户选择图片时自动上传
                                uploadImageToServer(files[0], $editor);
                            }
                        }
                    });
                });
            }
        }, 100);
    });
</script>

