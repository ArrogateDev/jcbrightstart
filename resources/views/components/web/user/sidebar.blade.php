@props(['active' => 'dashboard'])
<div class="col-lg-2 theiaStickySidebar d-none d-md-block">
    <aside class="sidebar">
        @foreach($user_menus as $menu)
            <div class="sidebar-title">{{$menu['title']}}</div>
            @foreach($menu['children'] as $item)
                <a href="{{$item['url']??'javascript:void(0);'}}" @class(['sidebar-item', 'active' => $active === $item['active'],$item['class']??'']) class="sidebar-item">
                    <span class="s-icon">{{$item['icon']}}</span>
                    {{$item['title']}}
                </a>
            @endforeach
        @endforeach
    </aside>
</div>
