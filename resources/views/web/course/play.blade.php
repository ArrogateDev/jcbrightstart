<style>
    .modal {
        z-index: 9999;
    }

    .modal-backdrop.show {
        opacity: .5;
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1040;
        width: 100vw;
        height: 100vh;
        background-color: #000;
    }

    #play-box .modal-body {
        padding: 0;
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
    }

    #play-box .modal-body.has-dflip {
        padding-bottom: 0;
        height: 911px;
    }

    #play-box .modal-body:has(._df_book) {
        padding-bottom: 0;
        height: 911px;
    }

    #play-box .modal-body iframe,
    #play-box .modal-body .pdf-viewer,
    #play-box .modal-body #youtube-player {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    #play-box .modal-body ._df_book {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 911px;
    }

    #play-box .modal-body ._df_book,
    #play-box .modal-body ._df_book * {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-touch-callout: none;
    }

    #play-box.modal-pdf .modal-dialog {
        max-width: 95%;
        width: 95%;
    }

    @media (min-width: 1200px) {
        #play-box.modal-pdf .modal-dialog {
            max-width: 1150px;
            width: 1150px;
        }
    }
</style>

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
            <div class="modal-body" id="play-content">
                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
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
                    },
                    onPageChanged: function (app) {
                        const currentPage = app.currentPageNumber;
                        const totalPages = app.pageCount;
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
                'controls': 0,
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
                updatePlayPosition();
            } else if (state === YT.PlayerState.ENDED) {
                isPlaying = false;
                if (currentUnit && currentChapter) {
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

        function recordPlayEnd(chapterId, unitId, playPosition) {
            if (!playStartTime) {
                return;
            }

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
                        showToast('error', data.msg);
                        return;
                    }

                    $modal.modal('hide')
                    $quiz.modal('show')
                },
                error: function () {
                    // 记录失败，但不影响
                }
            });

            playStartTime = null;
        }

        function savePlayRecord(chapterId, unitId, playPosition) {
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

            window.dFlipBindRetryCount = 0;

            $('#dflip-pdf-viewer').remove();
            $('#play-box .modal-body').removeClass('has-dflip');

            $modal.removeClass('modal-pdf');

            stopPlayPositionTracking()
        }

        $modal.on('show.bs.modal', function (event) {
            const button = event.relatedTarget
            const unit = JSON.parse(button.getAttribute('data-unit')) || 0
            const position = JSON.parse(button.getAttribute('data-play-position'))

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
            $('#play-content').html('<div class="d-flex justify-content-center align-items-center" style="height: 100%;"><div class="spinner-border" role="status"><span class="sr-only">{{__('加载中...')}}</span></div></div>');
        });
    })
</script>
