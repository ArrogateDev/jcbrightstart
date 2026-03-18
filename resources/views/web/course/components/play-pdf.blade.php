<script>
    $(function () {
        const $modal = $('#learn-box');
        let currentUnit = null;
        let currentChapter = null;
        let dFlipInstance = null;
        let pageCount = 0;
        let status = 0;
        let pdfAutoCompleteTimer = null;
        let pendingPdfInit = null;

        function playPdf(unit, position = 0) {
            clearPdf()
            currentUnit = unit.id
            currentChapter = unit.chapter_id
            
            // 开始加载新内容时显示 Loading
            $('#play-loading').removeClass('d-none').addClass('d-flex')
            
            if (unit.type === 1 && unit.file_url) {
                $('#play-content').html(`<div class="_df_book" id="pdf-viewer"></div>`);
                $('#learn-box .modal-body').addClass('has-dflip');
                $modal.addClass('modal-pdf');

                function getPdfHeight() {
                    const $playContent = $('#play-content');
                    const modalHeader = $('#learn-box .modal-header').height() || 0;
                    let height = $(window).height() - modalHeader + 120;

                    const $parent = $playContent.parent();
                    if ($parent.length && $parent.height() > 0) {
                        height = Math.min(height, $parent.height());
                    }

                    return Math.max(height, 400);
                }

                pendingPdfInit = function () {
                    if (!$('#pdf-viewer').length) return;
                    try {
                        const pdfHeight = getPdfHeight();
                        console.log('PDF 高度:', pdfHeight);
                        
                        dFlipInstance = $('#pdf-viewer').flipBook(unit.file_url, {
                            showDownloadControl: false,
                            enableDownload: false,
                            showPrintControl: false,
                            showSearchControl: false,
                            height: pdfHeight + 'px',
                            autoOpenOutline: false,
                            showThumbnail: false,
                            autoOpenThumbnail: false,
                            onReady: function onReady(app) {
                                // 使用主文件的公用函数
                                if (typeof window.recordPlayStart === 'function') {
                                    window.recordPlayStart(currentChapter, currentUnit);
                                }
                                pageCount = app.pageCount;
                                $('#play-loading').removeClass('d-flex').addClass('d-none')
                                setupPdfAutoComplete(pageCount);
                            },
                            onPageChanged: function (app) {
                                const currentPage = app.currentPageNumber;
                                const totalPages = app.pageCount;

                                if (pdfAutoCompleteTimer) {
                                    clearTimeout(pdfAutoCompleteTimer);
                                    pdfAutoCompleteTimer = null;
                                }

                                if (currentPage === totalPages) {
                                    // 使用主文件的公用函数
                                    if (typeof window.recordPlayEnd === 'function') {
                                        window.recordPlayEnd(currentChapter, currentUnit);
                                    }
                                } else {
                                    // 使用主文件的公用函数
                                    if (typeof window.savePlayRecord === 'function') {
                                        window.savePlayRecord(currentChapter, currentUnit, currentPage)
                                    }
                                }
                            }
                        });
                        pendingPdfInit = null;
                    } catch (e) {
                        console.error('初始化 PDF 失败:', e);
                    }
                };

                if ($('#learn-play').hasClass('active') && $modal.hasClass('show')) {
                    setTimeout(function () {
                        if (pendingPdfInit) pendingPdfInit();
                    }, 150);
                }
            } else {
                $modal.removeClass('modal-pdf');
                $('#play-content').html('<div class="alert alert-warning text-center">{{__("该单元暂无内容")}}</div>');
                $('#play-loading').removeClass('d-flex').addClass('d-none')
            }
        }

        function recordPlayStart(chapterId, unitId) {
            if (status > 0) return
            $.ajax({
                url: '{{route('course.play-start.html', ['course' => $course->id])}}',
                type: 'POST',
                data: {
                    chapter_id: chapterId,
                    unit_id: unitId,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json'
            });
        }

        function setupPdfAutoComplete(totalPages) {
            if (totalPages <= 2) {
                const delay = totalPages === 1 ? 3000 : 6000;

                pdfAutoCompleteTimer = setTimeout(function () {
                    if (currentUnit && currentChapter) {
                        recordPlayEnd(currentChapter, currentUnit, totalPages);
                    }
                }, delay);
            }
        }

        function clearPdf() {
            if (dFlipInstance) {
                try {
                    if (typeof dFlipInstance.destroy === 'function') {
                        dFlipInstance.destroy();
                    }
                } catch (e) {
                    console.error('销毁 dFlip 实例失败:', e);
                }
                dFlipInstance = null;
            }

            if (pdfAutoCompleteTimer) {
                clearTimeout(pdfAutoCompleteTimer);
                pdfAutoCompleteTimer = null;
            }

            pendingPdfInit = null;
            window.dFlipBindRetryCount = 0;

            $('#dflip-pdf-viewer').remove();
            $('#learn-box .modal-body').removeClass('has-dflip');
            $modal.removeClass('modal-pdf');
        }

        // 导出函数供外部调用
        window.playPdf = playPdf;
        window.clearPdf = clearPdf;
        
        // 暴露一些必要的变量和方法
        window.getPdfPageCount = function() { return pageCount; };
        window.getPdfCurrentUnit = function() { return currentUnit; };
        window.getPdfCurrentChapter = function() { return currentChapter; };
        window.setPdfStatus = function(newStatus) { status = newStatus; };
        window.triggerPendingPdfInit = function() {
            if (pendingPdfInit && $('#learn-play').hasClass('active') && $modal.hasClass('show')) {
                setTimeout(function () {
                    if (pendingPdfInit) pendingPdfInit();
                }, 150);
            }
        };
    })
</script>
