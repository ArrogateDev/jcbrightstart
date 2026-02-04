<!DOCTYPE html>
<html lang="en">

<x-web.head/>
<link href="{{web_resource_url('assets/web/css/course.css')}}" rel="stylesheet" media="all">

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
                                    <h5 class="mb-3">Overview</h5>
                                    <h6 class="mb-2">Course Description</h6>
                                    <div>
                                        {!! $course->description !!}
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <h5 class="subs-title mb-2 mb-sm-3">Course Content</h5>
                                        <h6 class="fs-16 fw-medium text-gray-7 mb-3">{{$course->unit_num??0}} Units</h6>
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
                                                                                @if($unit->status === 1)
                                                                                    <a href="#" class="preview-link" data-toggle="modal" data-target="#quiz-box"
                                                                                       data-course="{{$unit->course_id??0}}"
                                                                                       data-chapter="{{$unit->chapter_id??0}}"
                                                                                       data-unit="{{$unit->id??0}}"
                                                                                       data-quiz="{{$unit->quiz_id??0}}"
                                                                                       data-status="{{$unit->status??0}}">Quiz</a>
                                                                                @else
                                                                                    <a href="#" class="preview-link" data-toggle="modal" data-target="#play-box"
                                                                                       data-unit="{{$unit->id??0}}"
                                                                                       data-status="{{$unit->status??0}}" data-play-position="{{$unit->play_position??0}}">Preview</a>
                                                                                @endif

                                                                                @if($unit->status === 1)
                                                                                    <i class="fa-solid fa-book text-warning ml-3"></i>
                                                                                @elseif($unit->status === 2)
                                                                                    <i class="fa-solid fa-circle-check text-success ml-3"></i>
                                                                                @endif

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

    @include('web.course.play')
    @include('web.course.quiz')

    <script>
        $(document).ready(function () {
            // 单元项点击展开/收起功能
            $('.unit-item').on('click', function (e) {
                // 如果点击的是链接或按钮，则不触发展开
                if ($(e.target).closest('a, button').length > 0) {
                    return;
                }

                const $item = $(this);
                const $expandContent = $item.find('.unit-expand-content');
                const $icon = $item.find('.unit-expand-icon');

                // 切换展开状态
                if ($item.hasClass('expanded')) {
                    // 收起
                    $expandContent.slideUp(300);
                    $item.removeClass('expanded');
                } else {
                    // 展开
                    $expandContent.slideDown(300);
                    $item.addClass('expanded');
                }
            });

            // 点击展开区域外部时收起所有展开的单元
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
