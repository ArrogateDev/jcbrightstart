<!DOCTYPE html>
<html lang="en">

<x-web.head/>
<script src="{{web_resource_url('assets/js/image-viewer.min.js')}}" id="gd-image-viewer"
        data-target-selector=".gallery-img"
        data-allow-rotate="false"
        data-allow-download="false">
</script>
<link href="{{web_resource_url('assets/web/css/course.css')}}" rel="stylesheet" media="all">
<style>
    .thumbnail-box {
        max-height: 90vh;
        text-align: center;
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
                        <div class="position-relative thumbnail-box">
                            <img src="{{$course->thumbnail}}" alt="img" class="img-fluid mb-4 gallery-img" style="border-radius: .25rem;">
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
                                                                    data-status="{{$unit->status}}"
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
