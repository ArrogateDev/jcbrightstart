<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/css/course-unit.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/lodash.js') }}"></script>
    <script src="{{web_resource_url('assets/js/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{web_resource_url('assets/js/wait-me/waitMe.min.css')}}">
    <link href="{{web_resource_url('assets/js/toastr/toastr.min.css')}}" rel="stylesheet"/>
    <script src="{{web_resource_url('assets/js/toastr/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/utils.js') }}"></script>
    <link rel="stylesheet" href="{{web_resource_url('assets/web/vendor/dflip/dflip.min.css')}}">
    <script src="{{web_resource_url('assets/web/vendor/dflip/js/dflip.min.js')}}"></script>
    <style>
        /* Video Container */
        .video-container {
            position: relative;
            width: 100%;
            @if ($unit->type === 0)
               aspect-ratio: 16 / 9;
            @endif
               border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 16px 56px rgba(26, 39, 68, .28);
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
<x-web.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="content pt-8">
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
                        <div class="info-tag">{{__('章节')}} {{$current_index + 1}} of {{$total_index}}</div>
                        <h1 class="info-title">{{$unit->title}}</h1>
                        <div class="info-meta">
                            <div class="meta-item">
                                @if($unit->type === 0)
                                    <i class="fa-solid fa-video"></i>
                                @else
                                    <i class="fa-solid fa-file-pdf"></i>
                                @endif
                                <span>{{$unit->type_text}}</span>
                            </div>
                            <div class="meta-item">
                                @if($play_record && $play_record->status === 2)
                                    <div class="status-chip done" id="playStatusChip">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5ECFA6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="8 12 11 15 16 9"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="status-chip pending" id="playStatusChip">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#A0AEC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/>
                                        </svg>
                                    </div>
                                @endif
                                @if($play_record && $play_record->status === 1)
                                    <span id="playStatusText">{{__('已观看')}}</span>
                                @elseif($play_record && $play_record->status === 2)
                                    <span id="playStatusText">{{__('已完成')}}</span>
                                @else
                                    <span id="playStatusText">{{__('未观看')}}</span>
                                @endif
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
                        <div id="btn-quiz" class="absolute alert alert-warning show" onclick="toggleQuiz()">{{__('进入测验')}}</div>

                        <div id="play-content">
                            @if($unit->type === 0)
                                @include('web.course.components.play-video')
                            @elseif($unit->type === 1)
                                @include('web.course.components.play-pdf')
                            @elseif($unit->type === 2)
                                @include('web.course.components.play-html')
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
                            {{__('上一单元')}}
                        </a>

                        <a href="{{$next ? route('course.unit.details.html', ['course' => $unit->course_id, 'unit' => $next]) : 'javascript:;' }}" @class(['nav-btn', 'primary' => $next, 'secondary' => !$next])>
                            {{__('下一单元')}}
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </a>
                    </div>

                </div>

                <!-- Right Column (Quiz) -->
                <div class="right-column hidden" id="rightColumn">
                    @include('web.course.components.quiz')
                </div>
            </div>
        </div>
    </div>
</section>

<x-web.footer/>
@csrfRefresh
</body>

<script>
    window.setPlayRecordStatus = function (newStatus) {
        const status = parseInt(newStatus || 0, 10);
        const $chip = $('#playStatusChip');
        const $text = $('#playStatusText');
        if (!$chip.length || !$text.length) return;

        const doneSvg = `
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5ECFA6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="8 12 11 15 16 9"/>
            </svg>
        `;
        const pendingSvg = `
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#A0AEC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
            </svg>
        `;

        if (status === 2) {
            $chip.removeClass('pending').addClass('done').html(doneSvg);
            $text.text('{{__('已完成')}}');
        } else if (status === 1) {
            $chip.removeClass('done').addClass('pending').html(pendingSvg);
            $text.text('{{__('已观看')}}');
        } else {
            $chip.removeClass('done').addClass('pending').html(pendingSvg);
            $text.text('{{__('未观看')}}');
        }
    };
</script>

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
            1: (unit, position) => window.playPdf?.(unit, position),
            2: (unit, position) => window.playHtml?.(unit, position)
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
            if (typeof window.clearHtml === 'function') {
                window.clearHtml();
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
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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

                    if (typeof window.updateUnitStatus === 'function') {
                        window.updateUnitStatus(unitId, 1);
                    }

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

        // 页面加载时初始化
        $(document).ready(function () {
            const info = {!! json_encode($unit) !!};
            if (info) {
                currentUnitId = info.id;
                currentChapterId = info.chapter_id;
                const position = info.play_position || 0;
                playUnit(info, position);

                @if($play_record && $play_record->status === 2)
                const params = {
                    course: {{$course->id}},
                    chapter: currentChapterId,
                    unit: currentUnitId,
                    quiz: info.quiz_id,
                };

                // 直接打开测验面板
                if (typeof window.openQuiz === 'function') {
                    window.openQuiz(params);
                }
                @endif
            }
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

        /**
         * 跨标签页更新单元状态
         */
        function updateUnitStatus(unitId, newStatus, isAllCompleted = false) {
            const message = {
                type: 'UPDATE_UNIT_STATUS',
                unitId: unitId,
                newStatus: newStatus,
                isAllCompleted: isAllCompleted
            };

            try {
                const channel = new BroadcastChannel('course_updates');
                channel.postMessage(message);
                channel.close();
            } catch (e) {
                console.error('✗ Failed to send via BroadcastChannel:', e);
            }
        }

        window.updateUnitStatus = updateUnitStatus;

        window.savePlayRecord = savePlayRecord;
        window.recordPlayEnd = recordPlayEnd;
        window.recordPlayStart = recordPlayStart;
    });
</script>
</html>
