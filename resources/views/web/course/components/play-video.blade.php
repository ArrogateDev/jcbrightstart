<script>
    $(function () {
        const $modal = $('#learn-box');
        let currentUnit = null;
        let currentChapter = null;
        let playStartTime = null;
        let youtubePlayer = null;
        let playPositionTimer = null;
        let isPlaying = false;
        let currentStartTime = 0;
        let status = 0;

        function playVideo(unit, position = 0) {
            clearVideo()
            currentUnit = unit.id
            currentChapter = unit.chapter_id
            // 开始加载新内容时显示 Loading
            $('#play-loading').removeClass('d-none').addClass('d-flex')
            
            if (unit.type === 0 && unit.video_url) {
                $modal.removeClass('modal-pdf');
                let videoId = unit.video_id;
                if (videoId) {
                    $('#play-content').html('<div id="youtube-player"></div>');
                    initYouTubePlayer(videoId, position);
                } else {
                    $('#play-content').html('<div class="alert alert-danger text-center">{{__("视频链接格式错误")}}</div>');
                }
            } else {
                $modal.removeClass('modal-pdf');
                $('#play-content').html('<div class="alert alert-warning text-center">{{__("该单元暂无内容")}}</div>');
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
                    // 使用主文件的公用函数
                    if (typeof window.recordPlayStart === 'function') {
                        window.recordPlayStart(currentChapter, currentUnit);
                    }
                }

                startPlayPositionTracking();
            } else if (state === YT.PlayerState.PAUSED) {
                isPlaying = false;
                if (currentUnit && currentChapter) {
                    // 使用主文件的公用函数
                    if (typeof window.recordPlayStart === 'function') {
                        window.recordPlayStart(currentChapter, currentUnit);
                    }
                }
                updatePlayPosition();
            } else if (state === YT.PlayerState.ENDED) {
                isPlaying = false;
                if (currentUnit && currentChapter) {
                    // 使用主文件的公用函数
                    if (typeof window.recordPlayEnd === 'function') {
                        const currentTime = event.target.getCurrentTime();
                        window.recordPlayEnd(currentChapter, currentUnit, Math.floor(currentTime));
                    }
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
                    errorMessage = "视频 ID 无效";
                    break;
                case 5:
                    errorMessage = "HTML5 播放器错误";
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
            console.error('YouTube 错误:', errorMessage);
            $('#play-content').html(`<div class="alert alert-danger text-center">{{__("播放错误")}}: ${errorMessage}</div>`);
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
                        // 使用主文件的公用函数
                        if (typeof window.savePlayRecord === 'function') {
                            window.savePlayRecord(currentChapter, currentUnit, Math.floor(currentTime));
                        }
                    }
                } catch (e) {
                    console.error('获取播放位置失败:', e);
                }
            }
        }

        function clearVideo() {
            if (youtubePlayer) {
                try {
                    youtubePlayer.destroy();
                } catch (e) {
                    console.error('销毁播放器失败:', e);
                }
                youtubePlayer = null;
            }

            stopPlayPositionTracking()
        }

        // 导出函数供外部调用
        window.playVideo = playVideo;
        window.clearVideo = clearVideo;
        
        // 暴露一些必要的变量和方法
        window.videoGetCurrentPosition = function() {
            if (youtubePlayer) {
                try {
                    return Math.floor(youtubePlayer.getCurrentTime() || 0);
                } catch (e) {
                    console.error('获取播放位置失败:', e);
                }
            }
            return 0;
        };
        
        window.getVideoCurrentUnit = function() { return currentUnit; };
        window.getVideoCurrentChapter = function() { return currentChapter; };
        window.setVideoStatus = function(newStatus) { status = newStatus; };
    })
</script>
