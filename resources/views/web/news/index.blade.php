<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
</head>
<body>
<x-web.header/>

<section class="bg-01">
    <div class="container mx-auto">

        <div class="content pt-8">
            @if($videos->isNotEmpty())
                <div class="flex items-center justify-between mt-5 mb-10">
                    <div class="text-[31px] text-[#998675] font-bold">{{__('最新视频')}}</div>
                </div>
                <div class="grid grid-cols-12 gap-x-5 list-container">
                    @if($videos->isNotEmpty())
                        @foreach($videos as $index => $video)
                            <div class="md:col-span-6 lg:col-span-3">
                                @include('web.news.item-video', ['news' => $video, 'col' => false, 'index' => $index])
                            </div>
                        @endforeach
                        @if($total_video > 7)
                            <div class="md:col-span-6 lg:col-span-3">
                                <div class="media media-blog-2 more-box card-border border-tricolor-wave">
                                    <a href="{{route('news.more.html',['type'=>1])}}" class="w-100 h-100 flex flex-column justify-center items-center" style="color:#666;">
                                        <i class="fa-solid fa-plus text-2xl mb-2"></i>
                                        {{__('更多')}}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="w-100 text-center py-4 text-muted">
                            <i class="fa-solid fa-book text-2xl mb-2"></i>
                            <p class="mb-0">{{__('暂无数据')}}</p>
                        </div>
                    @endif
                </div>
            @endif

            @if($articles->isNotEmpty())
                <div class="flex items-center justify-between mt-5 mb-10">
                    <div class="text-[31px] text-[#998675] font-bold">{{__('最新消息')}}</div>
                </div>
                <div class="grid grid-cols-12 gap-x-5 list-container">
                    @if($articles->isNotEmpty())
                        @foreach($articles as $index => $article)
                            <div class="md:col-span-6 lg:col-span-3">
                                @include('web.news.item', ['news' => $article, 'col' => false, 'index' => $index])
                            </div>
                        @endforeach
                        @if($total_article > 7)
                            <div class="md:col-span-6 lg:col-span-3">
                                <div class="media media-blog-2 more-box card-border border-tricolor-wave">
                                    <a href="{{route('news.more.html',['type'=>0])}}" class="w-100 h-100 flex flex-column justify-center items-center" style="color:#666;">
                                        <i class="fa-solid fa-plus text-2xl mb-2"></i>
                                        {{__('更多')}}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="w-100 text-center py-4 text-muted">
                            <i class="fa-solid fa-book text-2xl mb-2"></i>
                            <p class="mb-0">{{__('暂无数据')}}</p>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</section>

<x-web.footer/>
</body>

</html>
