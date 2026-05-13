<header id="header">
    <section class="bg-top w-full fixed top-0 z-999">
        <div class="container mx-auto">
            <div class="flex justify-between pt-[45px] pb-[42px]">
                <a href="{{route('index.html')}}">
                    <img class="w-[185px] h-[81px]" src="{{web_resource_url('assets/web/images/logo.png')}}" alt="Jockey Club Bright Start Project">
                </a>
                <div class="flex items-end gap-x-[33px]">
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
                        <div class="flex items-center gap-x-3">
                            <div class="flex gap-x-1 flex-none">
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
                            <label class="flex-initial input bg-transparent h-[30px] rounded-lg">
                                <input type="search" required placeholder="Search"/>
                                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g
                                        stroke-linejoin="round"
                                        stroke-linecap="round"
                                        stroke-width="2.5"
                                        fill="none"
                                        stroke="currentColor"
                                    >
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </g>
                                </svg>
                            </label>
                        </div>
                        @auth
                            <div class="bg-[#43c8d5] px-[45px] rounded-lg">
                                <a class="flex gap-x-1 text-white text-[21px] font-bold" href="{{route('login.html')}}">
                                    <img class="w-[20px]" src="{{web_resource_url('assets/web/images/v1/login.svg')}}" alt="">
                                    {{__('家长登入')}}
                                </a>
                            </div>
                        @else
                            <div class="bg-[#43c8d5] px-[45px] rounded-lg">
                                <a class="flex gap-x-1 text-white text-[21px] font-bold" href="{{route('login.html')}}">
                                    <img class="w-[20px]" src="{{web_resource_url('assets/web/images/v1/login.svg')}}" alt="">
                                    {{__('家长登入')}}
                                </a>
                            </div>
                        @endauth
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
