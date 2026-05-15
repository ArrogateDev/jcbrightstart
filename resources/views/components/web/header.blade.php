<header id="header">
    <section class="bg-top w-full fixed top-0 z-999">
        <div class="container mx-auto">
            <div class="flex justify-between pt-[45px] pb-[42px]">
                <a href="{{route('index.html')}}">
                    <img class="w-[185px] h-[81px]" src="{{web_resource_url('assets/web/images/logo.png')}}" alt="Jockey Club Bright Start Project">
                </a>
                <div class="flex items-center gap-x-[33px]">
                    @if(!empty($navs))
                        <nav>
                            <ul class="flex gap-x-[35px]">
                                @foreach($navs as $index => $nav)
                                    <li @class(['dropdown' => $nav['has_children'], 'dropdown-hover' => $nav['has_children']])>
                                        <a tabindex="0" role="button" href="{{$nav['url']}}" class="flex items-center gap-x-1.5 text-[22px] text-[#998675] font-bold">
                                            <img class="h-[20px]" src="{{$nav['icon']}}" alt="{{$nav['title']}}">
                                            <span>{{$nav['title']}}</span>
                                        </a>
                                        @if($nav['has_children'])
                                            <ul tabindex="-1" class="dropdown-content menu bg-[#ffffffcc] rounded-box z-1 w-52 p-2 shadow-sm">
                                                @foreach($nav['children'] as $child)
                                                    <li>
                                                        <a class="flex align-center gap-x-3 text-[19px] text-[#998675] font-bold" href="{{$child['url']}}" target="{{$child['target']??'_self'}}">
                                                            <img class="w-[20px]" src="{{web_resource_url('assets/web/images/v1/arrow.svg')}}" alt="{{$child['title']}}">
                                                            <span>{{$child['title']}}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    @endif
                    <div class="flex flex-col gap-y-3">
                        @auth
                            <div class="dropdown dropdown-hover">
                                <div tabindex="0" role="button" class="flex items-center gap-x-2 text-[19px] text-[#998675] font-bold">
                                    <div tabindex="0" role="button" class="w-10 h-10 bg-white rounded-full">
                                        <img src="{{$user->avatar}}" alt="Img" class="img-fluid rounded-full">
                                    </div>
                                    <h6>{{$user->full_name}}</h6>
                                </div>
                                <ul tabindex="-1" class="dropdown-content menu bg-[#ffffffcc] rounded-box z-1 w-52 p-2 shadow-sm">
                                    @foreach($avatar_menus as $menu)
                                        <li>
                                            <a class="flex align-center gap-x-3 text-[19px] text-[#998675] font-bold" href="{{$menu['url']}}" target="{{$menu['target']??'_self'}}">
                                                <img class="w-[20px]" src="{{web_resource_url('assets/web/images/v1/arrow.svg')}}" alt="{{$menu['title']}}">
                                                <span>{{$menu['title']}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                    <div class="divider"></div>
                                    <li>
                                        <a href="#" class="flex align-center gap-x-3 text-[19px] text-[#998675] font-bold logout">
                                            <img class="w-[20px]" src="{{web_resource_url('assets/web/images/v1/arrow.svg')}}" alt="{{__('退出登录')}}">
                                            <span>{{__('退出登录')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="bg-[#43c8d5] px-[45px] rounded-lg">
                                <a class="flex justify-center gap-x-1 text-white text-[21px] font-bold" href="{{route('login.html')}}">
                                    <img class="w-[20px]" src="{{web_resource_url('assets/web/images/v1/login.svg')}}" alt="">
                                    {{__('家长登入')}}
                                </a>
                            </div>
                        @endauth
                        <div class="flex items-center gap-x-3 shrink">
                            <div class="flex justify-between gap-x-1 flex-none w-full">
                                <a href="https://www.facebook.com/JCBrightStartProject">
                                    <img class="h-[20px]" src="{{web_resource_url('assets/web/images/v1/facebook.svg')}}" alt="">
                                </a>
                                <a href="https://www.instagram.com/JCBrightStartProject">
                                    <img class="w-[20px]" src="{{web_resource_url('assets/web/images/v1/instagram.svg')}}" alt="">
                                </a>
                                <a href="https://www.facebook.com/JCBrightStartProject">
                                    <img class="h-[20px]" src="{{web_resource_url('assets/web/images/v1/youtube.svg')}}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</header>
<script>
    $(function () {
        $('body').css('padding-top', $('#header section').outerHeight(true) - 15)
        $(window).on('resize', function () {
            $('body').css('padding-top', $('#header section').outerHeight(true) - 15)
        })
    });
</script>
