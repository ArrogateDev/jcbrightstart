@props(['news' => null])
<div class="col-span-12 md:col-span-6 drop-shadow-xl news-col-item relative">
    <a href="{{$news->url}}" class="block w-full h-full border-b-[5px] border-[#fbe0df] rounded-b-lg news-item-box">
        <div class="news-perforated-line rounded-t-lg" aria-hidden="true"></div>
        <div class="news-item-box-body bg-[#fff] p-[45px] rounded-b-lg">
            <div class="flex gap-[20px]">
                <div class="title border-t-[1px] border-[#d1c7c0] grow title-tooltip pt-[17px]" data-tooltip="{{$news->release_date}}">
                    <span class="h-[112px] text-[28px] font-bold leading-9 line-clamp-3">{{$news->title}}</span>
                </div>
                <div class="w-[203px] h-[153px] rounded-lg flex-none overflow-hidden">
                    <img class="w-full rounded-lg" src="{{$news->thumbnail}}" alt="{{$news->title}}">
                </div>
            </div>
            <div class="text-[15px] text-[#736357] mt-[52px] font-normal">
                {{$news->short??''}}
            </div>
        </div>
        <svg class="absolute top-[0] left-[0px] w-[70px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 53.64 18.9">
            <defs>
                <style>.cls-1 {
                        fill: #a76f70;
                    }</style>
            </defs>
            <g id="图层_2" data-name="图层 2">
                <g id="new-1.9">
                    <path class="cls-1"
                          d="M53.64,6.73A6.69,6.69,0,0,1,47,13.2l-22.84.12A1.16,1.16,0,0,1,23,12.16h0A1.16,1.16,0,0,1,24.1,11L47,10.88a4.36,4.36,0,0,0,4.36-4.37A4.29,4.29,0,0,0,47,2.32L9.47,2.48A7.15,7.15,0,0,0,2.32,9.4a7.06,7.06,0,0,0,7.09,7.18l3.48,0v2.33H9.58A9.47,9.47,0,0,1,0,9.76,9.39,9.39,0,0,1,9.33.16L47,0A6.6,6.6,0,0,1,53.64,6.73Z"/>
                </g>
            </g>
        </svg>
    </a>
</div>
