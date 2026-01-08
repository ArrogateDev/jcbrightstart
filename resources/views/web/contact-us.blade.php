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
                    <div class="col-sm-6 col-lg-3">
                        <div class="box box-info">
                            <div class="box__head">
                                <div class="box__icon au-icon-4 blue">
                                    <span class="lnr lnr-phone-handset"></span>
                                </div>
                            </div>
                            <div class="box__body">
                                <h3 class="title title--xl">Phone</h3>
                                <span>(363) 287 6443</span>
                                <span>(996) 406 3959</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="box box-info">
                            <div class="box__head">
                                <div class="box__icon au-icon-4 yellow">
                                    <span class="lnr lnr-map"></span>
                                </div>
                            </div>
                            <div class="box__body">
                                <h3 class="title title--xl">Address</h3>
                                <span>No 40 Baria Sreet 133/2</span>
                                <span>NewYork 13589</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="box box-info">
                            <div class="box__head">
                                <div class="box__icon au-icon-4 pink">
                                    <span class="lnr lnr-envelope"></span>
                                </div>
                            </div>
                            <div class="box__body">
                                <h3 class="title title--xl">Email</h3>
                                <span>
                                    <a href="mailto:brightstart.jc@yccece.edu.hk" style="color: unset;" class="__cf_email__">brightstart.jc@yccece.edu.hk</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="box box-info">
                            <div class="box__head">
                                <div class="box__icon au-icon-4 green">
                                    <span class="lnr lnr-clock"></span>
                                </div>
                            </div>
                            <div class="box__body">
                                <h3 class="title title--xl">Open Time</h3>
                                <span>Monday-Saturday: 6AM – 9PM</span>
                                <span>Sunday: Closed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section p-t-30 p-b-85">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading section-heading-1">
                            <h2 class="section-heading__title">{{__('联系我们')}}</h2>
                        </div>
                        <x-forms.about-us/>
                    </div>
                </div>
            </div>
        </section>

        <x-web.footer/>

    </main>
</div>

</body>

</html>
