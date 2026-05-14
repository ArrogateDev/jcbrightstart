<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/css/user.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<x-web.v1.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="pt-[60px]">
            <x-web.user.v1-profile :user="$user"/>
        </div>

        <div class="grid grid-cols-12 gap-x-12">
            <x-web.user.v1-sidebar active="dashboard"/>

            <div class="lg:col-span-10">
                <x-web.user.breadcrumb title="{{__('仪表板')}}"/>

                @if($last_quiz)
                    <div class="card bg-light quiz-ans-card j-user-box">
                        <img src="{{web_resource_url('assets/admin/img/shapes/withdraw-bg1.svg')}}" class="quiz-ans-bg1" alt="img">
                        <img src="{{web_resource_url('assets/admin/img/shapes/withdraw-bg2.svg')}}" class="quiz-ans-bg2" alt="img">
                        <div class="card-body">
                            <div class="grid grid-cols-12 items-center">
                                <div class="md:col-span-8">
                                    <div>
                                        <h6 class="mb-1">{{__('测验')}} : {{$last_quiz->title}} </h6>
                                        <p>{{__('已回答')}} : {{$last_quiz->answered}}/{{$last_quiz->total_questions}}</p>
                                    </div>
                                </div>
                                <div class="md:col-span-4">
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

                <div class="grid grid-cols-12 gap-x-6 mb-6">
                    <div class="md:col-span-6 xl:col-span-4">
                        <div class="card j-user-box">
                            <div class="card-body">
                                <div class="flex items-center">
                                    <span class="icon-box bg-primary-transparent me-2 2xl:me-3 flex-shrink-0 text-4xl">📚</span>
                                    <div>
                                        <span class="block">{{__('我的课程')}}</span>
                                        <h4 class="text-2xl font-bold mt-1">{{$start_course}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-6 xl:col-span-4">
                        <div class="card j-user-box">
                            <div class="card-body">
                                <div class="flex items-center">
                                    <span class="icon-box bg-secondary-transparent me-2 2xl:me-3 flex-shrink-0 text-4xl">📖</span>
                                    <div>
                                        <span class="block">{{__('待完成课程')}}</span>
                                        <h4 class="text-2xl font-bold mt-1">{{$complete_course}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-6 xl:col-span-4">
                        <div class="card j-user-box">
                            <div class="card-body">
                                <div class="flex items-center">
                                    <span class="icon-box bg-success-transparent me-2 2xl:me-3 flex-shrink-0 text-4xl">🏅</span>
                                    <div>
                                        <span class="block">{{__('我的证书')}}</span>
                                        <h4 class="text-2xl font-bold mt-1">{{$complete_quizzes}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!empty($courses))
                    <h5 class="mb-3 text-lg font-bold">{{__('近期观看')}}</h5>
                    <div class="grid grid-cols-12">
                        @foreach($courses as $item)
                            <div class="xl:col-span-4 md:col-span-6">
                                <div class="course-item-two course-item mx-0 j-user-box">
                                    <div class="course-img">
                                        <a href="{{$item->url}}">
                                            <img src="{{$item->course->thumbnail??''}}" alt="img" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="course-content">
                                        <h6 class="title mb-2">
                                            <a href="{{$item->url}}">{{$item->course->title??''}}</a>
                                        </h6>
                                        <div class="flex items-center justify-center">
                                            <a href="{{$item->url}}" class="btn btn-dark btn-sm d-inline-flex items-center">
                                                {{__('进入课程')}}
                                                <i class="fa-solid fa-chevron-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-12 mt-10">
                    <div class="col-span-12">
                        <div class="card mb-0 j-user-box">
                            <div class="card-body">
                                <h5 class="mb-3 text-lg font-bold border-b-1 border-[#e7e7e7] pb-3">{{__('最新测验记录')}}</h5>
                                @foreach($quizzes as $quiz)
                                    <div
                                        class="flex items-center flex-wrap justify-between mb-3">
                                        <div class="flex-1 min-w-0">
                                            <div class="text-base mb-1 font-semibold truncate">{{$quiz->title}}</div>
                                            <div class="flex items-center text-[#6d6d6d]">
                                                <p>{{__('已回答')}} : {{$quiz->answered}}/{{$quiz->total_questions}}</p>
                                            </div>
                                        </div>
                                        <div
                                            @class(['flex-none', 'radial-progress', 'text-[10px]', 'text-red-600' => $quiz->finishing_rate <= 50, 'text-orange-500' => $quiz->finishing_rat > 50 && $quiz->finishing_rat < 100, 'text-green-700' => $quiz->finishing_rate == 100]) style="--value:{{$quiz->finishing_rate}};--size:38px; --thickness: 4px;"
                                            aria-valuenow="{{$quiz->finishing_rate}}" role="progressbar">{{$quiz->finishing_rate}}%
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

<x-web.v1.footer/>
</body>
</html>

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
        --white: #fff;
        --dark: #000;
        --black: #000;
        --light: #f8f8f8;
        --gray-100: #e7e7e7;
        --gray-200: #d1d1d1;
        --gray-300: #b0b0b0;
        --gray-400: #888888;
        --gray-500: #6d6d6d;
        --gray-600: #5d5d5d;
        --gray-700: #4f4f4f;
        --gray-800: #3d3d3d;
        --gray-900: #191919;
        --light-100: #fefefe;
        --light-200: #fcfcfd;
        --light-300: #fbfbfd;
        --light-400: #f9fafc;
        --light-500: #f8fafb;
        --light-600: #f7f9fb;
        --light-700: #f6f8fa;
        --light-800: #f5f7fa;
        --light-900: #f4f6f9;
    }


    .icon-box {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }


    .course-item {
        padding: 20px;
        border: 1px solid var(--gray-100);
        box-shadow: 0px 4px 4px 0px rgba(212, 212, 212, 0.2);
        border-radius: 10px;
        -webkit-transition: all 0.5s ease;
        -ms-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    .course-item .course-img {
        margin-bottom: 24px;
        position: relative;
    }

    .course-item .course-img img {
        width: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .course-item:hover {
        border: 1px solid rgba(57, 44, 125, 0.3);
    }

    .course-item .course-content {
        padding: 0;
    }

    .course-item.course-item-two {
        background: var(--white);
        margin-bottom: 24px;
    }

    .course-item.course-item-two .course-img {
        border-radius: 10px;
        overflow: hidden;
        transition: all 1.5s;
        max-height: 200px;
    }

    .course-item.course-item-two .course-content .title {
        font-size: 18px;
        font-weight: 700;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 991.98px) {
        .course-item.course-item-two .course-content .title {
            font-size: 16px;
        }
    }

    .btn {
        border-radius: 1.5rem;
        padding: 0.4rem 0.85rem;
        font-size: 14px;
        transition: all 0.5s;
        font-weight: 500;
    }

    .btn:focus {
        box-shadow: none !important;
    }

    .btn:hover {
        transition: all 0.5s;
    }

    .btn.btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .btn.btn-dark {
        background: var(--gray-900) !important;
        border-color: var(--gray-900) !important;
        box-shadow: none;
        color: var(--white);
    }

    .btn.btn-dark:hover {
        background: #252a30 !important;
    }
</style>
