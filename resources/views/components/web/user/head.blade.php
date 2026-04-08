<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">

    <title>{{$title}}</title>

    <link rel="shortcut icon" href="{{web_resource_url('assets/img/favicon.ico')}}'">
    <link rel="apple-touch-icon" href="{{web_resource_url('assets/img/favicon.ico')}}">

    <!-- Theme Settings Js -->
    <script src="{{web_resource_url('assets/admin/js/theme-script.js')}}" type="text/javascript"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/css/bootstrap.min.css')}}">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/swiper/css/swiper-bundle.min.css')}}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/fontawesome/css/all.min.css')}}">
    <link href="{{web_resource_url('assets/web/vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/select2/css/select2.min.css')}}">

    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/slick/slick.css')}}">
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/slick/slick-theme.css')}}">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/feather/feather.css')}}">

    <!-- Aos CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/aos/aos.css')}}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/tabler-icons/tabler-icons.css')}}">

    <!-- Iconsax CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/css/iconsax.css')}}">

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/css/owl.theme.default.min.css')}}">

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/fancybox/jquery.fancybox.min.css')}}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/css/style.css')}}">

    <!-- jQuery -->
    <script src="{{web_resource_url('assets/admin/js/jquery-3.7.1.min.js')}}" type="text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{web_resource_url('assets/admin/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>

    <!-- Select2 JS -->
    <script src="{{web_resource_url('assets/admin/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>

    <!-- Slick Slider -->
    <script src="{{web_resource_url('assets/admin/plugins/slick/slick.js')}}" type="text/javascript"></script>

    <!-- Swiper Slider -->
    <script src="{{web_resource_url('assets/admin/plugins/swiper/js/swiper-bundle.min.js')}}" type="text/javascript"></script>

    <!-- counterup JS -->
    <script src="{{web_resource_url('assets/admin/js/counter.js')}}" type="text/javascript"></script>
    <script src="{{web_resource_url('assets/admin/js/jquery.waypoints.js')}}" type="text/javascript"></script>
    <script src="{{web_resource_url('assets/admin/js/jquery.counterup.min.js')}}" type="text/javascript"></script>

    <!-- Owl Carousel -->
    <script src="{{web_resource_url('assets/admin/js/owl.carousel.min.js')}}" type="text/javascript"></script>

    <!-- Aos -->
    <script src="{{web_resource_url('assets/admin/plugins/aos/aos.js')}}" type="text/javascript"></script>

    <!-- Fancybox JS -->
    <script src="{{web_resource_url('assets/admin/plugins/fancybox/jquery.fancybox.min.js')}}" type="text/javascript"></script>

    <!-- Custom JS -->
    <script src="{{web_resource_url('assets/admin/js/script.js')}}" type="text/javascript"></script>

    <script type="text/javascript" src="{{ web_resource_url('assets/js/lodash.js') }}"></script>
    <script src="{{web_resource_url('assets/js/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{web_resource_url('assets/js/wait-me/waitMe.min.css')}}">
    <link href="{{web_resource_url('assets/js/toastr/toastr.min.css')}}" rel="stylesheet"/>
    <script src="{{web_resource_url('assets/js/toastr/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{ web_resource_url('assets/js/utils.js') }}"></script>


    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=ZCOOL+XiaoWei&family=Baloo+2:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --coral: #FF6B6B;
            --peach: #FFB347;
            --mint: #5ECFA6;
            --sky: #4FC3F7;
            --lavender: #B39DDB;
            --cream: #FFF8F0;
            --deep: #1A2744;
            --mid: #2E4080;
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--cream);
            color: var(--deep);
            overflow-x: hidden;
        }

        /* ─── TOP NAV ─────────────────────────────────────────────── */
        .topnav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
            height: 70px;
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 2px 24px rgba(79, 195, 247, 0.10);
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-bubble {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--coral) 0%, var(--peach) 50%, var(--mint) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: 0 4px 14px rgba(255, 107, 107, 0.35);
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% {
                transform: translateY(0) rotate(-2deg);
            }
            50% {
                transform: translateY(-4px) rotate(2deg);
            }
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .nav-links a {
            text-decoration: none;
            font-size: .85rem;
            font-weight: 700;
            color: var(--deep);
            padding: .45rem .9rem;
            border-radius: 999px;
            transition: background .2s, color .2s;
        }

        .nav-links a:hover {
            background: rgba(94, 207, 166, 0.15);
            color: var(--mint);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .nav-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.7);
            border: 1.5px solid rgba(0, 0, 0, .08);
            color: var(--mid);
            font-size: 1.05rem;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
        }

        .nav-icon:hover {
            transform: scale(1.12);
            box-shadow: 0 4px 14px rgba(79, 195, 247, .3);
        }

        .avatar-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sky), var(--lavender));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            font-size: .9rem;
            cursor: pointer;
            border: none;
            box-shadow: 0 3px 10px rgba(179, 157, 219, .4);
            transition: transform .2s;
        }

        .avatar-btn:hover {
            transform: scale(1.1);
        }

        /* ─── HERO BANNER ─────────────────────────────────────────── */
        .hero {
            margin-top: 70px;
            position: relative;
            min-height: 420px;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        /* Gradient mesh background */
        .hero-bg {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 60% 80% at 15% 50%, rgba(255, 179, 71, .35) 0%, transparent 60%),
            radial-gradient(ellipse 50% 70% at 80% 20%, rgba(79, 195, 247, .4) 0%, transparent 55%),
            radial-gradient(ellipse 55% 60% at 60% 85%, rgba(94, 207, 166, .3) 0%, transparent 55%),
            radial-gradient(ellipse 45% 50% at 35% 10%, rgba(255, 107, 107, .25) 0%, transparent 50%),
            linear-gradient(145deg, #FFF4EC 0%, #E8F7FF 40%, #E6FFF6 70%, #F5EEFF 100%);
        }

        /* Floating blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(0);
            opacity: .18;
        }

        .blob-1 {
            width: 320px;
            height: 320px;
            top: -60px;
            right: 5%;
            background: var(--sky);
            animation: drift1 8s ease-in-out infinite;
        }

        .blob-2 {
            width: 200px;
            height: 200px;
            bottom: -40px;
            right: 22%;
            background: var(--mint);
            animation: drift2 7s ease-in-out infinite;
        }

        .blob-3 {
            width: 160px;
            height: 160px;
            top: 40px;
            right: 32%;
            background: var(--peach);
            animation: drift3 9s ease-in-out infinite;
        }

        @keyframes drift1 {
            0%, 100% {
                transform: translate(0, 0) scale(1)
            }
            50% {
                transform: translate(-20px, 15px) scale(1.05)
            }
        }

        @keyframes drift2 {
            0%, 100% {
                transform: translate(0, 0)
            }
            50% {
                transform: translate(15px, -20px)
            }
        }

        @keyframes drift3 {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg)
            }
            50% {
                transform: translate(-10px, 10px) rotate(8deg)
            }
        }

        /* Stars / sparkles */
        .sparkle {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            opacity: 0;
            animation: twinkle 3s ease-in-out infinite;
        }

        @keyframes twinkle {
            0%, 100% {
                opacity: 0;
                transform: scale(0)
            }
            50% {
                opacity: .7;
                transform: scale(1)
            }
        }

        .sp-1 {
            top: 18%;
            left: 55%;
            background: var(--coral);
            animation-delay: 0s;
        }

        .sp-2 {
            top: 55%;
            left: 62%;
            background: var(--sky);
            animation-delay: .8s;
            width: 6px;
            height: 6px;
        }

        .sp-3 {
            top: 28%;
            left: 74%;
            background: var(--mint);
            animation-delay: 1.4s;
            width: 10px;
            height: 10px;
        }

        .sp-4 {
            top: 70%;
            left: 48%;
            background: var(--peach);
            animation-delay: .4s;
            width: 7px;
            height: 7px;
        }

        .sp-5 {
            top: 12%;
            left: 45%;
            background: var(--lavender);
            animation-delay: 2s;
            width: 9px;
            height: 9px;
        }

        /* Decorative circles outline */
        .ring {
            position: absolute;
            border-radius: 50%;
            border: 2px solid rgba(79, 195, 247, .25);
            animation: ringExpand 6s ease-in-out infinite;
        }

        .ring-1 {
            width: 240px;
            height: 240px;
            top: -80px;
            right: 8%;
        }

        .ring-2 {
            width: 160px;
            height: 160px;
            bottom: -50px;
            right: 26%;
            animation-delay: 2s;
        }

        @keyframes ringExpand {
            0%, 100% {
                transform: scale(1);
                opacity: .3
            }
            50% {
                transform: scale(1.08);
                opacity: .6
            }
        }

        /* Hero content */
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            padding: 3rem 2.5rem;
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .hero-left {
            flex: 1;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(94, 207, 166, .18);
            border: 1.5px solid rgba(94, 207, 166, .4);
            border-radius: 999px;
            padding: .35rem .9rem;
            font-size: .8rem;
            font-weight: 800;
            color: #2E9E7A;
            letter-spacing: .04em;
            margin-bottom: 1.2rem;
            animation: fadeSlideUp .6s ease both;
        }

        .hero-tag::before {
            content: '✦';
            font-size: .7rem;
        }

        .hero-headline {
            font-size: 3rem;
            line-height: 1.2;
            color: var(--deep);
            animation: fadeSlideUp .7s .1s ease both;
        }

        .hero-headline .highlight {
            background: linear-gradient(135deg, var(--coral), var(--peach));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-headline .highlight-b {
            background: linear-gradient(135deg, var(--sky), var(--lavender));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-sub {
            margin-top: .9rem;
            font-size: 1rem;
            line-height: 1.8;
            color: #4A5568;
            max-width: 500px;
            animation: fadeSlideUp .7s .2s ease both;
        }

        .hero-stats {
            display: flex;
            gap: 1.5rem;
            margin-top: 2rem;
            animation: fadeSlideUp .7s .3s ease both;
        }

        .stat-pill {
            background: rgba(255, 255, 255, .75);
            border: 1.5px solid rgba(255, 255, 255, .9);
            border-radius: 16px;
            padding: .7rem 1.2rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, .07);
            text-align: center;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-pill:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(79, 195, 247, .2);
        }

        .stat-num {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1;
        }

        .stat-num.c1 {
            color: var(--coral);
        }

        .stat-num.c2 {
            color: var(--mint);
        }

        .stat-num.c3 {
            color: var(--sky);
        }

        .stat-label {
            font-size: .72rem;
            font-weight: 700;
            color: #718096;
            margin-top: .2rem;
        }

        .hero-ctas {
            display: flex;
            gap: .85rem;
            margin-top: 2rem;
            animation: fadeSlideUp .7s .4s ease both;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--coral) 0%, var(--peach) 100%);
            color: #fff;
            font-weight: 800;
            font-size: .9rem;
            padding: .75rem 1.6rem;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(255, 107, 107, .4);
            transition: transform .2s, box-shadow .2s;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(255, 107, 107, .5);
        }

        .btn-ghost {
            background: rgba(255, 255, 255, .7);
            color: var(--mid);
            font-weight: 800;
            font-size: .9rem;
            padding: .75rem 1.6rem;
            border-radius: 999px;
            border: 1.5px solid rgba(46, 64, 128, .15);
            cursor: pointer;
            backdrop-filter: blur(8px);
            transition: transform .2s, background .2s;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .btn-ghost:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, .95);
        }

        /* Right illustration area */
        .hero-right {
            flex: 0 0 340px;
            position: relative;
            height: 320px;
            animation: fadeSlideRight .8s .2s ease both;
        }

        .illo-card {
            position: absolute;
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(16px);
            border: 1.5px solid rgba(255, 255, 255, .95);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .1);
            padding: 1rem 1.2rem;
            display: flex;
            align-items: center;
            gap: .8rem;
            transition: transform .3s;
        }

        .illo-card:hover {
            transform: scale(1.04);
        }

        .illo-card-icon {
            font-size: 2rem;
        }

        .illo-card-text .label {
            font-size: .7rem;
            font-weight: 700;
            color: #718096;
        }

        .illo-card-text .value {
            font-size: 1rem;
            font-weight: 800;
            color: var(--deep);
            margin-top: .1rem;
        }

        .card-a {
            top: 0;
            left: 0;
            animation: float1 5s ease-in-out infinite;
        }

        .card-b {
            top: 100px;
            right: 0;
            animation: float2 6s ease-in-out infinite;
        }

        .card-c {
            bottom: 0;
            left: 30px;
            animation: float3 5.5s ease-in-out infinite;
        }

        /* Big emoji illustration */
        .big-illo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 7rem;
            user-select: none;
            filter: drop-shadow(0 12px 24px rgba(0, 0, 0, .12));
            animation: bigFloat 4s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes bigFloat {
            0%, 100% {
                transform: translate(-50%, -50%) rotate(-3deg)
            }
            50% {
                transform: translate(-50%, -56%) rotate(3deg)
            }
        }

        @keyframes float1 {
            0%, 100% {
                transform: translateY(0)
            }
            50% {
                transform: translateY(-10px)
            }
        }

        @keyframes float2 {
            0%, 100% {
                transform: translateY(0) rotate(2deg)
            }
            50% {
                transform: translateY(-8px) rotate(-1deg)
            }
        }

        @keyframes float3 {
            0%, 100% {
                transform: translateY(0)
            }
            50% {
                transform: translateY(-12px)
            }
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(22px)
            }
            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes fadeSlideRight {
            from {
                opacity: 0;
                transform: translateX(28px)
            }
            to {
                opacity: 1;
                transform: translateX(0)
            }
        }

        /* ─── PROFILE BANNER ──────────────────────────────────────── */
        /*.profile-banner {*/
        /*  max-width:1200px; margin:2.5rem auto 0;*/
        /*  padding:0 2.5rem;*/
        /*}*/
        .profile-card {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            padding: 2rem 2.5rem;
            background: linear-gradient(135deg, var(--mid) 0%, #1A3A7A 45%, #0D2255 100%);
            box-shadow: 0 12px 48px rgba(26, 39, 68, .35);
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        /* Inner deco shapes */
        .profile-card::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(79, 195, 247, .12);
            pointer-events: none;
        }

        .profile-card::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: 20%;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(94, 207, 166, .1);
            pointer-events: none;
        }

        .profile-dots {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 45%;
            opacity: .07;
            background-image: radial-gradient(circle, #fff 1.5px, transparent 1.5px);
            background-size: 22px 22px;
            pointer-events: none;
        }

        .profile-avatar-wrap {
            position: relative;
            flex-shrink: 0;
            animation: fadeSlideUp .6s ease both;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            border: 3px solid rgba(255, 255, 255, .3);
            box-shadow: 0 6px 24px rgba(0, 0, 0, .2);
        }

        .online-dot {
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--mint);
            border: 3px solid #1A3A7A;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(94, 207, 166, .6)
            }
            50% {
                box-shadow: 0 0 0 8px rgba(94, 207, 166, 0)
            }
        }

        .profile-info {
            flex: 1;
        }

        .profile-greeting {
            font-size: .8rem;
            font-weight: 700;
            color: rgba(255, 255, 255, .55);
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: .25rem;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
            display: flex;
            align-items: center;
            gap: .6rem;
            line-height: 1.1;
        }

        .edit-btn {
            background: rgba(255, 255, 255, .15);
            border: none;
            border-radius: 8px;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: .85rem;
            color: rgba(255, 255, 255, .7);
            transition: background .2s;
        }

        .edit-btn:hover {
            background: rgba(255, 255, 255, .25);
        }

        .profile-role {
            font-size: .85rem;
            color: rgba(255, 255, 255, .6);
            margin-top: .3rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .role-badge {
            background: rgba(94, 207, 166, .25);
            border: 1px solid rgba(94, 207, 166, .4);
            border-radius: 999px;
            padding: .15rem .7rem;
            font-size: .72rem;
            font-weight: 800;
            color: var(--mint);
        }

        /* ─── DASHBOARD CONTENT ───────────────────────────────────── */
        .dash-body {
            max-width: 1200px;
            margin: 2.5rem auto 3rem;
            padding: 0 2.5rem;
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .sidebar {
            flex: 0 0 200px;
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(12px);
            border: 1.5px solid rgba(255, 255, 255, .9);
            border-radius: 24px;
            padding: 1.5rem 1.2rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
        }

        .sidebar-title {
            font-size: .72rem;
            font-weight: 800;
            color: #A0AEC0;
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: .7rem;
            padding: .65rem .8rem;
            border-radius: 14px;
            margin-bottom: .25rem;
            font-weight: 700;
            font-size: .88rem;
            color: #4A5568;
            cursor: pointer;
            transition: background .2s, color .2s;
        }

        .sidebar-item:hover {
            background: rgba(79, 195, 247, .1);
            color: var(--sky);
        }

        .sidebar-item.active {
            background: linear-gradient(135deg, rgba(255, 107, 107, .12), rgba(255, 179, 71, .12));
            color: var(--coral);
        }

        .sidebar-item .s-icon {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        .main-area {
            flex: 1;
        }

        .section-title {
            font-size: 1.1rem;
            color: var(--deep);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, rgba(0, 0, 0, .08), transparent);
        }

        /*.recent-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }*/
        /*.course-card {*/
        /*  background:rgba(255,255,255,.9); border-radius:20px;*/
        /*  overflow:hidden;*/
        /*  border:1.5px solid rgba(255,255,255,.95);*/
        /*  box-shadow:0 4px 20px rgba(0,0,0,.07);*/
        /*  cursor:pointer; transition:transform .25s, box-shadow .25s;*/
        /*}*/
        /*.course-card:hover { transform:translateY(-4px); box-shadow:0 12px 36px rgba(0,0,0,.12); }*/
        /*.course-thumb {*/
        /*  height:120px;*/
        /*  display:flex; align-items:center; justify-content:center;*/
        /*  font-size:3.5rem;*/
        /*}*/
        /*.thumb-a { background:linear-gradient(135deg,#FFD6CC,#FFB3A0); }*/
        /*.thumb-b { background:linear-gradient(135deg,#C8F0E8,#9FE5D3); }*/
        /*.course-info { padding:1rem; }*/
        /*.course-title { font-weight:800; font-size:.9rem; color:var(--deep); margin-bottom:.3rem; }*/
        /*.course-meta { font-size:.75rem; color:#A0AEC0; font-weight:700; display:flex; align-items:center; gap:.4rem; }*/
        /*.progress-bar { height:4px; border-radius:99px; background:#EDF2F7; margin-top:.75rem; overflow:hidden; }*/
        /*.progress-fill { height:100%; border-radius:99px; background:linear-gradient(90deg,var(--coral),var(--peach)); }*/

        /* breadcrumb */
        .breadcrumb {
            font-size: 1.2rem;
            color: #A0AEC0;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: .4rem;
            margin-bottom: 1.5rem;
        }

        .breadcrumb a {
            color: var(--sky);
            text-decoration: none;
        }

        .breadcrumb span {
            color: #CBD5E0;
        }

        .j-user-box {
            background: rgba(255, 255, 255, .85) !important;
            backdrop-filter: blur(12px) !important;
            border: 1.5px solid rgba(255, 255, 255, .9) !important;
            border-radius: 24px !important;
            box-shadow: 0 4px 24px rgba(0, 0, 0, .07) !important;
        }
    </style>
</head>
