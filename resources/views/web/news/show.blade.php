<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/font-awesome/all.min.css'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
</head>
<body>
<x-web.header/>

<section>
    <div class="owl-carousel">
        <div class="w-full">
            <img class="w-full" src="{{web_resource_url('assets/web/images/news/banner.png')}}" alt="{{__('最新消息')}}">
        </div>
    </div>
</section>

<section class="bg-01">
    <div class="container mx-auto p-5 md:p-10">

        <x-web.breadcrumb :breadcrumbs="$breadcrumbs"/>

        <div class="bg-[#fff] rounded-lg p-[45px_52px] mt-[30px]">
            @if($news->thumbnail_show === 1 && $news->getRawOriginal('thumbnail'))
                <div class="w-full mb-[20px]">
                    <img class="w-full" src="{{$news->thumbnail}}" alt="{{$news->title}}">
                </div>
            @endif
            <div class="text-[31px] text-[#ec6d74] font-bold">
                {{$news->title}}
            </div>
            <div class="text-[15px] text-[#736357] mt-[10px]">{{$news->short}}</div>
            <div class="w-fit text-[15px] text-[#998675] font-bold my-[21px] p-[13px] date-bg"
                 style="background-image: url('{{web_resource_url('assets/web/images/news/date-bg.svg')}}')">{{__('发布日期')}}：{{$news->release_date}}</div>
            <div class="mb-[30px]">
                {!! $news->description !!}
            </div>
            <nav>
                <ul class="flex justify-between">
                    <li>
                        @if($prev)
                            <a class="flex items-center gap-2" href="{{route('news.show.html', ['news' => $prev])}}">
                                <i class="fa-solid fa-angles-left text-[#999]"></i>
                                <span class="text-[15px] font-blod text-[#999]">previous post</span>
                            </a>
                        @endif
                    </li>
                    <li>
                        @if($next)
                            <a class="flex items-center gap-2" href="{{route('news.show.html', ['news' => $next])}}">
                                <span class="text-[15px] font-blod text-[#999]">next post</span>
                                <i class="fa-solid fa-angles-right text-[#999]"></i>
                            </a>
                        @endif
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>

<x-web.footer/>
</body>
</html>
