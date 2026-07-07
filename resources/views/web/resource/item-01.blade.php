@props(['resource' => null])
<div class="col-span-12 md:col-span-6 lg:col-span-4">
    <div class="bg-[#d6d2cd8a] rounded-lg p-[21px]">
        <a class="block bg-[#fffef9] rounded-lg p-[14px_21px] resource-kit-icon" href="{{$resource->url}}">
            <div data-tooltip="{{$resource->date}}"
                 class="h-[145px] text-[24px] text-[#00A99D] font-bold mt-[18px] line-clamp-4 pb-[9px] border-y-[1px] border-[#d1c7c0] title-tooltip">{{$resource->title}}</div>
            <div class="p-[14px_7px] flex gap-[9px] min-h-[64px] hidden">
                @if($resource->category_top_text)
                    <div class="text-[13px] text-[#fff] font-bold bg-[#bd98b1] rounded-lg p-[8px_14px]" style="background: {{$resource->category_top_color??'#00c8d4'}};">{{$resource->category_top_text}}</div>
                @endif
                @if($resource->category_text)
                    <div class="text-[13px] text-[#fff] font-bold bg-[#bd98b1] rounded-lg p-[8px_14px]" style="background: {{$resource->category_color??'#00c8d4'}};">{{$resource->category_text}}</div>
                @endif
            </div>
        </a>
    </div>
</div>
