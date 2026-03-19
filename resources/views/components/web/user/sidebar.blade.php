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
<x-sweetalert/>

<script>
    $(function () {
        $('.logout').click(function () {
            confirm_alert('{{__('确定退出吗')}}', '{{__('你将无法撤销这一操作！')}}', '{{__('确定')}}', 'warning', '{{__('取消')}}')
                .then((result) => {
                    if (result.isConfirmed) {
                        showLoading()
                        $.ajax({
                            url: "{{ route('user.logout.html') }}",
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                if (response.code !== 0) {
                                    showToast('error', response.msg);
                                    return;
                                }

                                showToast('success', 'Successful');
                                setTimeout(function () {
                                    window.location.href = '{{route('home')}}';
                                }, 800)
                            },
                            error: function () {
                                showToast('error', 'Login failed, please try again later')
                            },
                            complete: function () {
                                hideLoading()
                            }
                        });
                    }
                })
        })
    })
</script>
