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
                    <div class="col-lg-8">
                        <div class="position-relative">
                            <div class="play-icon" data-toggle="modal" data-target="#play-box" data-unit="{{$play_record->unit_id??0}}" data-play-position="{{$play_record->play_position??0}}">
                                <i class="fa-solid fa-play" style="font-size: 1.5rem;"></i>
                            </div>
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
                                                                <li class="p-4 px-3 d-flex justify-content-between" data-title="{{$chapter->title}} - {{$unit->title}}" data-unit="{{$unit->id}}"
                                                                    data-info="{{$unit}}">
                                                                    <p class="mb-0">
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
                                                                               data-status="{{$unit->status??0}}"
                                                                               data-play-position="{{$unit->play_position??0}}">Preview</a>
                                                                        @endif

                                                                        @if($unit->status === 1)
                                                                            <i class="fa-solid fa-book text-warning ml-3"></i>
                                                                        @elseif($unit->status === 2)
                                                                            <i class="fa-solid fa-circle-check text-success ml-3"></i>
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
                    <div class="col-lg-4">
                        <div class="course-sidebar-sec mt-0">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="subs-title mb-4">Includes</h5>
                                    <p class="mb-3"><img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/play.svg')}}" alt="img">11 hours
                                        on-demand video</p>
                                    <p class="mb-3"><img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/import.svg')}}" alt="img">69
                                        downloadable resources</p>
                                    <p class="mb-3"><img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/key.svg')}}" alt="img">Full
                                        lifetime access</p>
                                    <p class="mb-3"><img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/monitor-mobbile.svg')}}" alt="img">Access on mobile and TV</p>
                                    <p class="mb-3"><img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/cloud-lightning.svg')}}" alt="img">Assignments</p>
                                    <p class="mb-0"><img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/teacher.svg')}}" alt="img">Certificate of Completion</p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body cou-features">
                                    <h5 class="subs-title mb-4">Course Features</h5>
                                    <p class="mb-3"><img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/people2.svg')}}" alt="img">Enrolled: 32 students</p>
                                    <p class="mb-3"><img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/timer-start3.svg')}}" alt="img">Duration: 20 hours</p>
                                    <p class="mb-3"><img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/note.svg')}}" alt="img">Chapters: 15</p>
                                    <p class="mb-3"><img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/play3.svg')}}" alt="img">Video: 12 hours</p>
                                    <p class="mb-0"><img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/chart.svg')}}" alt="img">Level: Beginner</p>
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

</div>

</body>

</html>
