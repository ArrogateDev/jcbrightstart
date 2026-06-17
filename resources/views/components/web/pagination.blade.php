@if($paginator->count() > 0)
    <ul class="flex justify-center gap-[14px]">

        <li @class(['page-item w-[40px] h-[40px] border-2 border-[#b3b3b3] rounded-full px-[18px] text-[21px] text-[#b3b3b3] cursor-pointer font-bold', 'disabled' => $paginator->onFirstPage()])  data-url="{{ $paginator->onFirstPage() ? null : $paginator->url(1) }}">
            <i class="fa-solid fa-angles-left"></i>
        </li>

        <li @class(['page-item w-[40px] h-[40px] border-2 border-[#b3b3b3] rounded-full px-[18px] text-[21px] text-[#b3b3b3] cursor-pointer font-bold', 'disabled' => $paginator->onFirstPage()])  data-url="{{ $paginator->onFirstPage() ? null : $paginator->previousPageUrl()}}">
            <i class="fa-solid fa-angle-left"></i>
        </li>

        @php
            $current_page = $paginator->currentPage();
            $last_page = $paginator->lastPage();
            $start = max(1, min($current_page - 2, $last_page - 4));
            $end = min($last_page, max($current_page + 2, 5));
        @endphp

        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $current_page)
                <li class="page-item w-[40px] h-[40px] border-2 border-[#b3b3b3] rounded-full px-[18px] text-[21px] text-[#b3b3b3] cursor-pointer font-bold active">
                    <span class="number">{{ $i }}</span>
                </li>
            @else
                <li class="page-item w-[40px] h-[40px] border-2 border-[#b3b3b3] rounded-full px-[18px] text-[21px] text-[#b3b3b3] cursor-pointer font-bold" data-url="{{ $paginator->url($i) }}">
                    <span class="number">{{ $i }}</span>
                </li>
            @endif
        @endfor

        <li @class(['page-item w-[40px] h-[40px] border-2 border-[#b3b3b3] rounded-full px-[18px] text-[21px] text-[#b3b3b3] cursor-pointer font-bold', 'disabled' => !$paginator->nextPageUrl()]) data-url="{{ !$paginator->nextPageUrl() ? null : $paginator->nextPageUrl()}}">
            <i class="fa-solid fa-angle-right"></i>
        </li>

        <li @class(['page-item w-[40px] h-[40px] border-2 border-[#b3b3b3] rounded-full px-[18px] text-[21px] text-[#b3b3b3] cursor-pointer font-bold', 'disabled' => !$paginator->nextPageUrl()]) data-url="{{ !$paginator->nextPageUrl() ? null : $paginator->url($last_page) }}">
            <i class="fa-solid fa-angles-right"></i>
        </li>
    </ul>
@endif
