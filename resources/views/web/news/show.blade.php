<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <script src="{{web_resource_url('assets/web/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{web_resource_url('assets/js/image-viewer.min.js')}}" id="gd-image-viewer"
            data-target-selector=".gallery-img"
            data-allow-rotate="false"
            data-allow-image-info="false"
            data-allow-navigation="false"
            data-allow-download="false">
    </script>
</head>
<body>
<x-web.header/>
<section class="bg-01">
    <div class="container mx-auto">
        <div class="content pt-8">
            @if($url)
                <a href="{{$url}}" class="flex items-center badge badge-primary mb-3">
                    <i class="fa-solid fa-angles-left"></i>
                    {{__('返回')}}
                </a>
            @endif
            <div class="card bg-base-100 w-full shadow-sm">
                @if($news->thumbnail_show === 1)
                    <figure>
                        <img src="{{$news->thumbnail}}" alt="{{$news->title}}"/>
                    </figure>
                @endif
                <div class="card-body">
                    <h2 class="card-title">{{$news->title}}</h2>
                    <p>{{$news->short}}</p>
                    <div>
                        {!! $news->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-web.footer/>

</body>

</html>
