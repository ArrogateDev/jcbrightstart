@props(['resource' => null])
<div class="col-span-12 md:col-span-4 xl:col-span-3">
    <div class="bg-[#d8d4cf57] rounded-lg p-[21px]">
        <a class="block bg-[#fff] rounded-lg p-[14px_21px]" href="{{$resource->url}}">
            <div class="aspect-[177/213] overflow-hidden rounded-lg">
                <img class="w-full h-auto" src="{{$resource->thumbnail}}" alt="{{$resource->title}}">
            </div>
            <div class="text-[21px] text-[#998675] mt-[18px] h-[63px] line-clamp-2">{{$resource->title}}</div>
        </a>
    </div>
</div>
