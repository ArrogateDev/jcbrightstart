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
        -webkit-line-clamp: 1;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .media-info {
        font-size: 14px;
    }

    .media-info img {
        width: 16px;
    }
</style>
<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('最新消息')}}" subtitle="{{__('最新消息')}}"/>

        <section class="section p-t-125 p-b-80">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-3">
                        <div class="page-sidebar p-sm-b-70">
                            <div class="widget">
                                <form class="form form--icon" method="post">
                                    <input id="search-input" class="input-border-3" type="text" placeholder="Search...">
                                    <button id="search-btn" class="btn-submit-2" type="submit">
                                        <span class="lnr lnr-magnifier"></span>
                                    </button>
                                </form>
                            </div>
                            @if(!empty($category))
                                <div class="widget p-b-30 p-t-45">
                                    <div class="section-heading section-heading-1 section-heading-1--tiny2 text-left">
                                        <h2 class="section-heading__title">Categories</h2>
                                    </div>
                                    <ul class="list-bare list-unstyled">
                                        @foreach($category as $item)
                                            <li class="list-bare__item" data-category="{{$item->id}}">
                                                <span class="dot"></span>
                                                <a class="list-bare__link" href="#">{{$item->title}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="widget p-b-35">
                                <div class="section-heading section-heading-1 section-heading-1--tiny2 text-left">
                                    <h2 class="section-heading__title">Tag Cloud</h2>
                                    <div class="m-b-25"></div>
                                </div>
                                <div class="au-tag-lists">
                                    <a class="au-tag__item" href="#">Music</a>
                                    <a class="au-tag__item" href="#">Children</a>
                                    <a class="au-tag__item" href="#">Dance</a>
                                    <a class="au-tag__item" href="#">Nutrition</a>
                                    <a class="au-tag__item" href="#">Safety</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-9">
                        <div class="row">
                            <div class="col-md-12">
                                <nav class="au-tab-2 m-b-50">
                                    <ul class="type-box list-unstyled au-tab__nav au-tab__nav--sspace iostope-filter">
                                        <li class="active au-tab__nav-item d-flex justify-content-center align-items-center" data-type="1">
                                            <span class="au-tab__nav-item-inner">{{__('最新活动')}}</span>
                                        </li>
                                        <li class="au-tab__nav-item d-flex justify-content-center align-items-center" data-type="0">
                                            <span class="au-tab__nav-item-inner">{{__('过去活动')}}</span>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="p-l-10 p-sm-l-0">
                            <div class="row list-container"></div>
                            <nav class="au-pagination p-t-10 pagination-container"></nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section cta-1 bg-pink p-t-80 p-b-55">
            <div class="container">
                <div class="cta-wrap">
                    <div class="cta__img wow fadeInUp" data-wow-delay=".2s">
                        <img src="{{web_resource_url('assets/web/images/cta-item-01.png')}}" alt="CTA">
                    </div>
                    <div class="row">
                        <div class="col-md-7 offset-md-5">
                            <div class="wrap--w625">
                                <div class="cta">
                                    <div class="cta__body">
                                        <h2 class="title cta__title">How to Enroll Your Child to a Class?</h2>
                                        <p class="cta__text">Interested in good preschool education for your child? Our kindergarten is the right decision!</p>
                                        <a class="au-btn au-btn--blue" href="#">find our more
                                            <i class="zmdi zmdi-chevron-right"></i>
                                            <i class="zmdi zmdi-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        const urlParams = new URLSearchParams(window.location.search);
        let page = urlParams.get('page') || 1;
        let params = {};
        let $search = $('#search-input');
        let $searchBtn = $('#search-btn');

        const urlKeywords = urlParams.get('keywords');
        const urlCategory = urlParams.get('category');
        const urlType = urlParams.get('type');
        if (urlKeywords) {
            $search.val(urlKeywords);
            params = Object.assign(params, {keywords: urlKeywords});
        }
        if (urlCategory) {
            $(`.list-bare__item[data-category="${urlCategory}"]`).addClass('active');
            params = Object.assign(params, {category: urlCategory});
        }
        if (urlType) {
            $(`.list-bare__item[data-type="${urlType}"]`).addClass('active');
            params = Object.assign(params, {type: urlType});
        }

        getData(page, params)

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

        $searchBtn.on('input', _.debounce(function () {
            const keywords = $(this).val().trim();
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

        $(document).on('click', '.type-box li', function () {
            $(this).addClass('active').siblings().removeClass('active');
            const type = $(this).data('type');

            page = 1
            params = Object.assign(params, {type: type, page: page});
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

            const newUrl = `${window.location.pathname}?${queryString}`;

            $.ajax({
                url: "{{route('news.list.html')}}",
                data: requestParams,
                dataType: "json",
                beforeSend: function () {
                    showLoading()
                },
                success: function (response) {
                    if (response.code !== 0) {
                        showToast('error', response.msg);
                        return;
                    }

                    $list = $('.list-container');
                    let {html, total, pagination} = response.data;
                    $('.pagination-container').html(pagination)

                    window.history.pushState({}, '', newUrl);

                    if (total === 0) {
                        $list.html(`
                        <div class="w-100 text-center py-4 text-muted">
                            <i class="isax isax-document-text fs-24 mb-2"></i>
                            <p class="mb-0">{{__('暂无数据')}}</p>
                        </div>
                        `);
                        return;
                    }

                    $list.html(html);
                },
                error: function () {
                    showToast('error', '{{__('加载失败，请稍后重试！')}}');
                },
                complete: function () {
                    hideLoading()
                }
            });
        }
    })
</script>
</body>

</html>
