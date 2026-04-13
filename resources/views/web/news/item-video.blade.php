@props(['news' => null, 'col'=>true, 'col_num'=>3])
@php
    $embed_url = $news->short??'';
    // Convert YouTube watch URL to embed URL
    if (str_contains($embed_url, 'youtube.com/watch?v=') || str_contains($embed_url, 'youtu.be/')) {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $embed_url, $matches);
        if (isset($matches[1])) {
            $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
        }
    }
@endphp
@if($col)
    <div class="col-md-6 col-lg-{{$col_num}}">
 @endif
        <div class="media media-blog-2 card border-tricolor-wave">
            <div class="media__img">
                <a href="{{$news->url}}">
                    <iframe class="w-100" src="{{$embed_url}}" frameborder="0" allowfullscreen></iframe>
                </a>
            </div>
            <div class="media__body">
                <h4 class="media__title title title--black title--md">
                    <a href="{{$news->url}}">{{$news->title}}</a>
                </h4>
            </div>
            <div class="wave-dot">⚡</div>
        </div>
@if($col)
    </div>
@endif

<style>
    .card {
        background: #ffffff;
        border-radius: 32px;
        transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        text-align: center;
        position: relative;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        overflow: visible;
    }

    .card:hover {
        /*!*transform: translateY(-8px);*!*/
        /*box-shadow: 0 18px 30px rgba(0, 0, 0, 0.1);*/
    }

    .border-tricolor-wave {
        border: 4px solid transparent;
        background: #FFFEF7;
        border-radius: 56px 32px 56px 32px;
        position: relative;
        background-clip: padding-box;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.05);
    }

    .border-tricolor-wave::before {
        content: "";
        position: absolute;
        inset: -6px;
        background: linear-gradient(120deg, #ffb900, #00c8d4, #ff71eb, #ffb900);
        border-radius: 60px 36px 60px 36px;
        z-index: -1;
        filter: blur(1px);
    }

    /* 波浪装饰点 */
    .border-tricolor-wave::after {
        content: "~~~";
        position: absolute;
        bottom: -18px;
        left: 20px;
        font-size: 1.8rem;
        color: #00c8d4;
        opacity: 0.6;
        letter-spacing: 6px;
        font-weight: bold;
        pointer-events: none;
    }

        .wave-dot {
            position: absolute;
            top: -14px;
            right: 25px;
            font-size: 1.5rem;
            color: #ff71eb;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

    .media-blog-2 .media__img img {
        border-radius: 60px 36px 0 0;
    }
</style>
