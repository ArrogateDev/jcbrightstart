@props(['resource' => null])
<div class="col-span-12 md:col-span-6 lg:col-span-4">
    <div class="bg-[#d6d2cd8a] rounded-lg p-[21px]">
        <a class="block bg-[#fffef9] rounded-lg p-[14px_21px] resource-kit-icon" href="{{$resource->url}}">
            <div data-tooltip="{{$resource->date}}"
                 class="text-[29px] text-[#00A99D] font-bold mt-[18px] h-[131px] line-clamp-3 pb-[9px] border-y-[1px] border-[#d1c7c0] title-tooltip">{{$resource->title}}</div>
            <div class="p-[14px_7px] flex gap-[9px] min-h-[64px]">
                @if($resource->category_top_text)
                    <div class="text-[13px] text-[#fff] font-bold bg-[#bd98b1] rounded-lg p-[8px_14px]">{{$resource->category_top_text}}</div>
                @endif
                @if($resource->category_text)
                    <div class="text-[13px] text-[#fff] font-bold bg-[#bd98b1] rounded-lg p-[8px_14px]">{{$resource->category_text}}</div>
                @endif
            </div>
        </a>
    </div>
</div>
