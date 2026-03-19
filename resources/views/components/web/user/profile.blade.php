@props([
    'user' => null
])
<div class="profile-banner mb-5">
    <div class="profile-card">
        <div class="profile-dots"></div>

        <div class="profile-avatar-wrap">
            <div class="profile-avatar">
                <img src="{{$user->avatar}}" alt="{{$user->full_name}}">
            </div>
            <div class="online-dot"></div>
        </div>

        <div class="profile-info">
            <div class="profile-greeting">歡迎回來</div>
            <div class="profile-name">
                {{$user->full_name}}
                <button class="edit-btn">
                    <a href="{{route('user.settings.html')}}">
                        ✏️
                    </a>
                </button>
            </div>
            <div class="profile-role">
                <span>學員</span>
                <span class="role-badge">Student</span>
            </div>
        </div>
    </div>
</div>
