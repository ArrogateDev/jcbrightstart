<!DOCTYPE html>
<html lang="en">

<x-web.head/>

<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="聯繫我們" subtitle="聯繫我們"/>

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
        <!-- END INFO-->

        <!-- MESSAGE-->
        <section class="section p-t-30 p-b-85">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading section-heading-1">
                            <h2 class="section-heading__title">Send Message</h2>
                            <div class="section-heading__line">
                                <img src="{{web_resource_url('assets/web/images/icon/line-blue.png')}}" alt="Line">
                            </div>
                        </div>
                        <form class="js-contact-form" method="post">
                            <div class="row">
                                <div class="col-md-6 p-r-10 p-md-r-15">
                                    <input class="input-border" type="text" name="name" required="" placeholder="Your name">
                                </div>
                                <div class="col-md-6 p-l-10 p-md-l-15">
                                    <input class="input-border" type="email" name="email" required="" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" placeholder="Your e-mail">
                                </div>
                            </div>
                            <textarea class="textarea-border" name="message" placeholder="Your message..." required=""></textarea>
                            <div class="text-center">
                                <button class="au-btn au-btn--blue" type="submit">submit
                                    <i class="zmdi zmdi-chevron-right"></i>
                                    <i class="zmdi zmdi-chevron-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <x-web.footer/>

    </main>
</div>

</body>

</html>
