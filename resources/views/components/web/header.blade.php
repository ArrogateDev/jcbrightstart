<header id="header">
    <section class="bg-top w-full fixed top-0 z-999">
        <div class="container mx-auto px-5 md:px-10">
            <div class="flex items-center justify-between pt-[45px] pb-[42px] gap-x-4">
                <a href="{{route('index.html')}}" class="shrink-0">
                    <img class="w-[185px] h-[81px]" src="{{web_resource_url('assets/web/images/logo.png')}}" alt="Jockey Club Bright Start Project">
                </a>

                <div class="hidden xl:flex items-center gap-x-[33px]">
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
                                                            <img class="w-[20px]" src="{{web_resource_url('assets/web/images/arrow.svg')}}" alt="{{$child['title']}}">
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
                        @if(false)
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
                                                    <img class="w-[20px]" src="{{web_resource_url('assets/web/images/arrow.svg')}}" alt="{{$menu['title']}}">
                                                    <span>{{$menu['title']}}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                        <div class="divider"></div>
                                        <li>
                                            <a href="#" class="flex align-center gap-x-3 text-[19px] text-[#998675] font-bold logout">
                                                <img class="w-[20px]" src="{{web_resource_url('assets/web/images/arrow.svg')}}" alt="{{__('退出登录')}}">
                                                <span>{{__('退出登录')}}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <div class="bg-[#43c8d5] px-[45px] rounded-lg">
                                    <a class="flex justify-center gap-x-1 text-white text-[21px] font-bold" href="{{route('login.html')}}">
                                        <img class="w-[20px]" src="{{web_resource_url('assets/web/images/login.svg')}}" alt="">
                                        {{__('家长登入')}}
                                    </a>
                                </div>
                            @endauth
                        @endif
                    </div>
                </div>

                <div class="drawer drawer-end xl:hidden w-auto">
                    <input id="header-drawer" type="checkbox" class="drawer-toggle"/>
                    <div class="drawer-content flex items-center">
                        <label for="header-drawer" class="btn btn-ghost btn-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#998675]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </label>
                    </div>
                    <div class="drawer-side z-[999]">
                        <label for="header-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                        <aside class="menu min-h-full w-80 bg-[#fffaf5] text-[#998675] p-6">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-[22px] font-bold">{{__('Menu')}}</span>
                                <label for="header-drawer" class="btn btn-ghost btn-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#998675]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </label>
                            </div>

                            @if(!empty($navs))
                                <ul class="space-y-3">
                                    @foreach($navs as $nav)
                                        <li class="rounded-2xl border border-[#e6ddd2] bg-white/70 shadow-sm overflow-hidden">
                                            @if($nav['has_children'])
                                                <details class="group">
                                                    <summary
                                                        class="flex cursor-pointer list-none items-center justify-between gap-x-3 px-4 py-3 text-[18px] text-[#998675] font-bold [&::-webkit-details-marker]:hidden">
                                                        <span class="flex items-center gap-x-3">
                                                            <img class="h-[18px]" src="{{$nav['icon']}}" alt="{{$nav['title']}}">
                                                            <span>{{$nav['title']}}</span>
                                                        </span>
                                                    </summary>
                                                    <div class="border-t border-[#f0e6dc] bg-[#fffaf5]">
                                                        <ul class="p-3 space-y-2">
                                                            @foreach($nav['children'] as $child)
                                                                <li>
                                                                    <a class="flex items-center gap-x-2 rounded-xl px-3 py-2 text-[16px] text-[#998675] font-bold hover:bg-[#f7eee6]"
                                                                       href="{{$child['url']}}" target="{{$child['target']??'_self'}}">
                                                                        <img class="w-[16px]" src="{{web_resource_url('assets/web/images/arrow.svg')}}" alt="{{$child['title']}}">
                                                                        <span>{{$child['title']}}</span>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </details>
                                            @else
                                                <a href="{{$nav['url']}}" class="flex items-center justify-between gap-x-3 px-4 py-3 text-[18px] text-[#998675] font-bold">
                                                    <span class="flex items-center gap-x-3">
                                                        <img class="h-[18px]" src="{{$nav['icon']}}" alt="{{$nav['title']}}">
                                                        <span>{{$nav['title']}}</span>
                                                    </span>
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </aside>
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
