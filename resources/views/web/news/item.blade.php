@props(['news' => null])
<div class="col-md-6 col-lg-4">
    <div class="media media-blog-2">
        <div class="media__img">
            <a href="{{$news->url}}">
                <img src="{{$news->thumbnail}}" alt="How to coax children">
            </a>
            <div class="media__date">
                <div class="media__date-inner">
                    <span class="day">{{$news->day}}</span>
                    <span class="month">{{$news->month}}</span>
                </div>
            </div>
        </div>
        <div class="media__body">
            <h4 class="media__title title title--black title--md">
                <a href="{{$news->url}}">{{$news->title}}</a>
            </h4>
            <p class="media__text">{{$news->short}}</p>
        </div>
    </div>
</div>
