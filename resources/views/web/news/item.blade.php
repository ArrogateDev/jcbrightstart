@props(['news' => null, 'col'=>true])
@if($col)
    <div class="col-md-6 col-lg-4">
        @endif
        <div class="media media-blog-2 card border-tricolor-wave">
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

    .media__text {
        min-height: 81px;
    }
</style>
