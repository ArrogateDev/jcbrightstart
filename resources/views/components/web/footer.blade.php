<footer class="footer p-t-85">
    <div class="container">
        <div class="related-item d-flex align-items-start">
            <div class="related-title">{{__('捐助机构')}}</div>
            <div class="related-item-logo-box">
                <div class="related-item-logo">
                    <img src="{{web_resource_url('assets/img/organization/organization-02.png')}}" class="logo" alt="">
                </div>
            </div>
        </div>
        <div class="related-item d-flex align-items-start">
            <div class="related-title">{{__('主办机构')}}</div>
            <div class="related-item-logo-box">
                <div class="related-item-logo">
                    <img src="{{web_resource_url('assets/img/organization/organization-01.png')}}" class="logo" alt="">
                </div>
            </div>
        </div>
        <div class="related-item d-flex align-items-start">
            <div class="related-title">{{__('专业合作伙伴')}}</div>
            <div class="related-item-logo-box d-flex">
                <div class="related-item-logo">
                    <img src="{{web_resource_url('assets/img/partner/PECERA.png')}}" class="logo" alt="">
                </div>
                <div class="related-item-logo">
                    <img src="{{web_resource_url('assets/img/partner/CUHK.png')}}" class="logo" alt="">
                </div>
            </div>
        </div>
    </div>
</footer>
<style>
    .related-item {
        margin-bottom: 40px;
    }

    .related-title {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
        color: #2d3748;
        text-align: left;
    }

    .related-item-logo-box {
        gap: 40px;
    }

    .related-item-logo {
        height: 55px;
    }

    .related-item-logo img {
        height: 100%;
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

    @media (max-width: 780px) {
        .copyright-box {
            display: block !important;
        }

        .copyright-box span {
            display: none !important;
        }
    }
</style>

<section class="section copyright">
    <div class="container">
        <div class="text-center p-3">
            <div class="copyright-box copyright__text d-flex align-items-center justify-content-center " style="font-size: 14px;">
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
