<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube iframe API - 完整解决方案</title>
    <!-- 权限策略声明 - 修复格式 -->
    <meta http-equiv="Permissions-Policy"
        content="autoplay=(self), encrypted-media=(self), accelerometer=(self), gyroscope=(self), picture-in-picture=(self), clipboard-write=(self), web-share=(self)">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            color: #fff;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            max-width: 1000px;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 15px;
            padding: 30px;
            margin-top: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .subtitle {
            font-size: 1.2rem;
            color: #fdbb2d;
            margin-bottom: 20px;
        }

        .player-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 30px;
        }

        .video-container {
            flex: 1;
            min-width: 300px;
        }

        #player {
            width: 100%;
            height: 300px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            background: #000;
        }

        .controls {
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .control-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        button {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            background: #fdbb2d;
            color: #1a2a6c;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            min-width: 120px;
        }

        button:hover {
            background: #ffcc44;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        }

        button:active {
            transform: translateY(0);
        }

        button:disabled {
            background: #777;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .status {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .status h3 {
            margin-bottom: 10px;
            color: #fdbb2d;
        }

        #events {
            max-height: 200px;
            overflow-y: auto;
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
        }

        .event-item {
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .event-time {
            color: #fdbb2d;
            margin-right: 10px;
        }

        .completed {
            color: #4CAF50;
        }

        .playing {
            color: #2196F3;
        }

        .paused {
            color: #FF9800;
        }

        .instructions {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
        }

        .instructions h3 {
            color: #fdbb2d;
            margin-bottom: 15px;
        }

        .instructions ul {
            padding-left: 20px;
        }

        .instructions li {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .warning-info {
            background: rgba(255, 193, 7, 0.2);
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .warning-info h4 {
            color: #ffc107;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .solution-section {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .solution-section h3 {
            color: #fdbb2d;
            margin-bottom: 15px;
        }

        .solution-item {
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
        }

        .solution-item h4 {
            color: #4CAF50;
            margin-bottom: 8px;
        }

        @media (max-width: 768px) {
            .player-container {
                flex-direction: column;
            }

            #player {
                height: 250px;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>YouTube iframe API 完整解决方案</h1>
        <p class="subtitle">解决权限策略警告和广告拦截问题</p>
    </header>

    <div class="container">
        <div class="player-container">
            <div class="video-container">
                <div id="player"></div>
            </div>

            <div class="controls">
                <h2>播放控制</h2>
                <div class="control-buttons">
                    <button id="play-btn" disabled>播放</button>
                    <button id="pause-btn" disabled>暂停</button>
                    <button id="stop-btn" disabled>停止</button>
                </div>

                <div class="status">
                    <h3>播放状态</h3>
                    <div id="player-state">播放器加载中...</div>
                </div>
            </div>
        </div>

        <div class="status">
            <h3>事件日志</h3>
            <div id="events"></div>
        </div>
    </div>

    <!-- 加载YouTube IFrame API -->
    <script>
        // 将事件添加到日志
        function logEvent(message, className = "") {
            const eventsDiv = document.getElementById('events');
            const now = new Date();
            const timeString = now.toTimeString().split(' ')[0];
            const eventItem = document.createElement('div');
            eventItem.className = `event-item ${className}`;
            eventItem.innerHTML = `<span class="event-time">[${timeString}]</span> ${message}`;
            eventsDiv.appendChild(eventItem);
            eventsDiv.scrollTop = eventsDiv.scrollHeight;
        }

        // 更新播放器状态显示
        function updatePlayerState(state) {
            const stateDiv = document.getElementById('player-state');
            let stateText = '';

            switch (state) {
                case -1:
                    stateText = '未开始';
                    break;
                case 0:
                    stateText = '已结束';
                    break;
                case 1:
                    stateText = '播放中';
                    break;
                case 2:
                    stateText = '已暂停';
                    break;
                case 3:
                    stateText = '缓冲中';
                    break;
                case 5:
                    stateText = '视频已排队';
                    break;
                default:
                    stateText = '未知状态';
            }

            stateDiv.innerHTML = `当前状态: <span class="state-${state}">${stateText}</span>`;
        }

        // 页面可见性检测
        function handleVisibilityChange() {
            if (document.hidden) {
                // 页面不可见
                logEvent('页面变为不可见状态', 'hidden');

                // 如果开启了自动暂停且正在播放，则暂停视频
                if (autoPauseEnabled && player && player.getPlayerState() === YT.PlayerState.PLAYING) {
                    wasPlaying = true;
                    player.pauseVideo();
                    logEvent('自动暂停视频播放', 'paused');
                }
            } else {
                // 页面可见
                logEvent('页面变为可见状态', 'visible');

                // 如果之前是播放状态且自动暂停开启，则恢复播放
                if (autoPauseEnabled && wasPlaying && player) {
                    setTimeout(() => {
                        player.playVideo();
                        wasPlaying = false;
                        logEvent('恢复视频播放', 'playing');
                    }, 1000);
                }
            }
        }

        // 初始化检测器
        function initializeDetectors() {
            // 页面可见性API
            document.addEventListener('visibilitychange', handleVisibilityChange);

            // 初始状态
            handleVisibilityChange();

            logEvent('页面状态检测器已初始化', 'visible');
        }

        // 视频ID列表
        const videoId = 'ma7r2HGqwXs';
        let autoPauseEnabled = true;
        let wasPlaying = false;

        // 设置 iframe allow 属性的辅助函数
        function setIframeAllowAttribute() {
            const playerDiv = document.getElementById('player');
            if (playerDiv) {
                // YouTube API 会将 div 替换为 iframe
                if (playerDiv.tagName === 'IFRAME') {
                    const allowValue = 'autoplay; encrypted-media; accelerometer; gyroscope; picture-in-picture; clipboard-write; web-share';
                    if (playerDiv.getAttribute('allow') !== allowValue) {
                        playerDiv.setAttribute('allow', allowValue);
                    }
                } else {
                    // 查找内部的 iframe
                    const iframeElement = playerDiv.querySelector('iframe');
                    if (iframeElement) {
                        const allowValue = 'autoplay; encrypted-media; accelerometer; gyroscope; picture-in-picture; clipboard-write; web-share';
                        if (iframeElement.getAttribute('allow') !== allowValue) {
                            iframeElement.setAttribute('allow', allowValue);
                        }
                    }
                }
            }
        }

        // 使用 MutationObserver 监听 DOM 变化，自动设置 allow 属性
        const observer = new MutationObserver(function (mutations) {
            setIframeAllowAttribute();
        });

        // 开始观察 #player 元素的变化
        const playerContainer = document.getElementById('player');
        if (playerContainer) {
            observer.observe(playerContainer, {
                childList: true,
                subtree: true,
                attributes: true
            });
        }

        // 加载YouTube IFrame API
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;
        function onYouTubeIframeAPIReady() {
            // 简化配置，移除可能导致错误 153 的参数
            let playerVars = {
                'playsinline': 1,
                'modestbranding': 1,
                'rel': 0,
                'controls': 0, // 显示控制条
                'disablekb': 1,
                'enablejsapi': 1, // 启用 JavaScript API（必需）
                'fs': 1, // 允许全屏
                'iv_load_policy': 3, // 不显示注释
                'cc_load_policy': 0, // 默认不显示字幕
                'rel': 0
            };

            // 完全移除 origin 参数以避免错误 153
            // origin 参数在某些情况下会导致配置错误

            player = new YT.Player('player', {
                height: '300',
                width: '100%',
                videoId: videoId,
                playerVars: playerVars,
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange,
                    'onError': onPlayerError
                }
            });

            // 播放器创建后，尝试设置 iframe 的 allow 属性
            // MutationObserver 会自动处理，这里也尝试一次以确保
            setTimeout(setIframeAllowAttribute, 500);

            // 初始化状态检测器
            initializeDetectors();
        }

        function onPlayerReady(event) {
            logEvent('播放器已准备就绪', 'playing');
            updatePlayerState(-1);

            // 启用控制按钮
            document.getElementById('play-btn').disabled = false;
            document.getElementById('pause-btn').disabled = false;
            document.getElementById('stop-btn').disabled = false;

            // 添加按钮事件监听
            document.getElementById('play-btn').addEventListener('click', function () {
                player.playVideo();
                logEvent('用户点击了播放按钮', 'playing');
            });

            document.getElementById('pause-btn').addEventListener('click', function () {
                player.pauseVideo();
                logEvent('用户点击了暂停按钮', 'paused');
            });

            document.getElementById('stop-btn').addEventListener('click', function () {
                player.stopVideo();
                logEvent('用户点击了停止按钮', 'paused');
            });
        }

        function onPlayerStateChange(event) {
            updatePlayerState(event.data);

            if (event.data == YT.PlayerState.ENDED) {
                logEvent('视频播放完成！可以在这里执行回调函数', 'completed');
            } else if (event.data == YT.PlayerState.PLAYING) {
                logEvent('视频开始播放', 'playing');
            } else if (event.data == YT.PlayerState.PAUSED) {
                logEvent('视频已暂停', 'paused');
            } else if (event.data == YT.PlayerState.BUFFERING) {
                logEvent('视频缓冲中', 'paused');
            } else if (event.data == YT.PlayerState.CUED) {
                logEvent('视频已加载并准备播放', 'playing');
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
                    errorMessage = "播放器配置错误 - 通常由 origin 参数或参数冲突引起";
                    break;
            }
            logEvent(`YouTube错误 ${event.data}: ${errorMessage}`, 'paused');
        }
    </script>
</body>

</html>
