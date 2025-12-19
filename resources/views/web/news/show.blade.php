<!DOCTYPE html>
<html lang="en">

<x-web.head/>
<style>
    .post-btn {
        font-size: 32px;
        color: #666;
    }

    .list-nav-blog__item a:hover .post-btn, .list-nav-blog__item a:hover .post-btn {
        color: #ff97a4;
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
                    <div class="col-md-8 col-lg-9">
                        <div class="blog-single">
                            <div class="media media-blog-4 m-b-10">
                                <div class="media__img">
                                    <a class="img-radius" href="javascript:void(0);">
                                        <img src="{{web_resource_url('assets/web/images/blog-19.jpg')}}" alt="{{$news->title}}">
                                    </a>
                                    <div class="media__date">
                                        <div class="media__date-inner">
                                            <span class="day">{{$news->day}}</span>
                                            <span class="month">{{$news->month}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="media__body">
                                    <h4 class="media__title title title--black title--s35">
                                        <a href="javascript:void(0);">{{$news->title}}</a>
                                    </h4>
                                    <p class="media__text">{{$news->short}}</p>
                                </div>
                            </div>
                            <div>
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
                                        <a class="ic-fb" href="#">
                                            <i class="zmdi zmdi-facebook-box"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="ic-twi" href="#">
                                            <i class="zmdi zmdi-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="ic-insta" href="#">
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
                            <div class="media media-author-2 m-t-40 m-b-55">
                                <div class="media__circle"></div>
                                <div class="media__img">
                                    <a class="img-circle-border-2" href="#">
                                        <img src="{{web_resource_url('assets/web/images/cmt-01.jpg')}}" alt="Author 2">
                                    </a>
                                </div>
                                <div class="media__body">
                                    <h4 class="title title--sbold title--sm">Denise Murray</h4>
                                    <span class="email"><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                           data-cfemail="92f6f7fcfbe1f7cdaaa1d2f7eaf3ffe2fef7bcf1fdff">[email&#160;protected]</a></span>
                                    <p class="m-t-15 m-b-20">On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms</p>
                                    <ul class="list-unstyled list-inline list-social list-social-3">
                                        <li class="list-inline-item">
                                            <a class="ic-fb" href="#">
                                                <i class="zmdi zmdi-facebook-box"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="ic-twi" href="#">
                                                <i class="zmdi zmdi-twitter"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="ic-insta" href="#">
                                                <i class="zmdi zmdi-instagram"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="ic-in" href="#">
                                                <i class="zmdi zmdi-linkedin"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <h3 class="title title--md">Comments</h3>
                            <ul class="list-unstyled list-cmts">
                                <li class="list-cmts__item p-t-35">
                                    <div class="list-cmts__avatar">
                                        <a class="img-circle" href="#">
                                            <img src="{{web_resource_url('assets/web/images/cmt-02.jpg')}}" alt="Cmt 2">
                                        </a>
                                    </div>
                                    <div class="list-cmts__content">
                                        <div class="list-cmts__content-head">
                                            <div class="left">
                                                <h5 class="title title--s18 title--black">
                                                    <a href="#">Amber Reyes</a>
                                                </h5>
                                                <span class="date">March 28, 2019</span>
                                            </div>
                                            <div class="right">
                                                <a class="link-reply" href="#">reply</a>
                                            </div>
                                        </div>
                                        <div class="list-cmts__content-body">
                                            <p>
                                                In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be
                                                welcomed and every pain avoided.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-cmts__item">
                                    <div class="list-cmts__avatar">
                                        <a class="img-circle" href="#">
                                            <img src="{{web_resource_url('assets/web/images/cmt-03.jpg')}}" alt="Cmt 3">
                                        </a>
                                    </div>
                                    <div class="list-cmts__content">
                                        <div class="list-cmts__content-head">
                                            <div class="left">
                                                <h5 class="title title--s18 title--black">
                                                    <a href="#">Teresa Henderson</a>
                                                </h5>
                                                <span>March 28, 2019</span>
                                            </div>
                                            <div class="right">
                                                <a class="link-reply" href="#">reply</a>
                                            </div>
                                        </div>
                                        <div class="list-cmts__content-body">
                                            <p>
                                                Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod
                                                maxime placeat facere</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <h3 class="title title--md m-b-35">Post a Comment</h3>
                            <form method="post">
                                <div class="au-input-group m-b-20">
                                    <textarea class="textarea-border-4" name="cmt" required="" placeholder="Your Comment"></textarea>
                                </div>
                                <div class="au-input-group m-b-20">
                                    <input class="input-border-4" type="text" name="name" required="" id="name">
                                    <label for="name">Your Name</label>
                                </div>
                                <div class="au-input-group m-b-10">
                                    <input class="input-border-4" type="text" name="mail" required="" id="mail">
                                    <label for="mail">Your Mail</label>
                                </div>
                                <button class="au-btn au-btn--blue" type="submit">Submit
                                    <i class="zmdi zmdi-chevron-right"></i>
                                    <i class="zmdi zmdi-chevron-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="page-sidebar p-sm-t-50">
                            <div class="widget">
                                <div class="form form--icon">
                                    <input id="search-input" class="input-border-3" type="text" placeholder="Search...">
                                    <button id="search-btn" class="btn-submit-2" type="submit">
                                        <span class="lnr lnr-magnifier"></span>
                                    </button>
                                </div>
                            </div>
                            @if(!empty($category))
                                <div class="widget p-b-30 p-t-45">
                                    <div class="section-heading section-heading-1 section-heading-1--tiny2 text-left">
                                        <h2 class="section-heading__title">Categories</h2>
                                        <div class="section-heading__line">
                                            <img src="{{web_resource_url('assets/web/images/icon/line-blue-tiny.png')}}" alt="Line">
                                        </div>
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
                                    <div class="section-heading__line">
                                        <img src="{{web_resource_url('assets/web/images/icon/line-blue-tiny.png')}}" alt="Line">
                                    </div>
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

<!-- Jquery JS-->
<script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap JS-->
<script src="{{web_resource_url('assets/web/vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
<!-- Vendor JS-->
<script src="{{web_resource_url('assets/web/vendor/animsition/animsition.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/slick/slick.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/lightbox2/js/lightbox.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/waypoints/jquery.waypoints.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/wow/wow.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/jquery.counterup/jquery.counterup.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/isotope/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/matchHeight/jquery.matchHeight-min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/select2/select2.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/noUiSlider/nouislider.min.js')}}"></script>
<script src="{{web_resource_url('assets/web/vendor/modalVideo/modal-video.min.js')}}"></script>
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
<script src="{{web_resource_url('assets/web/js/theme-map.min.js')}}"></script>

<!-- Main JS-->
<script src="{{web_resource_url('assets/web/js/global.js')}}"></script>

<script type="text/javascript" src="{{ web_resource_url('assets/admin/js/lodash.js') }}"></script>
<script src="{{web_resource_url('assets/admin/plugins/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/wait-me/waitMe.min.css')}}">
<link href="{{web_resource_url('assets/admin/plugins/toastr/toastr.min.css')}}" rel="stylesheet"/>
<script src="{{web_resource_url('assets/admin/plugins/toastr/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{ web_resource_url('assets/admin/js/utils.js') }}"></script>
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
