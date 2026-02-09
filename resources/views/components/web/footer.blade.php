<footer class="footer p-t-85">
    <div class="container">
        <div class="section-heading section-heading-1 section-heading-1--small text-left">
            <h2 class="section-heading__title">{{__('专业合作伙伴')}}</h2>
        </div>
        <div class="w-100 d-flex" style="margin-bottom: 80px;">
            <div class="mr-5" style="height: 120px;">
                <img class="h-100" src="{{web_resource_url('assets/img/partner/PECERA.png')}}" alt="PECERA">
            </div>
            <div class="ml-5" style="height: 120px;">
                <img class="h-100" src="{{web_resource_url('assets/img/partner/CUHK.png')}}" alt="CUHK">
            </div>
        </div>
        <div class="row my-5">
            <div class="col-12 col-md-6">
                <div class="section-heading section-heading-1 section-heading-1--small text-left" style="margin-bottom: 55px;">
                    <h2 class="section-heading__title">{{__('主办机构')}}</h2>
                </div>
                <div class="w-100 d-flex">
                    <img src="{{web_resource_url('assets/img/organization/organization-01.png')}}" class="logo" alt="">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="section-heading section-heading-1 section-heading-1--small text-left" style="margin-bottom: 55px;">
                    <h2 class="section-heading__title">{{__('捐助机构')}}</h2>
                </div>
                <div class="w-100 d-flex">
                    <img style="height: 110px;" src="{{web_resource_url('assets/img/organization/organization-02.png')}}" class="logo" alt="">
                </div>
            </div>
        </div>
    </div>
</footer>
<style>
    .footer .section-heading__title {
        font-size: 24px;
    }

    .footer img.logo {
        height: 100px;
    }

    .footer-link {
        list-style-type: none;
    }

    .footer-link li {
        padding: 0 4px;
    }

    .footer-link a {
        color: #666;
    }
</style>

<section class="section copyright">
    <div class="container">
        <div class="text-center p-3">
            <div class="copyright__text d-flex align-items-center justify-content-center " style="font-size: 14px;">
                {{__('版权所有', ['date'=>date('Y')])}}
                <span class="mx-2">|</span>
                <ul class="d-flex align-items-center justify-content-center footer-link">
                    <li><a href="{{route('page', ['page' => 'terms-and-conditions.html'])}}">Terms & Conditions</a></li>
                    <li class="mx-2">|</li>
                    <li><a href="{{route('page', ['page' => 'privacy-policy.html'])}}">Privacy Policy</a></li>
                </ul>
            </div>
            <p class="copyright__text" style="font-size: 12px;">Powered by Arrogate Maker Limited.</p>
        </div>
    </div>
</section>

<div id="to-top">
    <a href="#">
        <img src="{{web_resource_url('assets/web/images/icon/to-top.png')}}" alt="To Top">
    </a>
</div>
