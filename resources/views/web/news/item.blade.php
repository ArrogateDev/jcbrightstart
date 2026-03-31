@props(['news' => null, 'col'=>true])
@if($col)
    <div class="col-md-6 col-lg-4">
        @endif
        <div class="media media-blog-2 card-border border-tricolor-wave">
            <div class="media__img text-center">
                <a href="{{$news->url}}">
                    <img src="{{$news->thumbnail}}" alt="How to coax children">
                </a>
            </div>
            <div class="media__body">
                <h4 class="media__title title title--black title--md">
                    <a href="{{$news->url}}">{{$news->title}}</a>
                </h4>
                <p class="media__text">{{$news->short}}</p>
                <div class="media-info py-2">
                    <div class="d-flex align-items-center flex-wrap justify-content-between">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <img class="me-1" src="{{web_resource_url('assets/img/icons/calendar.svg')}}" alt="img">
                            <p>{{__('发布日期')}}：{{$news->release_date}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wave-dot">⚡</div>
        </div>
        @if($col)
    </div>
@endif
