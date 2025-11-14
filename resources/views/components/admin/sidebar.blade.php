@props(['active' => 'dashboard'])

<div class="col-lg-3 theiaStickySidebar d-none d-md-block">
    <div class="settings-sidebar mb-lg-0">
        <div>
            @foreach($menus as $menu)
                <h6 class="mb-3">{{__($menu['name'])}}</h6>
                <ul>
                    @foreach($menu['children'] as $item)
                        <li>
                            <a href="{{$item['url']}}" @class(['d-inline-flex align-items-center', 'active' => $active === $item['active']])>
                                <i class="{{$item['icon']}} me-2"></i>{{__($item['name'])}}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <hr>
            @endforeach
            <h6 class="mb-3">{{__('账户设置')}}</h6>
            <ul>
                <li>
                    <a href="{{route('admin.settings.html')}}" @class(['d-inline-flex align-items-center', 'active' => $active === 'settings'])>
                        <i class="isax isax-setting-25 me-2"></i>{{__('设置')}}
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="d-inline-flex align-items-center logout">
                        <i class="isax isax-logout5 me-2"></i>{{__('退出登录')}}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.logout').click(function () {
            confirm_alert('Are you sure?', "You won't be able to revert this!", 'Yes, logout!')
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
                                    window.location.href = '{{route('admin.login.html')}}';
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

    function confirm_alert(title = 'Are you sure?', text = "You won't be able to revert this!", confirmText = 'Yes, Delete!', icon = 'warning') {
        return Swal.fire({
            title,
            text,
            icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmText
        });
    }
</script>
