<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/font-awesome/all.min.css'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{web_resource_url('assets/web/js/owlcarousel/owl.carousel.min.js')}}"></script>
    <link rel="stylesheet" href="{{web_resource_url('assets/web/js/owlcarousel/owl.carousel.min.css')}}">
</head>
<body>
<x-web.header/>

<section>
    <div class="owl-carousel">
        @foreach([0] as $index => $banner)
            <div class="w-full">
                <img class="w-full" src="{{web_resource_url('assets/web/images/banner.png')}}" alt="{{$index}}">
            </div>
        @endforeach
    </div>
</section>

<section class="bg-01">
    <div class="container mx-auto p-5 md:p-10">
        <div class="block lg:flex py-8 lg:py-[60px] gap-x-12">
            <div class="flex-none">
                <div class="flex flex-col lg:items-end">
                    <div>
                        <div class="flex items-center gap-x-2.5">
                            <img class="h-[30px]" src="{{web_resource_url('assets/web/images/last-news.png')}}" alt="{{__('计划消息')}}">
                            <div class="text-[31px] text-[#998675] font-bold">{{__('计划消息')}}</div>
                        </div>
                    </div>
                    <a href="{{route('news.html')}}" class="more-box mt-6 bg-[#e0d5c7]">
                        <div class="more !bg-[#43c8d5] font-bold">
                            {{__('了解更多')}}>>
                        </div>
                        <div class="shadow bg-[#dbd8d2]"></div>
                    </a>
                </div>
            </div>
            <div class="grow h-[280px] overflow-auto customize-scrollbar">
                @foreach($news as $item)
                    <a href="{{$item->url}}" class="flex items-center gap-x-[66px] text-[22px] text-[#666] font-bold py-[30px] border-b-1 border-[#b9b9b9]">
                        <div class="flex-none">
                            {{$item->date}}
                        </div>
                        <div class="grow line-clamp-1">
                            {{$item->title}}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="bg-02">
    <div class="container mx-auto p-5 md:p-10">
        <div class="block lg:flex justify-center py-8 lg:py-[60px] gap-x-14">
            <div class="flex flex-col items-start lg:items-center gap-y-[15px]">
                <div class="lg:writing-mode-v-rl bg-[#ef857d] rounded-[8px] px-[15px] py-[2px] text-white text-[31px] font-bold">
                    {{__('關於計劃')}}
                </div>
            </div>
            <div class="relative">
                <div class="text-[31px] lg:text-[45px] text-[#998675] leading-[76px] underline decoration-dotted underline-offset-[16px] font-medium">
                    教顧實踐專業啟導，<br/>致力提升教顧者專業能力。
                </div>
                <div class="w-full xl:max-w-[645px] mt-[40px] text-[19px] text-[#736357] font-medium leading-[44px]">
                    賽馬會幼兒「喜步」計劃獲香港賽馬會慈善信託基金繼續撥款捐助，於2025年展開為期4年的第二階段。計劃涵蓋全港約八成為初生至3歲嬰幼兒提供服務的幼兒中心，惠及15間參與計劃的幼兒中心、其他幼稚園暨幼兒中心、各大社會服務單位，以及相關家長與社區人士。
                </div>
                <div class="flex justify-end">
                    <a href="{{route('about-us.html')}}" class="more-box mt-12">
                        <div class="more font-bold">
                            {{__('了解更多')}}>>
                        </div>
                        <div class="shadow"></div>
                    </a>
                </div>
                <div class="absolute top-[-80px] right-0 xl:right-[-248px] w-[150px] md:w-[328px]">
                    <img src="{{web_resource_url('assets/web/images/character_about_01.png')}}" alt="{{__('關於計劃')}}">
                </div>
            </div>
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
                        <img class="w-[36px]" src="{{web_resource_url('assets/web/images/icon_001.svg')}}" alt="知識庫">
                        <div class="text-[31px] font-bold">知識庫</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-[74px] mt-[80px]">
                <div class="relative sway-box">
                    <div class="rounded-[8px]">
                        <img class="rounded-[8px] aspect-[405/389]" src="{{web_resource_url('assets/web/images/professional-learning-community.jpg')}}" alt="">
                    </div>
                    <div class="p-[30px]">
                        <div class="flex items-center gap-[12px] mb-[17px]">
                            <img class="h-[32px]" src="{{web_resource_url('assets/web/images/icon_003.svg')}}" alt="">
                            <div class="text-[30px] text-[#998675] font-bold">專業學習社群</div>
                        </div>
                        <div class="text-[18px] text-[#534741] font-medium line-bg px-1.5">
                            精進專業培訓，延續優質教顧
                        </div>
                        <div class="text-[18px] text-[#736357] font-medium leading-[33px] mt-[25px]">
                            本計劃協助推動幼兒中心間的互相觀摩與經驗分享，全面提升教顧者的專業素質。團隊對幼兒中心的種子團隊進行專業培訓，引領掌握關鍵專業知能，進而帶動同儕間的專業交流。全面深化幼兒中心園長及教師的專業知識、技能與態度，確保計劃完結後，優質的教顧實踐理念與文化得以延續。
                        </div>
                        <div class="mt-[25px]">
                            <a class="flex items-center gap-[8px]" href="{{route('about-us.html')}}">
                                <div class="text-[22px] text-[#998675] font-bold">< 更多</div>
                                <img class="h-[24px]" src="{{web_resource_url('assets/web/images/other.png')}}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="absolute top-[-60px] right-0 xl:right-[-30px] w-[160px]">
                        <img class="motion" src="{{web_resource_url('assets/web/images/character_knowledge_02.png')}}" alt="">
                    </div>
                </div>
                <div class="relative sway-box">
                    <div class="rounded-[8px]">
                        <img class="rounded-[8px] aspect-[405/389]" src="{{web_resource_url('assets/web/images/home-01.jpg')}}" alt="">
                    </div>
                    <div class="p-[30px]">
                        <div class="flex items-center gap-[12px] mb-[17px]">
                            <img class="h-[32px]" src="{{web_resource_url('assets/web/images/icon_004.svg')}}" alt="">
                            <div class="text-[30px] text-[#998675] font-bold">家長學習平台</div>
                        </div>
                        <div class="text-[18px] text-[#534741] font-medium relative line-bg px-1.5">
                            家長可登入平台，與孩子一起「喜步」成長
                        </div>
                        <div class="text-[18px] text-[#736357] font-medium leading-[33px] mt-[25px]">
                            本平台專為家長打造，提供豐富的育兒與嬰幼兒發展資源。家長只需使用電郵地址及密碼輕鬆登入，即可開啟三個階段的自主學習之旅，從而增進育兒知識。
                        </div>
                        <div class="mt-[25px]">
                            <a class="flex items-center gap-[8px]" href="{{route('about-us.html')}}">
                                <div class="text-[22px] text-[#998675] font-bold">< 更多</div>
                                <img class="h-[24px]" src="{{web_resource_url('assets/web/images/other.png')}}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="absolute top-[-80px] right-0 xl:right-[-30px] w-[120px]">
                        <img class="motion" src="{{web_resource_url('assets/web/images/character_knowledge_03.png')}}" alt="">
                    </div>
                </div>
                <div class="relative sway-box">
                    <div class="rounded-[8px]">
                        <img class="rounded-[8px] aspect-[405/389]" src="{{web_resource_url('assets/web/images/home-02.jpg')}}" alt="">
                    </div>
                    <div class="p-[30px]">
                        <div class="flex items-center gap-[12px] mb-[17px]">
                            <img class="h-[32px]" src="{{web_resource_url('assets/web/images/icon_002.svg')}}" alt="">
                            <div class="text-[30px] text-[#998675] font-bold">幼兒服務資訊</div>
                        </div>
                        <div class="text-[18px] text-[#534741] font-medium line-bg px-1.5">
                            全港0-3歲幼兒服務導覽
                        </div>
                        <div class="text-[18px] text-[#736357] font-medium leading-[33px] mt-[25px]">
                            匯集了全港所有提供0-3歲日間幼兒照顧服務的關鍵資料，不論是日間嬰兒園、幼兒園、幼兒中心的名單與地區分佈，均能在此一目了然。亦提供了鄰里支援幼兒照顧計劃的服務名單及詳情資料，讓有需要家居照顧服務的家長可以查閱。
                        </div>
                        <div class="mt-[25px]">
                            <a class="flex items-center gap-[8px]" href="{{route('maps.html')}}">
                                <div class="text-[22px] text-[#998675] font-bold">< 更多</div>
                                <img class="h-[24px]" src="{{web_resource_url('assets/web/images/other.png')}}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="absolute top-[-50px] right-0 xl:right-[-30px] w-[160px]">
                        <img class="motion" src="{{web_resource_url('assets/web/images/character_knowledge_01.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-web.footer/>
<script>
    $(function () {
        $('.owl-carousel').owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            nav: true,
            dots: false,
            margin: 0,
            navText: [
                '<i class="fa-solid fa-chevron-left"></i>',
                '<i class="fa-solid fa-chevron-right"></i>'
            ]
        })
    });
</script>
</body>
</html>
