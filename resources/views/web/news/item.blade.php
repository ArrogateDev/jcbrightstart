@props(['news' => null, 'col'=>true])
@if($col)
    <div class="col-md-6 col-lg-4">
        @endif
        <div class="media media-blog-2 card border-balloon-string">
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
            <div class="balloon-tricolor"></div>
            <div class="balloon-tricolor balloon2"></div>
            <div class="balloon-tricolor balloon3"></div>
            <div class="string-line">🎈🎈</div>
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
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 30px rgba(0, 0, 0, 0.1);
    }

    .border-balloon-string {
        border: 4px solid #ff71eb;
        border-radius: 50px 30px 55px 25px;
        background: #FFFDF9;
        position: relative;
        overflow: visible;
    }

    /* 纯CSS气球 */
    .balloon-tricolor {
        position: absolute;
        width: 30px;
        height: 34px;
        background: radial-gradient(circle at 35% 35%, #ffb900, #e6a100);
        border-radius: 50% 50% 50% 50%;
        top: -28px;
        left: 20px;
    }

    .balloon-tricolor::after {
        content: "";
        position: absolute;
        bottom: -12px;
        left: 11px;
        width: 2px;
        height: 16px;
        background: #b47c5a;
    }

    .balloon2 {
        background: radial-gradient(circle at 35% 35%, #00c8d4, #00a5b0);
        left: 65px;
        top: -32px;
        width: 28px;
        height: 32px;
    }

    .balloon3 {
        background: radial-gradient(circle at 35% 35%, #ff71eb, #e55ad4);
        right: 25px;
        left: auto;
        top: -26px;
        width: 32px;
        height: 36px;
    }

    .string-line {
        position: absolute;
        bottom: -18px;
        right: 30px;
        font-size: 1.8rem;
        color: #ffb900;
        opacity: 0.6;
    }

    .media-blog-2 .media__img img {
        border-radius: 50px 30px 0 0;
    }
</style>
