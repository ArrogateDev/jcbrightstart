@props(['active' => 'dashboard'])
<div class="col-lg-3 theiaStickySidebar">
    <div class="settings-sidebar mb-lg-0">
        <div>
            <h6 class="mb-3">Main Menu</h6>
            <ul class="mb-3 pb-1">
                <li>
                    <a href="{{route('user.dashboard.html')}}" @class(['d-inline-flex align-items-center', 'active' => $active === 'dashboard'])>
                        <i class="isax isax-grid-35 me-2"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{route('user.profile.html')}}" @class(['d-inline-flex align-items-center', 'active' => $active === 'profile'])>
                        <i class="fa-solid fa-user me-2"></i>My Profile
                    </a>
                </li>
                <li>
                    <a href="{{route('user.course.html')}}" @class(['d-inline-flex align-items-center', 'active' => $active === 'course'])>
                        <i class="isax isax-teacher5 me-2"></i>My Courses
                    </a>
                </li>
                <li>
                    <a href="{{route('user.certificate.html')}}" @class(['d-inline-flex align-items-center', 'active' => $active === 'certificate'])>
                        <i class="isax isax-note-215 me-2"></i>My Certificates
                    </a>
                </li>
                <li>
                    <a href="{{route('user.quiz.html')}}" @class(['d-inline-flex align-items-center', 'active' => $active === 'quiz'])>
                        <i class="isax isax-medal-star5 me-2"></i>My Quiz
                    </a>
                </li>
            </ul>
            <hr>
            <h6 class="mb-3">Account Settings</h6>
            <ul>
                <li>
                    <a href="{{route('user.settings.html')}}" @class(['d-inline-flex align-items-center', 'active' => $active === 'settings'])>
                        <i class="isax isax-setting-25 me-2"></i>Settings
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="d-inline-flex align-items-center logout">
                        <i class="isax isax-logout5 me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ web_resource_url('assets/js/sweetalert2.js') }}"></script>
<script>
    $(function () {
        $('.logout').click(function () {
            confirm_alert('Are you sure?', "You won't be able to revert this!", 'Yes, logout!')
                .then((result) => {
                    if (result.isConfirmed) {
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
