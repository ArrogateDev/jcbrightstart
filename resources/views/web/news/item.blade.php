@props(['news' => null, 'col'=>true, 'col_num'=>4, 'index'=>0])
@php
    $num = $index%3 +1;
@endphp
@if($col)
    <div class="md:col-span-6 lg:col-span-{{$col_num}}">
@endif
        <div class="hover-3d">
            <a href="{{$news->url}}" class="relative bg-white rounded-[8px] overflow-visible sway-box">
                <div class="rounded-[8px_8px_0px_0px]">
                    <img class="rounded-[8px_8px_0px_0px] aspect-[405/389]" src="{{$news->thumbnail}}" alt="{{$news->title}}">
                </div>
                <div class="p-[30px]">
                    <div class="flex items-center gap-[12px] mb-[17px]">
                        <img class="h-[32px]" src="{{web_resource_url(sprintf('assets/web/images/v1/icon_00%s.svg', $num))}}" alt="{{$news->title}}">
                        <div class="text-[30px] text-[#998675] font-bold line-clamp-1">{{$news->title}}</div>
                    </div>
                    <div class="text-[18px] text-[#534741] font-medium line-bg px-1.5">
                        {{__('发布日期')}}：{{$news->release_date}}
                    </div>
                    <div class="text-[18px] text-[#736357] font-medium leading-[33px] mt-[25px] line-clamp-3">
                        {{$news->short??''}}
                    </div>
                </div>
                <div @class(['absolute', 'top-[-60px]' => $num !== 1, 'top-[-30px]' => $num === 1, 'right-[-30px]', 'w-[150px]' => $num === 1, 'w-[130px]' => $num === 2, 'w-[110px]' => $num === 3])>
                    <img class="motion" src="{{web_resource_url(sprintf('assets/web/images/v1/character_knowledge_0%s.png', $num))}}" alt="">
                </div>
            </a>
        </div>
@if($col)
    </div>
@endif
