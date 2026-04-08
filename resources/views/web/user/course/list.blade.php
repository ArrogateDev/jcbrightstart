<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>

<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <div class="content">
        <div class="container">

            <x-web.user.profile :user="$user"/>

            <div class="row">

                <x-web.user.sidebar active="course"/>

                <div class="col-lg-9">

                    <x-web.user.breadcrumb title="{{__('我的课程')}}"/>

                    <div class="page-title d-flex flex-wrap gap-3 align-items-center justify-content-between">
                        <h5>{{__('我的课程')}}</h5>
                        <div class="tab-list row justify-content-end">
                            <div class="col-md-4">
                                <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <i class="isax isax-search-normal-14"></i>
                                </span>
                                    <input type="text" id="search-input" class="form-control form-control-md" placeholder="{{__('搜索课程名称')}}">
                                </div>
                            </div>
                            <div class="col-md-auto">
                                <ul class="nav mb-0 gap-2 status-list">
                                    <li class="nav-item mb-0" data-status="0">
                                        <a href="javascript:void(0);" class="active">All
                                            ({{$all}})</a>
                                    </li>
                                    <li class="nav-item mb-0" data-status="1">
                                        <a href="javascript:void(0);">Active ({{$active}})</a>
                                    </li>
                                    <li class="nav-item mb-0" data-status="2">
                                        <a href="javascript:void(0);">Completed ({{$completed}})</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row courses-container"></div>

                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="button" class="btn btn-primary load-more-btn border-0 m-auto">
                                    <span class="btn-text" style="display: none;">{{__('更多')}}</span>
                                    <span class="btn-loading">
                                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                            Loading...
                                        </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-web.user.footer/>

</div>

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
            $(this).find('a').addClass('active');
            $(this).siblings().find('a').removeClass('active');
        })

        function getData(page = 1, params = {}) {
            tableParams = params;
            const requestParams = Object.assign({page: page,}, tableParams);

            $.ajax({
                url: "{{route('user.course.list.html')}}",
                data: requestParams,
                dataType: "json",
                beforeSend: function () {
                    $more.hide()
                    $loading.show()
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
                        <div class="text-center py-4 text-muted">
                            <i class="isax isax-document-text fs-24 mb-2"></i>
                            <p class="mb-0">{{__('暂无数据')}}</p>
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
                        $('.load-more-btn').hide()
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

</body>

</html>
