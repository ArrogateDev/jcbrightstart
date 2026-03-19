@props(['title' => 'Dashboard'])
<div class="breadcrumb">
    <a href="{{route('index.html')}}">{{__('首页')}}</a><span>›</span><span>{{$title}}</span>
</div>
