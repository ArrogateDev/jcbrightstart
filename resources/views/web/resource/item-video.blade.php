@props(['resource' => null, 'col'=>true])
@php
    $embed_url = $resource->short;
    // Convert YouTube watch URL to embed URL
    if (str_contains($embed_url, 'youtube.com/watch?v=') || str_contains($embed_url, 'youtu.be/')) {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $embed_url, $matches);
        if (isset($matches[1])) {
            $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
        }
    }
@endphp
@if($col)
    <div class="col-md-6 col-lg-3">
 @endif
        <div class="media media-blog-2">
            <div class="media__img">
                <a href="{{$resource->url}}">
                    <iframe class="w-100" src="{{$embed_url}}" frameborder="0" allowfullscreen></iframe>
                </a>
            </div>
            <div class="media__body">
                <h4 class="media__title title title--black title--md">
                    <a href="{{$resource->url}}">{{$resource->title}}</a>
                </h4>
            </div>
        </div>
@if($col)
    </div>
@endif
