@php
    $embed_url = $resource->short??'';
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
            <img class="w-full" src="{{web_resource_url('assets/web/images/resource-kit/banner-02.png')}}" alt="幼兒中心專業學習歷程">
        </div>
    </div>
</section>

<section class="bg-01">
    <div class="container mx-auto p-5 xl:p-10">

        <x-web.breadcrumb :breadcrumbs="$breadcrumbs"/>

        <div class="bg-[#fff] rounded-lg p-[53px_54px] border-b-[28px] border-[#cceeeb] mt-[30px]">
            <div class="w-full aspect-[4/3] rounded-lg">
                <iframe class="w-full h-full rounded-lg" src="{{$embed_url}}" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="text-[28px] text-[#00A99D] font-bold py-[11px] mt-[33px] mb-[60px]">
                {{$resource->title}}
            </div>

            <nav>
                <ul class="flex justify-between">
                    <li>
                        @if($prev)
                            <a class="flex items-center gap-2" href="{{route('resource.show.html', ['resource' => $prev])}}">
                                <i class="fa-solid fa-angles-left text-[#999]"></i>
                                <span class="text-[15px] font-blod text-[#999]">上一篇</span>
                            </a>
                        @endif
                    </li>
                    <li>
                        @if($next)
                            <a class="flex items-center gap-2" href="{{route('resource.show.html', ['resource' => $next])}}">
                                <span class="text-[15px] font-blod text-[#999]">下一篇</span>
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
