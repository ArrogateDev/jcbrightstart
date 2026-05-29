@props(['breadcrumbs' => []])
@if(!empty($breadcrumbs))
    <div class="breadcrumbs px-0 md:px-10">
        <ul>
            @foreach($breadcrumbs as $breadcrumb)
                <li class="text-[15px] font-bold" style="color: {{$breadcrumb['color']}};">
                    @if(!empty($breadcrumb['url']))
                        <a href="{{$breadcrumb['url']}}">{{$breadcrumb['title']}}</a>
                    @else
                        {{$breadcrumb['title']}}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif
