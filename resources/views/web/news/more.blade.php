<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/lodash.js') }}"></script>
    <script src="{{web_resource_url('assets/js/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{web_resource_url('assets/js/wait-me/waitMe.min.css')}}">
    <link href="{{web_resource_url('assets/js/toastr/toastr.min.css')}}" rel="stylesheet"/>
    <script src="{{web_resource_url('assets/js/toastr/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/utils.js') }}"></script>
</head>
<body>
<x-web.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="content pt-8">

            <div class="flex items-center justify-between mt-5 mb-3">
                <div class="text-[31px] text-[#998675] font-bold">{{$type === 1 ? __('最新视频') : __('最新消息')}}</div>
            </div>

            @if($type === 0 && $categories->isNotEmpty())
                <div class="tabs tabs-box mb-15">
                    <input type="radio" name="category_0" class="tab text-[20px] text-[#998675] font-bold" aria-label="{{__('全部')}}" data-filter="0" checked="checked"/>
                    @foreach($categories as $item)
                        <input type="radio" name="category_{{$item->id}}" class="tab text-[20px] text-[#998675] font-bold" aria-label="{{$item->title}}" data-category="{{$item->id}}"/>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-12 gap-x-5 list-container"></div>
            <nav class="au-pagination p-t-10 pagination-container"></nav>
        </div>
    </div>
</section>

<x-web.footer/>
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

        $(document).on('click', '.tabs input[type="radio"]', function () {
            const filter = $(this).data('filter');
            const category = $(this).data('category');
            $(this).siblings().removeAttr('checked');

            page = 1;

            if (filter === '0') {
                delete params.category;
            } else {
                params = Object.assign(params, {category: category});
            }

            getData(page, params);
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
                            <i class="fa-solid fa-book text-2xl mb-2"></i>
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
