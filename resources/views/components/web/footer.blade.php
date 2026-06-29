<footer>
    <section class="bg-footer border-b-[17px] border-[#e4c6c6]">
        <div class="container mx-auto px-5 md:px-10">
            <div class="flex flex-col items-start pt-[120px] pb-[76px] gap-y-12">
                <div class="flex flex-col xl:flex-row gap-y-10 xl:gap-y-0 xl:gap-x-[68px]">
                    <div>
                        <div class="text-[22px] text-[#998675] mb-[32px] font-bold">{{__('主办机构')}}</div>
                        <div class="flex gap-x-[24px]">
                            <div><img class="h-[80px]" src="{{web_resource_url('assets/img/organization/organization-01.png')}}" alt=""></div>
                        </div>
                    </div>
                    <div>
                        <div class="text-[22px] text-[#998675] mb-[32px] font-bold">{{__('专业合作伙伴')}}</div>
                        <div class="flex gap-x-[24px]">
                            <div><img class="h-[80px]" src="{{web_resource_url('assets/img/partner/PECERA.png')}}" alt="PECERA"></div>
                            <div><img class="h-[80px]" src="{{web_resource_url('assets/img/partner/CUHK.png')}}" alt="CUHK"></div>
                        </div>
                    </div>
                    <div>
                        <div class="text-[22px] text-[#998675] mb-[32px] font-bold">{{__('捐助机构')}}</div>
                        <div class="flex gap-x-[24px]">
                            <div><img class="h-[80px]" src="{{web_resource_url('assets/img/organization/organization-02.png')}}" alt=""></div>
                        </div>
                    </div>
                </div>
                <div class="text-[#736357]">
                    <div class="flex gap-x-4 mb-5">
                        <a href="https://www.facebook.com/JCBrightStartProject">
                            <img class="h-[30px]" src="{{web_resource_url('assets/web/images/facebook.svg')}}" alt="">
                        </a>
                        <a href="https://www.instagram.com/JCBrightStartProject">
                            <img class="w-[30px]" src="{{web_resource_url('assets/web/images/instagram.svg')}}" alt="">
                        </a>
                        <a href="https://www.youtube.com/@jcbrightstart">
                            <img class="h-[30px]" src="{{web_resource_url('assets/web/images/youtube.svg')}}" alt="">
                        </a>
                    </div>

                    <div class="font-medium">{{__('版权所有', ['date'=>date('Y')])}}</div>
                    <ul class="flex items-center fon-ar-mt font-medium">
                        <li><a href="{{route('page', ['page' => 'terms-and-conditions.html'])}}">Terms & Conditions</a></li>
                        <li class="mx-2">|</li>
                        <li><a href="{{route('page', ['page' => 'privacy-policy.html'])}}">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</footer>

{{--<x-web.demo/>--}}
