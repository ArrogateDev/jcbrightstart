@props(['title' => 'Dashboard'])
<div class="breadcrumb">
    <a class="text-[#4fc3f7]" href="{{route('user.dashboard.html')}}">{{__('首页')}}</a><span>›</span><span>{{$title}}</span>
</div>
