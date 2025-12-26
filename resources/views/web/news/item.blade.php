@props(['news' => null])
<div class="col-md-6 col-lg-4">
    <div class="media media-blog-2">
        <div class="media__img">
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
                        <p>{{$news->event_date_text}}</p>
                    </div>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <img class="me-1" src="{{web_resource_url('assets/img/icons/clock.svg')}}" alt="img">
                        <p>{{$news->event_time_text}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
