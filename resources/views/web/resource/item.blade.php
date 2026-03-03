@props(['resource' => null, 'col'=>true])
@if($col)
    <div class="col-md-6 col-lg-3">
 @endif
        <div class="media media-blog-2">
            <div class="media__img">
                <a href="{{$resource->url}}">
                    <img src="{{$resource->thumbnail}}" alt="How to coax children">
                </a>
            </div>
            <div class="media__body">
                <h4 class="media__title title title--black title--md">
                    <a href="{{$resource->url}}">{{$resource->title}}</a>
                </h4>
                <p class="category-text">{{$resource->category_text}}</p>
                <p class="media__text">{{$resource->short}}</p>
            </div>
        </div>
@if($col)
    </div>
@endif
