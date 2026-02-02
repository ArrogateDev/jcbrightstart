@props(['title' => '', 'subtitle' => ''])
<section class="section page-heading js-parallax-scroll" style="background-image: url('{{web_resource_url('assets/web/images/bg-heading-001.png')}}');">
    <div class="container">
        <div class="page-heading-inner">
            <div class="section-heading section-heading-1 section-heading-1--tiny text-left">
                <h2 class="section-heading__title">{{$title}}</h2>
            </div>
            <nav class="au-breadcrumb">
                <ul class="list-unstyled list-breadcrumb">
                    <li class="list-breadcrumb__item">
                        <a href="{{route('index.html')}}">{{__('首页')}}</a>
                    </li>
                    <li class="list-breadcrumb__item">{{$subtitle}}</li>
                </ul>
            </nav>
        </div>
    </div>
</section>
