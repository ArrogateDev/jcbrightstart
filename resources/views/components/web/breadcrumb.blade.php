@props(['title' => '', 'subtitle' => null])
<div class="breadcrumbs">
  <ul>
    <li><a href="{{route('index.html')}}">{{__('首页')}}</a></li>
    <li>{!! $title !!}</li>
  </ul>
</div>
