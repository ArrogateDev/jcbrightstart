<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>

<link rel="stylesheet" href="{{web_resource_url('assets/web/vendor/dflip/dflip.min.css')}}">
<script src="{{web_resource_url('assets/web/vendor/dflip/js/dflip.min.js')}}"></script>

<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=ZCOOL+XiaoWei&family=Baloo+2:wght@700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --coral: #FF6B6B;
        --peach: #FFB347;
        --mint: #5ECFA6;
        --sky: #4FC3F7;
        --lavender: #B39DDB;
        --cream: #FFF8F0;
        --deep: #1A2744;
        --mid: #2E4080;
    }

    *, *::before, *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: var(--cream);
        color: var(--deep);
        overflow-x: hidden;
        min-height: 100vh;
    }

    /* ─── SUBTLE PAGE BG ─────────────────────────────────────── */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        z-index: -1;
        background: radial-gradient(ellipse 55% 40% at 90% 10%, rgba(79, 195, 247, .12) 0%, transparent 60%),
        radial-gradient(ellipse 45% 35% at 5% 80%, rgba(94, 207, 166, .10) 0%, transparent 55%),
        radial-gradient(ellipse 50% 40% at 50% 50%, rgba(255, 179, 71, .07) 0%, transparent 60%),
        linear-gradient(160deg, #FFF8F0 0%, #F0F8FF 50%, #F0FFF8 100%);
    }

    /* ─── PAGE SHELL ─────────────────────────────────────────── */
    .page-wrap {
        max-width: 1400px;
        margin-left: auto;
        margin-right: auto;
        padding: 2rem 2rem 3rem;
    }

    /* ─── BREADCRUMB ─────────────────────────────────────────── */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .8rem;
        font-weight: 700;
        color: #A0AEC0;
        margin-bottom: 1.5rem;
        animation: fadeUp .5s ease both;
    }

    .breadcrumb a {
        color: var(--sky);
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .breadcrumb .sep {
        color: #CBD5E0;
    }

    /* ─── MAIN LAYOUT ────────────────────────────────────────── */
    .main-layout {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 2rem;
        align-items: start;
    }

    .main-layout.quiz-hidden {
        grid-template-columns: 1fr;
    }

    /* ─── LEFT COLUMN ────────────────────────────────────────── */
    .left-column {
        min-width: 0;
        animation: fadeUp .6s ease both;
    }

    /* Video Container */
    .video-container {
        position: relative;
        width: 100%;
        @if($unit->type === 0)
        aspect-ratio: 16 / 9;
        @endif
        border-radius: 24px;
        overflow: hidden;
        background: linear-gradient(135deg, var(--mid) 0%, #1A3A7A 45%, #0D2255 100%);
        box-shadow: 0 16px 56px rgba(26, 39, 68, .28);
        margin-bottom: 2rem;
    }

    .video-container iframe,
    .video-container .video-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .video-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, .6);
        background: radial-gradient(ellipse at center, rgba(79, 195, 247, .15) 0%, transparent 70%);
    }

    .video-placeholder svg {
        width: 80px;
        height: 80px;
        margin-bottom: 1.5rem;
        opacity: .8;
    }

    .video-title {
        font-family: 'Baloo 2', cursive;
        font-size: 1.5rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: .5rem;
    }

    .video-subtitle {
        font-size: .9rem;
        color: rgba(255, 255, 255, .5);
    }

    /* Course Info Card */
    .course-info-card {
        background: rgba(255, 255, 255, .88);
        backdrop-filter: blur(12px);
        border: 1.5px solid rgba(255, 255, 255, .95);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
        animation: fadeUp .6s .1s ease both;
    }

    .info-header {
        display: flex;
        align-items: flex-start;
        gap: 1.2rem;
        margin-bottom: 1.5rem;
    }

    .info-icon-box {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(255, 107, 107, .15), rgba(255, 179, 71, .15));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        flex-shrink: 0;
    }

    .info-title-block {
        flex: 1;
    }

    .info-tag {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: rgba(94, 207, 166, .2);
        border: 1px solid rgba(94, 207, 166, .4);
        border-radius: 999px;
        padding: .25rem .8rem;
        font-size: .72rem;
        font-weight: 800;
        color: var(--mint);
        letter-spacing: .05em;
        margin-bottom: .75rem;
    }

    .info-tag::before {
        content: '✦';
        font-size: .6rem;
    }

    .info-title {
        font-family: 'ZCOOL XiaoWei', serif;
        font-size: 1.8rem;
        color: var(--deep);
        line-height: 1.3;
        margin-bottom: .5rem;
    }

    .info-meta {
        display: flex;
        align-items: center;
        gap: 1.2rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .85rem;
        font-weight: 700;
        color: #A0AEC0;
    }

    .meta-item svg {
        width: 16px;
        height: 16px;
    }

    .info-description {
        font-size: .95rem;
        line-height: 1.9;
        color: #4A5568;
        padding-left: 1.2rem;
        border-left: 3px solid var(--mint);
        background: rgba(94, 207, 166, .05);
        border-radius: 0 12px 12px 0;
        padding: 1.2rem 1.2rem 1.2rem 1.5rem;
    }

    /* Navigation Footer */
    .nav-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1.5px solid rgba(0, 0, 0, .05);
    }

    .nav-btn {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .7rem 1.4rem;
        border-radius: 12px;
        font-size: .9rem;
        font-weight: 800;
        text-decoration: none;
        transition: all .2s;
        cursor: pointer;
        border: none;
    }

    .nav-btn.secondary {
        background: rgba(160, 174, 192, .12);
        color: #A0AEC0;
    }

    .nav-btn.secondary:hover {
        background: rgba(160, 174, 192, .2);
        transform: translateX(-4px);
    }

    .nav-btn.primary {
        background: linear-gradient(135deg, var(--sky), var(--lavender));
        color: #fff;
        box-shadow: 0 4px 14px rgba(79, 195, 247, .3);
    }

    .nav-btn.primary:hover {
        transform: translateX(4px);
        box-shadow: 0 6px 20px rgba(79, 195, 247, .4);
    }

    /* ─── RIGHT COLUMN (QUIZ) ────────────────────────────────── */
    .right-column {
        position: sticky;
        top: 90px;
        animation: fadeUp .6s .15s ease both;
        transition: all .3s ease;
    }

    .right-column.hidden {
        display: none;
    }

    .quiz-card {
        background: rgba(255, 255, 255, .88);
        backdrop-filter: blur(12px);
        border: 1.5px solid rgba(255, 255, 255, .95);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
        position: relative;
    }

    .quiz-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .quiz-title {
        display: flex;
        align-items: center;
        gap: .7rem;
    }

    .quiz-icon {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(179, 157, 219, .2), rgba(79, 195, 247, .12));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .quiz-label {
        font-family: 'ZCOOL XiaoWei', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--deep);
    }

    .collapse-btn {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: rgba(160, 174, 192, .12);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #A0AEC0;
        cursor: pointer;
        transition: all .2s;
    }

    .collapse-btn:hover {
        background: rgba(160, 174, 192, .2);
        color: var(--deep);
    }

    .quiz-progress {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1.5px solid rgba(0, 0, 0, .05);
    }

    .quiz-progress-bar {
        flex: 1;
        height: 6px;
        background: rgba(160, 174, 192, .15);
        border-radius: 99px;
        overflow: hidden;
    }

    .quiz-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--mint), var(--sky));
        border-radius: 99px;
        transition: width .5s ease;
    }

    .quiz-progress-text {
        font-family: 'Baloo 2', cursive;
        font-size: .8rem;
        font-weight: 800;
        color: var(--deep);
        min-width: 60px;
        text-align: right;
    }

    .quiz-question {
        margin-bottom: 1.5rem;
    }

    .question-text {
        font-size: 1rem;
        font-weight: 700;
        color: var(--deep);
        line-height: 1.6;
        margin-bottom: 1.2rem;
    }

    .options-list {
        display: flex;
        flex-direction: column;
        gap: .75rem;
    }

    .option-item {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1rem 1.2rem;
        border-radius: 14px;
        background: rgba(255, 255, 255, .6);
        border: 1.5px solid rgba(0, 0, 0, .05);
        cursor: pointer;
        transition: all .2s;
        position: relative;
    }

    .option-item:hover {
        background: rgba(255, 255, 255, .95);
        border-color: rgba(79, 195, 247, .3);
        transform: translateX(4px);
    }

    .option-item.selected {
        background: rgba(79, 195, 247, .12);
        border-color: var(--sky);
    }

    .option-item.correct {
        background: rgba(94, 207, 166, .15);
        border-color: var(--mint);
    }

    .option-item.incorrect {
        background: rgba(255, 107, 107, .12);
        border-color: var(--coral);
    }

    .option-marker {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #CBD5E0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all .2s;
    }

    .option-item.selected .option-marker {
        border-color: var(--sky);
        background: var(--sky);
    }

    .option-item.correct .option-marker {
        border-color: var(--mint);
        background: var(--mint);
    }

    .option-item.incorrect .option-marker {
        border-color: var(--coral);
        background: var(--coral);
    }

    .check-icon, .cross-icon {
        width: 14px;
        height: 14px;
        color: #fff;
    }

    .option-text {
        flex: 1;
        font-size: .95rem;
        font-weight: 600;
        color: #4A5568;
        line-height: 1.5;
    }

    .quiz-feedback {
        padding: 1.2rem;
        border-radius: 14px;
        margin-bottom: 1.5rem;
        display: none;
    }

    .quiz-feedback.show {
        display: block;
        animation: fadeUp .3s ease both;
    }

    .quiz-feedback.correct {
        background: rgba(94, 207, 166, .1);
        border: 1.5px solid rgba(94, 207, 166, .3);
    }

    .quiz-feedback.incorrect {
        background: rgba(255, 107, 107, .1);
        border: 1.5px solid rgba(255, 107, 107, .3);
    }

    .feedback-title {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .9rem;
        font-weight: 800;
        margin-bottom: .5rem;
    }

    .feedback-title.correct {
        color: var(--mint);
    }

    .feedback-title.incorrect {
        color: var(--coral);
    }

    .feedback-text {
        font-size: .85rem;
        line-height: 1.7;
        color: #4A5568;
    }

    .quiz-actions {
        display: flex;
        gap: 1rem;
    }

    .btn {
        flex: 1;
        padding: .85rem 1.5rem;
        border-radius: 12px;
        font-size: .9rem;
        font-weight: 800;
        cursor: pointer;
        transition: all .2s;
        border: none;
        text-align: center;
    }

    .btn:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .btn-outline {
        background: transparent;
        border: 1.5px solid #CBD5E0;
        color: #A0AEC0;
    }

    .btn-outline:hover:not(:disabled) {
        border-color: var(--deep);
        color: var(--deep);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--sky), var(--lavender));
        color: #fff;
        box-shadow: 0 4px 14px rgba(79, 195, 247, .25);
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 195, 247, .35);
    }

    /* ─── RESPONSIVE ─────────────────────────────────────────── */
    @media (max-width: 1024px) {
        .main-layout {
            grid-template-columns: 1fr;
        }

        .right-column {
            position: static;
        }

        .quiz-card {
            margin-top: 2rem;
        }
    }

    @media (max-width: 768px) {
        .page-wrap {
            padding: 1.5rem 1.25rem 2rem;
        }

        .course-info-card,
        .quiz-card {
            padding: 1.5rem;
        }

        .info-title {
            font-size: 1.4rem;
        }

    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(18px)
        }
        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    #btn-quiz {
        top: 10px;
        right: 10px;
        padding: 2px 12px !important;
        cursor: pointer;
        pointer-events: auto;
        z-index: 100;
        display: none;
    }

    #btn-quiz.show {
        display: block !important;
        animation: fadeUp .3s ease both;
    }

    .current-sep {
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <div class="content pt-0">
        <div class="container">

            <div class="page-wrap">

                <div class="breadcrumb">
                    <a href="{{route('user.dashboard.html')}}">{{__('首页')}}</a>
                    <span class="sep">›</span>
                    <a class="current-sep" href="{{route('course.details.html', ['course'=>$course->id])}}">{{$course->title}}</a>
                    <span class="sep">›</span>
                    <span>{{$unit->title}}</span>
                </div>

                <div class="course-info-card">
                    <div class="info-header">
                        <div class="info-title-block">
                            <div class="info-tag">單元 1 of 7</div>
                            <h1 class="info-title">{{$unit->title}}</h1>
                            <div class="info-meta">
                                <div class="meta-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="23 7 16 12 23 17 23 7"/>
                                        <rect x="1" y="5" width="15" height="14" rx="2"/>
                                    </svg>
                                    <span>{{$unit->type === 0?'影片課程':'PDF課程'}}</span>
                                </div>
                                <div class="meta-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                    <span>已完成</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($unit->description))
                        <div class="info-description">
                            <p>{!! $unit->description !!}</p>
                        </div>
                    @endif
                </div>

                <!-- Main Layout -->
                <div class="main-layout quiz-hidden" id="mainLayout">

                    <!-- Left Column -->
                    <div class="left-column">

                        <!-- Video Container -->
                        <div class="video-container">
                            <div id="btn-quiz" class="position-absolute alert alert-warning show" onclick="toggleQuiz()">測驗</div>

                            <div id="play-content">
                                @if($unit->type === 0)

                                    @include('web.course.new.components.play-video')
                                @else
                                    @include('web.course.new.components.play-pdf')
                                @endif
                            </div>
                            <div id="play-loading" class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                <div class="spinner-border text-white" role="status">
                                    <span class="sr-only">{{__('加载中...')}}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="nav-footer">
                                <a href="{{$prev ? route('course.unit.details.html', ['course' => $unit->course_id, 'unit' => $prev]) : 'javascript:;' }}" @class(['nav-btn', 'primary' => $prev, 'secondary' => !$prev])>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="15 18 9 12 15 6"/>
                                    </svg>
                                    上一課
                                </a>

                                <a href="{{$next ? route('course.unit.details.html', ['course' => $unit->course_id, 'unit' => $next]) : 'javascript:;' }}" @class(['nav-btn', 'primary' => $next, 'secondary' => !$next])>
                                    下一課
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="9 18 15 12 9 6"/>
                                    </svg>
                                </a>
                        </div>

                    </div>

                    <!-- Right Column (Quiz) -->
                    <div class="right-column hidden" id="rightColumn">
                        @include('web.course.new.components.quiz')
                    </div>
                </div>

            </div>
        </div>

    </div>

    <x-web.user.footer/>

</div>
</body>

<script>
    $(function () {
        let currentUnitId = null;
        let currentChapterId = null;
        let status = 0;

        /**
         * 播放策略映射
         */
        const playStrategies = {
            0: (unit, position) => window.playVideo?.(unit, position),
            1: (unit, position) => window.playPdf?.(unit, position)
        };

        /**
         * 播放单元内容
         */
        function playUnit(unit, position = 0) {
            const playStrategy = playStrategies[unit.type];

            if (playStrategy) {
                playStrategy(unit, position);
            } else {
                $('#play-content').html('<div class="alert alert-warning text-center">{{__("该单元暂无内容")}}</div>');
                $('#play-loading').removeClass('d-flex').addClass('d-none');
            }
        }

        /**
         * 清理播放器
         */
        function clearPlay() {
            if (typeof window.clearVideo === 'function') {
                window.clearVideo();
            }
            if (typeof window.clearPdf === 'function') {
                window.clearPdf();
            }
        }

        /**
         * 获取当前播放位置
         */
        function getCurrentPlayPosition() {
            if (typeof window.videoGetCurrentPosition === 'function') {
                const videoPos = window.videoGetCurrentPosition();
                if (videoPos > 0) return videoPos;
            }
            if (typeof window.getPdfPageCount === 'function') {
                return window.getPdfPageCount();
            }
            return 0;
        }

        /**
         * 记录播放开始
         */
        function recordPlayStart(chapterId, unitId) {
            if (status > 0) return;
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

        /**
         * 保存播放记录
         */
        function savePlayRecord(chapterId, unitId, playPosition) {
            if (status > 0) return;
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

        /**
         * 记录播放结束
         */
        function recordPlayEnd(chapterId, unitId, playPosition) {
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

                    const quiz = response.data.quiz;
                    const params = {
                        course: {{$course->id}},
                        chapter: chapterId,
                        unit: unitId,
                        quiz: quiz,
                    };

                    // 直接打开测验面板
                    if (typeof window.openQuiz === 'function') {
                        window.openQuiz(params);
                    }
                }
            });
        }

        /**
         * 更新单元状态
         */
        function updateUnitStatus(unitId, newStatus) {
            const $unitItem = $(`li[data-unit="${unitId}"]`);
            if (!$unitItem.length) {
                return;
            }

            const $actionDiv = $unitItem.find('.unit-status');
            if (!$actionDiv.length) {
                return;
            }

            let unitInfo = $unitItem.data('info');
            if (unitInfo) {
                unitInfo.status = newStatus;
                $unitItem.data('info', unitInfo);
            }
            $unitItem.attr('data-status', newStatus);

            if (newStatus === 2) {
                const playPosition = unitInfo ? (unitInfo.play_position || 0) : 0;

                $actionDiv.html(`
                    <a href="#" class="play-unit-link"
                       data-unit="${unitId}"
                       data-status="2"
                       data-play-position="${playPosition}">{{__('重新学习')}}</a>
                    <i class="fa-solid fa-circle-check text-success ml-3"></i>
                `);
            } else if (newStatus === 1) {
                $actionDiv.html(`
                    <span>{{__('已完成播放')}}</span>
                    <i class="fa-solid fa-book text-warning ml-3"></i>
                `);
            }
        }

        // 页面加载时初始化
        $(document).ready(function () {
            const info = {!! json_encode($unit) !!};
            console.log(info)
            if (info) {
                currentUnitId = info.id;
                currentChapterId = info.chapter_id;
                const position = info.play_position || 0;
                playUnit(info, position);
            }
        });

        // 监听单元切换
        $(document).on('click', '.play-unit-link', function (e) {
            e.preventDefault();
            const unitId = parseInt($(this).data('unit') || 0);
            const position = parseInt($(this).data('play-position') || 0);

            let $unit = $(`li[data-unit="${unitId}"]`);
            const info = $unit.data('info');
            if (!info) return;

            currentUnitId = unitId;
            currentChapterId = info.chapter_id;
            playUnit(info, position);
        });

        // 页面离开前保存播放进度
        $(window).on('beforeunload', function () {
            const currentUnit = typeof window.getVideoCurrentUnit === 'function' ? window.getVideoCurrentUnit() : null;
            const currentChapter = typeof window.getVideoCurrentChapter === 'function' ? window.getVideoCurrentChapter() : null;

            const pdfUnit = typeof window.getPdfCurrentUnit === 'function' ? window.getPdfCurrentUnit() : null;
            const pdfChapter = typeof window.getPdfCurrentChapter === 'function' ? window.getPdfCurrentChapter() : null;

            if (currentUnit && currentChapter) {
                const playPosition = getCurrentPlayPosition();
                savePlayRecord(currentChapter, currentUnit, playPosition);
            } else if (pdfUnit && pdfChapter) {
                const playPosition = getCurrentPlayPosition();
                savePlayRecord(pdfChapter, pdfUnit, playPosition);
            }
        });

        // 导出全局函数
        window.openPlay = function (unitId, position) {
            let $unit = $(`li[data-unit="${unitId}"]`);
            const info = $unit.data('info');
            if (!info) return;
            currentUnitId = unitId;
            currentChapterId = info.chapter_id;
            playUnit(info, position || 0);
        };

        window.savePlayRecord = savePlayRecord;
        window.updateUnitStatus = updateUnitStatus;
        window.recordPlayEnd = recordPlayEnd;
        window.recordPlayStart = recordPlayStart;
    });
</script>
</html>
