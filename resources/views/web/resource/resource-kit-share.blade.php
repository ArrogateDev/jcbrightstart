<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/font-awesome/all.min.css'])
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

<section>
    <div class="owl-carousel">
        <div class="w-full">
            <img class="w-full" src="{{web_resource_url('assets/web/images/resource-kit/banner-01.png')}}" alt="專家分享">
        </div>
    </div>
</section>

<section class="bg-01">
    <div class="container mx-auto p-5 md:p-10">
        <div class="py-[60px]">
            <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                <div class="divider-line"></div>
                <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                    <div class="flex items-center gap-x-[11px]">
                        <img class="w-[36px]" src="{{web_resource_url('assets/web/images/resource-kit/icon-01.svg')}}" alt="專家分享">
                        <div class="text-[31px] font-bold">專家分享</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="px-[48px] mt-[31px]">
                @if($categories->isNotEmpty())
                    <ul class="flex flex-wrap justify-center gap-x-[27px] gap-y-[23px]">
                        <li class="text-[17px] text-[#736357] font-bold p-[12px_48px] rounded-full bg-[#d6d2cd8a] category active cursor-pointer" data-category="0">{{__('全部')}}</li>
                        @foreach($categories as $item)
                            <li class="text-[17px] text-[#736357] font-bold p-[12px_48px] rounded-full bg-[#d6d2cd8a] cursor-pointer category" data-category="{{$item->id}}">{{$item->title}}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="grid grid-cols-12 gap-x-0 md:gap-x-[22px] gap-y-[77px] p-[55px_42px_0px] list-container"></div>
            <div class="pagination-container mt-[48px]"></div>
        </div>
    </div>
</section>

<x-web.footer/>
</body>
<script>
    $(function () {
        const urlParams = new URLSearchParams(window.location.search);
        let page = urlParams.get('page') || 1;
        let params = {};
        const urlCategory = urlParams.get('category');
        if (urlCategory) {
            $(`.category[data-category="${urlCategory}"]`).addClass('active').siblings().removeClass('active');
            params = Object.assign(params, {category: urlCategory});
        }

        $(document).on('click', '.category', function () {
            $(this).addClass('active').siblings().removeClass('active');
            const category = parseInt($(this).data('category'));

            page = 1
            params = Object.assign(params, {category: category, page: page});
            getData(page, params)
        })

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

        getData(page, params)

        function getData(page = 1, params = {}) {
            let requestParams = Object.assign({page: page}, params);

            const searchParams = new URLSearchParams();
            Object.keys(requestParams).forEach(key => {
                if (requestParams[key]) {
                    searchParams.append(key, requestParams[key]);
                }
            });

            const queryString = searchParams.toString();

            const newUrl = `${window.location.pathname}?${queryString}`;
            requestParams.mod = 14;

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
                        <div class="col-span-12 h-100 flex justify-center items-center gap-5 text-[56px] text-[#998675] font-bold">
                            <i class="fa-regular fa-hourglass text-[56px]"></i>
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
</html>
