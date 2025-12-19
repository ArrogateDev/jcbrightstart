<header id="header">
    <section class="top-contact">
        <div class="container">
            <div class="top-contact-inner">
                <div class="top-contact__left">
                    <div class="top-contact__item">
                        <span class="lnr lnr-map"></span>No 40 Baria Sreet 133/2
                    </div>
                    <div class="top-contact__item">
                        <span class="lnr lnr-phone-handset"></span>(849) 490 4283
                    </div>
                </div>
                <div class="top-contact__right">
                    <ul class="list-unstyled list-inline list-social">
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
                        <li class="list-inline-item seprator">
                            <span></span>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" data-toggle="modal" data-target="#modal-search">
                                <i class="fas fa-search"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="header header-1 d-none d-lg-block js-header-1">
        <div class="header__bar">
            <div class="container">
                <div class="header__content">
                    <div class="logo py-2">
                        <a href="{{route('index.html')}}">
                            <img src="{{web_resource_url('assets/web/images/logo.png')}}" alt="Jockey Club Bright Start Project" style="height: 65px;">
                        </a>
                    </div>
                    @if(!empty($navs))
                        <nav class="header-navbar">
                            <ul class="list-unstyled">
                                @foreach($navs as $nav)
                                    <li @class(['header-navbar__item', 'has-sub' => !empty($nav['children'])])>
                                        <a href="{{$nav['url']}}">
                                            <span class="bg-link">{{$nav['title']}}</span>
                                        </a>
                                        @if(!empty($nav['children']))
                                            <ul class="list-unstyled header-navbar-child first">
                                                @foreach($nav['children'] as $child)
                                                    <li @class(['has-sub' => !empty($child['children'])])>
                                                        <a href="{{$child['url']}}">{{$child['title']}}</a>
                                                        @if(!empty($child['children']))
                                                            <ul class="list-unstyled header-navbar-child second">
                                                                @foreach($child['children'] as $item)
                                                                    <li>
                                                                        <a href="{{$item['url']}}">{{$item['title']}}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-search" role="dialog">
        <button class="close" type="button" data-dismiss="modal">
            <i class="zmdi zmdi-close"></i>
        </button>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form form--icon" method="POST">
                        <input type="text" name="search" placeholder="Search here...">
                        <button class="btn-submit-1" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="header-mobile js-header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid clearfix">
                <a class="logo" href="{{route('index.html')}}">
                    <img src="{{web_resource_url('assets/web/images/logo.png')}}" alt="Jooby" style="height: 55px;">
                </a>
                <button class="hamburger hamburger--slider float-right" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                </button>
            </div>
        </div>
        @if(!empty($navs))
            <nav class="navbar-mobile">
                <ul class="navbar-mobile__list list-unstyled">
                    @foreach($navs as $nav)
                        <li  @class(['has-sub' => !empty($nav['children'])])>
                            <a href="{{$nav['url']}}">
                                <span class="bg-link">{{$nav['title']}}</span>
                            </a>
                            @if(!empty($nav['children']))
                                <ul class="navbar-mobile__child list-unstyled first">
                                    @foreach($nav['children'] as $child)
                                        <li  @class(['has-sub' => !empty($child['children'])])>
                                            <a href="{{$child['url']}}">{{$child['title']}}</a>
                                            @if(!empty($child['children']))
                                                <ul class="navbar-mobile__child list-unstyled second">
                                                    @foreach($child['children'] as $item)
                                                        <li>
                                                            <a href="{{$item['url']}}">{{$item['title']}}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif
    </div>
</header>
