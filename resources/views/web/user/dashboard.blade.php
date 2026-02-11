<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>

<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <x-web.user.breadcrumb title="{{__('仪表板')}}"/>

    <div class="content">
        <div class="container">

            <x-web.user.profile :user="$user"/>

            <div class="row">

                <x-web.user.sidebar active="dashboard"/>

                <div class="col-lg-9">
                    @if($last_quiz)
                        <div class="card bg-light quiz-ans-card">
                            <img src="{{web_resource_url('assets/admin/img/shapes/withdraw-bg1.svg')}}" class="quiz-ans-bg1" alt="img">
                            <img src="{{web_resource_url('assets/admin/img/shapes/withdraw-bg2.svg')}}" class="quiz-ans-bg2" alt="img">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div>
                                            <h6 class="mb-1">{{__('测验')}} : {{$last_quiz->title}} </h6>
                                            <p>{{__('已回答')}} : {{$last_quiz->answered}}/{{$last_quiz->total_questions}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-end">
                                            <a href="{{$last_quiz->url}}" class="btn btn-primary rounded-pill">
                                                {{__('继续测验')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
											<span
                                                class="icon-box bg-primary-transparent me-2 me-xxl-3 flex-shrink-0"><img
                                                    src="{{web_resource_url('assets/admin/img/icon/graduation.svg')}}" alt=""></span>
                                        <div>
                                            <span class="d-block">{{__('我的课程')}}</span>
                                            <h4 class="fs-24 mt-1">{{$start_course}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
											<span
                                                class="icon-box bg-secondary-transparent me-2 me-xxl-3 flex-shrink-0"><img
                                                    src="{{web_resource_url('assets/admin/img/icon/book.svg')}}" alt=""></span>
                                        <div>
                                            <span class="d-block">{{__('待完成课程')}}</span>
                                            <h4 class="fs-24 mt-1">{{$complete_course}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
											<span
                                                class="icon-box bg-success-transparent me-2 me-xxl-3 flex-shrink-0"><img
                                                    src="{{web_resource_url('assets/admin/img/icon/bookmark.svg')}}" alt=""></span>
                                        <div>
                                            <span class="d-block">{{__('我的证书')}}</span>
                                            <h4 class="fs-24 mt-1">{{$complete_quizzes}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!empty($courses))
                        <h5 class="mb-3 fs-18">{{__('近期观看')}}</h5>
                        <div class="row">
                            @foreach($courses as $item)
                                <div class="col-xl-4 col-md-6">
                                    <div class="course-item-two course-item mx-0">
                                        <div class="course-img">
                                            <a href="{{$item->url}}">
                                                <img src="{{$item->course->thumbnail}}" alt="img" class="img-fluid">
                                            </a>
                                        </div>
                                        <div class="course-content">
                                            <div class="d-flex justify-content-between mb-2">
                                                <div class="d-flex align-items-center">
                                                    <a href="{{$item->url}}" class="avatar avatar-sm">
                                                        <img src="{{web_resource_url('assets/img/avatar.png')}}" alt="img"
                                                             class="img-fluid avatar avatar-sm rounded-circle">
                                                    </a>
                                                    <div class="ms-2">
                                                        <a href="{{$item->url}}" class="link-default fs-14">Brenda Slaton</a>
                                                    </div>
                                                </div>
                                                <span class="badge badge-light rounded-pill bg-light d-inline-flex align-items-center fs-13 fw-medium mb-0">
                                                    Design
                                                </span>
                                            </div>
                                            <h6 class="title mb-2">
                                                <a href="{{$item->url}}">{{$item->course->title}}</a>
                                            </h6>
                                            <p class="d-flex align-items-center mb-3"><i
                                                    class="fa-solid fa-star text-warning me-2"></i>4.9 (200 Reviews)</p>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="{{$item->url}}" class="btn btn-dark btn-sm d-inline-flex align-items-center">
                                                    View  Course<i class="isax isax-arrow-right-3 ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h5 class="mb-3 fs-18 border-bottom pb-3">{{__('最新测验记录')}}</h5>
                                    @foreach($quizzes as $quiz)
                                        <div
                                            class="d-flex align-items-center flex-wrap flex-md-nowrap justify-content-between row-gap-2 mb-3">
                                            <div>
                                                <h6 class="mb-1">{{$quiz->title}}</h6>
                                                <div class="d-flex align-items-center">
                                                    <p>{{__('已回答')}} : {{$quiz->answered}}/{{$quiz->total_questions}}</p>
                                                </div>
                                            </div>
                                            <div class="circle-progress flex-shrink-0" data-value='{{$quiz->finishing_rate}}'>
                                                @if($quiz->finishing_rate == 100)
                                                    <span class="progress-left">
                                                            <span class="progress-bar border-success"></span>
                                                        </span>
                                                    <span class="progress-right">
                                                            <span class="progress-bar border-success"></span>
                                                        </span>
                                                @elseif($quiz->finishing_rat > 50 && $quiz->finishing_rat < 100)
                                                    <span class="progress-left">
                                                            <span class="progress-bar border-warning"></span>
                                                        </span>
                                                    <span class="progress-right">
                                                            <span class="progress-bar border-warning"></span>
                                                        </span>
                                                @else
                                                    <span class="progress-left">
                                                            <span class="progress-bar border-danger"></span>
                                                        </span>
                                                    <span class="progress-right">
                                                            <span class="progress-bar border-danger"></span>
                                                        </span>
                                                @endif
                                                <div class="progress-value">{{$quiz->finishing_rate}}%</div>
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
    </div>


    <x-web.user.footer/>

</div>

</body>

</html>
