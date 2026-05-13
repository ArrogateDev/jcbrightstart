<footer>
    <section class="bg-footer border-b-[17px] border-[#e4c6c6]">
        <div class="container mx-auto">
            <div class="flex justify-between items-end pt-[120px] pb-[76px]">
                <div class="flex gap-x-[68px]">
                    <div>
                        <div class="text-[22px] text-[#998675] mb-[28px] font-bold">{{__('专业合作伙伴')}}</div>
                        <div class="flex gap-x-[24px]">
                            <div><img class="h-[80px]" src="{{web_resource_url('assets/img/partner/PECERA.png')}}" alt="PECERA"></div>
                            <div><img class="h-[80px]" src="{{web_resource_url('assets/img/partner/CUHK.png')}}" alt="CUHK"></div>
                        </div>
                    </div>
                    <div>
                        <div class="text-[22px] text-[#998675] mb-[28px] font-bold">{{__('主办机构')}}</div>
                        <div class="flex gap-x-[24px]">
                            <div><img class="h-[80px]" src="{{web_resource_url('assets/img/organization/organization-01.png')}}" alt=""></div>
                        </div>
                    </div>
                    <div>
                        <div class="text-[22px] text-[#998675] mb-[28px] font-bold">{{__('捐助机构')}}</div>
                        <div class="flex gap-x-[24px]">
                            <div><img class="h-[80px]" src="{{web_resource_url('assets/img/organization/organization-02.png')}}" alt=""></div>
                        </div>
                    </div>
                </div>
                <div class="text-[#736357]">
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

{{--<x-web.v1.demo/>--}}
