<!DOCTYPE html>
<html lang="en">

<x-web.head/>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
<style>
    .media__img {
        height: 300px;
    }

    .object-fit-cover {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
</style>

<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <div class="container">
            <div class="row picture-wall-box">
                @foreach($banners as $banner)
                    <div class="col-md-{{$banner['col']??0}} p-1">
                        <a class="w-100 h-100" href="{{$banner['url']??'javascript:void(0);'}}">
                            <div class="picture-wal overflow-hidden position-relative">
                                <img src="{{$banner['bg']??''}}"
                                     class="w-100 h-100 object-fit-cover"
                                     alt="{{$banner['title']??''}}">
                                <div class="title h2 position-absolute">
                                    {{$banner['title']??''}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <section class="section p-t-150 p-b-140 p-md-t-60 p-md-b-60">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="img-border img-border--blue">
                            <div class="img-border-inner">
                                <img src="{{web_resource_url('assets/img/home/home-01.png')}}" alt="Welcome">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="p-l-70 p-md-l-0">
                            <div class="welcome-wrap">
                                <div class="welcome-wrap__inner">
                                    <div
                                        class="section-heading section-heading-1 section-heading-1--small text-left">
                                        <h2 class="section-heading__title">{{__('HOME1_TITLE')}}</h2>
                                    </div>
                                    <p class="m-b-15">{{__('HOME1_CONTENT01')}}</p>
                                    <p class="m-b-60">{{__('HOME1_CONTENT02')}}</p>
                                    <a class="au-btn--blue au-btn" href="{{route('page',['page'=>'about-us.html'])}}">
                                        {{__('更多')}}
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
                                        <h2 class="section-heading__title">{{__('HOME2_TITLE')}}</h2>
                                    </div>
                                    <p class="m-b-15" style="text-indent: 50px;">{{__('HOME2_CONTENT01')}}</p>
                                    <p class="m-b-15" style="text-indent: 50px;">{{__('HOME2_CONTENT02')}}</p>
                                    <p class="m-b-15" style="text-indent: 50px;">{{__('HOME2_CONTENT03')}}</p>
                                    <p class="m-b-15" style="text-indent: 50px;">{{__('HOME2_CONTENT04')}}</p>
                                    <a class="au-btn--blue au-btn" href="#">
                                        {{__('更多')}}
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
                                <img src="{{web_resource_url('assets/img/home/home-02.png')}}" alt="Welcome 2">
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
                                <img src="{{web_resource_url('assets/img/home/home-03.png')}}" alt="About Us">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="p-l-70 p-md-l-0">
                            <div class="welcome-wrap welcome-wrap-2 p-t-0">
                                <div class="welcome-wrap__inner">
                                    <div class="section-heading section-heading-1 section-heading-1--small text-left">
                                        <h2 class="section-heading__title">{{__('HOME3_TITLE')}}</h2>
                                    </div>
                                    <p class="m-b-15">
                                        {{__('HOME3_CONTENT01')}}</p>
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
                                        <h2 class="section-heading__title">{{__('HOME4_TITLE')}}</h2>
                                    </div>
                                    <div class="box box-program-2 m-b-15">
                                        <div class="box__head">
                                            <div class="box__head-bg" style="width: 50px;">
                                                <img src="{{web_resource_url('assets/web/images/icon/bg-program-05.png')}}" alt="Background">
                                                <div class="box__head-icon">
                                                    <img src="{{web_resource_url('assets/web/images/icon/program-09.png')}}" alt="Icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box__body">
                                            <h3 class="title title--sm title--black box__title m-0">
                                                <a style="color:#666;">{{__('HOME4_CONTENT01')}}</a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="box box-program-2 m-b-15">
                                        <div class="box__head">
                                            <div class="box__head-bg" style="width: 50px;">
                                                <img src="{{web_resource_url('assets/web/images/icon/bg-program-03.png')}}" alt="Background">
                                                <div class="box__head-icon">
                                                    <img src="{{web_resource_url('assets/web/images/icon/program-03.png')}}" alt="Icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box__body">
                                            <h3 class="title title--sm title--black box__title m-0">
                                                <a style="color:#666;">{{__('HOME4_CONTENT02')}}</a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="box box-program-2 m-b-15">
                                        <div class="box__head">
                                            <div class="box__head-bg" style="width: 50px;">
                                                <img src="{{web_resource_url('assets/web/images/icon/bg-program-06.png')}}" alt="Background">
                                                <div class="box__head-icon">
                                                    <img src="{{web_resource_url('assets/web/images/icon/program-06.png')}}" alt="Icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box__body">
                                            <h3 class="title title--sm title--black box__title m-0">
                                                <a style="color:#666;">{{__('HOME4_CONTENT03')}}</a>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="box box-program-2 m-b-15">
                                        <div class="box__head">
                                            <div class="box__head-bg" style="width: 50px;">
                                                <img src="{{web_resource_url('assets/web/images/icon/bg-program-04.png')}}" alt="Background">
                                                <div class="box__head-icon">
                                                    <img src="{{web_resource_url('assets/web/images/icon/program-04.png')}}" alt="Icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box__body">
                                            <h3 class="title title--sm title--black box__title m-0">
                                                <a style="color:#666;">{{__('HOME4_CONTENT04')}}</a>
                                            </h3>
                                        </div>
                                    </div>
                                    <p class="m-b-15">{{__('HOME4_EXPLAIN')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 offset-md-1">
                        <div class="img-border img-border--pink">
                            <div class="img-border-inner">
                                <img src="{{web_resource_url('assets/img/home/home-04.png')}}" alt="Welcome 2">
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
                                <img src="{{web_resource_url('assets/img/home/home-05.png')}}" alt="Welcome 2">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex align-items-center">
                        <div class="p-l-70 p-md-l-0 w-100">
                            <div class="welcome-wrap welcome-wrap-2 p-t-0">
                                <div class="welcome-wrap__inner">
                                    <div class="section-heading section-heading-1 section-heading-1--small text-left">
                                        <h2 class="section-heading__title">{{__('HOME5_TITLE')}}</h2>
                                    </div>
                                    <div class="realm-box">
                                        <div class="realm-item">{{__('HOME5_CONTENT01')}}</div>
                                        <div class="realm-item">{{__('HOME5_CONTENT02')}}</div>
                                        <div class="realm-item">{{__('HOME5_CONTENT03')}}</div>
                                        <div class="realm-item">{{__('HOME5_CONTENT04')}}</div>
                                        <div class="realm-item">{{__('HOME5_CONTENT05')}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
                             data-slick-md="3" data-slick-lg="3" data-slick-xl="3" data-slick-dots="false"
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

                    <div class="text-center p-t-30">
                        <a class="au-btn au-btn--white" href="{{route('news.html')}}">
                            {{__('更多')}}
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
                            <h2 class="section-heading__title">{{__('联系我们')}}</h2>
                        </div>
                        <x-forms.about-us/>
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

<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
</body>

</html>
