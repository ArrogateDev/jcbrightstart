<!DOCTYPE html>
<html lang="en">

<x-web.head/>
<link href="{{web_resource_url('assets/web/css/course.css')}}" rel="stylesheet" media="all">
<style>
    #learn-box .tab-content {
        height: 500px;
        overflow: hidden;
    }

    #learn-box .tab-content:has(#learn-quiz) {
        height: 670px;
        overflow: hidden;
    }

    #learn-box.modal-pdf .tab-content {
        height: 75vh;
    }

    #learn-box #learn-play,
    #learn-box #learn-quiz,
    #learn-box #play-content,
    #learn-box #quiz-content {
        height: 100%;
    }

    #learn-box #pdf-viewer,
    #learn-box ._df_book {
        height: 100%;
    }

    #learn-box #play-loading {
        height: 100% !important;
    }

    #learn-box .modal-dialog {
        width: 1080px;
        max-width: 100%;
    }

    .modal {
        padding: 15px !important;
    }

    #learn-box .nav {
        border: unset;
        gap: .5rem;
    }

    #learn-box .nav-item {
        border: unset;
        border-radius: 45px;
        padding: 0.5rem 1rem;
        background-color: #f8f9fa;
    }

    #learn-box .nav-item a {
        padding: 0;
        border: unset;
        color: black;
        background: transparent;
        font-size: .875rem;
        line-height: 1.25rem;
        font-weight: 500;
    }

    #learn-box .nav-item:has(.active) {
        background-color: #ffb900;
    }

    #learn-box .nav-item:has(.active) a {
        color: white;
    }

    .quiz-start {
        background-image: linear-gradient(to bottom right, #fffbeb, #fff7ed);
        gap: 4rem;
    }

    .quiz-line {
        width: 8rem;
        height: .25rem;
        background-image: linear-gradient(to right, transparent, #fbbf24, transparent);
    }

    #quiz-start-button {
        background-image: linear-gradient(to right, #10b981, #0d9488);
        border-radius: .75rem;
        font-size: 1.25rem;
        line-height: 1.75rem;
        font-weight: 700;
        padding: 1rem;
        color: white;
    }

    .quiz-question {
        border-radius: 1rem;
    }

    #quiz-content .progress {
        border-radius: 1rem;
    }

    #quiz-content .progress-bar {
        background-image: linear-gradient(to right, #4f46e5, #9333ea);
    }

    .quiz-question-title {
        background-image: linear-gradient(to right, #4f46e5, #9333ea);
        padding: 1.5rem;
        border-radius: 1rem 1rem 0 0;
    }

    .quiz-question-title .tag {
        width: fit-content;
        margin-bottom: .75rem;
        border-radius: 9999px;
        background-color: #ffffff33;
        padding: .375rem 1rem;
        font-size: .875rem;
        line-height: 1.25rem;
        font-weight: 500;
        color: white;
    }

    .quiz-question-title .title {
        font-weight: 700;
        font-size: 1.25rem;
        line-height: 1.75rem;
        color: white;
    }

    .per-btn, .next-btn {
        font-weight: 500;
        padding: .75rem 1rem;
        border-radius: 0.5rem;
        color: #374151;
    }

    .per-btn {
        background-color: #e5e7eb;
    }

    .next-btn {
        background-image: linear-gradient(to right, #10b981, #0d9488);
        color: white;
    }

    .per-btn.disabled, .per-btn.disabled:hover {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #d1d5db !important;
        border-color: #6b7280 !important;
        transform: none !important;
    }

    .quiz-statistics {
        width: 400px;
        max-width: 100%;
        margin: 10px auto;
        height: calc(100% - 30px);
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 0 #0000, 0 25px 50px -12px #00000040;
        border-radius: 1.5rem;
        padding: 2rem;
        gap: 2rem;
    }

    .quiz-statistics-icon {
        height: 95px;
        line-height: normal;
        font-size: 5rem;
    }

    .quiz-statistics-title {
        color: #1f2937;
        font-weight: 700;
        font-size: 1.875rem;
        line-height: 2.25rem;
    }

    .quiz-statistics-progress {
        width: 100%;
        text-align: center;
        background-image: linear-gradient(to right, #6366f1, #9333ea);
        border-radius: 1rem;
        padding: 1.5rem;
        color: white;
    }

    .quiz-statistics-progress h1 {
        color: white;
        font-size: 3rem;
        line-height: 1;
        margin-bottom: .5rem;
    }

    .quiz-statistics-progress .progress-value {
        opacity: .9;
        font-size: 1.25rem;
        line-height: 1.75rem;
    }

    .quiz-statistics-btn {
        width: 100%;
    }

    .quiz-statistics-btn .btn {
        width: 100%;
        border-radius: .75rem;
        font-weight: 700;
    }

    .quiz-statistics-btn .btn-next-unit {
        background-image: linear-gradient(to right, #10b981, #0d9488);
    }
</style>
<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('课程')}}" subtitle="{{__('课程')}}"/>

        <section class="section p-t-125 p-b-75 p-md-t-60 course-details">
            <div class="container">

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="position-relative">
                            <img src="{{$course->thumbnail}}" alt="img" class="img-fluid mb-4" style="border-radius: .25rem;">
                        </div>
                        <div class="course-page-content pt-0">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="mb-3">{{__('概览')}}</h5>
                                    <h6 class="mb-2">{{__('课程简介')}}</h6>
                                    <div>
                                        {!! $course->description !!}
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <h5 class="subs-title mb-2 mb-sm-3">{{__('课程内容')}}</h5>
                                        <h6 class="fs-16 fw-medium text-gray-7 mb-3">{{$course->unit_num??0}} {{__('单元')}}</h6>
                                    </div>
                                    <div class="accordion accordion-customicon1 accordions-items-seperate p-0" id="chapter-box">
                                        @foreach($course->chapters as $chapter)
                                            <div class="accordion-item" data-aos="fade-up">
                                                <h2 class="accordion-header" id="chapter-{{$chapter->id}}">
                                                    <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#chapter-units-{{$chapter->id}}"
                                                            aria-expanded="false"
                                                            aria-controls="chapter-units-{{$chapter->id}}" style="font-weight: 700;">
                                                        {{$chapter->title}} <i class="fa-solid fa-chevron-down"></i>
                                                    </button>
                                                </h2>
                                                <div id="chapter-units-{{$chapter->id}}" class="accordion-collapse collapse" aria-labelledby="chapter-{{$chapter->id}}" data-parent="#chapter-box">
                                                    <div class="accordion-body p-0">
                                                        <ul>
                                                            @foreach($chapter->units as $unit)
                                                                <li class="unit-item p-4 px-3 d-flex justify-content-between" data-title="{{$chapter->title}} - {{$unit->title}}"
                                                                    data-unit="{{$unit->id}}"
                                                                    data-info="{{$unit}}">
                                                                    <div class="unit-main-content w-100">
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <p class="mb-0 unit-title">
                                                                                <img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/play.svg')}}" alt="img">
                                                                                {{$unit->title}}
                                                                            </p>
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="unit-status">
                                                                                    @if($unit->status === 1)
                                                                                        <a href="#" class="preview-link" data-toggle="modal" data-target="#learn-box" data-tab="quiz"
                                                                                           data-course="{{$unit->course_id??0}}"
                                                                                           data-chapter="{{$unit->chapter_id??0}}"
                                                                                           data-unit="{{$unit->id??0}}"
                                                                                           data-quiz="{{$unit->quiz_id??0}}"
                                                                                           data-status="{{$unit->status??0}}">{{__('测验')}}</a>
                                                                                    @else
                                                                                        <a href="#" class="preview-link" data-toggle="modal" data-target="#learn-box" data-tab="play"
                                                                                           data-unit="{{$unit->id??0}}"
                                                                                           data-status="{{$unit->status??0}}" data-play-position="{{$unit->play_position??0}}">{{__('打开')}}</a>
                                                                                    @endif

                                                                                    @if($unit->status === 1)
                                                                                        <i class="fa-solid fa-book text-warning ml-3"></i>
                                                                                    @elseif($unit->status === 2)
                                                                                        <i class="fa-solid fa-circle-check text-success ml-3"></i>
                                                                                    @endif
                                                                                </div>

                                                                                @if(!empty(html_entity_decode(strip_tags($unit->description))))
                                                                                    <i class="fas fa-chevron-down unit-expand-icon ml-3 text-muted"></i>
                                                                                @endif
                                                                            </div>
                                                                        </div>

                                                                        @if(!empty(html_entity_decode(strip_tags($unit->description))))
                                                                            <div class="unit-expand-content mt-3" style="display: none;">
                                                                                <div class="unit-description">
                                                                                    <p class="text-muted mb-0">{!! $unit->description !!}</p>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <x-web.footer/>

    @include('web.course.content')
    @include('web.course.signature')

    <script>
        $(document).ready(function () {
            $('.unit-item').on('click', function (e) {
                if ($(e.target).closest('a, button').length > 0) {
                    return;
                }

                const $item = $(this);
                const $expandContent = $item.find('.unit-expand-content');

                if ($item.hasClass('expanded')) {
                    $expandContent.slideUp(300);
                    $item.removeClass('expanded');
                } else {
                    $expandContent.slideDown(300);
                    $item.addClass('expanded');
                }
            });

            $(document).on('click', function (e) {
                if (!$(e.target).closest('.unit-item').length) {
                    $('.unit-item.expanded').each(function () {
                        const $item = $(this);
                        $item.find('.unit-expand-content').slideUp(300);
                        $item.removeClass('expanded');
                    });
                }
            });
        });
    </script>

</div>

</body>

</html>
