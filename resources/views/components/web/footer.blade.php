<footer class="footer">
    <div class="container">
        <div class="row my-5">
            <div class="col-12 col-md-6">
                <div class="section-heading section-heading-1 section-heading-1--small text-left">
                    <h3 class="section-heading__title">Organised by 主辦機構</h3>
                    <div class="section-heading__line">
                        <img src="{{web_resource_url('assets/web/images/icon/line-blue-small.png')}}" alt="Line">
                    </div>
                </div>
                <div class="w-100 d-flex">
                    <img src="{{web_resource_url('assets/img/organization/organization-01.png')}}1" class="logo" alt="">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="section-heading section-heading-1 section-heading-1--small text-left">
                    <h3 class="section-heading__title">Funded by 捐助機構</h3>
                    <div class="section-heading__line">
                        <img src="{{web_resource_url('assets/web/images/icon/line-blue-small.png')}}" alt="Line">
                    </div>
                </div>
                <div class="w-100 d-flex">
                    <img src="{{web_resource_url('assets/img/organization/organization-02.png')}}" class="logo" alt="">
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
</style>

<section class="section copyright">
    <div class="container">
        <div class="text-center p-3">
            <p class="copyright__text" style="font-size: 14px;">版權所有 © {{date('Y')}} 香港賽馬會慈善信託基金</p>
            <p class="copyright__text" style="font-size: 12px;">Powered by Arrogate Maker Limited.</p>
        </div>
    </div>
</section>

<div id="to-top">
    <a href="#">
        <img src="{{web_resource_url('assets/web/images/icon/to-top.png')}}" alt="To Top">
    </a>
</div>
