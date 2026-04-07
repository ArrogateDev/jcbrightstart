<!DOCTYPE html>
<html lang="zh-Hant">

<x-web.head/>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;700;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
<style>
    :root {
        --forest: #006B73;
        --forest-light: #0099A3;
        --sage: #00c8d4;
        --sage-light: #A8C68F;
        --cream: #FFF8F0;
        --warm-white: #FFFDFB;
        --gold: #C8A44E;
        --gold-light: #E8D498;
        --blush: #E8B4B8;
        --lavender: #C4A8D8;
        --sky: #8CBAD9;
        --coral: #D4836B;
        --text-dark: #2A2A28;
        --text-mid: #5A5A55;
        --text-light: #8A8A82;
        --shadow-soft: 0 4px 30px rgba(45, 80, 22, 0.08);
        --shadow-medium: 0 8px 40px rgba(45, 80, 22, 0.12);
        --shadow-strong: 0 16px 60px rgba(45, 80, 22, 0.16);
    }

    .page-heading-inner {
        background: linear-gradient(46deg, #007078 0%, #007982 100%);
    }

    .page-heading-inner .section-heading__title {
        color: white !important;
    }

    /* ===== HERO ===== */
    .development {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(160deg, var(--forest) 0%, var(--forest-light) 40%, var(--sage) 100%);
        overflow: hidden;
    }

    .development::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 800px;
        height: 800px;
        background: radial-gradient(circle, rgba(200, 164, 78, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 20s ease-in-out infinite;
    }

    .development::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(168, 198, 143, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 15s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% {
            transform: translate(0, 0) scale(1);
        }
        33% {
            transform: translate(30px, -30px) scale(1.05);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.95);
        }
    }

    .development-page section:nth-child(odd) {
        background: linear-gradient(160deg, var(--forest) 0%, var(--forest-light) 40%, var(--sage) 100%) !important;
    }

    .development-page section:nth-child(even) {
        background: white !important;
    }

    .development-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 2rem;
        max-width: 900px;
    }

    .development-badge {
        display: inline-block;
        padding: 0.5rem 1.8rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 50px;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.85rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 2.5rem;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.05);
        animation: fadeInDown 1s ease-out;
    }

    .development-number {
        font-family: 'Playfair Display', serif;
        font-size: clamp(6rem, 15vw, 12rem);
        font-weight: 900;
        color: rgba(255, 255, 255, 0.12);
        line-height: 1;
        margin-bottom: -2rem;
        animation: fadeInUp 0.8s ease-out;
    }

    .development-title {
        font-size: clamp(2.2rem, 5vw, 3.8rem);
        font-weight: 900;
        color: #fff;
        line-height: 1.3;
        margin-bottom: 1.5rem;
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .development-subtitle {
        font-size: clamp(1rem, 2vw, 1.25rem);
        font-weight: 300;
        color: rgba(255, 255, 255, 0.8);
        max-width: 600px;
        margin: 0 auto 3rem;
        animation: fadeInUp 1s ease-out 0.4s both;
    }

    .development-scroll {
        animation: fadeInUp 1s ease-out 0.6s both;
    }

    .development-scroll a {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--gold-light);
        text-decoration: none;
        font-size: 1.2rem;
        letter-spacing: 2px;
        transition: all 0.3s;
    }

    .development-scroll a:hover {
        gap: 0.8rem;
    }

    .scroll-arrow {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-right: 2px solid var(--gold-light);
        border-bottom: 2px solid var(--gold-light);
        transform: rotate(45deg);
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% {
            transform: rotate(45deg) translate(0, 0);
        }
        50% {
            transform: rotate(45deg) translate(5px, 5px);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== SECTIONS ===== */
    .development-page section {
        padding: 6rem 2rem;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-label {
        display: inline-block;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--sage);
        margin-bottom: 1rem;
        font-weight: 700;
        font-size: 18px;
    }

    .section-title {
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        font-weight: 900;
        color: var(--forest);
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .section-desc {
        color: var(--text-mid);
        margin-bottom: 3rem;
        font-weight: 300;
        font-size: 18px;
    }

    /* ===== PROFESSIONAL DEVELOPMENT (Tier Cards) ===== */
    .pd-section {
        background: var(--warm-white);
    }

    .tier-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        position: relative;
    }

    @media (max-width: 900px) {
        .tier-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }

    .tier-card {
        position: relative;
        background: #fff;
        border-radius: 24px;
        padding: 2.5rem 2rem;
        box-shadow: var(--shadow-soft);
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        overflow: hidden;
    }

    .tier-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-strong);
    }

    .tier-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        border-radius: 24px 24px 0 0;
    }

    .tier-card:nth-child(3)::before {
        background: #ff71eb;
    }

    .tier-card:nth-child(4)::before {
        background: #00c8d4;
    }

    .tier-card:nth-child(5)::before {
        background: #ffb900;
    }

    .tier-number {
        font-family: 'Playfair Display', serif;
        font-size: 4rem;
        font-weight: 900;
        color: rgba(45, 80, 22, 0.06);
        line-height: 1;
        margin-bottom: -0.5rem;
    }

    .tier-label {
        display: inline-block;
        padding: 0.3rem 1rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .tier-card:nth-child(3) .tier-label {
        background: rgba(168, 198, 143, 0.2);
        color: #ff71eb;
    }

    .tier-card:nth-child(4) .tier-label {
        background: rgba(58, 107, 30, 0.1);
        color: #00c8d4;
    }

    .tier-card:nth-child(5) .tier-label {
        background: rgba(45, 80, 22, 0.1);
        color: #ffb900;
    }

    .tier-name {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.3rem;
    }

    .tier-name-en {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-bottom: 1.5rem;
        font-weight: 400;
    }

    .tier-target {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding: 1rem;
        background: rgba(245, 242, 235, 0.6);
        border-radius: 12px;
    }

    .tier-target-icon {
        flex-shrink: 0;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-top: 2px;
    }

    .tier-card:nth-child(1) .tier-target-icon {
        background: rgba(168, 198, 143, 0.25);
    }

    .tier-card:nth-child(2) .tier-target-icon {
        background: rgba(58, 107, 30, 0.15);
    }

    .tier-card:nth-child(3) .tier-target-icon {
        background: rgba(45, 80, 22, 0.15);
    }

    .tier-target-text {
        font-size: 1.2rem;
        line-height: 1.7;
        color: var(--text-mid);
    }

    .tier-target-text strong {
        color: var(--text-dark);
        font-weight: 700;
    }

    /* Arrow connectors (desktop) */
    .tier-arrow {
        display: none;
    }

    @media (min-width: 901px) {
        .tier-arrow {
            display: flex;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            width: 40px;
            height: 40px;
            background: var(--gold);
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(200, 164, 78, 0.3);
        }

        .tier-arrow-1 {
            left: calc(33.33% - 26px);
        }

        .tier-arrow-2 {
            left: calc(66.66% - 16px);
        }

        .tier-arrow svg {
            width: 16px;
            height: 16px;
            fill: #fff;
        }
    }

    /* ===== PLC SECTION ===== */
    .plc-section {
        background: linear-gradient(180deg, var(--cream) 0%, #f3ede4 100%);
    }

    .plc-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    @media (max-width: 900px) {
        .plc-grid {
            grid-template-columns: 1fr;
        }
    }

    .plc-card {
        position: relative;
        border-radius: 24px;
        padding: 2.5rem 2rem 2rem;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        overflow: hidden;
    }

    .plc-card:hover {
        transform: translateY(-6px);
    }

    .plc-card:nth-child(1) {
        background: linear-gradient(145deg, #E8D4E8, #F0E4F0);
        box-shadow: 0 8px 30px rgba(196, 168, 216, 0.2);
    }

    .plc-card:nth-child(2) {
        background: linear-gradient(145deg, #DFD0EF, #EDE4F5);
        box-shadow: 0 8px 30px rgba(196, 168, 216, 0.2);
    }

    .plc-card:nth-child(3) {
        background: linear-gradient(145deg, #D4E4F0, #E4EFF7);
        box-shadow: 0 8px 30px rgba(140, 186, 217, 0.2);
    }

    .plc-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .plc-card:nth-child(1) .plc-icon {
        background: rgba(180, 130, 180, 0.2);
    }

    .plc-card:nth-child(2) .plc-icon {
        background: rgba(160, 130, 200, 0.2);
    }

    .plc-card:nth-child(3) .plc-icon {
        background: rgba(100, 160, 200, 0.2);
    }

    .plc-title {
        font-size: 1.55rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.2rem;
    }

    .plc-items {
        list-style: none;
    }

    .plc-items li {
        position: relative;
        padding-left: 1.2rem;
        margin-bottom: 0.8rem;
        font-size: 1.2rem;
        color: black;
        line-height: 1.6;
    }

    .plc-items li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0.6rem;
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .plc-card:nth-child(1) .plc-items li::before {
        background: #9B6B9B;
    }

    .plc-card:nth-child(2) .plc-items li::before {
        background: #8B6BB8;
    }

    .plc-card:nth-child(3) .plc-items li::before {
        background: #5B8BAB;
    }

    /* ===== SUPPORT SECTION ===== */
    .support-section {
        background: var(--forest);
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .support-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .support-section .section-label {
        color: var(--forest);
        font-size: 18px;
    }

    .support-section .section-title {
        color: var(--forest);
    }

    .support-section .section-desc {
        color: var(--forest);
        font-size: 18px;
    }

    .support-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2.5rem;
        position: relative;
        z-index: 2;
    }

    @media (max-width: 900px) {
        .support-layout {
            grid-template-columns: 1fr;
        }
    }

    .support-main {
        background: linear-gradient(145deg, #98d4f9, #ccf7ff);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 2.5rem;
    }

    .support-main-title {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--forest);
    }

    .support-main-subtitle {
        color: var(--forest);
        margin-bottom: 2rem;
    }

    .support-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.2rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 14px;
        transition: background 0.3s;
    }

    .support-item:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .support-item-dot {
        flex-shrink: 0;
        width: 8px;
        height: 8px;
        background: var(--forest);
        border-radius: 50%;
        margin-top: 8px;
    }

    .support-item-text {
        font-size: 1.2rem;
        color: var(--forest);
        line-height: 1.6;
    }

    .support-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .support-highlight {
        border-radius: 24px;
        padding: 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        transition: transform 0.4s;
    }

    .support-highlight:hover {
        transform: scale(1.02);
    }

    .support-highlight:nth-child(1) {
        background: linear-gradient(145deg, #c0e178, #ddff9b);
        color: var(--forest);
    }

    .support-highlight:nth-child(2) {
        background: linear-gradient(145deg, #f6a3ad, #ffdce0);
        color: var(--forest);
    }

    .support-highlight:nth-child(3) {
        background: linear-gradient(145deg, #f7e26f, #fff5c3);
        color: var(--forest);
    }

    .support-highlight-icon {
        font-size: 2rem;
        margin-bottom: 0.8rem;
        background: rgba(180, 130, 180, 0.2);
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .support-highlight-title {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .support-highlight-desc {
        font-size: 1.2rem;
        opacity: 0.85;
        line-height: 1.5;
    }

    /* ===== SCROLL ANIMATIONS ===== */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .reveal-delay-1 {
        transition-delay: 0.1s;
    }

    .reveal-delay-2 {
        transition-delay: 0.2s;
    }

    .reveal-delay-3 {
        transition-delay: 0.3s;
    }

    /* ===== WAVE DIVIDER ===== */
    .wave-divider {
        height: 80px;
        overflow: hidden;
        position: relative;
    }

    .wave-divider svg {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 80px;
    }
</style>
<body class="animsition js-preloader">
<div class="page-wrapper">

    <x-web.header/>

    <main id="main">

        <x-web.breadcrumb title="{{__('HOME5_TITLE')}}" subtitle="{{__('HOME5_TITLE')}}"/>

        <div class="development-page">
            <section class="development" id="top">
                <div class="development-content">
                    <div class="development-badge">{{__('幼儿教育 · 专业框架')}}</div>
                    <div class="development-number">4</div>
                    <h1 class="development-title">{{__('4个层级的专业介入')}}</h1>
                    <p class="development-subtitle">
                        {!! __('从知识基础到专业同行，透过系统化的专业发展路径，<br>持续提升幼儿教顾实践的品质与专业水平') !!}
                    </p>
                    <div class="development-scroll">
                        <a href="#pd">
                            <span>{{__('探索框架')}}</span> <span class="scroll-arrow"></span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="pd-section" id="pd">
                <div class="container">
                    <span class="section-label reveal">{{__('第一层面')}}</span>
                    <h2 class="section-title reveal">{{__('专业发展')}}</h2>
                    <p class="section-desc reveal">
                        {{__('三个递进式阶段，从基础知识到综合应用，再到专业同行启导，全面支持幼儿老师的专业成长。')}}
                    </p>

                    <div class="tier-grid">
                        <!-- Arrow Connectors -->
                        <div class="tier-arrow tier-arrow-1">
                            <svg viewBox="0 0 24 24">
                                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/>
                            </svg>
                        </div>
                        <div class="tier-arrow tier-arrow-2">
                            <svg viewBox="0 0 24 24">
                                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/>
                            </svg>
                        </div>

                        <!-- Tier 0 -->
                        <div class="tier-card reveal reveal-delay-1">
                            <div class="tier-number">01</div>
                            <span class="tier-label">Tier 1</span>
                            <h3 class="tier-name">{{__('知识回廊')}}</h3>
                            <p class="tier-name-en">Knowledge Foundation</p>
                            <div class="tier-target">
                                <div class="tier-target-icon">👶</div>
                                <div class="tier-target-text">
                                    {!! __('<strong>新入职幼儿老师</strong><br>加深对教顾实践的理解') !!}
                                </div>
                            </div>
                            <div class="tier-target">
                                <div class="tier-target-icon">🌱</div>
                                <div class="tier-target-text">
                                    {!! __('<strong>在职幼儿老师</strong><br>刷新专业技能及知识') !!}
                                </div>
                            </div>
                        </div>

                        <!-- Tier 1 -->
                        <div class="tier-card reveal reveal-delay-2">
                            <div class="tier-number">02</div>
                            <span class="tier-label">Tier 2</span>
                            <h3 class="tier-name">{{__('综合应用')}}</h3>
                            <p class="tier-name-en">Integrated Application</p>
                            <div class="tier-target">
                                <div class="tier-target-icon">🔗</div>
                                <div class="tier-target-text">
                                    {!! __('全面理解在教顾实践上各个方面的<strong>相互关联</strong>') !!}
                                </div>
                            </div>
                        </div>

                        <!-- Tier 2 -->
                        <div class="tier-card reveal reveal-delay-3">
                            <div class="tier-number">03</div>
                            <span class="tier-label">Tier 3</span>
                            <h3 class="tier-name">{{__('专业同行')}}</h3>
                            <p class="tier-name-en">Professional Mentoring</p>
                            <div class="tier-target">
                                <div class="tier-target-icon">🏫</div>
                                <div class="tier-target-text">
                                    {!! __('<strong>到校启导</strong>：对当前的实践进行深入讨论、评估和反思') !!}
                                </div>
                            </div>
                            <div class="tier-target">
                                <div class="tier-target-icon">⭐</div>
                                <div class="tier-target-text">
                                    {!! __('追求<strong>高品质</strong>的教顾环境，提升学校整体教顾质素') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="plc-section" id="plc">
                <div class="container">
                    <span class="section-label reveal text-white">{{__('第二层面')}}</span>
                    <h2 class="section-title reveal text-white">{{__('专业学习社群')}}</h2>
                    <p class="section-desc reveal text-white">
                        {{__('透过学校互访、专业交流会及海外考察，建构开放的学习型社群，促进知识分享与持续成长。')}}
                    </p>

                    <div class="plc-grid">
                        <!-- School Visits -->
                        <div class="plc-card reveal reveal-delay-1">
                            <div class="plc-icon">🏠</div>
                            <h3 class="plc-title">{{__('学校互访')}}</h3>
                            <ul class="plc-items">
                                <li>{{__('幼儿中心环境观摩')}}</li>
                                <li>{{__('教顾实践分享')}}</li>
                                <li>{{__('专业对话、知识交流')}}</li>
                            </ul>
                        </div>

                        <!-- PLC Exchange -->
                        <div class="plc-card reveal reveal-delay-2">
                            <div class="plc-icon">💬</div>
                            <h3 class="plc-title">{{__('专业学习社群（PLC）交流会')}}</h3>
                            <ul class="plc-items">
                                <li>{{__('回顾及总结专业发展的学习历程')}}</li>
                                <li>{{__('分享得著成功经验')}}</li>
                            </ul>
                        </div>

                        <!-- Overseas Study -->
                        <div class="plc-card reveal reveal-delay-3">
                            <div class="plc-icon">✈️</div>
                            <h3 class="plc-title">{{__('海外考察团')}}</h3>
                            <ul class="plc-items">
                                <li>{!! __('PECERA 国际会议及海外婴幼园参访') !!}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <section class="support-section" id="support">
                <div class="container">
                    <span class="section-label reveal text-black">{{__('第三层面')}}</span>
                    <h2 class="section-title reveal text-black">{{__('持续专业支援')}}</h2>
                    <p class="section-desc reveal text-black">
                        {{__('专业介入后提供为期一年的持续支援，确保实践成果的巩固与延续。')}}
                    </p>

                    <div class="support-layout">
                        <div class="support-main reveal">
                            <div class="support-main-title">{{__('教顾实践核心')}}</div>
                            <div class="support-main-subtitle">{{__('教学与照顾实践的专业深化')}}</div>

                            <div class="support-item">
                                <div class="support-item-dot"></div>
                                <div class="support-item-text">{{__('ITERS 应用与评估')}}</div>
                            </div>
                            <div class="support-item">
                                <div class="support-item-dot"></div>
                                <div class="support-item-text">{{__('“童．发现框架”（Discovery Framework）')}}</div>
                            </div>
                            <div class="support-item">
                                <div class="support-item-dot"></div>
                                <div class="support-item-text">{{__('医护实践')}}</div>
                            </div>
                            <div class="support-item">
                                <div class="support-item-dot"></div>
                                <div class="support-item-text">{{__('有效且可持续的学校领导')}}</div>
                            </div>
                            <div class="support-item">
                                <div class="support-item-dot"></div>
                                <div class="support-item-text">{{__('发展校本学习型团队')}}</div>
                            </div>
                            <div class="support-item">
                                <div class="support-item-dot"></div>
                                <div class="support-item-text">{{__('基础设施提升的规划与执行')}}</div>
                            </div>
                        </div>

                        <div class="support-sidebar reveal reveal-delay-1">
                            <div class="support-highlight">
                                <div class="support-highlight-icon">🤝</div>
                                <div class="support-highlight-title">{{__('领导伙伴协作')}}</div>
                                <div class="support-highlight-desc">{{__('幼儿中心管理与组织的专业提升')}}</div>
                            </div>
                            <div class="support-highlight">
                                <div class="support-highlight-icon">🌿</div>
                                <div class="support-highlight-title">{{__('社区日')}}</div>
                                <div class="support-highlight-desc">{{__('“喜步”同行耀社区')}}</div>
                            </div>
                            <div class="support-highlight">
                                <div class="support-highlight-icon">🎓</div>
                                <div class="support-highlight-title">{{__('专业形象建设')}}</div>
                                <div class="support-highlight-desc">{{__('提升香港幼儿中心的专业形象与地位')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <x-web.footer/>

</div>

</body>

<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>

</html>
