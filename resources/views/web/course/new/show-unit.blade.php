<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>

<link rel="stylesheet" href="{{web_resource_url('assets/web/vendor/dflip/dflip.min.css')}}">
<script src="{{web_resource_url('assets/web/vendor/dflip/js/dflip.min.js')}}"></script>

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
        min-height: 100vh;
    }

    /* ─── SUBTLE PAGE BG ─────────────────────────────────────── */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        z-index: -1;
        background: radial-gradient(ellipse 55% 40% at 90% 10%, rgba(79, 195, 247, .12) 0%, transparent 60%),
        radial-gradient(ellipse 45% 35% at 5% 80%, rgba(94, 207, 166, .10) 0%, transparent 55%),
        radial-gradient(ellipse 50% 40% at 50% 50%, rgba(255, 179, 71, .07) 0%, transparent 60%),
        linear-gradient(160deg, #FFF8F0 0%, #F0F8FF 50%, #F0FFF8 100%);
    }

    /* ─── PAGE SHELL ─────────────────────────────────────────── */
    .page-wrap {
        max-width: 1400px;
        margin-left: auto;
        margin-right: auto;
        padding: 2rem 2rem 3rem;
    }

    /* ─── BREADCRUMB ─────────────────────────────────────────── */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .8rem;
        font-weight: 700;
        color: #A0AEC0;
        margin-bottom: 1.5rem;
        animation: fadeUp .5s ease both;
    }

    .breadcrumb a {
        color: var(--sky);
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .breadcrumb .sep {
        color: #CBD5E0;
    }

    /* ─── MAIN LAYOUT ────────────────────────────────────────── */
    .main-layout {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 2rem;
        align-items: start;
    }

    .main-layout.quiz-hidden {
        grid-template-columns: 1fr;
    }

    /* ─── LEFT COLUMN ────────────────────────────────────────── */
    .left-column {
        min-width: 0;
        animation: fadeUp .6s ease both;
    }

    /* Video Container */
    .video-container {
        position: relative;
        width: 100%;
        @if($unit->type === 0)
          aspect-ratio: 16 / 9;
        @endif
          border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 16px 56px rgba(26, 39, 68, .28);
        margin-bottom: 2rem;
    }

    .video-container iframe,
    .video-container .video-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .video-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, .6);
        background: radial-gradient(ellipse at center, rgba(79, 195, 247, .15) 0%, transparent 70%);
    }

    .video-placeholder svg {
        width: 80px;
        height: 80px;
        margin-bottom: 1.5rem;
        opacity: .8;
    }

    .video-title {
        font-family: 'Baloo 2', cursive;
        font-size: 1.5rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: .5rem;
    }

    .video-subtitle {
        font-size: .9rem;
        color: rgba(255, 255, 255, .5);
    }

    /* Course Info Card */
    .course-info-card {
        background: rgba(255, 255, 255, .88);
        backdrop-filter: blur(12px);
        border: 1.5px solid rgba(255, 255, 255, .95);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
        animation: fadeUp .6s .1s ease both;
    }

    .info-header {
        display: flex;
        align-items: flex-start;
        gap: 1.2rem;
        margin-bottom: 1.5rem;
    }

    .info-icon-box {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(255, 107, 107, .15), rgba(255, 179, 71, .15));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        flex-shrink: 0;
    }

    .info-title-block {
        flex: 1;
    }

    .info-tag {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: rgba(94, 207, 166, .2);
        border: 1px solid rgba(94, 207, 166, .4);
        border-radius: 999px;
        padding: .25rem .8rem;
        font-size: .72rem;
        font-weight: 800;
        color: var(--mint);
        letter-spacing: .05em;
        margin-bottom: .75rem;
    }

    .info-tag::before {
        content: '✦';
        font-size: .6rem;
    }

    .info-title {
        font-family: 'ZCOOL XiaoWei', serif;
        font-size: 1.8rem;
        color: var(--deep);
        line-height: 1.3;
        margin-bottom: .5rem;
    }

    .info-meta {
        display: flex;
        align-items: center;
        gap: 1.2rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .85rem;
        font-weight: 700;
        color: #A0AEC0;
    }

    .meta-item svg {
        width: 16px;
        height: 16px;
    }

    .info-description {
        font-size: .95rem;
        line-height: 1.9;
        color: #4A5568;
        padding-left: 1.2rem;
        border-left: 3px solid var(--mint);
        background: rgba(94, 207, 166, .05);
        border-radius: 0 12px 12px 0;
        padding: 1.2rem 1.2rem 1.2rem 1.5rem;
    }

    /* Navigation Footer */
    .nav-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1.5px solid rgba(0, 0, 0, .05);
    }

    .nav-btn {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .7rem 1.4rem;
        border-radius: 12px;
        font-size: .9rem;
        font-weight: 800;
        text-decoration: none;
        transition: all .2s;
        cursor: pointer;
        border: none;
    }

    .nav-btn.secondary {
        background: rgba(160, 174, 192, .12);
        color: #A0AEC0;
        cursor: no-drop;
    }

    .nav-btn.secondary:hover {
        background: rgba(160, 174, 192, .2);
        transform: translateX(-4px);
        cursor: no-drop;
    }

    .nav-btn.primary {
        background: linear-gradient(135deg, var(--sky), var(--lavender));
        color: #fff;
        box-shadow: 0 4px 14px rgba(79, 195, 247, .3);
    }

    .nav-btn.primary:hover {
        transform: translateX(4px);
        box-shadow: 0 6px 20px rgba(79, 195, 247, .4);
    }

    /* ─── RIGHT COLUMN (QUIZ) ────────────────────────────────── */
    .right-column {
        position: sticky;
        top: 90px;
        animation: fadeUp .6s .15s ease both;
        transition: all .3s ease;
    }

    .right-column.hidden {
        display: none;
    }

    .quiz-card {
        background: rgba(255, 255, 255, .88);
        backdrop-filter: blur(12px);
        border: 1.5px solid rgba(255, 255, 255, .95);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
        position: relative;
    }

    .quiz-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .quiz-title {
        display: flex;
        align-items: center;
        gap: .7rem;
    }

    .quiz-icon {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(179, 157, 219, .2), rgba(79, 195, 247, .12));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .quiz-label {
        font-family: 'ZCOOL XiaoWei', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--deep);
    }

    .collapse-btn {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: rgba(160, 174, 192, .12);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #A0AEC0;
        cursor: pointer;
        transition: all .2s;
    }

    .collapse-btn:hover {
        background: rgba(160, 174, 192, .2);
        color: var(--deep);
    }

    .quiz-progress {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1.5px solid rgba(0, 0, 0, .05);
    }

    .quiz-progress-bar {
        flex: 1;
        height: 6px;
        background: rgba(160, 174, 192, .15);
        border-radius: 99px;
        overflow: hidden;
    }

    .quiz-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--mint), var(--sky));
        border-radius: 99px;
        transition: width .5s ease;
    }

    .quiz-progress-text {
        font-family: 'Baloo 2', cursive;
        font-size: .8rem;
        font-weight: 800;
        color: var(--deep);
        min-width: 60px;
        text-align: right;
    }

    .quiz-question {
        margin-bottom: 1.5rem;
    }

    .question-text {
        font-size: 1rem;
        font-weight: 700;
        color: var(--deep);
        line-height: 1.6;
        margin-bottom: 1.2rem;
    }

    .options-list {
        display: flex;
        flex-direction: column;
        gap: .75rem;
    }

    .option-item {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1rem 1.2rem;
        border-radius: 14px;
        background: rgba(255, 255, 255, .6);
        border: 1.5px solid rgba(0, 0, 0, .05);
        cursor: pointer;
        transition: all .2s;
        position: relative;
    }

    .option-item:hover {
        background: rgba(255, 255, 255, .95);
        border-color: rgba(79, 195, 247, .3);
        transform: translateX(4px);
    }

    .option-item.selected {
        background: rgba(79, 195, 247, .12);
        border-color: var(--sky);
    }

    .option-item.correct {
        background: rgba(94, 207, 166, .15);
        border-color: var(--mint);
    }

    .option-item.incorrect {
        background: rgba(255, 107, 107, .12);
        border-color: var(--coral);
    }

    .option-marker {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #CBD5E0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all .2s;
    }

    .option-item.selected .option-marker {
        border-color: var(--sky);
        background: var(--sky);
    }

    .option-item.correct .option-marker {
        border-color: var(--mint);
        background: var(--mint);
        color: green;
    }

    .option-item.incorrect .option-marker {
        border-color: var(--coral);
        background: var(--coral);
        color: red;
    }

    .check-icon, .cross-icon {
        width: 14px;
        height: 14px;
        color: #fff;
    }

    .option-text {
        flex: 1;
        font-size: .95rem;
        font-weight: 600;
        color: #4A5568;
        line-height: 1.5;
    }

    .quiz-feedback {
        padding: 1.2rem;
        border-radius: 14px;
        margin-bottom: 1.5rem;
        display: none;
    }

    .quiz-feedback.show {
        display: block;
        animation: fadeUp .3s ease both;
    }

    .quiz-feedback.correct {
        background: rgba(94, 207, 166, .1);
        border: 1.5px solid rgba(94, 207, 166, .3);
    }

    .quiz-feedback.incorrect {
        background: rgba(255, 107, 107, .1);
        border: 1.5px solid rgba(255, 107, 107, .3);
    }

    .feedback-title {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .9rem;
        font-weight: 800;
        margin-bottom: .5rem;
    }

    .feedback-title.correct {
        color: var(--mint);
    }

    .feedback-title.incorrect {
        color: var(--coral);
    }

    .feedback-text {
        font-size: .85rem;
        line-height: 1.7;
        color: #4A5568;
    }

    .quiz-actions {
        display: flex;
        gap: 1rem;
    }

    .btn {
        flex: 1;
        padding: .85rem 1.5rem;
        border-radius: 12px;
        font-size: .9rem;
        font-weight: 800;
        cursor: pointer;
        transition: all .2s;
        border: none;
        text-align: center;
    }

    .btn:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .btn-outline {
        background: transparent;
        border: 1.5px solid #CBD5E0;
        color: #A0AEC0;
    }

    .btn-outline:hover:not(:disabled) {
        border-color: var(--deep);
        color: var(--deep);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--sky), var(--lavender));
        color: #fff;
        box-shadow: 0 4px 14px rgba(79, 195, 247, .25);
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 195, 247, .35);
    }

    /* ─── RESPONSIVE ─────────────────────────────────────────── */
    @media (max-width: 1024px) {
        .main-layout {
            grid-template-columns: 1fr;
        }

        .right-column {
            position: static;
        }

        .quiz-card {
            margin-top: 2rem;
        }
    }

    @media (max-width: 768px) {
        .page-wrap {
            padding: 1.5rem 1.25rem 2rem;
        }

        .course-info-card,
        .quiz-card {
            padding: 1.5rem;
        }

        .info-title {
            font-size: 1.4rem;
        }

    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(18px)
        }
        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    #btn-quiz {
        top: 10px;
        right: 10px;
        padding: 2px 12px !important;
        cursor: pointer;
        pointer-events: auto;
        z-index: 100;
        display: none;
        font-size: 32px;
    }

    #btn-quiz.show {
        display: block !important;
        animation: fadeUp .3s ease both;
    }

    .current-sep {
        max-width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <div class="content pt-0">
        <div class="container">

            <div class="page-wrap">

                <div class="breadcrumb">
                    <a href="{{route('user.dashboard.html')}}">{{__('首页')}}</a>
                    <span class="sep">›</span>
                    <a class="current-sep" href="{{route('course.details.html', ['course'=>$course->id])}}">{{$course->title}}</a>
                    <span class="sep">›</span>
                    <span>{{$unit->title}}</span>
                </div>

                <div class="course-info-card">
                    <div class="info-header">
                        <div class="info-title-block">
                            <div class="info-tag">{{__('章节')}} {{$current_index + 1}} of {{$total_index}}</div>
                            <h1 class="info-title">{{$unit->title}}</h1>
                            <div class="info-meta">
                                <div class="meta-item">
                                    @if($unit->type === 0)
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="23 7 16 12 23 17 23 7"/>
                                            <rect x="1" y="5" width="15" height="14" rx="2"/>
                                        </svg>
                                    @else
                                        <svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="12" height="12">
                                            <path
                                                d="M905.185809 178.844158C898.576738 172.685485 891.19337 165.824412 883.21687 158.436127 860.422682 137.322863 837.434925 116.207791 815.697647 96.487895 813.243072 94.261877 813.243072 94.261877 810.786411 92.037081 781.783552 65.781062 757.590948 44.376502 739.713617 29.293612 729.254178 20.469111 721.020606 13.860686 714.970549 9.501727 710.955023 6.608611 707.690543 4.524745 704.47155 2.998714 700.417679 1.07689 696.638044-0.094029 691.307277 0.005928 677.045677 0.273349 665.6 11.769337 665.6 26.182727L665.6 77.352844 665.6 128.522961 665.6 230.863194 665.6 256.448252 691.2 256.448252 896 256.448252 870.4 230.863194 870.4 998.414942 896 972.829884 230.381436 972.829884C187.90385 972.829884 153.6 938.623723 153.6 896.20663L153.6 26.182727 128 51.767786 588.8 51.767786C602.93849 51.767786 614.4 40.312965 614.4 26.182727 614.4 12.05249 602.93849 0.597669 588.8 0.597669L128 0.597669 102.4 0.597669 102.4 26.182727 102.4 896.20663C102.4 966.91021 159.652833 1024 230.381436 1024L896 1024 921.6 1024 921.6 998.414942 921.6 230.863194 921.6 205.278135 896 205.278135 691.2 205.278135 716.8 230.863194 716.8 128.522961 716.8 77.352844 716.8 26.182727C716.8 39.813762 705.748075 50.91427 692.267725 51.167041 687.705707 51.252584 685.069822 50.435995 682.52845 49.231204 682.259458 49.103682 683.344977 49.796618 685.029451 51.010252 689.779394 54.432502 697.145822 60.34494 706.686383 68.394196 724.009052 83.009121 747.816448 104.072869 776.413589 129.961594 778.850014 132.168064 778.850014 132.168064 781.285216 134.376514 802.876774 153.964212 825.739479 174.96442 848.413564 195.966437 856.350957 203.3185 863.697005 210.144893 870.269888 216.269843 874.209847 219.941299 877.019309 222.565641 878.499674 223.951409 888.81866 233.610931 905.019017 233.081212 914.684179 222.768247 924.349344 212.455283 923.819315 196.264383 913.500326 186.604861 911.981323 185.182945 909.155025 182.542876 905.185809 178.844158ZM102.4 461.128719 0 461.128719 0 896.074709 512 896.074709 1024 896.074709 1024 461.128719 153.6 461.128719 153.6 460.531049 102.4 460.531049 102.4 461.128719ZM208.2 711 208.2 819.2 157.6 819.2 157.6 528 269 528C301.533495 528 327.366571 536.466581 346.5 553.4 365.633429 570.333419 375.2 592.733195 375.2 620.6 375.2 649.133476 365.833427 671.333254 347.1 687.2 328.366573 703.066746 302.133502 711 268.4 711L208.2 711ZM208.2 670.4 269 670.4C287.00009 670.4 300.733286 666.166709 310.2 657.7 319.666714 649.233291 324.4 637.000079 324.4 621 324.4 605.266588 319.600047 592.700047 310 583.3 300.399951 573.899953 287.200083 569.066669 270.4 568.8L208.2 568.8 208.2 670.4ZM419.4 819.2 419.4 528 505.4 528C531.133461 528 553.966566 533.733276 573.9 545.2 593.833434 556.666724 609.266611 572.933229 620.2 594 631.133389 615.066771 636.6 639.199863 636.6 666.4L636.6 681C636.6 708.600139 631.100055 732.866562 620.1 753.8 609.099945 774.733438 593.433436 790.866609 573.1 802.2 552.766564 813.533391 529.466799 819.2 503.2 819.2L419.4 819.2ZM470 568.8 470 778.8 503 778.8C529.533466 778.8 549.89993 770.500083 564.1 753.9 578.30007 737.299917 585.533331 713.466822 585.8 682.4L585.8 666.2C585.8 634.599842 578.933402 610.46675 565.2 593.8 551.466598 577.13325 531.533463 568.8 505.4 568.8L470 568.8ZM854.8 695.8 737.6 695.8 737.6 819.2 687 819.2 687 528 872 528 872 568.8 737.6 568.8 737.6 655.4 854.8 655.4 854.8 695.8Z"
                                                fill="#5E5E5E"></path>
                                        </svg>
                                    @endif
                                    <span>{{__($unit->type === 0?'影片课程':'PDF课程')}}</span>
                                </div>
                                <div class="meta-item">
                                    @if($play_record && $play_record->status === 2)
                                        <div class="status-chip done" id="playStatusChip">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5ECFA6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"/>
                                                <polyline points="8 12 11 15 16 9"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="status-chip pending" id="playStatusChip">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#A0AEC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"/>
                                            </svg>
                                        </div>
                                    @endif
                                    @if($play_record && $play_record->status === 1)
                                        <span id="playStatusText">{{__('已观看')}}</span>
                                    @elseif($play_record && $play_record->status === 2)
                                        <span id="playStatusText">{{__('已完成')}}</span>
                                    @else
                                        <span id="playStatusText">{{__('未观看')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($unit->description))
                        <div class="info-description">
                            <p>{!! $unit->description !!}</p>
                        </div>
                    @endif
                </div>

                <!-- Main Layout -->
                <div class="main-layout quiz-hidden" id="mainLayout">

                    <!-- Left Column -->
                    <div class="left-column">

                        <!-- Video Container -->
                        <div class="video-container">
                            <div id="btn-quiz" class="position-absolute alert alert-warning show" onclick="toggleQuiz()">{{__('进入测验')}}</div>

                            <div id="play-content">
                                @if($unit->type === 0)

                                    @include('web.course.new.components.play-video')
                                @else
                                    @include('web.course.new.components.play-pdf')
                                @endif
                            </div>
                            <div id="play-loading" class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                <div class="spinner-border text-white" role="status">
                                    <span class="sr-only">{{__('加载中...')}}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="nav-footer">
                            <a href="{{$prev ? route('course.unit.details.html', ['course' => $unit->course_id, 'unit' => $prev]) : 'javascript:;' }}" @class(['nav-btn', 'primary' => $prev, 'secondary' => !$prev])>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="15 18 9 12 15 6"/>
                                </svg>
                                {{__('上一单元')}}
                            </a>

                            <a href="{{$next ? route('course.unit.details.html', ['course' => $unit->course_id, 'unit' => $next]) : 'javascript:;' }}" @class(['nav-btn', 'primary' => $next, 'secondary' => !$next])>
                                {{__('下一单元')}}
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </a>
                        </div>

                    </div>

                    <!-- Right Column (Quiz) -->
                    <div class="right-column hidden" id="rightColumn">
                        @include('web.course.new.components.quiz')
                    </div>
                </div>

            </div>
        </div>

    </div>

    <x-web.user.footer/>

</div>
</body>

<script>
    // 供测验完成后即时更新“观看/完成”状态
    window.setPlayRecordStatus = function (newStatus) {
        const status = parseInt(newStatus || 0, 10);
        const $chip = $('#playStatusChip');
        const $text = $('#playStatusText');
        if (!$chip.length || !$text.length) return;

        const doneSvg = `
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5ECFA6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="8 12 11 15 16 9"/>
            </svg>
        `;
        const pendingSvg = `
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#A0AEC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
            </svg>
        `;

        if (status === 2) {
            $chip.removeClass('pending').addClass('done').html(doneSvg);
            $text.text('{{__('已完成')}}');
        } else if (status === 1) {
            $chip.removeClass('done').addClass('pending').html(pendingSvg);
            $text.text('{{__('已观看')}}');
        } else {
            $chip.removeClass('done').addClass('pending').html(pendingSvg);
            $text.text('{{__('未观看')}}');
        }
    };
</script>

<script>
    $(function () {
        let currentUnitId = null;
        let currentChapterId = null;
        let status = 0;

        /**
         * 播放策略映射
         */
        const playStrategies = {
            0: (unit, position) => window.playVideo?.(unit, position),
            1: (unit, position) => window.playPdf?.(unit, position)
        };

        /**
         * 播放单元内容
         */
        function playUnit(unit, position = 0) {
            const playStrategy = playStrategies[unit.type];

            if (playStrategy) {
                playStrategy(unit, position);
            } else {
                $('#play-content').html('<div class="alert alert-warning text-center">{{__("该单元暂无内容")}}</div>');
                $('#play-loading').removeClass('d-flex').addClass('d-none');
            }
        }

        /**
         * 清理播放器
         */
        function clearPlay() {
            if (typeof window.clearVideo === 'function') {
                window.clearVideo();
            }
            if (typeof window.clearPdf === 'function') {
                window.clearPdf();
            }
        }

        /**
         * 获取当前播放位置
         */
        function getCurrentPlayPosition() {
            if (typeof window.videoGetCurrentPosition === 'function') {
                const videoPos = window.videoGetCurrentPosition();
                if (videoPos > 0) return videoPos;
            }
            if (typeof window.getPdfPageCount === 'function') {
                return window.getPdfPageCount();
            }
            return 0;
        }

        /**
         * 记录播放开始
         */
        function recordPlayStart(chapterId, unitId) {
            if (status > 0) return;
            $.ajax({
                url: '{{route('course.play-start.html', ['course' => $course->id])}}',
                type: 'POST',
                data: {
                    chapter_id: chapterId,
                    unit_id: unitId,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json'
            });
        }

        /**
         * 保存播放记录
         */
        function savePlayRecord(chapterId, unitId, playPosition) {
            if (status > 0) return;
            $.ajax({
                url: '{{route('course.save-play-record.html', ['course' => $course->id])}}',
                type: 'POST',
                data: {
                    chapter_id: chapterId,
                    unit_id: unitId,
                    play_position: playPosition || 0,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json'
            });
        }

        /**
         * 记录播放结束
         */
        function recordPlayEnd(chapterId, unitId, playPosition) {
            $.ajax({
                url: '{{route('course.play-end.html', ['course' => $course->id])}}',
                type: 'POST',
                data: {
                    chapter_id: chapterId,
                    unit_id: unitId,
                    play_position: playPosition || 0,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.code !== 0) {
                        showToast('error', response.msg);
                        return;
                    }

                    if (typeof window.updateUnitStatus === 'function') {
                        window.updateUnitStatus(unitId, 1);
                    }

                    const quiz = response.data.quiz;
                    const params = {
                        course: {{$course->id}},
                        chapter: chapterId,
                        unit: unitId,
                        quiz: quiz,
                    };

                    // 直接打开测验面板
                    if (typeof window.openQuiz === 'function') {
                        window.openQuiz(params);
                    }
                }
            });
        }

        // 页面加载时初始化
        $(document).ready(function () {
            const info = {!! json_encode($unit) !!};
            if (info) {
                currentUnitId = info.id;
                currentChapterId = info.chapter_id;
                const position = info.play_position || 0;
                playUnit(info, position);
            }
        });

        // 页面离开前保存播放进度
        $(window).on('beforeunload', function () {
            const currentUnit = typeof window.getVideoCurrentUnit === 'function' ? window.getVideoCurrentUnit() : null;
            const currentChapter = typeof window.getVideoCurrentChapter === 'function' ? window.getVideoCurrentChapter() : null;

            const pdfUnit = typeof window.getPdfCurrentUnit === 'function' ? window.getPdfCurrentUnit() : null;
            const pdfChapter = typeof window.getPdfCurrentChapter === 'function' ? window.getPdfCurrentChapter() : null;

            if (currentUnit && currentChapter) {
                const playPosition = getCurrentPlayPosition();
                savePlayRecord(currentChapter, currentUnit, playPosition);
            } else if (pdfUnit && pdfChapter) {
                const playPosition = getCurrentPlayPosition();
                savePlayRecord(pdfChapter, pdfUnit, playPosition);
            }
        });

        /**
         * 跨标签页更新单元状态
         */
        function updateUnitStatus(unitId, newStatus, isAllCompleted = false) {
            const message = {
                type: 'UPDATE_UNIT_STATUS',
                unitId: unitId,
                newStatus: newStatus,
                isAllCompleted: isAllCompleted
            };

            try {
                const channel = new BroadcastChannel('course_updates');
                channel.postMessage(message);
                channel.close();
            } catch (e) {
                console.error('✗ Failed to send via BroadcastChannel:', e);
            }
        }

        window.updateUnitStatus = updateUnitStatus;

        window.savePlayRecord = savePlayRecord;
        window.recordPlayEnd = recordPlayEnd;
        window.recordPlayStart = recordPlayStart;
    });
</script>
</html>
