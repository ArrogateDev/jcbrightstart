@props(['title' => 'Dashboard'])
<div class="breadcrumb">
    <a href="{{route('user.dashboard.html')}}">{{__('首页')}}</a><span>›</span><span>{{$title}}</span>
</div>
