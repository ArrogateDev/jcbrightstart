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
                    <div class="relative mb-6 overflow-hidden rounded-2xl border border-[#e7e7e7] bg-white shadow-[0_4px_24px_rgba(212,212,212,0.2)]">
                        <img src="{{web_resource_url('assets/admin/img/shapes/withdraw-bg1.svg')}}" class="pointer-events-none absolute left-0 top-0 h-full w-auto opacity-20" alt="img">
                        <img src="{{web_resource_url('assets/admin/img/shapes/withdraw-bg2.svg')}}" class="pointer-events-none absolute right-0 top-0 h-full w-auto opacity-20" alt="img">
                        <div class="relative z-10 p-6">
                            <div class="grid grid-cols-12 items-center gap-4">
                                <div class="md:col-span-8">
                                    <div>
                                        <h6 class="mb-1 text-base font-semibold text-slate-900">{{__('测验')}} : {{$last_quiz->title}} </h6>
                                        <p class="text-sm text-slate-600">{{__('已回答')}} : {{$last_quiz->answered}}/{{$last_quiz->total_questions}}</p>
                                    </div>
                                </div>
                                <div class="md:col-span-4">
                                    <div class="text-right md:text-end">
                                        <a href="{{$last_quiz->url}}" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800">
                                            {{__('继续测验')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mb-6 grid grid-cols-12 gap-6">
                    <div class="md:col-span-6 xl:col-span-4">
                        <div class="rounded-2xl border border-[#e7e7e7] bg-white p-5 shadow-[0_4px_24px_rgba(212,212,212,0.2)] transition hover:border-[rgba(57,44,125,0.3)]">
                            <div class="flex items-center gap-3">
                                <span class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl bg-[rgba(13,110,253,0.12)] text-4xl">📚</span>
                                <div>
                                    <span class="block text-sm text-slate-600">{{__('我的课程')}}</span>
                                    <h4 class="mt-1 text-2xl font-bold text-slate-900">{{$start_course}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-6 xl:col-span-4">
                        <div class="rounded-2xl border border-[#e7e7e7] bg-white p-5 shadow-[0_4px_24px_rgba(212,212,212,0.2)] transition hover:border-[rgba(57,44,125,0.3)]">
                            <div class="flex items-center gap-3">
                                <span class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl bg-[rgba(108,117,125,0.12)] text-4xl">📖</span>
                                <div>
                                    <span class="block text-sm text-slate-600">{{__('待完成课程')}}</span>
                                    <h4 class="mt-1 text-2xl font-bold text-slate-900">{{$complete_course}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-6 xl:col-span-4">
                        <div class="rounded-2xl border border-[#e7e7e7] bg-white p-5 shadow-[0_4px_24px_rgba(212,212,212,0.2)] transition hover:border-[rgba(57,44,125,0.3)]">
                            <div class="flex items-center gap-3">
                                <span class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl bg-[rgba(25,135,84,0.12)] text-4xl">🏅</span>
                                <div>
                                    <span class="block text-sm text-slate-600">{{__('我的证书')}}</span>
                                    <h4 class="mt-1 text-2xl font-bold text-slate-900">{{$complete_quizzes}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!empty($courses))
                    <h5 class="mb-3 text-lg font-bold text-slate-900">{{__('近期观看')}}</h5>
                    <div class="grid grid-cols-12 gap-6">
                        @foreach($courses as $item)
                            <div class="md:col-span-6 xl:col-span-4">
                                <div class="overflow-hidden rounded-2xl border border-[#e7e7e7] bg-white p-5 shadow-[0_4px_24px_rgba(212,212,212,0.2)] transition hover:border-[rgba(57,44,125,0.3)]">
                                    <div class="mb-6 overflow-hidden rounded-xl max-h-[200px]">
                                        <a href="{{$item->url}}">
                                            <img src="{{$item->course->thumbnail??''}}" alt="img" class="h-full w-full object-cover">
                                        </a>
                                    </div>
                                    <div>
                                        <h6 class="mb-3 line-clamp-2 text-lg font-bold text-slate-900">
                                            <a href="{{$item->url}}" class="transition hover:text-slate-700">{{$item->course->title??''}}</a>
                                        </h6>
                                        <div class="flex items-center justify-center">
                                            <a href="{{$item->url}}" class="inline-flex items-center rounded-full bg-slate-900 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-slate-800">
                                                {{__('进入课程')}}
                                                <i class="fa-solid fa-chevron-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-10 grid grid-cols-12">
                    <div class="col-span-12">
                        <div class="mb-0 rounded-2xl border border-[#e7e7e7] bg-white shadow-[0_4px_24px_rgba(212,212,212,0.2)]">
                            <div class="p-5">
                                <h5 class="mb-3 border-b border-[#e7e7e7] pb-3 text-lg font-bold text-slate-900">{{__('最新测验记录')}}</h5>
                                @foreach($quizzes as $quiz)
                                    <div class="mb-3 flex flex-wrap items-center justify-between gap-4">
                                        <div class="min-w-0 flex-1">
                                            <div class="mb-1 truncate text-base font-semibold text-slate-900">{{$quiz->title}}</div>
                                            <div class="flex items-center text-sm text-[#6d6d6d]">
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
