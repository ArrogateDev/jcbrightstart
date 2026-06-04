@php
    $embed_url = $news->short??'';
    // Convert YouTube watch URL to embed URL
    if (str_contains($embed_url, 'youtube.com/watch?v=') || str_contains($embed_url, 'youtu.be/')) {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $embed_url, $matches);
        if (isset($matches[1])) {
            $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
        }
    }
@endphp
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
            <div class="media media-blog-4 m-b-10">
                <iframe class="w-full aspect-video" src="{{$embed_url}}" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="text-[31px] text-[#ec6d74] font-bold">
                {{$news->title}}
            </div>
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
