<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/font-awesome/all.min.css'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{web_resource_url('assets/web/vendor/dflip/dflip.min.css')}}">
    <script src="{{web_resource_url('assets/web/vendor/dflip/js/dflip.min.js')}}"></script>
</head>
<body>
<x-web.header/>

<section>
    <div class="owl-carousel">
        <div class="w-full">
            <img class="w-full" src="{{web_resource_url('assets/web/images/resource-kit/banner-02.png')}}" alt="">
        </div>
    </div>
</section>

<section class="bg-01">
    <div class="container mx-auto p-5 md:p-10">

        <x-web.breadcrumb :breadcrumbs="$breadcrumbs"/>

        <div class="bg-[#fff] rounded-lg p-[40px_50px] border-b-[28px] border-[#fce199] mt-[30px]">
            <div class="text-[31px] text-[#F7931E] py-[11px] border-b-[1px] border-[#cdc3bb]">{{$resource->title}}</div>
            <div class="text-[17px] text-[#736357] font-sans mt-[18px] mb-[30px]">{{$resource->short}}</div>
            @if($resource->pdf)
                <div class="mb-[30px]" id="pdf-viewer"></div>
            @endif
            <div class="mb-[30px] resource-page">
                {!! $resource->description !!}
            </div>
            <nav>
                <ul class="flex justify-between">
                    <li>
                        @if($prev)
                            <a class="flex items-center gap-2" href="{{route('resource.show.html', ['resource' => $prev])}}">
                                <i class="fa-solid fa-angles-left text-[#999]"></i>
                                <span class="text-[15px] font-blod text-[#999]">previous post</span>
                            </a>
                        @endif
                    </li>
                    <li>
                        @if($next)
                            <a class="flex items-center gap-2" href="{{route('resource.show.html', ['resource' => $next])}}">
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

@if($resource->pdf)
    <script>
        $(function () {
            $('#pdf-viewer').flipBook('{{$resource->pdf}}', {
                showDownloadControl: false,
                enableDownload: false,
                showPrintControl: false,
                showSearchControl: false,
                autoOpenOutline: false,
                showThumbnail: false,
                autoOpenThumbnail: false
            });
        });
    </script>
@endif
</html>
