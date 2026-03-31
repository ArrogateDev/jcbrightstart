<!DOCTYPE html>
<html lang="en">

<x-web.head/>
<style>
    .media-blog-2 .media__body {
        text-align: left;
        padding: 8px;
    }

    .media-blog-2 .media__title {
        height: 60px;
    }

    .media-blog-2 .media__title a {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .media-blog-2 .media__text {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .media-info {
        font-size: 14px;
    }

    .media-info img {
        width: 16px;
    }

    .media__img {
        height: 180px;
    }

    .category-box .category {
        background: #f5f5f5;
        color: #364050;
        padding: 2px 20px;
        border-radius: 25px;
        margin-right: 10px;
        margin-bottom: 10px;
        font-weight: 500;
        cursor: pointer;
    }

    .category-box .category:hover, .category-box .category.active {
        background: #ffb900;
        color: #fff;
    }

    .category-tag {
        background: #ffb90066;
        color: #ffb900;
        padding: 0 10px;
        border-radius: 15px;
        margin-right: 10px;
    }

    .top-short {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 4;
        overflow: hidden;
    }

    .category-text {
        color: #76a466;
        margin-bottom: 5px;
    }

    .more-box {
        height: stretch;
        height: -moz-available; /* Firefox */
        height: -webkit-fill-available; /* Chrome/Safari */
    }
</style>
<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('专业学习社群')}}" subtitle="{{__('专业学习社群')}}"/>

        <section>
            <div class="container">
                <div class="d-flex align-items-center justify-content-between my-4 mt-5">
                    <h3>{{__('最新视频')}}</h3>
                </div>
                <div class="row list-container">
                    @if($videos->isNotEmpty())
                        @foreach($videos as $video)
                            @include('web.resource.item-video', ['resource' => $video])
                        @endforeach
                        @if($total_video > 7)
                            <div class="col-md-6 col-lg-3">
                                <div class="media media-blog-2 more-box card-border border-tricolor-wave">
                                    <a href="{{route('resource.more.html',['type'=>1])}}" class="w-100 h-100 d-flex flex-column justify-content-center align-items-center" style="color:#666;">
                                        <i class="isax isax-element-plus" style="font-size: 36px;"></i>
                                        {{__('更多')}}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="w-100 text-center py-4 text-muted">
                            <i class="isax isax-document-text fs-24 mb-2"></i>
                            <p class="mb-0">{{__('暂无数据')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="d-flex align-items-center justify-content-between my-4">
                    <h3>{{__('最新文章')}}</h3>
                </div>
                <div class="row list-container">
                    @if($articles->isNotEmpty())
                        @foreach($articles as $article)
                            @include('web.resource.item', ['resource' => $article])
                        @endforeach
                        @if($total_article > 7)
                            <div class="col-md-6 col-lg-3">
                                <div class="media media-blog-2 more-box card-border border-tricolor-wave">
                                    <a href="{{route('resource.more.html',['type'=>0])}}" class="w-100 h-100 d-flex flex-column justify-content-center align-items-center" style="color:#666;">
                                        <i class="isax isax-element-plus" style="font-size: 36px;"></i>
                                        {{__('更多')}}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="w-100 text-center py-4 text-muted">
                            <i class="isax isax-document-text fs-24 mb-2"></i>
                            <p class="mb-0">{{__('暂无数据')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <x-web.footer/>

</div>

</body>

</html>
