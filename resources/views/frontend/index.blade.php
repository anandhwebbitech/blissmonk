@extends('frontend.layout.app')

@section('title', 'BlissMonk - Home')

<style>
    /* Individual Grid Block Card Reset */
    .fx-webinar-module-block {
        background-color: #0b1517;
        /* Deep Premium Dark Teal Canvas */
        padding: 35px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.03);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    /* Module Heading Structure Design */
    .fx-webinar-module-title {
        color: #ffffff;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin-bottom: 25px;
        padding-left: 15px;
        position: relative;
    }

    /* Left Side Title Vertical Line Indicator */
    .fx-webinar-module-title::before {
        content: "";
        position: absolute;
        left: 0;
        top: 4px;
        width: 3px;
        height: 24px;
        background-color: #475569;
        /* Muted sleek dark bar border */
        border-radius: 4px;
    }

    /* List Layout Grid Stack */
    .fx-webinar-module-list {
        list-style: none;
        padding-left: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 18px;
        /* Clean tracking spacing between nodes */
    }

    /* Core List Item Typography */
    .fx-webinar-module-item {
        display: flex;
        align-items: flex-start;
        font-size: 16px;
        font-weight: 500;
        line-height: 1.5;
        letter-spacing: -0.2px;
    }

    /* Accent Configuration: 'none' markup variant style */
    .fx-accent-none {
        color: #5c6f84;
        /* Deep slate dim gray text */
    }

    .fx-accent-none::before {
        content: "—";
        color: #3b4856;
        margin-right: 14px;
        font-weight: bold;
        flex-shrink: 0;
    }

    /* Accent Configuration: 'green' markup variant style */
    .fx-accent-green {
        color: #94a3b8;
        /* Crisp active readable gray text */
    }

    .fx-accent-green::before {
        content: "▲";
        color: #10b981;
        /* High contrast vibrant emerald green glow */
        margin-right: 14px;
        font-size: 13px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* Accent Configuration: 'red' markup variant style */
    .fx-accent-red {
        color: #94a3b8;
        /* Crisp active readable gray text */
    }

    .fx-accent-red::before {
        content: "▼";
        color: #ef4444;
        /* High contrast bright scarlet red alert */
        margin-right: 14px;
        font-size: 13px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .swiper-wrapper{
        height: 280px !important;
    }
</style>
@section('content')

    <div class="page-wrapper" id="home">
        <!-- Background Elements -->
        <div class="bg-animation"></div>
        <div class="candlestick-overlay"></div>

        <!-- Trading Ticker -->
        <div class="ticker-bar">
            <div class="ticker-move">
                <span class="mx-4">BTC/USD <span style="color: #27AE60;">▲ <span
                            style="color: #C0392B;">▼</span></span></span>
                <span class="mx-4">GOLD/USD <span style="color: #27AE60;">▲ <span
                            style="color: #C0392B;">▼</span></span></span></span>
                <span class="mx-4">EUR/USD <span style="color: #27AE60;">▲ <span
                            style="color: #C0392B;">▼</span></span></span>
                <span class="mx-4">GBP/USD <span style="color: #27AE60;">▲ <span
                            style="color: #C0392B;">▼</span></span></span>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="container content-container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Dynamic Main Title Header -->
                    <h1 class="display-4 fw-bold mb-3">
                        {{ $hero->title ?? 'Million Dollar Prop Funded Trader Program' }}
                    </h1>

                    <!-- Dynamic Subtitle -->
                    <h3 class="mb-4 text-uppercase">
                        {{ $hero->subtitle ?? 'STOP TRADING YOUR OWN MONEY.' }}
                    </h3>

                    <!-- Dynamic Description Loaded from CKEditor Rich Content -->
                    <div class="mb-4 banner-rich-text">
                        @if (!empty($hero->description))
                            {!! $hero->description !!}
                        @else
                            <p class="lead mb-4">Become a Disciplined Prop-Funded Trader. Managing $1M+ Capital Without
                                Risking Large Personal Capital.</p>
                            <p class="mb-4">⚡ <b>Free Live Webinar</b> Reveals The Exact Framework Used To Help Retail
                                Traders Transition From Inconsistent Trading To Professional Prop-Funded Trading.</p>
                            <p>Learn how to trade Forex, Gold, and Crypto using a proven Buy/Sell Indicator, trade only
                                30–60 minutes per day, and follow a step-by-step roadmap to scale from a $10K funded account
                                toward managing $1M+ in prop firm capital.</p>
                        @endif
                    </div>

                    <!-- Dynamic Action Link Buttons Setup -->
                    <div class="d-flex mb-3 gap-2">
                        @if (!empty($hero->btn_register_url))
                            <a href="{{ $hero->btn_register_url }}" target="_blank"
                                class="btn btn-gold btn-lg open-modal-btn" id="openModalBtn">
                                {{ $hero->btn_register_text ?? 'REGISTER FOR FREE WEBINAR' }}
                            </a>
                        @else
                            <button class="btn btn-gold btn-lg open-modal-btn" id="openModalBtn">
                                {{ $hero->btn_register_text ?? 'REGISTER FOR FREE WEBINAR' }}
                            </button>
                        @endif

                        <a href="{{ $hero->btn_whatsapp_url ?? 'https://chat.whatsapp.com/' }}" target="_blank"
                            class="btn btn-whatsapp btn-lg">
                            <i class="bi bi-whatsapp"></i> {{ $hero->btn_whatsapp_text ?? 'JOIN WHATSAPP GROUP' }}
                        </a>
                    </div>
                </div>

                <!-- Glass Form Registration Section remain intact -->
                <div class="col-lg-4 mx-auto">
                    <div class="glass-form">
                        <h4 class="mb-4 text-center">Register Now</h4>
                        <form action="{{ route('webinar.register') }}" method="POST" id="registerForm">
                            @csrf

                            <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>

                            <input type="tel" name="phone" class="form-control mb-3" maxlength="10"
                                pattern="[0-9]{10}" placeholder="Phone Number" required>

                            <input type="email" name="email" class="form-control mb-3" placeholder="Email Address"
                                required>

                            <input type="text" name="city" class="form-control mb-3" placeholder="City" required>

                            <button type="submit" class="btn btn-success w-100" id="submitBtn">
                                <span id="btnText">SEND MESSAGE</span>
                                <span id="btnLoader" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($about)
        <div class="page-wrapper" id="about">
            <div class="bg-animate "></div>

            <div class="container py-5">
                <!-- Who We Are Section -->
                <section class="flex-box">
                    <div class="card-custom">
                        <h2 class="mb-4 text-green">{{ $about->title }}</h2>
                        <p class="lead">{{ $about->description }}</p>
                    </div>
                    <div class="card-custom p-0 d-flex justify-content-center align-items-center">
                        <!-- Dynamic Image Path -->
                        <img src="{{ asset($about->image) }}" alt="Market Analysis" class="chart-img"
                            onerror="this.style.display='none'">
                    </div>
                </section>

                <!-- Expertise Section -->
                <section class="flex-box">
                    <div class="card-custom" style="flex: 1 1 100%;">
                        <h3 class="mb-4 text-red">{{ $about->expertise_title }}</h3>
                        <h4 class="mb-3">{{ $about->expertise_subtitle }}</h4>
                        <p class="mb-4">{{ $about->expertise_description }}</p>

                        <!-- Expertise Items Loop -->
                        <div class="expertise-container">
                            @foreach ($about->expertise_items as $item)
                                <div class="expertise-item">{{ $item }}</div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>
    @endif



    @if ($problemsolving)
        <div class="terminal-container">
            <div class="container">
                <!-- Problem Section -->
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-12">
                        <div class="terminal-card border-red p-4">

                            <!-- Icon + Heading -->
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="header-icon text-red fs-1">
                                    <i class="fa-solid fa-chart-line"></i>
                                </div>
                                <h3 class="mb-0">{{ $problemsolving->heading }}</h3>
                            </div>

                            <div class="row align-items-center g-4">
                                <!-- Content Area -->
                                <div class="col-lg-6">
                                    <p class="lead">{{ $problemsolving->subheading_lead }}</p>

                                    <!-- Good & Bad Points Render Area (Rendered via CKEditor HTML strings directly) -->
                                    <div class="terminal-rich-text custom-bullet-style">
                                        {!! $problemsolving->good_points !!}
                                    </div>

                                    <!-- Unused dynamic title element handled cleanly -->
                                    @if ($problemsolving->mid_title)
                                        <h5 class="mt-4 text-danger">{{ $problemsolving->mid_title }}</h5>
                                    @endif

                                    <p class="text-secondary mt-3">
                                        {{ $problemsolving->footer_text }}
                                    </p>
                                </div>

                                <!-- Image Column -->
                                <div class="col-lg-6 text-center">
                                    <img src="{{ asset($problemsolving->image) }}" alt="Trading Losses"
                                        class="img-fluid rounded">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Two Column Row -->
                <div class="row justify-content-center">
                    <!-- Worst Part Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="terminal-card border-blue" style="height: 100%;">
                            <h3>{{ $problemsolving->worst_part_title }}</h3>
                            <div class="terminal-rich-text">
                                {!! $problemsolving->worst_part_desc_1 !!}
                            </div>
                            @if ($problemsolving->worst_part_desc_2)
                                <div class="terminal-rich-text mt-2">
                                    {!! $problemsolving->worst_part_desc_2 !!}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Wondering Questions Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="terminal-card border-green" style="height: 100%;">
                            <h3>{{ $problemsolving->wondering_title }}</h3>

                            <!-- Wondering Questions Rendered directly from DB via formatted HTML -->
                            <div class="terminal-rich-text wondering-bullet-style">
                                {!! $problemsolving->wondering_footer !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 💡 Quick CSS Patch for Terminal Bullet points alignment -->
        <style>
            .terminal-rich-text ul {
                list-style: none;
                padding-left: 0;
                margin-bottom: 1rem;
            }

            .terminal-rich-text ul li {
                position: relative;
                padding-left: 1.5rem;
                margin-bottom: 0.5rem;
            }

            /* Custom dynamic icons matching your previous logic */
            .custom-bullet-style ul li::before {
                content: "\f058";
                /* Check mark icon */
                font-family: "Font Awesome 6 Free";
                font-weight: 900;
                position: absolute;
                left: 0;
                color: #198754;
                /* bootstrap success green */
            }

            .wondering-bullet-style ul li::before {
                content: "\f29c";
                /* Question mark icon */
                font-family: "Font Awesome 6 Free";
                font-weight: 900;
                position: absolute;
                left: 0;
                color: #198754;
                /* terminal green */
            }
        </style>
    @endif

    @if ($marketing)
        <!-- Section 1: Why Most Traders Never Get Funded -->
        <div class="pagee-wrapper">
            <div class="container">
                <div class="row align-items-center g-5">
                    <!-- Left Side: Header & The Problem -->
                    <div class="col-lg-6">
                        <div class="market-analysis-header">
                            {!! $marketing->why_heading !!}
                            <p>{{ $marketing->why_subheading }}</p>
                        </div>

                        <p class="lead">{{ $marketing->lead_text }}</p>
                        <p class="fw-bold mb-4">{{ $marketing->problem_label }}</p>

                        @php
                            $problems = str_replace('<ul>', '<ul class="problem-list">', $marketing->problems_list);
                            $problems = str_replace('<li>', '<li><i class="bi bi-x-circle-fill"></i> ', $problems);
                        @endphp
                        {!! $problems !!}
                    </div>

                    <!-- Right Side: The Result & Truth -->
                    <div class="col-lg-6">
                        <div class="p-4 bg-dark rounded">
                            <h4 class="text-danger mb-3">{{ $marketing->result_title }}</h4>
                            <div class="text-white">
                                {!! $marketing->result_desc !!}
                            </div>
                        </div>

                        <div class="solution-box mt-4">
                            <h4 class="text-success mb-3">{{ $marketing->truth_title }}</h4>
                            {!! $marketing->truth_desc !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Introducing The Program -->
        <div class="prop-thesis-wrapper">
            <main class="prop-thesis-container container mt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="prop-thesis-headline-wrapper">
                            {!! $marketing->program_headline !!}
                        </div>
                        <p class="prop-thesis-subheadline">{{ $marketing->program_subheadline }}</p>

                        <img src="{{ asset($marketing->program_image) }}" alt="Trading infrastructure"
                            class="prop-thesis-image-frame">
                    </div>

                    <div class="col-lg-6">
                        <section>
                            <p class="prop-thesis-text-content">{{ $marketing->discover_text }}</p>

                            @php
                                $benefits = str_replace(
                                    '<ul>',
                                    '<ul class="prop-thesis-benefit-list">',
                                    $marketing->benefits_list,
                                );
                                $benefits = str_replace('<li>', '<li class="prop-thesis-benefit-item">', $benefits);
                                $benefits = str_replace('✔️', '', $benefits);
                            @endphp
                            {!! $benefits !!}
                        </section>

                        <section class="prop-sect">
                            <p class="prop-thesis-pain-point">{{ $marketing->pain_point_text }}</p>
                            <div class="prop-thesis-solution-text">
                                {!! $marketing->solution_text !!}
                            </div>
                        </section>
                    </div>
                </div>
            </main>
        </div>
    @endif


    @if ($section)
        <div class="fx-webinar-master-wrapper">
            <main class="fx-webinar-container">

                <!-- Dynamic Main Title -->
                <h3 class="fx-webinar-main-title">{{ $section->section_title }}</h3>

                <!-- Dynamic Editorial Image -->
                <img class="fx-webinar-editorial-image" src="{{ asset($section->editorial_image) }}"
                    alt="Trading Terminal Setup">

                <div class="fx-webinar-trading-element">
                    <svg width="100%" height="100%" viewBox="0 0 800 60" preserveAspectRatio="none">
                        <line x1="0" y1="30" x2="800" y2="30" stroke="#1f2937"
                            stroke-width="1" stroke-dasharray="4 4" />
                        <rect x="50" y="20" width="2" height="25" fill="#27AE60" />
                        <rect x="46" y="25" width="10" height="15" fill="#27AE60" />
                        <rect x="90" y="10" width="2" height="35" fill="#C0392B" />
                        <rect x="86" y="15" width="10" height="20" fill="#C0392B" />
                        <rect x="130" y="15" width="2" height="20" fill="#27AE60" />
                        <rect x="126" y="20" width="10" height="10" fill="#27AE60" />
                        <rect x="170" y="5" width="2" height="25" fill="#27AE60" />
                        <rect x="166" y="10" width="10" height="15" fill="#27AE60" />
                        <polyline points="0,45 48,32 88,25 128,25 168,17 800,17" fill="none" stroke="#374151"
                            stroke-width="2" />
                    </svg>
                </div>

                <!-- Modules Looping Section -->
                <div class="row gy-5 gx-md-5">
                    @foreach ($section->modules_data as $module)
                        <div class="col-12 col-md-6">
                            <section class="fx-webinar-module-block h-100">

                                <h3 class="fx-webinar-module-title">{{ $module['title'] }}</h3>

                                <ul class="fx-webinar-module-list">
                                    @foreach ($module['items'] as $item)
                                        {{-- Fallback 'fx-accent-none' class path set to prevent breakage --}}
                                        @php
                                            $accentClass = isset($item['accent'])
                                                ? 'fx-accent-' . $item['accent']
                                                : 'fx-accent-none';
                                        @endphp

                                        <li class="fx-webinar-module-item {{ $accentClass }}">
                                            {{ $item['text'] }}
                                        </li>
                                    @endforeach
                                </ul>

                            </section>
                        </div>
                    @endforeach
                </div>

            </main>
        </div>
    @endif



    <div class="zx-master-wrapper">
        <div class="container zx-grid-container">

            <header class="zx-header-section">
                <h3 class="zx-main-title">{!! $frameworkBonus->fw_title !!}</h3>
            </header>

            <!-- Editorial Image -->
            <div class="zx-image-frame">
                <img class="zx-editorial-photo" src="{{ asset($frameworkBonus->fw_image) }}" alt="Trading Concept">
            </div>

            <div class="zx-trading-visual">
                <svg width="100%" height="80" viewBox="0 0 1200 80" preserveAspectRatio="none">
                    <line x1="0" y1="40" x2="1200" y2="40" stroke="rgba(255,255,255,0.1)"
                        stroke-width="1" stroke-dasharray="4 4" />
                    <line x1="100" y1="20" x2="100" y2="60" stroke="#C0392B"
                        stroke-width="2" />
                    <rect x="94" y="25" width="12" height="25" fill="#C0392B" />
                    <line x1="250" y1="10" x2="250" y2="50" stroke="#27AE60"
                        stroke-width="2" />
                    <rect x="244" y="15" width="12" height="30" fill="#0d1217" stroke="#27AE60"
                        stroke-width="2" />
                    <line x1="400" y1="15" x2="400" y2="70" stroke="#27AE60"
                        stroke-width="2" />
                    <rect x="394" y="15" width="12" height="45" fill="#27AE60" />
                    <line x1="550" y1="30" x2="550" y2="75" stroke="#C0392B"
                        stroke-width="2" />
                    <rect x="544" y="40" width="12" height="30" fill="#0d1217" stroke="#C0392B"
                        stroke-width="2" />
                    <line x1="700" y1="5" x2="700" y2="40" stroke="#27AE60"
                        stroke-width="2" />
                    <rect x="694" y="10" width="12" height="20" fill="#27AE60" />
                    <line x1="850" y1="5" x2="850" y2="60" stroke="#27AE60"
                        stroke-width="2" />
                    <rect x="844" y="15" width="12" height="35" fill="#27AE60" />
                    <line x1="1000" y1="10" x2="1000" y2="45" stroke="#27AE60"
                        stroke-width="2" />
                    <rect x="994" y="10" width="12" height="25" fill="#0d1217" stroke="#27AE60"
                        stroke-width="2" />
                    <line x1="1100" y1="20" x2="1100" y2="50" stroke="#C0392B"
                        stroke-width="2" />
                    <rect x="1094" y="25" width="12" height="20" fill="#C0392B" />
                </svg>
            </div>

            <!-- SECTION 1: The Framework -->
            <div class="row mb-5">
                <div class="col-12 col-lg-10 mx-auto">
                    <p class="zx-text-paragraph">
                        {{ $frameworkBonus->fw_paragraph_1 }}
                    </p>

                    <div class="zx-emphasis-box">
                        <span class="zx-emphasis-text-light">{{ $frameworkBonus->fw_emphasis_light }}</span>
                        <span class="zx-emphasis-text-bold">{{ $frameworkBonus->fw_emphasis_bold }}</span>
                    </div>

                    <p class="zx-text-paragraph">
                        {{ $frameworkBonus->fw_paragraph_2 }}
                    </p>

                    <ul class="zx-framework-list">
                        @if (is_array($frameworkBonus->fw_list_items) || is_object($frameworkBonus->fw_list_items))
                            @foreach ($frameworkBonus->fw_list_items as $item)
                                <li class="zx-framework-item">{{ $item }}</li>
                            @endforeach
                        @endif
                    </ul>

                    <p class="zx-conclusion-text">
                        {{ $frameworkBonus->fw_conclusion }}
                    </p>
                </div>
            </div>

            <!-- SECTION 2: Who This Is For -->
            <div class="zx-secondary-section">
                <h3 class="zx-section-title text-center" style="border-bottom: none; margin-bottom: 3.5rem;">🎯 Who This
                    Is For</h3>

                <div class="row g-5">
                    <!-- Left Side: Perfect For -->
                    <div class="col-12 col-lg-6">
                        <div class="zx-target-group">
                            <h3 class="zx-target-header zx-header-green">{{ $frameworkBonus->perfect_title }}</h3>
                            <ul class="zx-target-list">
                                @if (is_array($frameworkBonus->perfect_items) || is_object($frameworkBonus->perfect_items))
                                    @foreach ($frameworkBonus->perfect_items as $perfect_item)
                                        <li class="zx-target-list-item">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="#27AE60" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                            </svg>
                                            <span>{{ $perfect_item }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Right Side: Not For -->
                    <div class="col-12 col-lg-6">
                        <div class="zx-target-group">
                            <h3 class="zx-target-header zx-header-red">{{ $frameworkBonus->not_perfect_title }}</h3>
                            <ul class="zx-target-list">
                                @if (is_array($frameworkBonus->not_perfect_items) || is_object($frameworkBonus->not_perfect_items))
                                    @foreach ($frameworkBonus->not_perfect_items as $not_item)
                                        <li class="zx-target-list-item">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="#C0392B" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="15" y1="9" x2="9" y2="15">
                                                </line>
                                                <line x1="9" y1="9" x2="15" y2="15">
                                                </line>
                                            </svg>
                                            <span>{{ $not_item }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="trd-master-stage">
        <div class="container trd-container">

            <div class="trd-header trd-anim">
                <h3 class="trd-title"><span>💎</span> {{ $frameworkBonus->bonus_heading }}</h3>
                <div class="trd-title-divider"></div>
            </div>

            <div class="row g-4 mb-2">
                @if (is_array($frameworkBonus->bonuses_cards) || is_object($frameworkBonus->bonuses_cards))
                    @foreach ($frameworkBonus->bonuses_cards as $index => $bonus)
                        @php
                            $animDelay = $index % 2 == 0 ? 'trd-d-1' : 'trd-d-2';
                        @endphp
                        <div class="col-12 col-md-6 trd-anim {{ $animDelay }}">
                            <div class="trd-bonus-card">
                                <div class="trd-bonus-label"><span>🎁</span> Bonus #{{ $index + 1 }}</div>
                                <h3 class="trd-bonus-title">{{ $bonus }}</h3>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="trd-urgent-strip trd-anim trd-d-3">
                <div class="trd-urgent-text trd-pulse">
                    <span>⚠</span> {{ $frameworkBonus->urgent_text }}
                </div>
            </div>

            <div class="trd-split-panel trd-anim trd-d-4">
                <!-- Green Side -->
                <div class="trd-split-side trd-split-green">
                    <h3 class="trd-panel-heading"><span>🛡</span> {!! $frameworkBonus->risk_title !!}</h3>
                    @if (is_array($frameworkBonus->risk_paragraphs) || is_object($frameworkBonus->risk_paragraphs))
                        @foreach ($frameworkBonus->risk_paragraphs as $risk_p)
                            <p class="trd-panel-p">{{ $risk_p }}</p>
                        @endforeach
                    @endif
                </div>

                <!-- Red Side -->
                <div class="trd-split-side trd-split-red">
                    <h3 class="trd-panel-heading"><span>⏳</span> {!! $frameworkBonus->expire_title !!}</h3>
                    <p class="trd-panel-p">{{ $frameworkBonus->expire_subtitle }}</p>
                    <ul class="trd-loss-list">
                        @if (is_array($frameworkBonus->expire_items) || is_object($frameworkBonus->expire_items))
                            @foreach ($frameworkBonus->expire_items as $expire_item)
                                <li class="trd-loss-item">
                                    <span class="trd-icon-x">❌</span>
                                    <span>{{ $expire_item }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p class="trd-footer-cta trd-anim trd-d-5">
                        {{ $frameworkBonus->footer_cta }}
                        <span class="trd-footer-highlight">{{ $frameworkBonus->footer_cta_highlight }}</span>
                    </p>
                </div>
            </div>

        </div>
    </div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<section class="fx-webinar-master-wrapper">

    <div class="testimonial-header">
        <h3 class="fx-webinar-main-title">
            Testimonial
        </h3>
    </div>

    <div class="swiper webinarSwiper trd-container">

        <div class="swiper-wrapper">
            @foreach ($testimonial->where('is_active', 1) as $item)
                
                <div class="swiper-slide">
                    <div class="video-card">
                        <div class="video-container">
                             <iframe src="{{ $item->video_url }}?rel=0&controls=1"
                                    title="{{ $item->title }}"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
           
            @endforeach

        </div>

        <!-- Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>

    </div>

</section>
 

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
 
    <div class="trdd-acc-stage">
        <div class="container trdd-acc-container">

            <div class="trdd-acc-header-box">
                <h3 class="trdd-acc-title">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#27AE60"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    Frequently Asked Questions
                </h3>
                <div class="trdd-acc-divider"></div>
            </div>

            <div class="row trdd-acc-grid">

                <!-- LEFT COLUMN -->
                <div class="col-12 col-lg-6">
                    @foreach ($leftColumnFaqs as $index => $faq)
                        @php
                            $itemNumber = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                        @endphp
                        <div class="trdd-acc-item">
                            <button class="trdd-acc-btn">
                                <span><span class="trdd-acc-number">{{ $itemNumber }}.</span>
                                    {{ $faq->question }}</span>
                                <span class="trdd-acc-icon"></span>
                            </button>
                            <div class="trdd-acc-panel">
                                <div class="trdd-acc-panel-inner">
                                    @if ($faq->highlight_answer)
                                        <span class="trdd-acc-highlight">{{ $faq->highlight_answer }}.</span>
                                    @endif
                                    {{ $faq->full_answer }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-12 col-lg-6 trdd-acc-grid-right">
                    @foreach ($rightColumnFaqs as $index => $faq)
                        @php
                            $itemNumber = str_pad(count($leftColumnFaqs) + $index + 1, 2, '0', STR_PAD_LEFT);
                        @endphp
                        <div class="trdd-acc-item">
                            <button class="trdd-acc-btn">
                                <span><span class="trdd-acc-number">{{ $itemNumber }}.</span>
                                    {{ $faq->question }}</span>
                                <span class="trdd-acc-icon"></span>
                            </button>
                            <div class="trdd-acc-panel">
                                <div class="trdd-acc-panel-inner">
                                    @if ($faq->highlight_answer)
                                        <span class="trdd-acc-highlight">{{ $faq->highlight_answer }}.</span>
                                    @endif
                                    {{ $faq->full_answer }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    @php
        // Fetch dynamic database row or fall back to default instance
        $fundedData = \App\Models\FundedAccountSection::first() ?? new \App\Models\FundedAccountSection();
    @endphp

    <div class="ddrt-final-stage">
        <div class="container ddrt-final-container">

            <!-- Header Box Section -->
            <div class="ddrt-final-header-box">
                <h3 class="ddrt-final-title">
                    <span class="ddrt-final-title-icon">🔥</span>
                    {{ $fundedData->main_heading }}
                </h3>
                <div class="ddrt-final-divider"></div>
            </div>

            <!-- Crossroads Content Grid Box -->
            <div class="ddrt-final-crossroads">
                <!-- Center Badge Element -->
                <div class="ddrt-final-or-badge">{{ $fundedData->divider_text }}</div>

                <div class="row g-0">
                    <!-- Left Pane: Red/Pain Points Section -->
                    <div class="col-12 col-md-6">
                        <div class="ddrt-final-path-panel ddrt-final-path-red">
                            <h3 class="ddrt-final-path-title">{{ $fundedData->left_title }}</h3>
                            <ul class="ddrt-final-list red-list">
                                @if (!empty($fundedData->left_points))
                                    @foreach ($fundedData->left_points as $leftPoint)
                                        <li>{{ $leftPoint }}</li>
                                    @endforeach
                                @else
                                    <li>Jump between strategies.</li>
                                    <li>Overtrade.</li>
                                    <li>Risk personal capital.</li>
                                    <li>And hope things change.</li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Right Pane: Green/Solution Section -->
                    <div class="col-12 col-md-6">
                        <div class="ddrt-final-path-panel ddrt-final-path-green">
                            <ul class="ddrt-final-list green-list">
                                @if (!empty($fundedData->right_points))
                                    @foreach ($fundedData->right_points as $rightPoint)
                                        <li>{{ $rightPoint }}</li>
                                    @endforeach
                                @else
                                    <li>You can learn the framework designed to help traders become disciplined, funded, and
                                        scalable.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Action CTA Buttons Grid -->
            <div class="row ddrt-final-actions g-4 justify-content-center">

                <!-- Button 1: Registration/Modal CTA -->
                <div class="col-12 col-md-6">
                    <div class="ddrt-final-btn-wrapper">
                        <!-- Note: dynamic href update or data attributes can be tied here -->
                        <button href="{{ $fundedData->btn1_url ?? '#' }}"
                            class="ddrt-final-btn ddrt-final-btn-primary open-modal-btn">
                            👉 {{ $fundedData->btn1_text }}
                            <svg class="ddrt-final-icon-right" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </button>

                        <span class="ddrt-final-btn-subtext">{{ $fundedData->btn1_subtext }}</span>
                    </div>
                </div>

                <!-- Button 2: WhatsApp Community Group -->
                <div class="col-12 col-md-6">
                    <div class="ddrt-final-btn-wrapper">
                        <a href="{{ $fundedData->btn2_url ?? 'https://chat.whatsapp.com/GmIHWwr19kZBei1iTjXT2b' }}"
                            class="ddrt-final-btn ddrt-final-btn-secondary" target="_blank" rel="noopener">
                            👉 {{ $fundedData->btn2_text }}
                            <svg class="ddrt-final-icon-right" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                </path>
                            </svg>
                        </a>
                        <span class="ddrt-final-btn-subtext">{{ $fundedData->btn2_subtext }}</span>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <div class="custom-modal-overlay" id="registrationModal">
        <div class="custom-modal-card">
            <button class="close-modal-btn" id="closeModalBtn" aria-label="Close modal">&times;</button>

            <h4 class="modal-title">Register Now</h4>

            <form action="{{ route('webinar.register') }}" method="POST" id="registerForm">
                @csrf

                <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>

                <input type="tel" name="phone" class="form-control mb-3" maxlength="10" pattern="[0-9]{10}"
                    placeholder="Phone Number" required>

                <input type="email" name="email" class="form-control mb-3" placeholder="Email Address" required>

                <input type="text" name="city" class="form-control mb-3" placeholder="City" required>

                <button type="submit" class="btn btn-success w-100" id="submitBtn">
                    <span id="btnText">SEND MESSAGE</span>
                    <span id="btnLoader" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                </button>

            </form>
        </div>
    </div>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function() {

            let btn = document.getElementById('submitBtn');

            btn.disabled = true;

            document.getElementById('btnText').innerHTML = "Please Wait...";

            document.getElementById('btnLoader').classList.remove('d-none');

        });
    </script>
@endsection
