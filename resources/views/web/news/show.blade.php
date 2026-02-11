<!DOCTYPE html>
<html lang="en">

<x-web.head/>

<script src="{{web_resource_url('assets/js/image-viewer.min.js')}}" id="gd-image-viewer"
        data-target-selector=".gallery-img"
        data-allow-rotate="false"
        data-allow-download="false">
</script>
<style>
    .post-btn {
        font-size: 32px;
        color: #666;
    }

    .list-nav-blog__item a:hover .post-btn, .list-nav-blog__item a:hover .post-btn {
        color: #ff97a4;
    }

    .date-box {
        background: #ffe8a4;
        margin-top: 20px;
        margin-bottom: 20px;
        padding: 20px;
        border-radius: 20px;
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
        max-height: 85vh;
        height: auto;
        width: auto;
    }
</style>

<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('最新消息')}}" subtitle="{{__('最新消息')}}"/>

        <section class="section p-t-125 p-b-80">
            <div class="container">
                <div class="blog-single">
                    <div class="media media-blog-4 m-b-10">
                        <div class="media__img">
                            <div class="img-radius text-center thumbnail-box">
                                <img class="mh-100 gallery-img" src="{{$news->thumbnail}}" alt="{{$news->title}}">
                            </div>
                        </div>

                        <div class="media__body">
                            <h4 class="media__title title title--black title--s35">
                                <a href="javascript:void(0);">{{$news->title}}</a>
                            </h4>
                            <p class="media__text">{{$news->short}}</p>
                            <div class="date-box w-100">
                                <p class="p-b-5">{{__('发布日期')}}：{{$news->release_date}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="m-b-40">
                        {!! $news->description !!}
                    </div>
                    <div class="blog-single__info m-b-40">
                        <ul class="list-tags list-unstyled">
                            <li class="list-tags__icon">
                                <i class="fas fa-tags"></i>
                            </li>
                            <li class="list-tags__item">
                                <a href="#">Learning</a>
                            </li>
                            <li class="list-tags__item">
                                <a href="#">Education</a>
                            </li>
                        </ul>
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
                                        <a href="{{route('news.show.html', ['news' => $prev])}}">
                                            <i class="zmdi zmdi-chevron-left post-btn mr-1"></i>
                                            <span class="list-nav-blog__text">previous post</span>
                                        </a>
                                    @endif
                                </li>
                                <li class="list-nav-blog__item next">
                                    @if($next)
                                        <a href="{{route('news.show.html', ['news' => $next])}}">
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

<!-- Revolution Slider JS (Page Specific)-->
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
<script type="text/javascript" src="{{web_resource_url('assets/web/vendor/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
<!--
| (Load Extensions only on Local File Systems !
| The following part can be removed on Server for On Demand Loading)
-->
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
<!-- Config Revolution Slider-->
<script type="text/javascript" src="{{web_resource_url('assets/web/js/config-revolution.min.js')}}"></script>
<!-- Page Specific JS-->
<script src="{{web_resource_url('assets/web/js/theme-map.min.js')}}"></script>

<script type="text/javascript" src="{{ web_resource_url('assets/js/lodash.js') }}"></script>
<script src="{{web_resource_url('assets/js/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{web_resource_url('assets/js/wait-me/waitMe.min.css')}}">
<link href="{{web_resource_url('assets/js/toastr/toastr.min.css')}}" rel="stylesheet"/>
<script src="{{web_resource_url('assets/js/toastr/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{ web_resource_url('assets/js/utils.js') }}"></script>
<script>
    $(function () {
        let params = {};
        let $search = $('#search-input');
        let $searchBtn = $('#search-btn');

        $search.on('input', _.debounce(function () {
            const keywords = $(this).val().trim();
            params = Object.assign(params, {keywords: keywords});
            getData(1, params);
        }, 150));

        $search.on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                const keywords = $(this).val().trim();
                params = Object.assign(params, {keywords: keywords});
                getData(1, params);
            }
        });

        $searchBtn.on('click', _.debounce(function () {
            const keywords = $search.val().trim();
            params = Object.assign(params, {keywords: keywords});
            getData(1, params);
        }, 150));

        $(document).on('click', '.pagination-container li', function () {
            const url = $(this).data('url');
            if (!url) return
            const urlObj = new URL(url);
            const searchObj = urlObj.searchParams;
            const paramsObj = _.fromPairs([...searchObj]);
            let $page = paramsObj.page;
            params = paramsObj;
            page = $page;
            getData($page, params)
        })

        $(document).on('click', '.list-bare__item', function () {
            $(this).addClass('active').siblings().removeClass('active');
            const category = $(this).data('category');
            if (!category) return

            page = 1
            params = Object.assign(params, {category: category, page: page});
            getData(page, params)
        })

        function getData(page = 1, params = {}) {
            tableParams = params;
            const requestParams = Object.assign({page: page,}, tableParams);

            const searchParams = new URLSearchParams();
            Object.keys(requestParams).forEach(key => {
                if (requestParams[key]) {
                    searchParams.append(key, requestParams[key]);
                }
            });
            const queryString = searchParams.toString();

            const newUrl = `{{route('news.html')}}?${queryString}`;

            window.location.href = newUrl;
            console.log(newUrl)
        }
    })
</script>
</body>

</html>
