<!DOCTYPE html>
<html lang="en">

<x-web.head/>

<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('HOME5_TITLE')}}" subtitle="{{__('HOME5_TITLE')}}"/>

        @for($i=1; $i<6; $i++)
            <section class="section section--h100 section--h100-nmobi development-item">
                <div class="container h-100" id="professional-{{$i}}">
                    <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="section-heading section-heading-2 m-b-50">
                            <h2 class="section-heading__title">{{__('HOME5_CONTENT0'.$i)}}</h2>
                        </div>
                        <div class="text-white" style="font-size: 22px;">
                            @for($j=1; $j<30; $j++)
                                {{__('HOME5_CONTENT0'.$i)}}
                            @endfor
                        </div>
                    </div>
                </div>
            </section>
        @endfor
    </main>

    <x-web.footer/>

</div>

</body>
<style>
    .development-item:nth-child(2) {
        background-color: #8bd5f9;
    }

    .development-item:nth-child(3) {
        background-color: #fce174;
    }

    .development-item:nth-child(4) {
        background-color: #ffa2ae;
    }

    .development-item:nth-child(5) {
        background-color: #bee17b;
    }

    .development-item:nth-child(6) {
        background-color: #f7c26a;
    }
</style>
</html>
