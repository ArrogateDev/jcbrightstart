@props(['height' => 300, 'type' => ''])

{{-- 图片上传函数 --}}
<script>
    // 辅助函数：在光标位置插入图片
    function insertImageAtCursor($editable, imgNode, loadingText) {
        try {
            // 聚焦编辑区域
            $editable.focus();

            // 获取当前选择
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                // 删除可能存在的加载文本
                if (range.startContainer.nodeType === Node.TEXT_NODE) {
                    const text = range.startContainer.textContent || '';
                    if (text.includes(loadingText)) {
                        range.startContainer.textContent = text.replace(loadingText, '');
                    }
                }
                // 在光标位置插入图片
                range.insertNode(imgNode);
                // 将光标移到图片后面
                range.setStartAfter(imgNode);
                range.collapse(true);
                selection.removeAllRanges();
                selection.addRange(range);
                return true;
            } else {
                // 如果没有选择，尝试在编辑区域末尾插入
                $editable.append(imgNode);
                return false;
            }
        } catch(e) {
            // 如果失败，追加到末尾
            $editable.append(imgNode);
            return false;
        }
    }

    // 图片上传函数
    function uploadImageToServer(file, $editor, savedCursorRange) {
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

        // 获取 summernote 的编辑区域
        const $noteEditor = $editor.next('.note-editor');
        const $noteEditable = $noteEditor.find('.note-editable');

        // 使用传入的保存范围，如果没有则尝试获取当前光标位置
        let savedRange = savedCursorRange || null;

        if (!savedRange) {
            try {
                // 聚焦编辑区域以确保有选择
                $noteEditable.focus();
                const selection = window.getSelection();
                if (selection.rangeCount > 0) {
                    const range = selection.getRangeAt(0);
                    savedRange = range.cloneRange();
                }
            } catch(e) {
                // 如果无法获取范围，忽略
            }
        }

        $.ajax({
            url: '{{route('admin.upload-image.html')}}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function () {
                // 不插入加载文本，避免改变光标位置
            },
            success: function (response) {
                if (response.code === 0 && response.data && response.data.url) {
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
                    const imgNode = $p[0];

                    // 尝试在光标位置插入图片
                    try {
                        // 获取当前内容
                        let editableContent = $noteEditable.html() || '';

                        // 如果编辑器为空，直接设置内容
                        if (!editableContent || editableContent.trim() === '' || editableContent === '<br>' || editableContent === '<p><br></p>') {
                            $noteEditable.html(imgNode.outerHTML);
                        } else {
                            // 聚焦编辑区域
                            $noteEditable.focus();

                            // 尝试恢复保存的光标位置
                            if (savedRange) {
                                try {
                                    const selection = window.getSelection();
                                    selection.removeAllRanges();

                                    // 检查保存的范围是否仍然有效
                                    if (savedRange.startContainer && document.contains(savedRange.startContainer)) {
                                        selection.addRange(savedRange);
                                        // 在光标位置插入图片
                                        savedRange.insertNode(imgNode);

                                        // 将光标移到图片后面
                                        const newRange = document.createRange();
                                        newRange.setStartAfter(imgNode);
                                        newRange.collapse(true);
                                        selection.removeAllRanges();
                                        selection.addRange(newRange);
                                    } else {
                                        // 如果保存的范围无效，使用当前光标位置
                                        insertImageAtCursor($noteEditable, imgNode, '');
                                    }
                                } catch(e) {
                                    // 如果恢复失败，使用当前光标位置
                                    insertImageAtCursor($noteEditable, imgNode, '');
                                }
                            } else {
                                // 如果没有保存的范围，尝试获取当前光标位置
                                insertImageAtCursor($noteEditable, imgNode, '');
                            }
                        }
                    } catch (e) {
                        // 如果所有方法都失败，使用最简单的追加方法
                        let editableContent = $noteEditable.html() || '';
                        if (!editableContent || editableContent.trim() === '' || editableContent === '<br>' || editableContent === '<p><br></p>') {
                            $noteEditable.html(imgNode.outerHTML);
                        } else {
                            $noteEditable.append(imgNode);
                        }
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
                                // 在回调中立即保存光标位置（此时光标还在）
                                const $noteEditor = $editor.next('.note-editor');
                                const $noteEditable = $noteEditor.find('.note-editable');

                                let savedCursorRange = null;
                                try {
                                    $noteEditable.focus();
                                    const selection = window.getSelection();
                                    if (selection.rangeCount > 0) {
                                        savedCursorRange = selection.getRangeAt(0).cloneRange();
                                    }
                                } catch(e) {
                                    // 忽略错误
                                }

                                // 当用户选择图片时自动上传，并传递保存的光标位置
                                uploadImageToServer(files[0], $editor, savedCursorRange);
                            }
                        }
                    });
                });
            }
        }, 100);
    });
</script>

