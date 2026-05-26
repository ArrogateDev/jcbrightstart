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
                    <div class="flex items-center gap-x-[11px]">
                        <img class="w-[28px]" src="{{web_resource_url('assets/web/images/maps/icon-01.svg')}}" alt="其他實用連結">
                        <div class="text-[31px] font-bold">其他實用連結</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="bg-[#e3dfdaa6] rounded-lg p-[32px] mt-[38px]">
                <div class="grid grid-cols-12 gap-x-0 md:gap-x-[42px] gap-y-[42px]">
                    @if(!empty($urls))
                        @foreach($urls as $url)
                            <a href="{{$url['url']}}" target="_blank" class="col-span-12 md:col-span-6 xl:col-span-4 cursor-pointer hover:text-[#754c24] hover:font-bold">
                                {{$url['title']}}
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
