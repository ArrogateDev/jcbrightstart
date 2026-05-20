<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/css/course.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<x-web.header/>

<section class="bg-01">
    <div class="container mx-auto">

        <div class="content pt-8">

            <div class="breadcrumb">
                <a href="{{route('user.dashboard.html')}}">{{__('首页')}}</a>
                <span class="sep">›</span>
                <span class="current-sep">{{$course->title}}</span>
            </div>

            <!-- Course Hero -->
            <div class="course-hero !mb-5">
                <div class="grid grid-cols-12 my-2">
                    <div class="col-span-12 md:col-span-2 my-2 flex justify-between md:block">
                        <div class="hero-dot-grid"></div>
                        <div class="course-hero-icon">
                            <img src="{{$course->thumbnail}}" alt="img" class="img-fluid gallery-img">
                        </div>
                        <div class="course-hero-progress block md:hidden">
                            <div class="ring-chart">
                                <svg viewBox="0 0 80 80" width="90" height="90">
                                    <defs>
                                        <linearGradient id="pg-pe" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FF6B6B"/>
                                            <stop offset="100%" stop-color="#FFB347"/>
                                        </linearGradient>
                                    </defs>
                                    <circle class="track" cx="40" cy="40" r="35"/>
                                    <circle class="fill" cx="40" cy="40" r="35" stroke="url(#pg-pe)"/>
                                </svg>
                                <div class="ring-label">
                                    <span class="ring-pct">{{$progress}}%</span>
                                    <span class="ring-sub">{{__('已完成')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-8 my-2">
                        <div class="course-hero-info">
                            <div class="course-hero-title">{{$course->title}}</div>
                            <div class="course-hero-meta">
                                <div class="meta-chip"><span class="dot"></span>{{$course->unit_num??0}} {{__('个章节')}}</div>
                                <div class="meta-chip"><span class="dot" style="background:var(--mint)"></span>{{$completed}} {{__('已完成')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-2 my-2 hidden md:block">
                        <div class="course-hero-progress">
                            <div class="ring-chart">
                                <svg viewBox="0 0 80 80" width="90" height="90">
                                    <defs>
                                        <linearGradient id="pg" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FF6B6B"/>
                                            <stop offset="100%" stop-color="#FFB347"/>
                                        </linearGradient>
                                    </defs>
                                    <circle class="track" cx="40" cy="40" r="35"/>
                                    <circle class="fill" cx="40" cy="40" r="35" stroke="url(#pg)"/>
                                </svg>
                                <div class="ring-label">
                                    <span class="ring-pct">{{$progress}}%</span>
                                    <span class="ring-sub">{{__('已完成')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4 mb-5">
                <div class="col-span-12 md:col-span-4">
                    <div class="stat-card">
                        <div class="stat-icon-box sb-coral">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FF6B6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                <line x1="9" y1="7" x2="15" y2="7"/>
                                <line x1="9" y1="11" x2="13" y2="11"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <div class="num nc">{{$course->unit_num??0}}</div>
                            <div class="lbl">{{__('课程章节')}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-4">
                    <div class="stat-card">
                        <div class="stat-icon-box sb-mint">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#5ECFA6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="8 12 11 15 16 9"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <div class="num nm">{{$completed}}</div>
                            <div class="lbl">{{__('已完成章节')}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-4">
                    <div class="stat-card">
                        <div class="stat-icon-box sb-lavender">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#B39DDB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 2h14"/>
                                <path d="M5 22h14"/>
                                <path d="M17 2L12 12 7 2"/>
                                <path d="M7 22l5-10 5 10"/>
                            </svg>
                        </div>
                        <div class="stat-info">
                            <div class="num nl">{{$surplus}}</div>
                            <div class="lbl">{{__('待完成章节')}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overview -->
            <div class="overview-card mb-5">
                <div class="section-header">
                    <div class="section-header-icon icon-orange">
                        <!-- clipboard -->
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF8C5A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                            <rect x="8" y="2" width="8" height="4" rx="1"/>
                            <line x1="9" y1="12" x2="15" y2="12"/>
                            <line x1="9" y1="16" x2="13" y2="16"/>
                        </svg>
                    </div>
                    <span class="section-label">{{__('概览')}}</span>
                </div>
                <div style="font-size:.8rem; font-weight:700; color:#A0AEC0; margin-bottom:.75rem; letter-spacing:.04em; text-transform:uppercase;">{{__('课程简介')}}</div>
                <div class="overview-text">
                    {!! $course->description !!}
                </div>
            </div>

            <div class="grid grid-cols-12 gap-x-5 pb-5">
                <div class="col-span-12 lg:col-span-9">
                    <!-- Curriculum -->
                    <div class="curriculum-card">
                        <div class="section-header">
                            <div class="section-header-icon icon-blue">
                                <!-- folder tabs / curriculum -->
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4FC3F7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h4l2-2h6l2 2h4v14H3z"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                    <line x1="8" y1="14" x2="16" y2="14"/>
                                    <line x1="8" y1="18" x2="13" y2="18"/>
                                </svg>
                            </div>
                            <span class="section-label">{{__('课程内容')}}</span>
                            <span class="section-count">{{$course->unit_num??0}} {{__('个章节')}}</span>
                        </div>

                        @foreach($course->chapters as $index => $chapter)
                            <div class="level-block">
                                <div class="level-header open" onclick="toggleLevel(this)">
                                    <div class="level-left">
                                        <div class="level-badge">{{$index + 1}}</div>
                                        <span class="level-name">{{$chapter->title}}</span>
                                    </div>
                                    <div class="level-right">
                                        <span class="level-meta">{{$chapter->unit_num}} {{__('个章节')}} · {{$chapter->unit_num_completed}} {{__('已完成')}}</span>
                                        <svg class="chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4FC3F7" stroke-width="2.5" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="lesson-list open">
                                    @foreach($chapter->units as $unit)
                                        <div @class(['lesson-row', 'done'=>$unit->status === 2]) data-unit="{{$unit->id}}" data-status="{{$unit->status}}">
                                            <div @class(['play-btn', 'ti-nutrition', 'done'=>$unit->status === 2])>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="38" height="38">
                                                    <text x="100" y="130"
                                                          font-size="80"
                                                          font-weight="800"
                                                          fill="#2C3E66"
                                                          text-anchor="middle"
                                                          dominant-baseline="middle">
                                                        {{ $loop->parent->iteration }}.{{ $loop->iteration }}
                                                    </text>
                                                    <line x1="45" y1="155" x2="155" y2="155" stroke="#A0B8D4" stroke-width="3" stroke-linecap="round" opacity="0.6"/>
                                                </svg>
                                            </div>
                                            <div class="lesson-info">
                                                <div class="lesson-title">{{$unit->title}}</div>
                                                <div class="lesson-sub">
                                                    @if($unit->type === 0)
                                                        <i class="fa-solid fa-video"></i>
                                                    @else
                                                        <i class="fa-solid fa-file-pdf"></i>
                                                    @endif
                                                    <span>{{$unit->type_text}}</span>
                                                </div>
                                            </div>
                                            <div class="lesson-actions">
                                                <a class="open-btn" href="{{$unit->url}}" target="_blank">{{__('打开')}}</a>
                                                @if($unit->status === 2)
                                                    <div class="status-chip done">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5ECFA6" stroke-width="2.5" stroke-linecap="round"
                                                             stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="10"/>
                                                            <polyline points="8 12 11 15 16 9"/>
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="status-chip pending">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#A0AEC0" stroke-width="2" stroke-linecap="round"
                                                             stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="10"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-3 mt-3 lg:mt-0">
                    <div class="curriculum-card">
                        <div class="section-header">
                            <div class="section-header-icon icon-blue">
                                🏅
                            </div>
                            <span class="section-label">{{__('证书状态')}}</span>
                        </div>
                        <div class="certificate-status-container">
                            <div class="certificate-icon">
                                🏆
                            </div>
                            <p class="certificate-description">{{__('完成所有章节和测验后可申请证书')}}</p>
                            <div class="certificate-requirements">
                                <div class="certificate-requirement-item">
                                    <div @class(['certificate-requirement-icon', 'certificate-unit', 'in-progress'=>$read_completed < $course->unit_num, 'completed'=>$read_completed >= $course->unit_num])>{{$read_completed >= $course->unit_num?'✓' : '◐'}}</div>
                                    <div>{{__('完成所有章节学习')}} (<span id="unit-progress">{{$read_completed > 0 ? bcdiv($read_completed, $course->unit_num, 2) * 100 : 0}}</span>%)</div>
                                </div>

                                <div class="certificate-requirement-item">
                                    <div @class(['certificate-requirement-icon', 'certificate-quiz', 'in-progress'=>$progress < 100, 'completed'=>$progress >=  100])>{{$progress >= 100?'✓' : '◐'}}</div>
                                    <div>{{__('完成所有测验')}} (<span id="quiz-progress">{{$progress}}</span>%)</div>
                                </div>
                            </div>

                            <button
                                @disabled($progress < 100)
                                @class(['certificate-button', 'disabled'=> $progress < 100, 'enabled'=> $progress >= 100])
                                data-url="{{$course->certificate_download_url}}"
                            >
                                <span class="certificate-button-content">
                                    <span class="svg">
                                        @if($progress >= 100)
                                            <svg class="certificate-button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                            </svg>
                                        @else
                                            <svg class="certificate-button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        @endif
                                    </span>
                                    <span>{{__('下载证书')}}</span>
                                </span>
                                <span class="loader-wrapper hide">
                                    <span>{{__('生成中')}}</span>
                                    <span class="loader">
                                        <span class="loader-ring"></span>
                                        <span class="loader-glow"></span>
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="course-complete-box" tabindex="-1" aria-labelledby="course-complete-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('確定證書姓名')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="course-complete-form">
                    <div class="form-group">
                        <label for="certificate-name">{{__('请输入您的姓名')}}</label>
                        <input type="text" class="form-control" id="certificate-name" placeholder="{{__('请输入姓名')}}" value="{{$user->full_name??''}}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="course-certificate">
                <button type="button" class="btn btn-primary border-0" id="submit-certificate-btn">{{__('提交')}}</button>
            </div>
        </div>
    </div>
</div>

<x-web.footer/>

</body>

<script>
    function toggleLevel(header) {
        header.classList.toggle('open');
        var list = header.nextElementSibling;
        list.classList.toggle('open');
    }

    const channel = new BroadcastChannel('course_updates');
    channel.onmessage = function (event) {
        if (event.data && event.data.type === 'UPDATE_UNIT_STATUS') {
            if (typeof window.updateUnitStatusInternal === 'function') {
                window.updateUnitStatusInternal(event.data.unitId, event.data.newStatus, event.data.isAllCompleted);
            } else {
                console.error('✗ updateUnitStatusInternal not defined yet!');
            }
        }
    };

    $(function () {
        /**
         * 更新单元状态（内部实现）
         */
        function updateUnitStatusInternal(unitId, newStatus, isAllCompleted) {
            const $unitItem = $(`div[data-unit="${unitId}"]`);
            if (!$unitItem.length) {
                return;
            }

            const status = $unitItem.data('status');

            if (status !== 1 && newStatus === 1) {
                const total = {{$course->unit_num}};
                const $unit = $('#unit-progress');
                const step = Math.ceil(1 / total * 100);
                let progress = parseInt($unit.text()) + step;
                progress = progress >= 100 ? 100 : progress;
                $unit.text(progress)
                if (progress >= 100) {
                    $('.certificate-unit').html(`✓`).removeClass('in-progress').addClass('completed');
                }
            }

            if (status !== 2 && newStatus === 2) {

                const total = {{$course->unit_num}};
                const $unit = $('#quiz-progress');
                const step = Math.ceil(1 / total * 100);
                let progress = parseInt($unit.text()) + step;
                progress = progress >= 100 ? 100 : progress;
                $unit.text(progress)
                if (progress >= 100) {
                    $('.certificate-quiz').html(`✓`).removeClass('in-progress').addClass('completed');
                }

                $unitItem.addClass('done');
                $unitItem.find('.play-btn').addClass('done');
                $unitItem.find('.status-chip').removeClass('pending').addClass('done');

                $unitItem.find('.status-chip').html(`
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5ECFA6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="8 12 11 15 16 9"/>
                    </svg>
                `);

                if (isAllCompleted) {
                    $('.certificate-button').removeClass('disabled').addClass('enabled').removeAttr('disabled');
                    $('.certificate-button .svg').html(`
                                                <svg class="certificate-button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                                </svg>`);
                }
            }
        }

        // 导出为全局函数供监听器调用
        window.updateUnitStatusInternal = updateUnitStatusInternal;

        const $courseCompleteModal = $('#course-complete-box');
        let pollTimer = null;
        let pollStartTime = null;
        const POLL_TIMEOUT = 60000; // 60 秒超时

        // 关闭模态框
        $courseCompleteModal.on('click', '[data-dismiss="modal"]', function () {
            $courseCompleteModal.modal('hide');
        });

        $(document).on('click', '.certificate-button[data-url]', function () {
            let url = $(this).attr('data-url');
            if (url) {
                window.open(url, '_blank');
                return
            }
            $('.certificate-button-content').hide()
            $('.loader-wrapper').removeClass('hide')
            $courseCompleteModal.modal('show');
        });

        $('#submit-certificate-btn').on('click', function () {
            const name = $('#certificate-name').val().trim();
            if (!name) {
                showToast('error', "{{__('请输入姓名')}}");
                return;
            }

            const currentCourseId = $('#course-certificate').val();
            showLoading($courseCompleteModal.find('.modal-content'));

            $.ajax({
                url: '{{route('course.handle.html', ['course' => $course->id])}}',
                type: 'POST',
                data: {
                    name: name,
                    _token: "{{csrf_token()}}"
                },
                dataType: 'json',
                success: function (response) {
                    if (response.code !== 0) {
                        hideLoading($courseCompleteModal.find('.modal-content'));
                        showToast('error', response.msg || "{{__('提交失败')}}");
                        return;
                    }

                    // 记录轮询开始时间
                    pollStartTime = Date.now();

                    // 开始轮询检查证书状态（每2秒检查一次）
                    if (pollTimer) {
                        clearInterval(pollTimer);
                    }
                    pollTimer = setInterval(function () {
                        checkCertificateStatus(currentCourseId);
                    }, 2000);

                    // 立即检查一次
                    checkCertificateStatus(currentCourseId);
                },
                error: function () {
                    hideLoading($courseCompleteModal.find('.modal-content'));
                    showToast('error', "{{__('提交失败，请重试')}}");
                }
            });
        });

        // 轮询检查证书状态
        function checkCertificateStatus() {
            // 检查超时
            if (pollStartTime && Date.now() - pollStartTime > POLL_TIMEOUT) {
                if (pollTimer) {
                    clearInterval(pollTimer);
                    pollTimer = null;
                }
                hideLoading($courseCompleteModal.find('.modal-content'));
                showToast('error', "{{__('证书生成超时，请稍后刷新页面查看')}}");
                return;
            }

            $.ajax({
                url: '{{route('course.certificate-status.html', ['course' => $course->id])}}',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.code !== 0) {
                        return;
                    }

                    const data = response.data || {};
                    // 如果证书已生成
                    if (data.status === 1 && data.download_url) {
                        // 停止轮询
                        if (pollTimer) {
                            clearInterval(pollTimer);
                            pollTimer = null;
                        }

                        // 隐藏 loading
                        hideLoading($courseCompleteModal.find('.modal-content'));

                        $courseCompleteModal.modal('hide');
                        $('.certificate-button').attr('data-url', data.download_url)
                        showToast('success', "{{__('证书生成成功')}}");
                        window.open(data.download_url, '_blank');
                    }
                }
            });
        }

        $courseCompleteModal.on('hidden.bs.modal', function () {
            // 停止轮询
            if (pollTimer) {
                clearInterval(pollTimer);
                pollTimer = null;
            }

            // 重置状态
            pollStartTime = null;
            $('.certificate-button-content').show()
            $('.loader-wrapper').addClass('hide')
        });
    })
</script>
</html>
