<script>
    $(function () {
        let $loading = $('#play-loading');
        let currentUnit = null;
        let currentChapter = null;
        let dFlipInstance = null;
        let pageCount = 0;
        let currentPdfPage = 0;
        let status = 0;
        let pdfAutoCompleteTimer = null;
        let pendingPdfInit = null;
        let hasRecordedEnd = false;

        function playPdf(unit, position = 0) {
            clearPdf()
            currentUnit = unit.id
            currentChapter = unit.chapter_id
            hasRecordedEnd = false;

            // 开始加载新内容时显示 Loading
            $loading.removeClass('d-none').addClass('d-flex')
            $('#play-content').html(`<div class="_df_book" id="pdf-viewer"></div>`);

            pendingPdfInit = function () {

                if (!$('#pdf-viewer').length) return;

                try {

                    const openPage = parseInt(position, 10);

                    const flipOptions = {
                        showDownloadControl: false,
                        enableDownload: false,
                        showPrintControl: false,
                        showSearchControl: false,
                        autoOpenOutline: false,
                        showThumbnail: false,
                        autoOpenThumbnail: false,
                        onReady: function onReady(app) {
                            // 使用主文件的公用函数
                            if (typeof window.recordPlayStart === 'function') {
                                window.recordPlayStart(currentChapter, currentUnit);
                            }
                            pageCount = app.pageCount;
                            currentPdfPage = app.currentPageNumber || 1;
                            $loading.removeClass('d-flex').addClass('d-none')
                            setupPdfAutoComplete(pageCount);
                        },
                        onPageChanged: function (app) {
                            const currentPage = app.currentPageNumber;
                            const totalPages = app.pageCount;
                            currentPdfPage = currentPage;

                            if (pdfAutoCompleteTimer) {
                                clearTimeout(pdfAutoCompleteTimer);
                                pdfAutoCompleteTimer = null;
                            }

                            if (currentPage === totalPages) {
                                // 使用主文件的公用函数
                                if (!hasRecordedEnd && typeof window.recordPlayEnd === 'function') {
                                    hasRecordedEnd = true;
                                    window.recordPlayEnd(currentChapter, currentUnit, totalPages);
                                }
                            } else {
                                // 使用主文件的公用函数
                                if (typeof window.savePlayRecord === 'function') {
                                    window.savePlayRecord(currentChapter, currentUnit, currentPage)
                                }
                            }
                        }
                    };

                    // dFlip 使用 1-based 页码；仅当 position>0 时覆盖默认打开页
                    if (!isNaN(openPage) && openPage > 0) {
                        flipOptions.openPage = openPage;
                    }

                    dFlipInstance = $('#pdf-viewer').flipBook(unit.file_url, flipOptions);
                    pendingPdfInit = null;
                } catch (e) {
                    console.error('初始化 PDF 失败:', e);
                }
            };
            // 新版：不用等待 modal 打开，直接初始化
            setTimeout(function () {
                if (pendingPdfInit) pendingPdfInit();
            }, 150);
        }

        function setupPdfAutoComplete(totalPages) {
            if (totalPages <= 2) {
                const delay = totalPages === 1 ? 3000 : 6000;

                pdfAutoCompleteTimer = setTimeout(function () {
                    if (currentUnit && currentChapter) {
                        if (!hasRecordedEnd && typeof window.recordPlayEnd === 'function') {
                            hasRecordedEnd = true;
                            window.recordPlayEnd(currentChapter, currentUnit, totalPages);
                        }
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
            hasRecordedEnd = false;
            currentPdfPage = 0;

            $('#dflip-pdf-viewer').remove();
            $('#pdf-viewer').remove();
            $('#play-content').find('#pdf-viewer').remove();
        }

        // 导出函数供外部调用
        window.playPdf = playPdf;
        window.clearPdf = clearPdf;

        // 暴露一些必要的变量和方法
        // 注意：这里按项目现有逻辑，用它来返回“当前页码”，用于保存/续播
        window.getPdfPageCount = function () {
            return currentPdfPage;
        };
        window.getPdfCurrentUnit = function () {
            return currentUnit;
        };
        window.getPdfCurrentChapter = function () {
            return currentChapter;
        };
        window.setPdfStatus = function (newStatus) {
            status = newStatus;
        };
        window.triggerPendingPdfInit = function () {
            if (!pendingPdfInit) return;
            setTimeout(function () {
                if (pendingPdfInit) pendingPdfInit();
            }, 150);
        };
    })
</script>
