<link rel="stylesheet" href="{{web_resource_url('assets/web/vendor/dflip/dflip.min.css')}}">

<div id="play-content"></div>
<div id="play-loading" class="d-flex justify-content-center align-items-center" style="height: 100%;">
    <div class="spinner-border" role="status">
        <span class="sr-only">{{__('加载中...')}}</span>
    </div>
</div>

<script src="{{web_resource_url('assets/web/vendor/dflip/js/dflip.min.js')}}"></script>

@include('web.course.components.play-video')
@include('web.course.components.play-pdf')

<script>
    $(function () {
        const $modal = $('#learn-box');
        let status = 0;

        const playStrategies = {
            0: (unit, position) => window.playVideo?.(unit, position),
            1: (unit, position) => window.playPdf?.(unit, position)
        };

        function playUnit(unit, position = 0) {
            const playStrategy = playStrategies[unit.type];

            if (playStrategy) {
                playStrategy(unit, position);
            } else {
                $modal.removeClass('modal-pdf');
                $('#play-content').html('<div class="alert alert-warning text-center">{{__("该单元暂无内容")}}</div>');
                $('#play-loading').removeClass('d-flex').addClass('d-none');
            }
        }

        function clearPlay() {
            if (typeof window.clearVideo === 'function') {
                window.clearVideo();
            }
            if (typeof window.clearPdf === 'function') {
                window.clearPdf();
            }
        }

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

                    const quiz = response.data.quiz
                    const params = {
                        course: {{$course->id}},
                        chapter: chapterId,
                        unit: unitId,
                        quiz: quiz,
                    };

                    $('#learn-tabs a[href="#learn-quiz"]').tab('show');
                    if (typeof window.openQuiz === 'function') {
                        window.openQuiz(params);
                    } else {
                        $modal.data('params', params);
                    }
                }
            });
        }

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
            $unitItem.attr('data-status', newStatus)

            if (newStatus === 2) {
                const playPosition = unitInfo ? (unitInfo.play_position || 0) : 0;

                $actionDiv.html(`
                    <a href="#" class="preview-link" data-toggle="modal" data-target="#learn-box" data-tab="play"
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
                    <a href="#" class="preview-link" data-toggle="modal" data-target="#learn-box" data-tab="quiz"
                       data-course="${courseId}"
                       data-chapter="${chapterId}"
                       data-unit="${unitId}"
                       data-quiz="${quizId}"
                       data-status="1">{{__('测验')}}</a>
                    <i class="fa-solid fa-book text-warning ml-3"></i>
                `);
            }
        }

        $modal.on('show.bs.modal', function (event) {
            const button = event.relatedTarget
            const unit = parseInt(button.getAttribute('data-unit') || 0)
            status = parseInt(button.getAttribute('data-status') || 0)
            const position = parseInt(button.getAttribute('data-play-position'))
            const tab = button.getAttribute('data-tab') || 'play'

            let $unit = $(`li[data-unit="${unit}"]`);
            if (!$unit.length) {
                $unit = $('li[data-unit]').eq(0)
            }

            const info = $unit.data('info')
            if (!info) {
                $modal.modal('hide')
                return
            }

            const title = $unit.data('title')
            $('#learn-label').text(title);
            $modal.data('lastUnit', unit);

            if (tab === 'quiz') {
                $('#learn-tabs a[href="#learn-quiz"]').tab('show');
                return;
            } else {
                $('#learn-tabs a[href="#learn-play"]').tab('show');
            }

            playUnit(info, position);
        });

        $modal.on('hidden.bs.modal', function (event) {
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

            clearPlay()

            status = 0;
            $('#play-loading').removeClass('d-none').addClass('d-flex')
            $('#certificate-loading').removeClass('d-none').addClass('d-flex')
            $('#certificate-content').hide()
        });

        $modal.on('shown.bs.modal', function () {
            if (typeof window.triggerPendingPdfInit === 'function') {
                window.triggerPendingPdfInit();
            }
        });

        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
            const target = $(e.target).attr('href');

            if (target !== '#learn-play') return

            if (typeof window.triggerPendingPdfInit === 'function') {
                window.triggerPendingPdfInit();
            }

            const lastUnit = parseInt($modal.data('lastUnit') || 0);
            if (lastUnit > 0 && $modal.hasClass('show')) {
                const $unitItem = $(`li[data-unit="${lastUnit}"]`);
                if ($unitItem.length) {
                    const info = $unitItem.data('info');
                    if (info) {
                        let pos = info ? (parseInt(info.play_position || 0) || 0) : 0;
                        playUnit(info, pos);
                    }
                }
            }
        });

        window.openPlay = function (unitId, position) {
            let $unit = $(`li[data-unit="${unitId}"]`);
            const info = $unit.data('info')
            if (!info) return;
            $modal.data('lastUnit', unitId);
            $('#learn-tabs a[href="#learn-play"]').tab('show');
            playUnit(info, position || 0);
        }

        window.savePlayRecord = savePlayRecord;
        window.updateUnitStatus = updateUnitStatus;
        window.recordPlayEnd = recordPlayEnd;
        window.recordPlayStart = recordPlayStart;
    })
</script>
