@props(['news' => null])
<div class="col-span-12 md:col-span-6 drop-shadow-xl news-col-item">
    <a href="{{$news->url}}" class="block w-full h-full p-[45px] border-b-[5px] border-[#fbe0df] rounded-lg news-item-box bg-[#fff]">
        <div class="flex gap-[20px]">
            <div class="title grow border-t-[1px] border-[#d1c7c0] title-tooltip pt-[17px]" data-tooltip="{{$news->release_date}}">
                <span class="h-[112px] text-[28px] font-bold leading-9 line-clamp-3">{{$news->title}}</span>
            </div>
            <div class="w-[203px] h-[153px] rounded-lg flex-none overflow-hidden">
                <img class="w-full rounded-lg" src="{{$news->thumbnail}}" alt="{{$news->title}}">
            </div>
        </div>
        <div class="text-[15px] text-[#736357] mt-[52px] font-normal">
            {{$news->short??''}}
        </div>
    </a>
</div>
