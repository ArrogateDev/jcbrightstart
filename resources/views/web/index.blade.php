<!DOCTYPE html>
<html lang="en">

<x-web.head/>

<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <div class="container">
            <div class="row picture-wall-box">
                <div class="col-md-8 p-1">
                    <div class="picture-wal overflow-hidden position-relative">
                        <div class="title h3 position-absolute">
                            最新消息
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-1">
                    <div class="picture-wal overflow-hidden position-relative">
                        <div class="title h3 position-absolute">
                            香港0-3歲嬰幼兒服務資訊
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-1">
                    <div class="picture-wal overflow-hidden position-relative">
                        <div class="title h3 position-absolute">
                            專業學習社群
                        </div>
                    </div>
                </div>
                <div class="col-md-8 p-1">
                    <div class="picture-wal overflow-hidden position-relative">
                        <div class="title h3 position-absolute">
                            家長學習平台
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .picture-wal {
                    width: 100%;
                    height: 360px;
                    background: url('{{web_resource_url('assets/web/images/our-class-11.jpg')}}') 100%;
                    background-size: cover;
                }

                .picture-wal .title {
                    width: 100%;
                    background: #00c8d4bd;
                    bottom: -150px;
                    opacity: 0;
                    margin: 0;
                    padding: 8px;
                    color: white;
                    transition: all 0.4s ease;
                    overflow: hidden;
                    white-space: nowrap;
                    text-overflow: ellipsis;
                }

                .picture-wal:hover .title {
                    bottom: 0;
                    opacity: 1;
                }
            </style>
        </div>

        <section class="section p-t-150 p-b-140 p-md-t-60 p-md-b-60">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="img-border img-border--blue">
                            <div class="img-border-inner">
                                <img src="{{web_resource_url('assets/web/images/welcome-08.jpg')}}" alt="Welcome">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="p-l-70 p-md-l-0">
                            <div class="welcome-wrap">
                                <div class="welcome-wrap__inner">
                                    <div
                                        class="section-heading section-heading-1 section-heading-1--small text-left">
                                        <h2 class="section-heading__title">優質教顧 喜步未來</h2>
                                    </div>
                                    <p class="m-b-15">
                                        香港賽馬會幼兒「喜步」計劃第二階段（2025-2029）旨在將優質的嬰幼兒照顧及教育理念推廣至全港育有0-3歲孩子的家庭及更廣泛的社區，全面營造促進嬰幼兒健康成長與發展的優質環境。</p>
                                    <p class="m-b-60">本計劃獲香港賽馬會慈善信託基金捐助，由耀中幼教學院主辦，並邀請太平洋區幼兒教育研究學會（香港）及香港中文大學為專業合作夥伴。</p>
                                    <a class="au-btn--blue au-btn" href="{{route('page',['page'=>'about-us.html'])}}">learn more
                                        <i class="zmdi zmdi-chevron-right"></i>
                                        <i class="zmdi zmdi-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section p-t-75 p-b-75">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 d-flex align-items-center">
                        <div class="p-md-t-0 p-md-b-30">
                            <div class="welcome-wrap welcome-wrap-2 p-t-0">
                                <div class="welcome-wrap__inner">
                                    <div class="section-heading section-heading-1 section-heading-1--small text-left">
                                        <h2 class="section-heading__title">關於計劃</h2>
                                    </div>
                                    <p class="m-b-15" style="text-indent: 50px;">
                                        賽馬會幼兒「喜步」計劃第二階段為期4年的計劃（2025-2029），獲得香港賽馬會慈善信託基金繼續支持，捐助約2億港元。計劃將涵蓋全港約八成為初生至3歲嬰幼兒提供服務的幼兒中心，惠及15間參與計劃的幼兒中心、其他幼稚園暨幼兒中心、各大社會服務單位、相關家長及社區人士。</p>
                                    <p class="m-b-15" style="text-indent: 50px;">
                                        本計劃由耀中幼教學院主辦，並邀請到太平洋區幼兒教育研究學會（香港）及香港中文大學作為專業夥伴。透過跨專業領域協作，為參與計劃的幼兒中心提供教顧實踐的專業啟導，並進一步推動家長教育及社區參與的支援，營造有利嬰幼兒的發展。</p>
                                    <p class="m-b-15" style="text-indent: 50px;">
                                        本階段計劃將涵蓋一系列專業支援項目，包括：跨專業支援及協作、建立專業學習社群、海外專業交流、家長與社區實踐、基礎設施提升及數碼化平台，以促進嬰幼兒教顧的持續優化。</p>
                                    <p class="m-b-15" style="text-indent: 50px;">
                                        「喜步」是生命的初始，讓嬰幼兒能夠享受最優質的教顧服務，以豐盛他們的未來，這就是賽馬會幼兒「喜步」計劃的用心。我們期望能與業界跨專業人士、家長及社區夥伴攜手合作，共同為香港幼兒教育的未來開創新篇章，以回應社會對優質幼兒教育服務的需求。</p>
                                    <a class="au-btn--blue au-btn" href="#">learn more
                                        <i class="zmdi zmdi-chevron-right"></i>
                                        <i class="zmdi zmdi-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 offset-md-1">
                        <div class="img-border img-border--pink">
                            <div class="img-border-inner">
                                <img src="{{web_resource_url('assets/web/images/welcome-09.jpg')}}" alt="Welcome 2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section p-t-75 p-b-75 p-md-t-60">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="img-border img-border--blue">
                            <div class="img-border-inner">
                                <img src="{{web_resource_url('assets/web/images/about-us-01.jpg')}}" alt="About Us">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="p-l-70 p-md-l-0">
                            <div class="welcome-wrap welcome-wrap-2 p-t-0">
                                <div class="welcome-wrap__inner">
                                    <div class="section-heading section-heading-1 section-heading-1--small text-left">
                                        <h2 class="section-heading__title">願景及目標</h2>
                                    </div>
                                    <p class="m-b-15">
                                        賽馬會幼兒「喜步」計劃將涵蓋全港約八成為初生至3歲嬰幼兒提供服務的幼兒中心，惠及15間參與計劃的幼兒中心、其他幼稚園暨幼兒中心、各大社會服務單位、相關家長及社區人士。本階段計劃將涵蓋一系列專業支援項目，包括：跨專業支援及協作、建立專業學習社群、海外專業交流、家長與社區實踐、基礎設施提升及數碼化平台，以促進嬰幼兒教顧的持續優化。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section p-t-75 p-b-75">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 d-flex align-items-center">
                        <div class="p-md-t-0 p-md-b-30">
                            <div class="welcome-wrap welcome-wrap-2 p-t-0">
                                <div class="welcome-wrap__inner">
                                    <div class="section-heading section-heading-1 section-heading-1--small text-left">
                                        <h2 class="section-heading__title">整體目標</h2>
                                    </div>
                                    <p class="m-b-15 h3"><i class="fa-solid fa-circle-check text-success mr-1"></i>促進幼兒老師專業能力</p>
                                    <p class="m-b-15 h3"><i class="fa-solid fa-circle-check text-success mr-1"></i>建立專業學習社群</p>
                                    <p class="m-b-15 h3"><i class="fa-solid fa-circle-check text-success mr-1"></i>提昇嬰幼兒服務質素</p>
                                    <p class="m-b-15 h3"><i class="fa-solid fa-circle-check text-success mr-1"></i>支持社區中的家庭</p>
                                    <p class="m-b-15">此計劃惠及15間參與計劃的幼兒中心、其他幼稚園暨幼兒中心、各大社會服務單位、相關家長及社區人士。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 offset-md-1">
                        <div class="img-border img-border--pink">
                            <div class="img-border-inner">
                                <img src="{{web_resource_url('assets/web/images/welcome-09.jpg')}}" alt="Welcome 2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section p-t-75 p-b-75">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="img-border img-border--pink">
                            <div class="img-border-inner">
                                <img src="{{web_resource_url('assets/web/images/welcome-09.jpg')}}" alt="Welcome 2">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex align-items-center">
                        <div class="p-l-70 p-md-l-0 w-100">
                            <div class="welcome-wrap welcome-wrap-2 p-t-0">
                                <div class="welcome-wrap__inner">
                                    <div class="section-heading section-heading-1 section-heading-1--small text-left">
                                        <h2 class="section-heading__title">專業發展領域</h2>
                                    </div>
                                    <div class="realm-box">
                                        <div class="realm-item">知識迴廊：基礎幼兒教育專業視頻系列</div>
                                        <div class="realm-item">專業發展工作坊</div>
                                        <div class="realm-item">到校專業啟導</div>
                                        <div class="realm-item">專業學習社群</div>
                                        <div class="realm-item">持續專業支援</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            .realm-box {
                display: flex;
                flex-direction: column;
                grid-row-gap: 15px;
            }

            .realm-item {
                padding: 20px;
                border-radius: 40px;
                text-align: center;
                color: white;
                font-size: 18px;
                font-weight: 600;
                letter-spacing: 1px;
                background-color: #a568a4;
            }

            .realm-item:nth-child(1) {
                background-color: #5f7bba;
            }

            .realm-item:nth-child(2) {
                background-color: #eb646b;
            }

            .realm-item:nth-child(3) {
                background-color: #05aa9c;
            }

            .realm-item:nth-child(4) {
                background-color: #f49539;
            }
        </style>

        <section class="section bg-blue-green p-t-130 p-b-170 p-md-t-60 p-md-b-80">
            <div class="bg-cloud-5">
                <img src="{{web_resource_url('assets/web/images/icon/bg-cloud-05.png')}}" alt="Cloud">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading section-heading-2">
                            <h2 class="section-heading__title">{{__('最新消息')}}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="wrap wrap--w1575">
                    <div class="slick-class-2 home-news">
                        <div class="slick__wrap-content js-slick-wrapper" data-slick-xs="1" data-slick-sm="2"
                             data-slick-md="5" data-slick-lg="5" data-slick-xl="5" data-slick-dots="false"
                             data-slick-customnav="true" data-slick-autoplay="true">
                            <div class="slick__content js-slick-content">
                                @foreach($news as $new)
                                    <div class="slick__item">
                                        @include('web.news.item', ['news'=>$new, 'col'=>false])
                                    </div>
                                @endforeach
                            </div>
                            <div class="slick__nav arrows-2">
                                <span class="slick-prev slick-arrow js-slick-prev"></span>
                                <span class="slick-next slick-arrow js-slick-next"></span>
                            </div>
                        </div>
                    </div>
                    <style>
                        .home-news .media-blog-2 .media__body {
                            text-align: left;
                            padding: 8px;
                        }

                        .home-news .media-blog-2 .media__title {
                            height: 60px;
                        }

                        .home-news .media-blog-2 .media__title a {
                            display: -webkit-box;
                            -webkit-box-orient: vertical;
                            -webkit-line-clamp: 2;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }

                        .home-news .media-blog-2 .media__text {
                            display: -webkit-box;
                            -webkit-box-orient: vertical;
                            -webkit-line-clamp: 1;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }

                        .home-news .media-info {
                            font-size: 15px;
                        }

                        .home-news .media-info img {
                            width: 16px;
                        }
                    </style>
                    <div class="text-center p-t-30">
                        <a class="au-btn au-btn--white" href="{{route('news.html')}}">learn more
                            <i class="zmdi zmdi-chevron-right"></i>
                            <i class="zmdi zmdi-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section p-t-30 p-b-85">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading section-heading-1">
                            <h2 class="section-heading__title">Contact Us</h2>
                        </div>
                        <form class="js-contact-form">
                            <div class="row">
                                <div class="col-md-6 p-r-10 p-md-r-15">
                                    <input class="input-border" type="text" name="name" required="" placeholder="Your name">
                                </div>
                                <div class="col-md-6 p-l-10 p-md-l-15">
                                    <input class="input-border" type="email" name="email" required="" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" placeholder="Your e-mail">
                                </div>
                            </div>
                            <textarea class="textarea-border" name="message" placeholder="Your message..." required=""></textarea>
                            <div class="text-center">
                                <button class="au-btn au-btn--blue" type="submit">submit
                                    <i class="zmdi zmdi-chevron-right"></i>
                                    <i class="zmdi zmdi-chevron-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <x-web.partner/>
    </main>

    <x-web.footer/>

</div>

<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.video.min.js')}}"></script>
<script type="text/javascript"
        src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.actions.min.js')}}"></script>
<script type="text/javascript"
        src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
<script type="text/javascript"
        src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.navigation.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.migration.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/extensions/revolution.extension.parallax.min.js')}}"></script>

<script type="text/javascript" src="{{web_resource_url('assets/web/js/config-revolution.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/js/theme-map.min.js')}}"></script>

</body>

</html>
