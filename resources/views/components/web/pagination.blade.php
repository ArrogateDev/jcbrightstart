@if($paginator->count() > 0)
    <ul class="list-unstyled list-pagination">
        @if ($paginator->onFirstPage())
            <li class="list-pagination__item arrow disabled">
                <i class="zmdi zmdi-chevron-left"></i>
            </li>
        @else
            <li class="list-pagination__item arrow" data-url="{{$paginator->previousPageUrl()}}">
                <i class="zmdi zmdi-chevron-left"></i>
            </li>
        @endif

        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            $start = max(1, min($currentPage - 2, $lastPage - 4));
            $end = min($lastPage, max($currentPage + 2, 5));
        @endphp

        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $currentPage)
                <li class="list-pagination__item active">
                    <span class="number">{{ $i }}</span>
                </li>
            @else
                <li class="list-pagination__item" data-url="{{ $paginator->url($i) }}">
                    <span class="number">{{ $i }}</span>
                </li>
            @endif
        @endfor

        @if ($paginator->hasMorePages())
            <li class="list-pagination__item arrow" data-url="{{$paginator->nextPageUrl()}}">
                <i class="zmdi zmdi-chevron-right"></i>
            </li>
        @else
            <li class="list-pagination__item arrow disabled">
                <i class="zmdi zmdi-chevron-right"></i>
            </li>
        @endif
    </ul>
@endif
