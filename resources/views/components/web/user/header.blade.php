<header id="header">
    <section class="bg-top w-full fixed top-0 z-999">
        <div class="container mx-auto">
            <div class="flex justify-between pt-[45px] pb-[42px]">
                <a href="{{route('home')}}">
                    <img class="w-[185px] h-[81px]" src="{{web_resource_url('assets/web/images/logo.png')}}" alt="Jockey Club Bright Start Project">
                </a>
                <div class="hidden lg:flex items-center gap-x-[33px]">
                    <div class="flex flex-col gap-y-3">
                        @auth
                            <div class="dropdown dropdown-hover">
                                <button type="button" class="flex items-center gap-x-2 text-[19px] text-[#998675] font-bold">
                                    <div class="w-10 h-10 bg-white rounded-full overflow-hidden shrink-0">
                                        <img src="{{$user->avatar}}" alt="Img" class="w-full h-full object-cover rounded-full">
                                    </div>
                                    <h6 class="whitespace-nowrap">{{$user->full_name}}</h6>
                                </button>

                                <ul tabindex="-1" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-4 shadow-sm">
                                    @foreach($avatar_menus as $menu)
                                        <li>
                                            <a class="flex items-center gap-x-3 px-0 py-3 text-[19px] font-bold text-[#998675]" href="{{$menu['url']}}" target="{{$menu['target']??'_self'}}">
                                                <img class="w-[20px]" src="{{web_resource_url('assets/web/images/arrow.svg')}}" alt="{{$menu['title']}}">
                                                <span>{{$menu['title']}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="mt-2 border-t border-base-300 pt-2">
                                        <a href="#" class="flex items-center gap-x-3 px-0 py-3 text-[19px] font-bold text-[#998675] logout">
                                            <img class="w-[20px]" src="{{web_resource_url('assets/web/images/arrow.svg')}}" alt="{{__('退出登录')}}">
                                            <span>{{__('退出登录')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <div class="bg-[#43c8d5] px-[45px] rounded-lg">
                                <a class="flex justify-center gap-x-1 text-white text-[21px] font-bold" href="{{route('login.html')}}">
                                    <img class="w-[20px]" src="{{web_resource_url('assets/web/images/login.svg')}}" alt="">
                                    {{__('家长登入')}}
                                </a>
                            </div>
                        @endauth
                        <div class="flex items-center gap-x-3 shrink">
                            <div class="flex justify-between gap-x-1 flex-none w-full">
                                <a href="https://www.facebook.com/JCBrightStartProject">
                                    <img class="h-[20px]" src="{{web_resource_url('assets/web/images/facebook.svg')}}" alt="">
                                </a>
                                <a href="https://www.instagram.com/JCBrightStartProject">
                                    <img class="w-[20px]" src="{{web_resource_url('assets/web/images/instagram.svg')}}" alt="">
                                </a>
                                <a href="https://www.facebook.com/JCBrightStartProject">
                                    <img class="h-[20px]" src="{{web_resource_url('assets/web/images/youtube.svg')}}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="drawer drawer-end lg:hidden w-auto">
                    <input id="header-drawer" type="checkbox" class="drawer-toggle"/>
                    <div class="drawer-content flex items-center">
                        <label for="header-drawer" class="btn btn-ghost btn-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#998675]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </label>
                    </div>
                    <div class="drawer-side z-[999]">
                        <label for="header-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                        <aside class="menu min-h-full w-80 bg-[#fffaf5] text-[#998675] p-6">
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-[22px] font-bold">{{__('Menu')}}</span>
                                <label for="header-drawer" class="btn btn-ghost btn-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#998675]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </label>
                            </div>

                            <ul class="space-y-3">
                                @foreach($avatar_menus as $menu)
                                    <li class="rounded-2xl border border-[#e6ddd2] bg-white/70 shadow-sm overflow-hidden">
                                        <a href="{{$menu['url']}}" class="flex items-center justify-between gap-x-3 px-4 py-3 text-[18px] text-[#998675] font-bold">
                                            <span class="flex items-center gap-x-3">
                                                <span class="s-icon">{{$menu['icon']}}</span>
                                                <span>{{$menu['title']}}</span>
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                                <li class="rounded-2xl border border-[#e6ddd2] bg-white/70 shadow-sm overflow-hidden logout">
                                    <a href="javascript:void(0);" class="flex items-center justify-between gap-x-3 px-4 py-3 text-[18px] text-[#998675] font-bold">
                                        <span class="flex items-center gap-x-3">
                                            <span class="s-icon">👋</span>
                                            <span>{{__('退出登录')}}</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
</header>
@if(($user->is_private_email ?? null) === 0 || ($user->is_first_login ?? null) === 0)
    <dialog id="info-modal" class="modal">
        <div class="modal-box w-11/12 max-w-xl rounded-2xl bg-white">
            <h3 class="mb-6 text-xl font-bold">{{ __('确认信息')}}</h3>

            <form id="info-form" novalidate="novalidate" class="space-y-4">
                <div>
                    <label class="label" for="first_name">
                        <span class="label-text font-medium">
                            {{__('姓')}}
                            <span class="text-error"> *</span>
                        </span>
                    </label>
                    <span id="error-container-first-name"></span>
                    <input type="text" id="first-name" name="first_name" class="input input-bordered w-full" placeholder="{{__('请输入姓')}}" value="{{$user->first_name}}">
                </div>
                <div>
                    <label class="label" for="last-name">
                        <span class="label-text font-medium">
                            {{__('名')}}
                            <span class="text-error"> *</span>
                        </span>
                    </label>
                    <span id="error-container-last-name"></span>
                    <input type="text" id="last-name" name="last_name" class="input input-bordered w-full" placeholder="{{__('请输入名')}}" value="{{$user->last_name}}">
                </div>
                @if($user->is_private_email === 0)
                    <div>
                        <label class="label" for="email">
                            <span class="label-text font-medium">
                                {{__('邮箱')}}
                                <span class="text-error"> * {{__('请输入正确的邮箱，填写后无法修改！')}}</span>
                            </span>
                        </label>
                        <span id="error-container-email"></span>
                        <input type="text" id="email" name="email" class="input input-bordered w-full" placeholder="{{__('请输入邮箱')}}" value="{{$user->email}}">
                    </div>
                @endif

                <div class="modal-action">
                    <button class="btn btn-primary submit" type="submit">{{__('提交')}}</button>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script src="{{web_resource_url('assets/js/validation.js')}}" type="text/javascript"></script>
    <script src="{{web_resource_url('assets/js/just-validate.production.min.js')}}" type="text/javascript"></script>
    <script>
        $(function () {
            let modal = document.getElementById('info-modal');
            if (modal && typeof modal.showModal === 'function' && !modal.open) {
                modal.showModal();
            }

            const validator = new window.JustValidate('#info-form', {
                errorLabelCssClass: 'd-inline',
            });
            validator
                .addField('#first-name', [
                    {
                        rule: 'required',
                        errorMessage: '{{__('请输入姓')}}'
                    }
                ], {
                    errorsContainer: '#error-container-first-name'
                })
                .addField('#last-name', [
                    {
                        rule: 'required',
                        errorMessage: '{{__('请输入名')}}'
                    }
                ], {
                    errorsContainer: '#error-container-last-name'
                })
                @if($user->is_private_email === 0)
                .addField('#email', [
                    {
                        rule: 'required',
                        errorMessage: '{{__('请输入邮箱')}}'
                    }
                ], {
                    errorsContainer: '#error-container-email'
                })
                @endif
                .onSuccess(() => {
                    handleSubmit();
                });

            function handleSubmit() {
                showLoading($('#info-modal'))

                let form = $('#info-form').serializeArray()

                $.ajax({
                    url: '{{route('user.info.confirm.html')}}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form,
                    dataType: "json",
                    success: function (data) {
                        if (data.code !== 0) {
                            showToast('error', data.msg);
                            return;
                        }

                        showToast('success', '{{__('更新成功')}}');
                        modal.close();
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }, error: function () {
                        showToast('error', '{{__('操作失败，请稍后再试！')}}')
                    }, complete: function () {
                        hideLoading($('#info-modal'))
                    }
                });
            }
        });
    </script>
@endif

<x-sweetalert/>
<script>
    $(function () {
        $('body').css('padding-top', $('#header section').outerHeight(true) - 15)
        $(window).on('resize', function () {
            $('body').css('padding-top', $('#header section').outerHeight(true) - 15)
        })

        $('.logout').click(function () {
            confirm_alert('{{__('确定退出吗')}}', '{{__('你将无法撤销这一操作！')}}', '{{__('确定')}}', 'warning', '{{__('取消')}}')
                .then((result) => {
                    if (result.isConfirmed) {
                        showLoading()
                        $.ajax({
                            url: "{{ route('user.logout.html') }}",
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
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
