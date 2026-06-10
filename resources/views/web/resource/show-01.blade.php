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
            <img class="w-full" src="{{web_resource_url('assets/web/images/resource-kit/banner-02.png')}}" alt="">
        </div>
    </div>
</section>

<section class="bg-01">
    <div class="container mx-auto p-5 md:p-10">

        <x-web.breadcrumb :breadcrumbs="$breadcrumbs"/>

        <div class="bg-[#d6d2cd8a] rounded-lg p-[28px] mt-[30px]">
            <div class="bg-[#fff] rounded-lg p-[53px_54px] border-b-[28px] border-[#cceeeb] resource-kit-show-icon">
                @if($resource->thumbnail_show === 1 && $resource->getRawOriginal('thumbnail'))
                    <div class="w-full mb-[40px]">
                        <img class="w-full" src="{{$resource->thumbnail}}" alt="{{$resource->title}}">
                    </div>
                @endif
                <div class="relative py-[23px]">
                    <div class="absolute z-50 top-[-18px] bg-[#fff] pr-[10px] category-tag">
                        <div class="p-[12px_50px] rounded-full bg-[#f4f0eb] text-[17px] text-[#736357]">{{$resource->category_text}}</div>
                    </div>
                    <div data-tooltip="{{$resource->date}}" class="text-[31px] text-[#00A99D] font-bold py-[11px] border-y-[1px] border-[#cdc3bb] title-tooltip">
                        {{$resource->title}}
                        <div class="text-[17px] text-[#736357] font-sans mt-[18px] mb-[30px] font-bold">{{$resource->short}}</div>
                    </div>
                </div>
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
    </div>
</section>

<x-web.footer/>
</body>

<script>
    $(function () {
        let width = $('.category-tag').outerWidth()
        const $element = $('.title-tooltip[data-tooltip]');
        $element.css('--tooltip-left', width + 'px');
    });
</script>
</html>
