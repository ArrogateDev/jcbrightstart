<!DOCTYPE html>
<html lang="en">

<x-web.head/>
<style>

    ul {
        list-style: none;
    }

    p {
        color: #6d6d6d;
    }

    p {
        margin-bottom: 20px;
    }

    .text-secondary {
        color: #ff4667 !important;
        opacity: 1;
    }

    .accordion-button {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        color: var(--bs-accordion-btn-color);
        text-align: left;
        background-color: var(--bs-accordion-btn-bg);
        border: 0;
        border-radius: 0;
        overflow-anchor: none;
        transition: var(--bs-accordion-transition);
    }

    h2 {
        font-size: 36px;
        font-weight: 700;
    }

    .course-page-content {
        padding-top: 60px;
    }

    @media (max-width: 575.98px) {
        .course-page-content {
            padding-top: 45px;
        }
    }

    .course-page-content .subs-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 17px;
    }

    .course-page-content
    .accordion.accordion-customicon1.accordions-items-seperate {
        padding: 0 18px;
    }

    .course-page-content
    .accordion.accordion-customicon1.accordions-items-seperate
    li {
        padding: 15px !important;
    }

    .course-page-content
    .accordion.accordion-customicon1.accordions-items-seperate
    li
    .preview-link {
        color: #5625e8;
        font-size: 14px;
        text-decoration: underline;
    }

    .course-page-content
    .accordion.accordion-customicon1.accordions-items-seperate
    li
    .preview-link:hover {
        color: #ff4667;
    }

    .course-page-content .accordion-item {
        margin-bottom: 10px;
        border: none;
    }

    .course-page-content .accordion-button {
        font-size: 14px;
        font-weight: 600;
        background-color: var(--light);
        border-radius: 5px;
        box-shadow: none;
        display: flex;
        justify-content: space-between;
        color: var(--gray-900);
        border: 1px solid #e7e7e7;
    }

    .course-page-content .accordion-button::after {
        display: none;
    }

    .course-page-content .accordion-button i {
        transform: rotate(-180deg);
    }

    .course-page-content .accordion-button.accordion-button.collapsed i {
        transform: rotate(0deg);
    }

    .course-page-content .accordion-body ul li {
        border-bottom: 1px solid #e7e7e7;
        flex-wrap: wrap;
        gap: 10px;
    }

    .course-page-content .accordion-body ul li:last-child {
        border-bottom: none;
    }

    @media (max-width: 767.98px) {
        .course-page-content .accordion-body ul li {
            padding: 13px 10px !important;
        }
    }

    .course-details .play-icon {
        width: 60px;
        height: 60px;
        background-color: rgba(1, 1, 1, 0.4);
        border-radius: 50px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--white);
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .course-sidebar-sec {
        margin-top: -252px;
    }

    @media (max-width: 991.98px) {
        .course-sidebar-sec {
            margin-top: 0;
        }
    }

    .course-sidebar-sec h5 {
        margin-bottom: 20px;
    }

    @media (max-width: 1199.98px) {
        .course-sidebar-sec .wishlist-btns {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 991.98px) {
        .course-sidebar-sec .wishlist-btns {
            flex-wrap: nowrap;
        }
    }

    @media (max-width: 575.98px) {
        .course-sidebar-sec .wishlist-btns {
            flex-wrap: wrap;
        }
    }

    .course-sidebar-sec .btn-wish {
        color: var(--gray-900);
        border: 1px solid #e7e7e7;
        width: 100%;
        text-align: center;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }

    .course-sidebar-sec .btn-wish:hover {
        background-color: #ff4667;
        border-color: #ff4667;
        color: var(--white);
    }

    .course-sidebar-sec .btn-enroll {
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .course-sidebar-sec .btn-enroll:hover {
        background-color: #ff4667;
        border-color: #ff4667;
    }

    .course-sidebar-sec .cou-features {
        padding: 20px;
    }

    .course-sidebar-sec .cou-features h5 {
        margin-bottom: 20px;
    }

    .course-details {
        position: relative;
        padding: 60px 0 45px;
    }

    @media (max-width: 575.98px) {
        .course-details {
            padding: 45px 0 30px;
        }
    }

    .course-details .play-icon {
        width: 60px;
        height: 60px;
        background-color: rgba(1, 1, 1, 0.4);
        border-radius: 50px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--white);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @media (max-width: 575.98px) {
        .course-details .play-icon {
            width: 70px;
            height: 70px;
        }
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
                                                                <li class="p-4 px-3 d-flex justify-content-between" data-title="{{$chapter->title}} - {{$unit->title}}" data-unit="{{$unit->id}}" data-info="{{$unit}}">
                                                                    <p class="mb-0">
                                                                        <img class="mr-2" src="{{web_resource_url('assets/admin/img/icons/play.svg')}}" alt="img">
                                                                        {{$unit->title}}
                                                                    </p>
                                                                    <div class="d-flex align-items-center">
                                                                        <a href="#" class="preview-link mr-3 mr-xl-5"  data-toggle="modal" data-target="#play-box" data-unit="{{$unit->id??0}}" data-play-position="{{$unit->play_position??0}}">Preview</a>
                                                                        <i class="fa-solid fa-circle-check text-success ml-1"></i>
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

</div>

</body>

</html>
