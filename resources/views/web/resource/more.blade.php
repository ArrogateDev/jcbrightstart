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
        width: 100%;
        aspect-ratio: 4 / 3;
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
</style>
<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('专业学习社群')}}"/>

        @if($type === 0)
            <section class="section p-t-80 p-b-35">
                <div class="container">
                    <div class="row m-0 p-b-10" style="border-bottom: 1px solid #d0d4db;">
                        <div class="col-md-9 m-0 p-0">
                            @if($categories->isNotEmpty())
                                <ul class="category-box">
                                    <li class="d-inline-block category active" data-filter="0">{{__('全部')}}</li>
                                    @foreach($categories as $item)
                                        <li class="d-inline-block category" data-category="{{$item->id}}">{{$item->title}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="col-md-3 m-0 p-0">
                            <div class="widget">
                                <form class="form form--icon" method="post">
                                    <input id="search-input" class="input-border-3" type="text" placeholder="Search...">
                                    <button id="search-btn" class="btn-submit-2" type="submit">
                                        <span class="lnr lnr-magnifier"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section>
            <div class="container">
                <div class="d-flex align-items-center justify-content-between my-4">
                    <h3>{{$type === 1 ? __('影片分享') : __('专家分享')}}</h3>
                    <div class="d-flex align-items-center">
                        <span>{{__('排序')}}：</span>
                        <select id="resource-sort" class="border rounded-lg px-3 py-2">
                            <option value="time">{{__('最新发布')}}</option>
                            <option value="view">{{__('最多浏览')}}</option>
                        </select>
                    </div>
                </div>
                <div class="row list-container"></div>
                <nav class="au-pagination p-t-10 pagination-container"></nav>
            </div>
        </section>
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

        const urlMod = urlParams.get('mod');
        const urlType = urlParams.get('type');
        const urlKeywords = urlParams.get('keywords');
        const urlCategory = urlParams.get('category');
        if (urlMod) {
            params = Object.assign(params, {mod: urlMod});
        }
        if (urlType) {
            params = Object.assign(params, {type: urlType});
        }
        if (urlKeywords) {
            $search.val(urlKeywords);
            params = Object.assign(params, {keywords: urlKeywords});
        }
        if (urlCategory) {
            $(`.category[data-category="${urlCategory}"]`).addClass('active').siblings().removeClass('active');
            params = Object.assign(params, {category: urlCategory});
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

        $(document).on('click', '.category', function () {
            $(this).addClass('active').siblings().removeClass('active');
            const category = parseInt($(this).data('category'));

            page = 1
            params = Object.assign(params, {category: category, page: page});
            getData(page, params)
        })

        $(document).on('change', '#resource-sort', function () {
            const sort = $(this).val();

            page = 1
            getData(page, tableParams)
        })

        function getData(page = 1, params = {}) {
            tableParams = params;
            const sort = $('#resource-sort').val();
            const requestParams = Object.assign({page: page, sort: sort}, tableParams);

            const searchParams = new URLSearchParams();
            Object.keys(requestParams).forEach(key => {
                if (requestParams[key]) {
                    searchParams.append(key, requestParams[key]);
                }
            });

            const queryString = searchParams.toString();

            const newUrl = `${window.location.pathname}?${queryString}`;

            $.ajax({
                url: "{{route('resource.list.html')}}",
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
