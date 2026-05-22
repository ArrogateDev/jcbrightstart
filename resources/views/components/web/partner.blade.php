<div class="flex flex-col w-full px-[48px] gap-[18px]">
    <div class="flex gap-x-[30px]">
        <div>
            <div class="text-[11px] text-[#998675] mb-[11px] font-bold">{{__('主办机构')}}</div>
            <div class="flex gap-x-[24px]">
                <div><img class="h-[33px]" src="{{web_resource_url('assets/img/organization/organization-01.png')}}" alt=""></div>
            </div>
        </div>
        <div>
            <div class="text-[11px] text-[#998675] mb-[11px] font-bold">{{__('专业合作伙伴')}}</div>
            <div class="flex gap-x-[24px]">
                <div><img class="h-[39px]" src="{{web_resource_url('assets/img/partner/PECERA.png')}}" alt="PECERA"></div>
                <div><img class="h-[40px]" src="{{web_resource_url('assets/img/partner/CUHK.png')}}" alt="CUHK"></div>
            </div>
        </div>
        <div>
            <div class="text-[11px] text-[#998675] mb-[11px] font-bold">{{__('捐助机构')}}</div>
            <div class="flex gap-x-[24px]">
                <div><img class="h-[31px]" src="{{web_resource_url('assets/img/organization/organization-02.png')}}" alt=""></div>
            </div>
        </div>
    </div>
    <div class="text-[#736357] text-center">
        <div class="text-[8px]">{{__('版权所有', ['date'=>date('Y')])}}</div>
        <ul class="flex justify-center items-center fon-ar-mt text-[8px]">
            <li><a href="{{route('page', ['page' => 'terms-and-conditions.html'])}}">Terms & Conditions</a></li>
            <li class="mx-2">|</li>
            <li><a href="{{route('page', ['page' => 'privacy-policy.html'])}}">Privacy Policy</a></li>
        </ul>
    </div>
</div>
