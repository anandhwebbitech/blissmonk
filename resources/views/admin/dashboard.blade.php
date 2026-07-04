@extends('admin.layouts.app')

@section('content')

<style>
    /* Premium Dashboard Grid Setup */
    .dashboard-container {
        padding: 30px 24px;
        background-color: #f8fafc;
        min-height: 100vh;
    }

    /* Ultra-Modern Minimalist Cards */
    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 4px rgba(15, 23, 42, 0.01), 0 1px 2px rgba(15, 23, 42, 0.02);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
        border-color: #cbd5e1;
    }

    /* Isolated Premium Icon Badges */
    .badge-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
        font-weight: 600;
    }

    /* Content Typography refinement */
    .stat-label {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 6px;
        text-transform: capitalize;
    }

    .stat-number {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        line-height: 1;
    }

    /* Organic & Clean Color Accent System */
    .accent-emerald { background-color: #f0fdf4; color: #15803d; }
    .accent-blue { background-color: #eff6ff; color: #1d4ed8; }
    .accent-amber { background-color: #fffbeb; color: #b45309; }
    .accent-indigo { background-color: #f5f3ff; color: #4338ca; }
    .accent-cyan { background-color: #ecfeff; color: #0e7490; }
    .accent-rose { background-color: #fff1f2; color: #be123c; }
    .accent-violet { background-color: #faf5ff; color: #6d28d9; }
    .accent-slate { background-color: #f1f5f9; color: #334155; }

    /* Micro Trend Indicator (Subtext) */
    .stat-subtext {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 12px;
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 500;
    }
</style>

<div class="dashboard-container">

    <!-- Page Heading Area -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
        <div>
            <h3 class="fw-extrabold text-slate-900 mb-1" style="font-weight: 800; color: #0f172a; letter-spacing: -0.5px;">Dashboard</h3>
            <p class="text-muted small mb-0">Overview of your farming platform activities.</p>
        </div>
        <div class="px-3 py-2 bg-white rounded-3 border text-sm font-medium" style="font-size: 14px; color: #475569; font-weight: 500;">
            Welcome back, <span style="font-weight: 700; color: #0f172a;">Admin 👋</span>
        </div>
    </div>

   
    <!-- Secondary Statistics Row -->
    <div class="row g-4 mt-1">

        <!-- Total Properties -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Total Webinar</div>
                        <div class="stat-number">00</div>
                    </div>
                    <div class="badge-icon-box accent-indigo">
                        <i class="fa-solid fa-chalkboard-user" style="color: rgb(234, 19, 0);"></i>

                    </div>
                </div>
            
            </div>
        </div>


    </div>

</div>

@endsection