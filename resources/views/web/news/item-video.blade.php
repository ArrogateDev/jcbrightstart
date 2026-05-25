@props(['news' => null, 'col'=>true, 'col_num'=>3, 'index'=>0]])
@php
    $num = $index%3 +1;
    $embed_url = $news->short??'';
    // Convert YouTube watch URL to embed URL
    if (str_contains($embed_url, 'youtube.com/watch?v=') || str_contains($embed_url, 'youtu.be/')) {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $embed_url, $matches);
        if (isset($matches[1])) {
            $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
        }
    }
@endphp

@if($col)
    <div class="md:col-span-6 lg:col-span-{{$col_num}}">
@endif
        <div class="hover-3d">
            <div class="relative bg-white rounded-[8px] overflow-visible sway-box">
                <div class="rounded-[8px_8px_0px_0px]">
                    <a href="{{$news->url}}">
                        <iframe class="w-100" src="{{$embed_url}}" frameborder="0" allowfullscreen></iframe>
                    </a>
                </div>
                <div class="p-[30px]">
                    <div class="flex items-center gap-[12px] mb-[17px]">
                        <img class="h-[32px]" src="{{web_resource_url(sprintf('assets/web/images/icon_00%s.svg', $num))}}" alt="{{$news->title}}">
                        <div class="text-[30px] text-[#998675] font-bold line-clamp-1">{{$news->title}}</div>
                    </div>
                </div>
                <div @class(['absolute', 'top-[-60px]' => $num !== 1, 'top-[-30px]' => $num === 1, 'right-[-30px]', 'w-[150px]' => $num === 1, 'w-[130px]' => $num === 2, 'w-[110px]' => $num === 3])>
                    <img class="motion" src="{{web_resource_url(sprintf('assets/web/images/character_knowledge_0%s.png', $num))}}" alt="">
                </div>
            </div>
        </div>
@if($col)
    </div>
@endif
