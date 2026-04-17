<!DOCTYPE html>
<html lang="en">

<x-web.head/>
<script src="{{web_resource_url('assets/js/image-viewer.min.js')}}" id="gd-image-viewer"
        data-target-selector=".gallery-img"
        data-allow-rotate="false"
        data-allow-image-info="false"
        data-allow-navigation="false"
        data-allow-download="false">
</script>
<style>
    .page-show .container {
        max-width: 1000px !important;
    }

    .blog-single {
        padding: 2rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }

    .post-btn {
        font-size: 32px;
        color: #666;
    }

    .list-nav-blog__item a:hover .post-btn, .list-nav-blog__item a:hover .post-btn {
        color: #ff97a4;
    }

    .thumbnail-box {
        max-height: 85vh;
        text-align: center;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: visible;
    }

    .thumbnail-box img {
        max-height: 85vh !important;
        height: auto;
        width: auto;
    }

    .btn-per {
        cursor: pointer;
        background: #ff97a4;
        width: fit-content;
        padding: 2px 10px;
        margin-bottom: 10px;
        border-radius: 8px;
        color: white;
        font-size: 18px;
    }
</style>

<link rel="stylesheet" href="{{web_resource_url('assets/web/vendor/dflip/dflip.min.css')}}">
<script src="{{web_resource_url('assets/web/vendor/dflip/js/dflip.min.js')}}"></script>
<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('专业学习社群')}}"/>

        <section class="section p-t-125 p-b-80 page-show ">
            <div class="container">
                @if($url)
                    <a href="{{$url}}" class="d-flex align-items-center btn-per">
                        <i class="zmdi zmdi-chevron-left mr-1"></i> {{__('返回')}}
                    </a>
                @endif
                <div class="blog-single">
                    <div class="media media-blog-4 m-b-10">
                        @if($resource->thumbnail_show === 1)
                            <div class="media__img">
                                <a class="img-radius text-center thumbnail-box" href="javascript:void(0);">
                                    <img class="mh-100 gallery-img" src="{{$resource->thumbnail}}" alt="{{$resource->title}}">
                                </a>
                            </div>
                        @endif
                        <div class="media__body">
                            <h4 class="media__title title title--black title--s35">
                                <a href="javascript:void(0);">{{$resource->title}}</a>
                            </h4>
                            <p class="media__text">{{$resource->short}}</p>
                        </div>
                    </div>
                    @if($resource->pdf)
                        <div id="pdf-viewer"></div>
                    @endif
                    <div class="m-b-40">
                        {!! $resource->description !!}
                    </div>
                    <div class="blog-single__info m-b-40 justify-content-end">
                        <ul class="list-unstyled list-inline list-social list-social-3">
                            <li class="list-inline-item">
                                <a class="ic-fb" href="https://www.facebook.com/JCBrightStartProject">
                                    <i class="zmdi zmdi-facebook-box"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="ic-insta" href="https://www.instagram.com/JCBrightStartProject/">
                                    <i class="zmdi zmdi-instagram"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="blog-single__footer">
                        <nav class="nav-blog">
                            <ul class="list-nav-blog list-unstyled">
                                <li class="list-nav-blog__item prev">
                                    @if($prev)
                                        <a href="{{route('resource.show.html', ['resource' => $prev])}}">
                                            <i class="zmdi zmdi-chevron-left post-btn mr-1"></i>
                                            <span class="list-nav-blog__text">previous post</span>
                                        </a>
                                    @endif
                                </li>
                                <li class="list-nav-blog__item next">
                                    @if($next)
                                        <a href="{{route('resource.show.html', ['resource' => $next])}}">
                                            <i class="zmdi zmdi-chevron-right post-btn ml-1"></i>
                                            <span class="list-nav-blog__text">next post</span>
                                        </a>
                                    @endif
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-web.footer/>

</div>
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
                autoOpenThumbnail: false,
                pageMode: 'single'
            });
        });
    </script>
@endif
</html>
