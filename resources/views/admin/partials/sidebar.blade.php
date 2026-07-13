<div class="sidebar">
    <style>
        /* Complete Layout Reset & Premium Trading Terminal UI */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            background-color: #0d1117 !important; /* Deep Crypto/Stock Terminal Slate Dark */
            padding: 0 16px;
            border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
            z-index: 1000;
        }

        /* Modernized Trading Brand Header Area */
        .sidebar-brand {
            padding: 26px 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            margin-bottom: 24px;
        }

        /* Chart Candlestick/Trending Icon Badge */
        .brand-logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #22c55e 0%, #ef4444 100%); /* Bullish Green to Bearish Red Premium Splice */
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2);
        }

        .sidebar-brand h5 {
            color: #ffffff !important;
            font-weight: 700;
            font-size: 18px;
            margin: 0;
            letter-spacing: -0.5px;
        }

        /* Clean & Spacious Trading Navigation Links */
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            color: #94a3b8 !important; /* Cool Indigo Slate Text */
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 12px;
            margin-bottom: 6px;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Smooth Interactive Hover State */
        .sidebar .nav-link:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.03) !important;
            transform: translateX(4px);
        }

        .sidebar .nav-link i {
            font-size: 16px;
            width: 24px;
            color: #4b5563; /* Subtle Icon Tone */
            transition: transform 0.2s ease, color 0.2s ease;
        }

        /* General Hover Glow Effect */
        .sidebar .nav-link:hover i {
            color: #38bdf8; /* Cyan Market Active Glow */
        }

        /* High-End Bullish Green Active State (Profit/Dashboard Target) */
        .sidebar .nav-link.active-bullish {
            background-color: rgba(34, 197, 94, 0.15) !important; /* Subtle Transparent Bullish Tint */
            color: #22c55e !important; /* Clean Neon Green Text */
            font-weight: 600;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .sidebar .nav-link.active-bullish i {
            color: #22c55e !important;
        }

        /* High-End Bearish Red Active State (Risk Assessment/System logs) */
        .sidebar .nav-link.active-bearish {
            background-color: rgba(239, 68, 68, 0.15) !important; /* Subtle Transparent Bearish Tint */
            color: #ef4444 !important; /* Signal Red Text */
            font-weight: 600;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .sidebar .nav-link.active-bearish i {
            color: #ef4444 !important;
        }

        /* Refined Logout Section */
        .sidebar-footer {
            margin-top: auto;
            padding: 20px 4px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            color: #64748b !important;
            font-weight: 600;
            font-size: 14px;
            padding: 12px;
            border-radius: 12px;
            width: 100%;
            transition: all 0.2s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        /* Immediate Liquidation/Session Close Red Trigger */
        .btn-logout:hover {
            background: #ef4444 !important;
            border-color: #ef4444 !important;
            color: #ffffff !important;
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.25);
        }
    </style>

    <!-- Trading Brand Header -->
    <div class="sidebar-brand">
        <div class="brand-logo-icon">
            <i class="fa-solid fa-chart-line"></i> <!-- Trading Line Icon instead of Leaf -->
        </div>
        <h5>Bliss Monk</h5>
    </div>

    <!-- Navigation Menu Links System -->
    <a href="{{route('admin.dashboard')}}" class="nav-link active-bullish">
        <i class="fa-solid fa-chart-pie me-2"></i> Dashboard
    </a>

    <a href="{{route('admin.webinars.index')}}" class="nav-link">
        <i class="fa-solid fa-wallet me-2"></i> Live Webinar 
    </a>

   
    <a href="{{route('admin.hero.index')}}" class="nav-link">
        <i class="fa-solid fa-sliders me-2"></i> Main Section 
    </a>
    <a href="{{route('admin.abouts.index')}}" class="nav-link">
        <i class="fa-solid fa-sliders me-2"></i> About Section 
    </a>
    <a href="{{route('admin.problem.index')}}" class="nav-link">
        <i class="fa-solid fa-sliders me-2"></i> problem Selection 
    </a>
    <a href="{{route('admin.marketing.edit')}}" class="nav-link">
        <i class="fa-solid fa-sliders me-2"></i> Marketting Selection 
    </a>
     <a href="{{route('admin.webinar-modules.edit')}}" class="nav-link">
        <i class="fa-solid fa-sliders me-2"></i> Webinar Module Selection
    </a>
     <a href="{{route('admin.framework-bonuses.edit')}}" class="nav-link">
        <i class="fa-solid fa-sliders me-2"></i> Webinar Framework Selection
    </a>
      <a href="{{route('admin.funded-section.edit')}}" class="nav-link">
        <i class="fa-solid fa-sliders me-2"></i> WFunded AccountSelection
    </a>
     <a href="{{route('admin.faqs.index')}}" class="nav-link">
        <i class="fa-solid fa-sliders me-2"></i> FAQ 
    </a>
     <a href="{{route('admin.testimonials.index')}}" class="nav-link">
        <i class="fa-solid fa-sliders me-2"></i> Testimonial 
    </a>
      <a href="{{route('admin.email-template.index')}}" class="nav-link">
        <i class="fa-solid fa-sliders me-2"></i> Email Templete
    </a>

    <!-- Footer Logout Area -->
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</div>