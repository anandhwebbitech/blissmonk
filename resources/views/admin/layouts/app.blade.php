<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Green Moon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/frontend/new/fav-icon.webp')}}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- jQuery (MUST be before DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Global Page Styling */
        body {
            margin: 0;
            background-color: #f8fafc; /* Ultra clean minimal light grey background */
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #0f172a;
        }

        /* 
           PREMIUM SIDEBAR RE-DESIGN 
           Replaced blue gradient with Elite Matte Charcoal/Dark Forest (#0f172a)
        */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            background: #0f172a !important; /* Premium Matte Dark Slate */
            padding: 0 16px;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            z-index: 1000;
        }

        .sidebar h4 {
            font-weight: 700;
            color: #ffffff !important;
            letter-spacing: -0.5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        /* Modern Sidebar Links */
        .sidebar a {
            color: #94a3b8 !important; /* Soft premium grey */
            text-decoration: none;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 600;
            border-radius: 12px;
            margin-bottom: 6px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Hover State */
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            color: #ffffff !important;
            padding-left: 20px;
        }

        /* Active State with Rich Organic Green Accent */
        .sidebar a.active {
            background: #166534 !important; /* Dark Forest Green Accent */
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(22, 101, 52, 0.25);
            padding-left: 18px;
        }

        /* Fixed Icon Spacing */
        .sidebar a i {
            width: 24px;
            font-size: 16px;
            transition: transform 0.2s ease;
        }
        
        .sidebar a:hover i {
            transform: scale(1.1);
        }

        /* Layout Grid Balancing */
        .main-content {
            margin-left: 260px; /* Align correctly with sidebar width */
            background-color: #f8fafc;
            min-height: 100vh;
        }

        /* Premium Minimal Header */
        .header {
            position: sticky;
            top: 0;
            z-index: 999;
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(12px); /* High-end Apple-style blur glass effect */
            padding: 16px 30px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Main Dashboard Content Wrapper */
        .content-area {
            padding: 35px 30px;
        }
    </style>
</head>

<script>
document.addEventListener("DOMContentLoaded", function () {
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif
});
</script>

<body>

    @include('admin.partials.sidebar')

    <div class="main-content">

        @include('admin.partials.header')

        <div class="content-area">
            @yield('content')
        </div>
        
        <!-- DataTables JS (after jQuery) -->
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        </script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        @yield('scripts')
    </div>
</body>

</html>