<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/css/user.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/lodash.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<x-web.user.header/>

<section class="bg-01">
    <div class="container mx-auto">
        <div class="pt-[60px]">
            <x-web.user.profile :user="$user"/>
        </div>

        <div class="grid grid-cols-12 lg:gap-x-12">
            <x-web.user.sidebar active="course"/>

            <div class="col-span-12 lg:col-span-10">

                <x-web.user.breadcrumb title="{{__('我的课程')}}"/>

                <div class="mb-5 flex flex-col gap-4 border-b border-[#998675] pb-5 lg:flex-row lg:items-center lg:justify-between">
                    <h5 class="text-xl font-bold text-slate-900">{{__('我的课程')}}</h5>
                    <div class="tab-list flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-end">
                        <div class="w-full lg:w-96">
                            <div class="relative">
                                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i class="isax isax-search-normal-14"></i>
                                </span>
                                <input type="text" id="search-input" class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" placeholder="{{__('搜索课程名称')}}">
                            </div>
                        </div>
                        <div class="w-full lg:w-auto">
                            <ul class="status-list flex flex-wrap gap-2">
                                <li class="mb-0" data-status="0">
                                    <a href="javascript:void(0);" class="status-link inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-slate-800" data-active="true">All
                                        ({{$all}})</a>
                                </li>
                                <li class="mb-0" data-status="1">
                                    <a href="javascript:void(0);" class="status-link inline-flex items-center rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200" data-active="false">Active ({{$active}})</a>
                                </li>
                                <li class="mb-0" data-status="2">
                                    <a href="javascript:void(0);" class="status-link inline-flex items-center rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200" data-active="false">Completed ({{$completed}})</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="courses-container grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3"></div>

                    <div class="mt-6 flex justify-center">
                        <button type="button" class="load-more-btn inline-flex items-center justify-center rounded-full bg-indigo-600 px-6 py-3 text-sm font-medium text-white transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-60">
                            <span class="btn-text" style="display: none;">{{__('更多')}}</span>
                            <span class="btn-loading inline-flex items-center">
                                <span class="spinner-border spinner-border-sm me-2 h-4 w-4 animate-spin rounded-full border-2 border-white border-r-transparent" role="status" aria-hidden="true"></span>
                                Loading...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<x-web.footer/>
</body>

<script>
    $(function () {
        let page = 1;
        let params = {};
        const $btn = $('.load-more-btn');
        const $more = $('.load-more-btn .btn-text');
        const $loading = $('.load-more-btn .btn-loading');

        getData(page)

        $btn.click(function () {
            $btn.prop('disabled', true);
            $btn.show();
            page = $(this).data('page');
            getData(page, params)
        })

        let searchInput = $('#search-input');
        searchInput.on('input', _.debounce(function () {
            const keywords = $(this).val().trim();
            $('.courses-container').html('');
            params = Object.assign({keywords: keywords,}, params);
            getData(1, params);
        }, 150));

        searchInput.on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                const keywords = $(this).val().trim();
                $('.courses-container').html('');
                params = Object.assign({keywords: keywords,}, params);
                getData(1, params);
            }
        });

        $('.status-list li').click(function () {
            let status = $(this).data('status');
            $('.courses-container').html('');
            params = Object.assign({status: status,}, params);
            getData(1, params);
            $('.status-link')
                .removeClass('bg-slate-900 text-white shadow-sm')
                .addClass('bg-slate-100 text-slate-700 hover:bg-slate-200')
                .attr('data-active', 'false');
            $(this).find('a')
                .removeClass('bg-slate-100 text-slate-700 hover:bg-slate-200')
                .addClass('bg-slate-900 text-white shadow-sm')
                .attr('data-active', 'true');
        })

        function getData(page = 1, params = {}) {
            tableParams = params;
            const requestParams = Object.assign({page: page,}, tableParams);

            $btn.show();
            $.ajax({
                url: "{{route('user.course.list.html')}}",
                data: requestParams,
                dataType: "json",
                beforeSend: function () {
                    $more.hide();
                    $loading.show();
                },
                success: function (response) {
                    if (response.code !== 0) {
                        showToast('error', response.msg);
                        return;
                    }

                    $courses = $('.courses-container');
                    let {html, page, total} = response.data;
                    if (total === 0) {
                        $courses.html(`
                        <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white py-10 text-center text-slate-500">
                            <i class="fa-solid fa-book text-2xl mb-2"></i>
                            <p class="mb-0 text-sm">{{__('暂无数据')}}</p>
                        </div>
                        `);
                        $btn.hide()
                        return;
                    }

                    if (page === 1) {
                        $courses.html(html);
                    } else {
                        $courses.append(html);
                    }

                    if (page >= total) {
                        $btn.hide();
                    }
                    $btn.data('page', page + 1);
                },
                error: function () {
                    showToast('error', '{{__('加载失败，请稍后重试！')}}');
                    $more.show()
                },
                complete: function () {
                    $more.show()
                    $loading.hide()
                    $btn.prop('disabled', false);
                }
            });
        }
    })
</script>

</html>
