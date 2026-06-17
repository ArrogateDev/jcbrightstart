<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js', 'resources/css/font-awesome/all.min.css'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
</head>
<body>
<x-web.header/>

<section>
    <div class="owl-carousel">
        <div class="w-full">
            <img class="w-full" src="{{web_resource_url('assets/web/images/maps/banner.png')}}" alt="地圖">
        </div>
    </div>
</section>

<section class="bg-01">
    <div class="container mx-auto p-5 xl:p-10">
        <div class="py-[60px]">
            <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                <div class="divider-line"></div>
                <div class="flex justify-center items-center gap-x-2 text-[#998675]">
                    <div class="flex items-center gap-x-[11px]">
                        <img class="w-[28px]" src="{{web_resource_url('assets/web/images/maps/icon-05.svg')}}" alt="按服務顯示">
                        <div class="text-[31px] font-bold">按服務顯示</div>
                    </div>
                </div>
                <div class="divider-line"></div>
            </div>
            <div class="mt-[25px]">
                <div class="flex gap-[13px]">
                    @foreach($maps as $map)
                        <div @class(['flex items-center gap-[6px] p-[3px_30px] rounded-t-lg cursor-pointer tab-title', 'active' =>$loop->first]) data-id="tab-{{ $map->id }}"
                             style="background-color: {{$map->bg}};">
                            <img class="w-[24px]" src="{{$map->icon}}" alt="{{$map->show_title}}">
                            <div class="text-[24px] text-[#998675]">{{$map->show_title}}</div>
                        </div>
                    @endforeach
                </div>

                <div class="bg-[#f5f5f5] rounded-b-lg p-[30px_0px_62px] md:p-[30px_37px_62px]">
                    @foreach($maps as $index => $map)
                        <div @class(['hidden'=>!$loop->first]) id="tab-{{ $map->id }}">
                            <div class="grid grid-cols-12 gap-x-0 md:gap-x-[42px] gap-y-[42px] rounded-lg">
                                @foreach($map->locations as $location)
                                    <div class="col-span-12 md:col-span-6 xl:col-span-4 drop-shadow-xl relative" data-id="{{$location->id}}">
                                        <div class="w-full h-full p-[33px_27px_88px] border-b-[5px] map-item-box map-item-{{$index}}-box" style="background-color: {{$map->i_bg}};border-color: {{$map->i_line}};">
                                            <div class="text-[20px] text-[#915DA3] pb-[9px] border-b-[1px] border-[#dfd8e0] font-normal" style="color: {{$map->i_text}};">{{$location->organization}}</div>
                                            <div class="w-full pt-[16px]">
                                                @if ($location->age)
                                                    <div class="w-full flex gap-[5px] text-[17px] leading-[23px] mb-[8px]">
                                                        <span class="w-[70px] flex-none">{{__('年龄范围')}}</span>
                                                        <span class="px-[2px]">:</span>
                                                        <span class="break-all">{{$location->age}}</span>
                                                    </div>
                                                @endif
                                                @if ($location->district)
                                                    <div class="w-full flex gap-[5px] text-[17px] leading-[23px] mb-[8px]">
                                                        <span class="w-[70px] flex-none">{{__('区域')}}</span>
                                                        <span class="px-[2px]">:</span>
                                                        <span class="break-all">{{$location->district}}</span>
                                                    </div>
                                                @endif
                                                @if ($location->capacity)
                                                    <div class="w-full flex gap-[5px] text-[17px] leading-[23px] mb-[8px]">
                                                        <span class="w-[70px] flex-none">{{__('容量')}}</span>
                                                        <span class="px-[2px]">:</span>
                                                        <span class="break-all">{{$location->capacity}}</span>
                                                    </div>
                                                @endif
                                                @if ($location->address)
                                                    <div class="w-full flex gap-[5px] text-[17px] leading-[23px] mb-[8px]">
                                                        <span class="w-[70px] flex-none">{{__('地址')}}</span>
                                                        <span class="px-[2px]">:</span>
                                                        <span class="break-all">{{$location->address}}</span>
                                                    </div>
                                                @endif
                                                @if ($location->phone)
                                                    <div class="w-full flex gap-[5px] text-[17px] leading-[23px] mb-[8px]">
                                                        <span class="w-[70px] flex-none">{{__('电话号码')}}</span>
                                                        <span class="px-[2px]">:</span>
                                                        <a class="break-all" href="tel:{{$location->phone}}">{{$location->phone}}</a>
                                                    </div>
                                                @endif
                                                @if ($location->email)
                                                    <div class="w-full flex gap-[5px] text-[17px] leading-[23px] mb-[8px]">
                                                        <span class="w-[70px] flex-none">{{__('电子邮件')}}</span>
                                                        <span class="px-[2px]">:</span>
                                                        <a class="break-all" href="mailto:{{$location->email}}">{{$location->email}}</a>
                                                    </div>
                                                @endif
                                                @if ($location->webpage)
                                                    <div class="w-full flex gap-[5px] text-[17px] leading-[23px] mb-[8px]">
                                                        <span class="w-[70px] flex-none">{{__('网页')}}</span>
                                                        <span class="px-[2px]">:</span>
                                                        <a class="break-all" href="{{$location->webpage}}" target="_blank" rel="noopener noreferrer">{{$location->webpage}}</a>
                                                    </div>
                                                @endif
                                                @if ($location->service_hours || $location->serviceHours)
                                                    <div class="w-full flex gap-[5px] text-[17px] leading-[23px] mb-[8px]">
                                                        <span class="w-[70px] flex-none">{{__('服务时间')}}</span>
                                                        <span class="px-[2px]">:</span>
                                                        <span class="break-all">{{$location->service_hours || ''}}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="absolute w-[89px] h-[30px] top-[-15px] left-0 right-0 mx-auto" style="background-color: {{$map->i_tag}};"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</section>

<x-web.footer/>
<script>
    $(function () {
        $('.tab-title').click(function () {
            $(this).addClass('active').siblings().removeClass('active');
            let id = $(this).data('id')
            $(`#${id}`).removeClass('hidden').siblings().addClass('hidden');
        })
    })
</script>
</body>
</html>
