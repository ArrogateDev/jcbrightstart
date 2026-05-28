<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <link href="{{web_resource_url('assets/web/vendor/open-layers/ol.css')}}" rel="stylesheet">
    <script src="{{web_resource_url('assets/web/vendor/open-layers/ol.js')}}"></script>
</head>
<body>
<x-web.header/>

<section>
    <div class="owl-carousel">
        <div class="w-full">
            <img class="w-full" src="{{web_resource_url('assets/web/images/maps/banner.png')}}" alt="其他實用連結">
        </div>
    </div>
</section>

<section class="bg-01">
    <div class="container mx-auto p-5 md:p-10">
        <div class="py-[60px]">
            <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                <div class="divider-line"></div>
                <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                    <div class="flex gap-x-[11px]">
                        <img class="w-[28px]" src="{{web_resource_url('assets/web/images/maps/icon-06.svg')}}" alt="其他實用連結">
                        <div class="text-[31px] font-bold">其他實用連結</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="p-[32px] mt-[38px]">
                <div class="grid grid-cols-12 gap-x-0 md:gap-x-[36px] gap-y-[36px]">
                    @if(!empty($urls))
                        @foreach($urls as $url)
                            <a href="{{$url['url']}}" target="_blank" class="col-span-12 md:col-span-6 xl:col-span-4 cursor-pointer relative block url-item">
                                <span class="block h-full corner-cutout p-[8px] bg">
                                    <span class="block h-full corner-cutout p-[1px] line">
                                        <span class="block h-full corner-cutout text[21px] font-bold p-[17px_28px] title">{{$url['title']}}</span>
                                    </span>
                                </span>
                                <span class="absolute w-[89px] h-[30px] top-[-15px] left-0 right-0 mx-auto tag"></span>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<x-web.footer/>
</body>
</html>
