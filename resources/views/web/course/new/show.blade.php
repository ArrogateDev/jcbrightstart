<!DOCTYPE html>
<html lang="en">

<x-web.user.head/>

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

    /* ─── COURSE HERO ────────────────────────────────────────── */
    .course-hero {
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, var(--mid) 0%, #1A3A7A 45%, #0D2255 100%);
        padding: 2.5rem 3rem;
        display: flex;
        align-items: center;
        gap: 2.5rem;
        box-shadow: 0 16px 56px rgba(26, 39, 68, .28);
        animation: fadeUp .55s ease both;
    }

    .course-hero::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 340px;
        height: 340px;
        border-radius: 50%;
        background: rgba(79, 195, 247, .12);
        pointer-events: none;
    }

    .course-hero::after {
        content: '';
        position: absolute;
        bottom: -60px;
        right: 18%;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(94, 207, 166, .09);
        pointer-events: none;
    }

    .hero-dot-grid {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        width: 40%;
        background-image: radial-gradient(circle, rgba(255, 255, 255, .08) 1.5px, transparent 1.5px);
        background-size: 22px 22px;
        pointer-events: none;
    }

    .course-hero-icon {
        flex-shrink: 0;
        width: 90px;
        height: 90px;
        border-radius: 24px;
        background: linear-gradient(135deg, rgba(255, 107, 107, .3), rgba(255, 179, 71, .3));
        border: 2px solid rgba(255, 255, 255, .2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        position: relative;
        z-index: 1;
        box-shadow: 0 8px 32px rgba(0, 0, 0, .2);
        animation: iconBounce 4s ease-in-out infinite;
    }

    @keyframes iconBounce {
        0%, 100% {
            transform: translateY(0) rotate(-3deg)
        }
        50% {
            transform: translateY(-6px) rotate(3deg)
        }
    }

    .course-hero-info {
        flex: 1;
        position: relative;
        z-index: 1;
    }

    .course-tag {
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

    .course-tag::before {
        content: '✦';
        font-size: .6rem;
    }

    .course-hero-title {
        font-family: 'ZCOOL XiaoWei', serif;
        font-size: 2rem;
        color: #fff;
        line-height: 1.3;
        margin-bottom: .6rem;
    }

    .course-hero-title em {
        font-style: normal;
        background: linear-gradient(135deg, var(--coral), var(--peach));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .course-hero-meta {
        display: flex;
        align-items: center;
        gap: 1.2rem;
        flex-wrap: wrap;
    }

    .meta-chip {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .8rem;
        font-weight: 700;
        color: rgba(255, 255, 255, .65);
    }

    .meta-chip .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--sky);
    }

    .course-hero-progress {
        flex-shrink: 0;
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .ring-chart {
        width: 90px;
        height: 90px;
        position: relative;
    }

    .ring-chart svg {
        transform: rotate(-90deg);
    }

    .ring-chart .track {
        fill: none;
        stroke: rgba(255, 255, 255, .1);
        stroke-width: 8;
    }

    .ring-chart .fill {
        fill: none;
        stroke: url(#pg);
        stroke-width: 8;
        stroke-linecap: round;
        stroke-dasharray: 220;
        stroke-dashoffset: calc(220 - ({{ $progress }}         / 100 * 220));
        transition: stroke-dashoffset 1s ease;
    }

    .ring-label {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .ring-pct {
        font-family: 'Baloo 2', cursive;
        font-size: 1.2rem;
        font-weight: 800;
        color: #fff;
        line-height: 1;
    }

    .ring-sub {
        font-size: .55rem;
        font-weight: 700;
        color: rgba(255, 255, 255, .5);
        margin-top: .1rem;
    }

    /* ─── OVERVIEW CARD ──────────────────────────────────────── */
    .overview-card {
        background: rgba(255, 255, 255, .88);
        backdrop-filter: blur(12px);
        border: 1.5px solid rgba(255, 255, 255, .95);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
        animation: fadeUp .6s .05s ease both;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: .8rem;
        margin-bottom: 1.2rem;
    }

    .section-header-icon {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .icon-orange {
        background: linear-gradient(135deg, rgba(255, 107, 107, .15), rgba(255, 179, 71, .15));
    }

    .icon-blue {
        background: linear-gradient(135deg, rgba(79, 195, 247, .15), rgba(179, 157, 219, .15));
    }

    .section-label {
        font-family: 'ZCOOL XiaoWei', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--deep);
    }

    .section-count {
        margin-left: auto;
        font-family: 'Baloo 2', cursive;
        font-size: .85rem;
        font-weight: 800;
        color: var(--sky);
        background: rgba(79, 195, 247, .12);
        border-radius: 999px;
        padding: .2rem .8rem;
    }

    .overview-text {
        font-size: .9rem;
        line-height: 1.9;
        color: #4A5568;
        border-left: 3px solid var(--mint);
        background: rgba(94, 207, 166, .05);
        border-radius: 0 12px 12px 0;
        padding: 1rem 1rem 1rem 1.2rem;
    }

    /* ─── CURRICULUM CARD ────────────────────────────────────── */
    .curriculum-card {
        background: rgba(255, 255, 255, .88);
        backdrop-filter: blur(12px);
        border: 1.5px solid rgba(255, 255, 255, .95);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, .07);
        animation: fadeUp .6s .1s ease both;
    }

    /* Level accordion */
    .level-block {
        margin-bottom: 1rem;
    }

    .level-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .9rem 1.2rem;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(46, 64, 128, .08), rgba(79, 195, 247, .08));
        border: 1.5px solid rgba(79, 195, 247, .15);
        cursor: pointer;
        user-select: none;
        transition: background .2s, box-shadow .2s;
    }

    .level-header:hover {
        background: linear-gradient(135deg, rgba(46, 64, 128, .13), rgba(79, 195, 247, .13));
        box-shadow: 0 4px 16px rgba(79, 195, 247, .12);
    }

    .level-header.open {
        background: linear-gradient(135deg, rgba(46, 64, 128, .14), rgba(79, 195, 247, .14));
        border-color: rgba(79, 195, 247, .35);
    }

    .level-left {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .level-badge {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--sky), var(--lavender));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .75rem;
        font-weight: 800;
        color: #fff;
        box-shadow: 0 3px 10px rgba(79, 195, 247, .35);
    }

    .level-name {
        font-weight: 800;
        font-size: .95rem;
        color: var(--deep);
    }

    .level-right {
        display: flex;
        align-items: center;
        gap: .8rem;
    }

    .level-meta {
        font-size: .75rem;
        font-weight: 700;
        color: #A0AEC0;
    }

    .chevron {
        color: var(--sky);
        transition: transform .3s;
        flex-shrink: 0;
    }

    .level-header.open .chevron {
        transform: rotate(180deg);
    }

    .lesson-sub svg {
        vertical-align: middle;
        opacity: .55;
    }

    /* Lesson list */
    .lesson-list {
        overflow: hidden;
        max-height: 0;
        transition: max-height .4s ease;
    }

    .lesson-list.open {
        max-height: 900px;
    }

    .lesson-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: .85rem 1rem .85rem 1.2rem;
        border-radius: 14px;
        margin-top: .5rem;
        background: rgba(255, 255, 255, .6);
        border: 1.5px solid rgba(0, 0, 0, .05);
        cursor: pointer;
        transition: background .2s, transform .2s, box-shadow .2s;
        position: relative;
        overflow: hidden;
    }

    .lesson-row::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        border-radius: 99px;
        background: transparent;
        transition: background .2s;
    }

    .lesson-row:hover {
        background: rgba(255, 255, 255, .95);
        transform: translateX(4px);
        box-shadow: 0 4px 18px rgba(0, 0, 0, .08);
    }

    .lesson-row:hover::before {
        background: var(--coral);
    }

    .lesson-row.done::before {
        background: var(--mint);
    }

    .lesson-row.done {
        background: rgba(94, 207, 166, .06);
    }

    .play-btn {
        flex-shrink: 0;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        transition: transform .2s, box-shadow .2s;
    }

    .play-btn.done {
        background: linear-gradient(135deg, rgba(94, 207, 166, .2), rgba(94, 207, 166, .1));
    }

    .play-btn.ready {
        background: linear-gradient(135deg, rgba(255, 107, 107, .18), rgba(255, 179, 71, .18));
    }

    .play-btn.lock {
        background: rgba(160, 174, 192, .1);
    }

    .lesson-row:hover .play-btn {
        transform: scale(1.12);
        box-shadow: 0 4px 14px rgba(255, 107, 107, .25);
    }

    .lesson-info {
        flex: 1;
        min-width: 0;
    }

    .lesson-title {
        font-weight: 800;
        font-size: .9rem;
        color: var(--deep);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .lesson-sub {
        font-size: .73rem;
        color: #A0AEC0;
        font-weight: 700;
        margin-top: .15rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .lesson-actions {
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-shrink: 0;
    }

    .open-btn {
        font-size: .78rem;
        font-weight: 800;
        color: var(--sky);
        background: rgba(79, 195, 247, .1);
        border: 1px solid rgba(79, 195, 247, .25);
        border-radius: 999px;
        padding: .3rem .85rem;
        cursor: pointer;
        transition: background .2s, transform .2s;
        text-decoration: none;
        display: inline-block;
    }

    .open-btn:hover {
        background: rgba(79, 195, 247, .2);
        transform: scale(1.04);
    }

    .status-chip {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .85rem;
    }

    .status-chip.done {
        background: rgba(94, 207, 166, .15);
    }

    .status-chip.pending {
        background: rgba(160, 174, 192, .1);
    }

    /* Topic icons mapping */
    .ti-nutrition {
        background: linear-gradient(135deg, #FFD6CC, #FFB3A0);
    }

    .ti-social {
        background: linear-gradient(135deg, #FFE4B3, #FFD080);
    }

    .ti-parenting {
        background: linear-gradient(135deg, #D0F5E8, #A0EDD0);
    }

    .ti-listening {
        background: linear-gradient(135deg, #C8E8FF, #A0D4FF);
    }

    .ti-cognitive {
        background: linear-gradient(135deg, #E8D5FF, #CEB3FF);
    }

    .ti-motor {
        background: linear-gradient(135deg, #FFD6F0, #FFB3E0);
    }

    .ti-extra {
        background: linear-gradient(135deg, #D0F0FF, #A0E0FF);
    }

    /* ─── QUICK STATS ROW ────────────────────────────────────── */
    .stats-row {
        display: grid;
        grid-template-columns:repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
        animation: fadeUp .6s 0s ease both;
    }

    .stat-card {
        background: rgba(255, 255, 255, .88);
        backdrop-filter: blur(12px);
        border: 1.5px solid rgba(255, 255, 255, .95);
        border-radius: 20px;
        padding: 1.2rem 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .07);
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 32px rgba(0, 0, 0, .1);
    }

    .stat-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .sb-coral {
        background: linear-gradient(135deg, rgba(255, 107, 107, .15), rgba(255, 179, 71, .15));
    }

    .sb-mint {
        background: linear-gradient(135deg, rgba(94, 207, 166, .15), rgba(79, 195, 247, .15));
    }

    .sb-lavender {
        background: linear-gradient(135deg, rgba(179, 157, 219, .2), rgba(79, 195, 247, .12));
    }

    .stat-info .num {
        font-family: 'Baloo 2', cursive;
        font-size: 1.7rem;
        font-weight: 800;
        line-height: 1;
    }

    .nc {
        color: var(--coral);
    }

    .nm {
        color: var(--mint);
    }

    .nl {
        color: var(--lavender);
    }

    .stat-info .lbl {
        font-size: .72rem;
        font-weight: 700;
        color: #A0AEC0;
        margin-top: .15rem;
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
</style>

<body>

<div class="main-wrapper">

    <x-web.user.header :user="$user"/>

    <div class="content">
        <div class="container">

            <!-- Course Hero -->
            <div class="course-hero">
                <div class="hero-dot-grid"></div>
                <div class="course-hero-icon">
                    <img src="{{$course->thumbnail}}" alt="img" class="img-fluid gallery-img">
                </div>
                <div class="course-hero-info">
                    <div class="course-hero-title">{{$course->title}}</div>
                    <div class="course-hero-meta">
                        <div class="meta-chip"><span class="dot"></span>{{$course->chapter_num??0}} 個學習單元</div>
                        <div class="meta-chip"><span class="dot" style="background:var(--mint)"></span>{{$completed}} 已完成</div>
                    </div>
                </div>
                <div class="course-hero-progress">
                    <div class="ring-chart">
                        <svg viewBox="0 0 80 80" width="90" height="90">
                            <defs>
                                <linearGradient id="pg" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#FF6B6B"/>
                                    <stop offset="100%" stop-color="#FFB347"/>
                                </linearGradient>
                            </defs>
                            <circle class="track" cx="40" cy="40" r="35"/>
                            <circle class="fill" cx="40" cy="40" r="35"/>
                        </svg>
                        <div class="ring-label">
                            <span class="ring-pct">{{$progress}}%</span>
                            <span class="ring-sub">已完成</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon-box sb-coral">
                        <!-- books / courses -->
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FF6B6B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            <line x1="9" y1="7" x2="15" y2="7"/>
                            <line x1="9" y1="11" x2="13" y2="11"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <div class="num nc">{{$course->unit_num??0}}</div>
                        <div class="lbl">課程單元</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-box sb-mint">
                        <!-- check circle -->
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#5ECFA6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="8 12 11 15 16 9"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <div class="num nm">{{$completed}}</div>
                        <div class="lbl">已完成單元</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon-box sb-lavender">
                        <!-- hourglass -->
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#B39DDB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 2h14"/>
                            <path d="M5 22h14"/>
                            <path d="M17 2L12 12 7 2"/>
                            <path d="M7 22l5-10 5 10"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <div class="num nl">{{$surplus}}</div>
                        <div class="lbl">待完成單元</div>
                    </div>
                </div>
            </div>

            <!-- Overview -->
            <div class="overview-card">
                <div class="section-header">
                    <div class="section-header-icon icon-orange">
                        <!-- clipboard -->
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF8C5A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                            <rect x="8" y="2" width="8" height="4" rx="1"/>
                            <line x1="9" y1="12" x2="15" y2="12"/>
                            <line x1="9" y1="16" x2="13" y2="16"/>
                        </svg>
                    </div>
                    <span class="section-label">概覽</span>
                </div>
                <div style="font-size:.8rem; font-weight:700; color:#A0AEC0; margin-bottom:.75rem; letter-spacing:.04em; text-transform:uppercase;">課程簡介</div>
                <div class="overview-text">
                    {!! $course->description !!}
                </div>
            </div>

            <!-- Curriculum -->
            <div class="curriculum-card">
                <div class="section-header">
                    <div class="section-header-icon icon-blue">
                        <!-- folder tabs / curriculum -->
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4FC3F7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h4l2-2h6l2 2h4v14H3z"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                            <line x1="8" y1="14" x2="16" y2="14"/>
                            <line x1="8" y1="18" x2="13" y2="18"/>
                        </svg>
                    </div>
                    <span class="section-label">課程內容</span>
                    <span class="section-count">{{$course->unit_num??0}} 個單元</span>
                </div>

                @foreach($course->chapters as $index => $chapter)
                    <div class="level-block">
                        <div class="level-header open" onclick="toggleLevel(this)">
                            <div class="level-left">
                                <div class="level-badge">{{$index + 1}}</div>
                                <span class="level-name">{{$chapter->title}}</span>
                            </div>
                            <div class="level-right">
                                <span class="level-meta">{{$chapter->unit_num}} 個章节 · {{$chapter->unit_num_completed}} 已完成</span>
                                <svg class="chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4FC3F7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"/>
                                </svg>
                            </div>
                        </div>

                        <div class="lesson-list open">
                            @foreach($chapter->units as $unit)
                                <div class="lesson-row done">
                                    <div class="play-btn done ti-nutrition">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="38" height="38">

                                            <text x="100" y="130"
                                                  font-family="'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif"
                                                  font-size="80"
                                                  font-weight="800"
                                                  fill="#2C3E66"
                                                  text-anchor="middle"
                                                  dominant-baseline="middle">
                                                {{ $loop->parent->iteration }}.{{ $loop->iteration }}
                                            </text>

                                            <line x1="45" y1="155" x2="155" y2="155" stroke="#A0B8D4" stroke-width="3" stroke-linecap="round" opacity="0.6"/>
                                        </svg>
                                    </div>
                                    <div class="lesson-info">
                                        <div class="lesson-title">{{$unit->title}}</div>
                                        <div class="lesson-sub">
                                            @if($unit->type === 0)
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polygon points="23 7 16 12 23 17 23 7"/>
                                                    <rect x="1" y="5" width="15" height="14" rx="2"/>
                                                </svg>
                                                <span>影片課程</span>
                                            @else
                                                <svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="12" height="12">
                                                    <path
                                                        d="M905.185809 178.844158C898.576738 172.685485 891.19337 165.824412 883.21687 158.436127 860.422682 137.322863 837.434925 116.207791 815.697647 96.487895 813.243072 94.261877 813.243072 94.261877 810.786411 92.037081 781.783552 65.781062 757.590948 44.376502 739.713617 29.293612 729.254178 20.469111 721.020606 13.860686 714.970549 9.501727 710.955023 6.608611 707.690543 4.524745 704.47155 2.998714 700.417679 1.07689 696.638044-0.094029 691.307277 0.005928 677.045677 0.273349 665.6 11.769337 665.6 26.182727L665.6 77.352844 665.6 128.522961 665.6 230.863194 665.6 256.448252 691.2 256.448252 896 256.448252 870.4 230.863194 870.4 998.414942 896 972.829884 230.381436 972.829884C187.90385 972.829884 153.6 938.623723 153.6 896.20663L153.6 26.182727 128 51.767786 588.8 51.767786C602.93849 51.767786 614.4 40.312965 614.4 26.182727 614.4 12.05249 602.93849 0.597669 588.8 0.597669L128 0.597669 102.4 0.597669 102.4 26.182727 102.4 896.20663C102.4 966.91021 159.652833 1024 230.381436 1024L896 1024 921.6 1024 921.6 998.414942 921.6 230.863194 921.6 205.278135 896 205.278135 691.2 205.278135 716.8 230.863194 716.8 128.522961 716.8 77.352844 716.8 26.182727C716.8 39.813762 705.748075 50.91427 692.267725 51.167041 687.705707 51.252584 685.069822 50.435995 682.52845 49.231204 682.259458 49.103682 683.344977 49.796618 685.029451 51.010252 689.779394 54.432502 697.145822 60.34494 706.686383 68.394196 724.009052 83.009121 747.816448 104.072869 776.413589 129.961594 778.850014 132.168064 778.850014 132.168064 781.285216 134.376514 802.876774 153.964212 825.739479 174.96442 848.413564 195.966437 856.350957 203.3185 863.697005 210.144893 870.269888 216.269843 874.209847 219.941299 877.019309 222.565641 878.499674 223.951409 888.81866 233.610931 905.019017 233.081212 914.684179 222.768247 924.349344 212.455283 923.819315 196.264383 913.500326 186.604861 911.981323 185.182945 909.155025 182.542876 905.185809 178.844158ZM102.4 461.128719 0 461.128719 0 896.074709 512 896.074709 1024 896.074709 1024 461.128719 153.6 461.128719 153.6 460.531049 102.4 460.531049 102.4 461.128719ZM208.2 711 208.2 819.2 157.6 819.2 157.6 528 269 528C301.533495 528 327.366571 536.466581 346.5 553.4 365.633429 570.333419 375.2 592.733195 375.2 620.6 375.2 649.133476 365.833427 671.333254 347.1 687.2 328.366573 703.066746 302.133502 711 268.4 711L208.2 711ZM208.2 670.4 269 670.4C287.00009 670.4 300.733286 666.166709 310.2 657.7 319.666714 649.233291 324.4 637.000079 324.4 621 324.4 605.266588 319.600047 592.700047 310 583.3 300.399951 573.899953 287.200083 569.066669 270.4 568.8L208.2 568.8 208.2 670.4ZM419.4 819.2 419.4 528 505.4 528C531.133461 528 553.966566 533.733276 573.9 545.2 593.833434 556.666724 609.266611 572.933229 620.2 594 631.133389 615.066771 636.6 639.199863 636.6 666.4L636.6 681C636.6 708.600139 631.100055 732.866562 620.1 753.8 609.099945 774.733438 593.433436 790.866609 573.1 802.2 552.766564 813.533391 529.466799 819.2 503.2 819.2L419.4 819.2ZM470 568.8 470 778.8 503 778.8C529.533466 778.8 549.89993 770.500083 564.1 753.9 578.30007 737.299917 585.533331 713.466822 585.8 682.4L585.8 666.2C585.8 634.599842 578.933402 610.46675 565.2 593.8 551.466598 577.13325 531.533463 568.8 505.4 568.8L470 568.8ZM854.8 695.8 737.6 695.8 737.6 819.2 687 819.2 687 528 872 528 872 568.8 737.6 568.8 737.6 655.4 854.8 655.4 854.8 695.8Z"
                                                        fill="#5E5E5E"></path>
                                                </svg>
                                                <span>PDF課程</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="lesson-actions">
                                        <a class="open-btn" href="{{$unit->url}}">打開</a>
                                        @if($unit->status === 2)
                                            <div class="status-chip done">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5ECFA6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <polyline points="8 12 11 15 16 9"/>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="status-chip pending">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#A0AEC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

    <x-web.user.footer/>

</div>

</body>

</html>
