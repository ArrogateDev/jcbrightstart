<!DOCTYPE html>
<html lang="en">

<x-web.head/>
<script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>

<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('联系我们')}}" subtitle="{{__('联系我们')}}"/>

        <section class="section p-t-125">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="img-border img-border--pink">
                            <div class="img-border-inner">
                                <img src="{{web_resource_url('assets/img/home/home-05.png')}}" alt="Welcome 2">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 d-flex align-items-center">
                        <div class="p-l-70 p-md-l-0 w-100">
                            <div class="welcome-wrap welcome-wrap-2 p-t-0">
                                <div class="section-heading section-heading-1 m-b-10">
                                    <h2 class="section-heading__title">{{__('联系我们')}}</h2>
                                    <p> If you have any questions, please fill out the form or email us at <a href="mailto:brightstart.jc@yccece.edu.hk">brightstart.jc@yccece.edu.hk</a> orsubmit your message in below:</p>
                                </div>
                                <x-forms.about-us/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-web.footer/>

    </main>
</div>

</body>

</html>
