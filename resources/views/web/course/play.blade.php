<link rel="stylesheet" href="{{web_resource_url('assets/web/vendor/dflip/dflip.min.css')}}">

<div class="modal fade" id="play-box" tabindex="-1" aria-labelledby="play-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="play-label">{{__('播放课程')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="play-content"></div>
                <div id="play-loading" class="d-flex justify-content-center align-items-center" style="height: 100%;">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">{{__('加载中...')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{web_resource_url('assets/web/vendor/dflip/js/dflip.min.js')}}"></script>

<script>
    $(function () {
        const $modal = $('#play-box');
        const $quiz = $('#quiz-box');
        let currentUnit = null;
        let currentChapter = null;
        let playStartTime = null;
        let youtubePlayer = null;
        let playPositionTimer = null;
        let isPlaying = false;
        let currentStartTime = 0;
        let dFlipInstance = null;
        let pageCount = 0;
        let status = 0;
        let pdfAutoCompleteTimer = null;

        function playUnit(unit, position = 0) {

            clearPlay()
            currentUnit = unit.id
            currentChapter = unit.chapter_id
            if (unit.type === 0 && unit.video_url) {
                $modal.removeClass('modal-pdf');
                let videoId = unit.video_id;
                if (videoId) {
                    $('#play-content').html('<div id="youtube-player"></div>');
                    initYouTubePlayer(videoId, position);
                } else {
                    $('#play-content').html('<div class="alert alert-danger text-center">{{__('视频链接格式错误')}}</div>');
                }
            } else if (unit.type === 1 && unit.file_url) {
                $('#play-content').html(`<div class="_df_book" id="pdf-viewer"></div>`);
                $('#play-box .modal-body').addClass('has-dflip');

                $modal.addClass('modal-pdf');

                $('#pdf-viewer').flipBook(unit.file_url, {
                    showDownloadControl: false,
                    enableDownload: false,
                    showPrintControl: false,
                    showSearchControl: false,
                    autoOpenOutline: false,
                    showThumbnail: false,
                    autoOpenThumbnail: false,
                    onReady: function onReady(app) {
                        recordPlayStart(currentChapter, currentUnit);
                        pageCount = app.pageCount;
                        $('#play-loading').removeClass('d-flex').addClass('d-none')

                        // 对于少页数PDF，设置自动完成检查
                        setupPdfAutoComplete(pageCount);
                    },
                    onPageChanged: function (app) {
                        const currentPage = app.currentPageNumber;
                        const totalPages = app.pageCount;

                        // 清除自动完成定时器，因为用户已经手动翻页
                        if (pdfAutoCompleteTimer) {
                            clearTimeout(pdfAutoCompleteTimer);
                            pdfAutoCompleteTimer = null;
                        }

                        if (currentPage === totalPages) {
                            recordPlayEnd(currentChapter, currentUnit)
                        } else {
                            savePlayRecord(currentChapter, currentUnit, currentPage)
                        }
                    }
                });
            } else {
                $modal.removeClass('modal-pdf');
                $('#play-content').html('<div class="alert alert-warning text-center">{{__('该单元暂无内容')}}</div>');
                $('#play-loading').removeClass('d-flex').addClass('d-none')
            }
        }

        function initYouTubePlayer(videoId, startTime = 0) {
            if (typeof YT === 'undefined' || typeof YT.Player === 'undefined') {
                const tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                const firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                window.onYouTubeIframeAPIReady = function () {
                    createYouTubePlayer(videoId, startTime);
                };
            } else {
                createYouTubePlayer(videoId, startTime);
            }
        }

        function createYouTubePlayer(videoId, startTime = 0) {
            currentStartTime = startTime;
            const playerVars = {
                'playsinline': 1,
                'modestbranding': 1,
                'rel': 0,
                'controls': 1,
                'disablekb': 1,
                'enablejsapi': 1,
                'fs': 1,
                'iv_load_policy': 3,
                'cc_load_policy': 0,
            };

            if (startTime > 0) {
                playerVars.start = startTime;
            }

            youtubePlayer = new YT.Player('youtube-player', {
                height: '100%',
                width: '100%',
                videoId: videoId,
                playerVars: playerVars,
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange,
                    'onError': onPlayerError
                }
            });
        }

        function onPlayerReady(event) {
            if (currentStartTime > 0) {
                event.target.seekTo(currentStartTime, true);
            }
            $('#play-loading').removeClass('d-flex').addClass('d-none')
        }

        function onPlayerStateChange(event) {
            const state = event.data;

            if (state === YT.PlayerState.PLAYING) {
                isPlaying = true;
                if (currentUnit && currentChapter) {
                    recordPlayStart(currentChapter, currentUnit);
                }

                startPlayPositionTracking();
            } else if (state === YT.PlayerState.PAUSED) {
                isPlaying = false;
                if (currentUnit && currentChapter) {
                    recordPlayStart(currentChapter, currentUnit);
                }
                updatePlayPosition();
            } else if (state === YT.PlayerState.ENDED) {
                isPlaying = false;
                if (currentUnit && currentChapter) {
                    recordPlayStart(currentChapter, currentUnit);
                    const currentTime = event.target.getCurrentTime();
                    recordPlayEnd(currentChapter, currentUnit, Math.floor(currentTime));
                }
                stopPlayPositionTracking();
            } else if (state === YT.PlayerState.BUFFERING) {
                isPlaying = false;
            }
        }

        function onPlayerError(event) {
            let errorMessage = "未知错误";
            switch (event.data) {
                case 2:
                    errorMessage = "视频ID无效";
                    break;
                case 5:
                    errorMessage = "HTML5播放器错误";
                    break;
                case 100:
                    errorMessage = "视频不存在或已被删除";
                    break;
                case 101:
                case 150:
                    errorMessage = "视频嵌入权限受限";
                    break;
                case 153:
                    errorMessage = "播放器配置错误";
                    break;
            }
            console.error('YouTube错误:', errorMessage);
            $('#play-content').html(`<div class="alert alert-danger text-center">{{__('播放错误')}}: ${errorMessage}</div>`);
        }

        function startPlayPositionTracking() {
            if (playPositionTimer) {
                clearInterval(playPositionTimer);
            }
            playPositionTimer = setInterval(function () {
                updatePlayPosition();
            }, 5000);
        }

        function stopPlayPositionTracking() {
            if (playPositionTimer) {
                clearInterval(playPositionTimer);
                playPositionTimer = null;
            }
        }

        function updatePlayPosition() {
            if (youtubePlayer && currentUnit && currentChapter) {
                try {
                    const currentTime = youtubePlayer.getCurrentTime();
                    if (currentTime !== null && currentTime !== undefined) {
                        savePlayRecord(currentChapter, currentUnit, Math.floor(currentTime));
                    }
                } catch (e) {
                    console.error('获取播放位置失败:', e);
                }
            }
        }

        function recordPlayStart(chapterId, unitId) {
            if (status > 0) return
            playStartTime = new Date();
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

        function updateUnitStatus(unitId, newStatus) {
            const $unitItem = $(`li[data-unit="${unitId}"]`);
            if (!$unitItem.length) {
                return;
            }

            const $actionDiv = $unitItem.find('.d-flex.align-items-center');
            if (!$actionDiv.length) {
                return;
            }

            let unitInfo = $unitItem.data('info');
            if (unitInfo) {
                unitInfo.status = newStatus;
                $unitItem.data('info', unitInfo);
            }

            if (newStatus === 2) {
                const playPosition = unitInfo ? (unitInfo.play_position || 0) : 0;

                $actionDiv.html(`
                    <a href="#" class="preview-link" data-toggle="modal" data-target="#play-box"
                       data-unit="${unitId}"
                       data-status="2"
                       data-play-position="${playPosition}">{{__('打开')}}</a>
                    <i class="fa-solid fa-circle-check text-success ml-3"></i>
                `);
            } else if (newStatus === 1) {
                const courseId = unitInfo ? (unitInfo.course_id || 0) : 0;
                const chapterId = unitInfo ? (unitInfo.chapter_id || 0) : 0;
                const quizId = unitInfo ? (unitInfo.quiz_id || 0) : 0;

                $actionDiv.html(`
                    <a href="#" class="preview-link" data-toggle="modal" data-target="#quiz-box"
                       data-course="${courseId}"
                       data-chapter="${chapterId}"
                       data-unit="${unitId}"
                       data-quiz="${quizId}"
                       data-status="1">{{__('测验')}}</a>
                    <i class="fa-solid fa-book text-warning ml-3"></i>
                `);
            }
        }

        function recordPlayEnd(chapterId, unitId, playPosition) {
            if (!playStartTime) {
                return;
            }
            if (status > 0) return

            $.ajax({
                url: '{{route('course.play-end.html', ['course' => $course->id])}}',
                type: 'POST',
                data: {
                    chapter_id: chapterId,
                    unit_id: unitId,
                    play_position: playPosition || 0,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.code !== 0) {
                        showToast('error', response.msg);
                        return;
                    }
                    updateUnitStatus(unitId, 1);

                    const quiz = response.data.quiz
                    $modal.modal('hide')
                    const params = {
                        course: {{$course->id}},
                        chapter: chapterId,
                        unit: unitId,
                        quiz: quiz,
                    };
                    $quiz.data('params', params);
                    $quiz.modal('show')
                },
                error: function () {
                    // 记录失败，但不影响
                }
            });

            playStartTime = null;
        }

        function savePlayRecord(chapterId, unitId, playPosition) {
            if (status > 0) return
            $.ajax({
                url: '{{route('course.save-play-record.html', ['course' => $course->id])}}',
                type: 'POST',
                data: {
                    chapter_id: chapterId,
                    unit_id: unitId,
                    play_position: playPosition || 0,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json'
            });
        }

        function setupPdfAutoComplete(totalPages) {
            // 如果PDF只有1-2页，则设置自动完成检查
            if (totalPages <= 2) {
                const delay = totalPages === 1 ? 3000 : 6000; // 1页30秒，2页60秒

                pdfAutoCompleteTimer = setTimeout(function() {
                    if (currentUnit && currentChapter) {
                        // 直接记录播放结束
                        recordPlayEnd(currentChapter, currentUnit, totalPages);
                    }
                }, delay);
            }
        }

        function clearPlay() {
            if (youtubePlayer) {
                try {
                    youtubePlayer.destroy();
                } catch (e) {
                    console.error('销毁播放器失败:', e);
                }
                youtubePlayer = null;
            }

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

            if (window.dFlipPageCheckInterval) {
                clearInterval(window.dFlipPageCheckInterval);
                window.dFlipPageCheckInterval = null;
            }

            // 清除PDF自动完成定时器
            if (pdfAutoCompleteTimer) {
                clearTimeout(pdfAutoCompleteTimer);
                pdfAutoCompleteTimer = null;
            }

            window.dFlipBindRetryCount = 0;

            $('#dflip-pdf-viewer').remove();
            $('#play-box .modal-body').removeClass('has-dflip');

            $modal.removeClass('modal-pdf');

            stopPlayPositionTracking()
        }

        $modal.on('show.bs.modal', function (event) {
            const button = event.relatedTarget
            const unit = parseInt(button.getAttribute('data-unit') || 0)
            status = parseInt(button.getAttribute('data-status') || 0)
            const position = parseInt(button.getAttribute('data-play-position'))

            let $unit = $(`li[data-unit="${unit}"]`);
            if (!$unit) {
                $unit = $('li[data-unit]').eq(0)
            }

            const info = $unit.data('info')
            if (!info) {
                $modal.modal('hide')
                return
            }

            const title = $unit.data('title')
            $('#play-label').text(title);
            playUnit(info, position);
        });

        $modal.on('hidden.bs.modal', function (event) {
            if (currentUnit && currentChapter) {
                let playPosition = 0;
                if (youtubePlayer) {
                    try {
                        playPosition = Math.floor(youtubePlayer.getCurrentTime() || 0);
                    } catch (e) {
                        console.error('获取播放位置失败:', e);
                    }
                } else if (dFlipInstance) {
                    playPosition = pageCount;
                }
                savePlayRecord(currentChapter, currentUnit, playPosition);
            }

            clearPlay()

            playStartTime = null;
            isPlaying = false;
            status = 0;
            $('#play-loading').removeClass('d-none').addClass('d-flex')
        });
    })
</script>
