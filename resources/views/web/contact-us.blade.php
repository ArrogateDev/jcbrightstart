<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<x-web.header/>

<section>
    <div class="owl-carousel">
        <div class="w-full">
            <img class="w-full" src="{{web_resource_url('assets/web/images/v1/contact-us/banner.png')}}" alt="">
        </div>
    </div>
</section>

<section class="bg-01">
    <div class="container mx-auto p-5 md:p-10">
        <div class="py-[60px]">
            <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                <div class="divider-line"></div>
                <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                    <div class="flex items-end gap-x-[11px]">
                        <img class="w-[36px]" src="{{web_resource_url('assets/web/images/v1/icon_001.svg')}}" alt="知識庫">
                        <div class="text-[31px] font-bold">聯絡我們</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="flex justify-center">
                <div class="max-w-full mt-[47px] xl:px-[200px] flex flex-col gap-[30px] contact-us-bg">
                    <div class="w-[671px] max-w-full flex flex-col gap-[11px]">
                        <label class="text-[#998675] text-[16px] font-normal ps-[19px]" for="">Full Name</label>
                        <input type="text" class="input w-full h-[67px] border-0 rounded-xl text-[21px]"/>
                    </div>
                    <div class="w-[671px] max-w-full flex flex-col gap-[11px]">
                        <label class="text-[#998675] text-[16px] font-normal ps-[19px]" for="">Email</label>
                        <input type="text" class="input w-full h-[67px] border-0 rounded-xl text-[21px]"/>
                    </div>
                    <div class="w-[671px] max-w-full flex flex-col gap-[11px]">
                        <label class="text-[#998675] text-[16px] font-normal ps-[19px]" for="">Your Message...</label>
                        <textarea class="textarea w-full h-[270px] border-0 rounded-xl text-[21px]"></textarea>
                    </div>
                    <div class="flex justify-center">
                        <div class="more-box mt-12 bg-[#98c3df]">
                            <div class="more font-bold !p-[6px_52px] text-[22px]">
                                {{__('了解更多')}}>>
                            </div>
                            <div class="shadow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-web.footer/>
</body>
</html>
