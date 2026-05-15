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
<x-web.v1.header/>

<section>
    <div class="owl-carousel">
        <div class="w-full">
            <img class="w-full" src="{{web_resource_url('assets/web/images/v1/about-us/banner.jpg')}}" alt="">
        </div>
    </div>
</section>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="pt-[60px] about-us-icon-bg-01">
            <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                <div class="divider-line"></div>
                <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                    <div class="flex items-center gap-x-[11px]">
                        <img class="h-[30px]" src="{{web_resource_url('assets/web/images/v1/about-us.svg')}}" alt="關於計劃">
                        <div class="text-[31px] font-bold">關於計劃</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="w-[1000px] max-w-[1000px] mx-auto text-[#736357] text-[20px] leading-[37px] mt-[20px]">
                <p class="mb-[20px]">
                    賽馬會幼兒「喜步」計劃獲香港賽馬會慈善信託基金繼續撥款捐助，於2025年展開為期4年的第二階段。計劃涵蓋全港約八成為初生至3歲嬰幼兒提供服務的幼兒中心，惠及15間參與計劃的幼兒中心、其他幼稚園暨幼兒中心、各大社會服務單位，以及相關家長與社區人士。</p>

                <p class="mb-[20px]">
                    本計劃由耀中幼教學院主辦，並聯同太平洋區幼兒教育研究學會（香港）及香港中文大學作為專業夥伴。透過跨專業領域協作，為參與計劃的幼兒中心提供教顧實踐的專業啟導，致力提升教顧者專業能力，同時推動家長教育及社區參與的支援，營造有利嬰幼兒發展的環境。</p>

                <p>計劃涵蓋一系列專業發展支援項目，包括：跨專業協作與啟導、建立專業學習社群、海外專業交流、家校與社區實踐、基礎設施優化及數碼化發展平台，以促進嬰幼兒教顧服務持續優化與發展。</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="py-[60px] about-us-icon-bg-02">
            <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                <div class="divider-line"></div>
                <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                    <div class="flex items-center gap-x-[11px]">
                        <img class="h-[36px]" src="{{web_resource_url('assets/web/images/v1/icon-01.svg')}}" alt="計劃目標">
                        <div class="text-[31px] font-bold">願景</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="w-[1000px] max-w-[1000px] mx-auto text-[#736357] text-[20px] leading-[37px] mt-[20px]">
                <p class="mb-[20px]">
                    「讓嬰幼兒自生命的初始，享有最優質的教育與照顧服務，邁向豐盛的未來！」這就是本計劃的初心。我們致力於將優質嬰幼兒照顧及教育理念推廣至全港育有零至三歲孩子的家庭及社區，全面促進嬰幼兒發展與健康成長的優質環境。</p>

                <p>作為一項以社會為本的計劃，我們與業界跨專業人士、家長及社區夥伴攜手合作，共同推動嬰幼兒服務的持續優化與發展。</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="py-[60px] about-us-icon-bg-03">
            <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                <div class="divider-line"></div>
                <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                    <div class="flex items-center gap-x-[11px]">
                        <img class="h-[36px]" src="{{web_resource_url('assets/web/images/v1/icon-02.svg')}}" alt="計劃目標">
                        <div class="text-[31px] font-bold">計劃目標</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="w-[470px] max-w-[470px] mx-auto text-[#736357] text-[20px] leading-[37px] mt-[20px]">
                <div class="mb-[20px] flex items-center gap-x-2">
                    <img class="w-[28px]" src="{{web_resource_url('assets/web/images/v1/plan-01.svg')}}" alt="提升幼兒老師的專業能力與專業形象">
                    <p class="text-[25px] text-[#998675]">提升幼兒老師的專業能力與專業形象</p>
                </div>

                <div class="mb-[20px] flex items-center gap-x-2">
                    <img class="w-[28px]" src="{{web_resource_url('assets/web/images/v1/plan-02.svg')}}" alt="促進專業學習社群的建立與發展">
                    <p class="text-[25px] text-[#998675]">促進專業學習社群的建立與發展</p>
                </div>

                <div class="mb-[20px] flex items-center gap-x-2">
                    <img class="w-[18px] mx-[5px]" src="{{web_resource_url('assets/web/images/v1/plan-03.svg')}}" alt="推動高品質的嬰幼兒教育及照顧服務">
                    <p class="text-[25px] text-[#998675]">推動高品質的嬰幼兒教育及照顧服務</p>
                </div>

                <div class="mb-[20px] flex items-center gap-x-2">
                    <img class="w-[28px]" src="{{web_resource_url('assets/web/images/v1/plan-04.svg')}}" alt="強調兒童早期發展及教保實踐的重要性">
                    <p class="text-[25px] text-[#998675]">強調兒童早期發展及教保實踐的重要性</p>
                </div>

                <div class="flex items-center gap-x-2">
                    <img class="w-[28px]" src="{{web_resource_url('assets/web/images/v1/plan-05.svg')}}" alt="加強家庭與社區的支援 / 支持網絡">
                    <p class="text-[25px] text-[#998675]">加強家庭與社區的支援 / 支持網絡</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="py-[60px]">
            <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                <div class="divider-line"></div>
                <div class="flex flex-col justify-center items-center gap-x-2 text-[#998675]">
                    <div class="flex items-center gap-x-[11px]">
                        <img class="w-[36px]" src="{{web_resource_url('assets/web/images/v1/icon-03.svg')}}" alt="參與計劃的幼兒中心名單">
                        <div class="text-[31px] font-bold">參與計劃的幼兒中心名單</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="w-[1000px] max-w-[1000px] mx-auto text-[#736357] text-[20px] leading-[37px] mt-[35px]">
                <div class="flex justify-center gap-[74px]">
                    @foreach($institutions as $institution)
                        <div>
                            <div @class(['text-[20px]', 'invisible' => $loop->index !== 0])>（按筆劃排列）</div>
                            <ul>
                                @foreach($institution as $item)
                                    <li class="text-[25px] text-[#998675] mb-[15px]">{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <div class="py-[60px]">
            <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                <div class="divider-line"></div>
                <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                    <div class="flex items-center gap-x-[11px]">
                        <img class="w-[36px]" src="{{web_resource_url('assets/web/images/v1/icon-03.svg')}}" alt="專業發展領域">
                        <div class="text-[31px] font-bold">專業發展領域</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="w-[1000px] max-w-[1000px] mx-auto text-[#736357] text-[20px] leading-[37px] mt-[20px]">
                <div class="flex gap-x-[50px] mt-[50px]">
                    <img class="origin-bottom -rotate-4" src="{{web_resource_url('assets/web/images/v1/about-us/professional-development.png')}}" alt="">
                    <div>
                        <div class="mb-[20px] flex align-center gap-x-2">
                            <img class="w-[28px]" src="{{web_resource_url('assets/web/images/v1/development-01.svg')}}" alt="知識迴廊">
                            <p class="text-[25px] text-[#998675]">知識迴廊</p>
                        </div>

                        <div class="mb-[20px] flex align-center gap-x-2">
                            <img class="w-[28px]" src="{{web_resource_url('assets/web/images/v1/development-02.svg')}}" alt="專業發展工作坊">
                            <p class="text-[25px] text-[#998675]">專業發展工作坊</p>
                        </div>

                        <div class="mb-[20px] flex align-center gap-x-2">
                            <img class="w-[28px]" src="{{web_resource_url('assets/web/images/v1/development-03.svg')}}" alt="到校專業啟導">
                            <p class="text-[25px] text-[#998675]">到校專業啟導</p>
                        </div>

                        <div class="flex align-center gap-x-2">
                            <img class="w-[28px]" src="{{web_resource_url('assets/web/images/v1/development-04.svg')}}" alt="專業學習社群">
                            <p class="text-[25px] text-[#998675]">專業學習社群</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-web.v1.footer/>
</body>
</html>
