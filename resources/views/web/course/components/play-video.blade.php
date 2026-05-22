<div id="youtube-player"></div>
<script>
    $(function () {
        let $loading = $('#play-loading');
        let youtubePlayer = null;
        let playPositionTimer = null;
        let currentUnit = null;
        let currentChapter = null;
        let currentStartTime = 0;

        /**
         * 初始化 YouTube 播放器
         */
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

        /**
         * 创建 YouTube 播放器实例
         */
        function createYouTubePlayer(videoId, startTime = 0) {
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

        /**
         * 播放器就绪回调
         */
        function onPlayerReady(event) {
            $loading.removeClass('d-flex').addClass('d-none');

            // 如果有起始时间，定位到该位置
            if (currentStartTime > 0) {
                event.target.seekTo(currentStartTime, true);
            }
        }

        /**
         * 播放器状态变化回调
         */
        function onPlayerStateChange(event) {
            const state = event.data;

            if (state === YT.PlayerState.PLAYING) {
                // 开始播放，记录播放行为
                if (currentUnit && currentChapter) {
                    if (typeof window.recordPlayStart === 'function') {
                        window.recordPlayStart(currentChapter, currentUnit);
                    }
                }
                startPlayPositionTracking();
            } else if (state === YT.PlayerState.PAUSED) {
                // 暂停时保存播放进度
                updatePlayPosition();
            } else if (state === YT.PlayerState.ENDED) {
                // 播放结束，记录完成
                if (currentUnit && currentChapter) {
                    if (typeof window.recordPlayEnd === 'function') {
                        const currentTime = event.target.getCurrentTime();
                        window.recordPlayEnd(currentChapter, currentUnit, Math.floor(currentTime));
                    }
                }
                stopPlayPositionTracking();
            }
        }

        /**
         * 播放器错误回调
         */
        function onPlayerError(event) {
            const errorMessages = {
                2: "视频 ID 无效",
                5: "HTML5 播放器错误",
                100: "视频不存在或已被删除",
                101: "视频嵌入权限受限",
                150: "视频嵌入权限受限",
                153: "播放器配置错误"
            };

            const errorMessage = errorMessages[event.data] || "未知错误";
            console.error('YouTube 错误:', errorMessage);

            $('#play-content').html(`<div class="alert alert-danger text-center">{{__("播放错误")}}: ${errorMessage}</div>`);
            $loading.removeClass('d-flex').addClass('d-none');
        }

        /**
         * 开始跟踪播放位置
         */
        function startPlayPositionTracking() {
            if (playPositionTimer) {
                clearInterval(playPositionTimer);
            }
            playPositionTimer = setInterval(function () {
                updatePlayPosition();
            }, 5000);
        }

        /**
         * 停止跟踪播放位置
         */
        function stopPlayPositionTracking() {
            if (playPositionTimer) {
                clearInterval(playPositionTimer);
                playPositionTimer = null;
            }
        }

        /**
         * 更新播放位置
         */
        function updatePlayPosition() {
            if (youtubePlayer && currentUnit && currentChapter) {
                try {
                    const currentTime = youtubePlayer.getCurrentTime();
                    if (currentTime !== null && currentTime !== undefined) {
                        if (typeof window.savePlayRecord === 'function') {
                            window.savePlayRecord(currentChapter, currentUnit, Math.floor(currentTime));
                        }
                    }
                } catch (e) {
                    console.error('获取播放位置失败:', e);
                }
            }
        }

        /**
         * 清理播放器
         */
        function clearVideo() {
            if (youtubePlayer) {
                try {
                    youtubePlayer.destroy();
                } catch (e) {
                    console.error('销毁播放器失败:', e);
                }
                youtubePlayer = null;
            }
            stopPlayPositionTracking();
        }

        /**
         * 播放视频
         */
        window.playVideo = function (unit, position = 0) {
            clearVideo();
            currentUnit = unit.id;
            currentChapter = unit.chapter_id;
            currentStartTime = position;
            let videoId = unit.video_id;

            $loading.removeClass('d-none').addClass('d-flex');

            if (videoId) {
                $('#play-content').html('<div id="youtube-player"></div>');
                initYouTubePlayer(videoId, position);
            } else {
                $('#play-content').html('<div class="alert alert-danger text-center">{{__("视频链接格式错误")}}</div>');
                $loading.removeClass('d-flex').addClass('d-none');
            }
        };

        window.clearVideo = clearVideo;

        window.videoGetCurrentPosition = function () {
            if (youtubePlayer) {
                try {
                    return Math.floor(youtubePlayer.getCurrentTime() || 0);
                } catch (e) {
                    console.error('获取播放位置失败:', e);
                }
            }
            return 0;
        };

        window.getVideoCurrentUnit = function () {
            return currentUnit;
        };
        window.getVideoCurrentChapter = function () {
            return currentChapter;
        };
    });
</script>
