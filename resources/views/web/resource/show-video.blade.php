@php
    $embed_url = $resource->short??'';
    // Convert YouTube watch URL to embed URL
    if (str_contains($embed_url, 'youtube.com/watch?v=') || str_contains($embed_url, 'youtu.be/')) {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $embed_url, $matches);
        if (isset($matches[1])) {
            $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
        }
    }
@endphp
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

<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('专业学习社群')}}" subtitle="{{__('专业学习社群')}}"/>

        <section class="section p-t-125 p-b-80 page-show ">
            <div class="container">
                @if($url)
                    <a href="{{$url}}" class="d-flex align-items-center btn-per">
                        <i class="zmdi zmdi-chevron-left mr-1"></i> {{__('返回')}}
                    </a>
                @endif
                <div class="blog-single">
                    <div class="media media-blog-4 m-b-10">
                        <iframe height="500" class="w-100" src="{{$embed_url}}" frameborder="0" allowfullscreen></iframe>
                    </div>
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
                </div>
            </div>
        </section>
    </main>

    <x-web.footer/>

</div>

</body>

</html>
