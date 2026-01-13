@props(['active' => 'dashboard'])
<div class="col-lg-3 theiaStickySidebar d-none d-md-block">
    <div class="settings-sidebar mb-lg-0">
        <div>
            @foreach($user_menus as $menu)
                <h6 class="mb-3">{{$menu['title']}}</h6>
                <ul class="mb-3 pb-1">
                    @foreach($menu['children'] as $item)
                        <li>
                            <a href="{{$item['url']??'javascript:void(0);'}}" @class(['d-inline-flex align-items-center', 'active' => $active === $item['active'],$item['class']??''])>
                                <i class="{{$item['icon']}} me-2"></i>{{$item['title']}}
                            </a>
                        </li>
                    @endforeach
                </ul>
                @if(!$loop->last)
                    <hr>
                @endif
            @endforeach
        </div>
    </div>
</div>

<x-sweetalert/>

<script>
    $(function () {
        $('.logout').click(function () {
            confirm_alert('{{__('确定退出吗')}}', '{{__('你将无法撤销这一操作！')}}', '{{__('确定')}}')
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
