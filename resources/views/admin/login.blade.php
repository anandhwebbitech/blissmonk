<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login | Bliss Monk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: flex-end; /* Moves container to the right side */
            align-items: center;
            background: url('{{ asset("asset/img/4.webp") }}') no-repeat center center / cover;
            position: relative;
            overflow: hidden;       
            padding: 20px 80px; /* Generous padding on screens to keep it away from the extreme edge */
        }

        /* Fallback class applied dynamically if local image fails */
        body.fallback-active {
            background-image: url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?q=80&w=1920');
        }

        /* Cinematic Eco-Dark Overlay */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(11, 27, 22, 0.3) 0%, rgba(11, 27, 22, 0.75) 100__);
            z-index: 1;
        }

        /* Premium Transparent Frosted-Glass Container */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.12); /* Semi-transparent white */
            backdrop-filter: blur(16px); /* Blurs background behind the card */
            -webkit-backdrop-filter: blur(16px);
            border-radius: 24px;
            padding: 45px 35px;
            border: 1px solid rgba(255, 255, 255, 0.2); /* Soft glass edge */
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.35);
            animation: appEntrance 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes appEntrance {
            from {
                opacity: 0;
                transform: scale(0.97) translateX(40px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateX(0);
            }
        }

        /* Eco Brand Header Icon */
        .brand-wrapper {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px auto;
            font-size: 24px;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        h4 {
            color: #ffffff;
            font-weight: 800;
            font-size: 26px;
            letter-spacing: -0.5px;
            text-align: center;
            margin-bottom: 6px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        p.subtitle {
            color: #e2e8f0;
            font-size: 14px;
            text-align: center;
            margin-bottom: 32px;
            font-weight: 400;
        }

        .form-group-custom {
            position: relative;
            margin-bottom: 22px;
        }

        label {
            color: #f8fafc;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 8px;
            display: block;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .input-field-wrapper {
            position: relative;
        }

        /* Glass Input Styling */
        .form-control {
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 14px 16px 14px 46px;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Focus state with sharp organic light green border */
        .form-control:focus {
            background: rgba(255, 255, 255, 0.18);
            border-color: #4ade80; 
            color: #ffffff;
            box-shadow: 0 0 0 4px rgba(74, 222, 128, 0.25);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            bottom: 16px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 16px;
            transition: color 0.2s ease;
            pointer-events: none;
        }

        .form-control:focus ~ .input-icon {
            color: #4ade80;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            bottom: 16px;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.6);
            font-size: 16px;
            transition: color 0.2s ease;
            z-index: 5;
        }

        .toggle-password:hover {
            color: #4ade80;
        }

        /* Vibrant Forest/Nature Green Action Button */
        .btn-agri {
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            padding: 14px;
            border: none;
            background: #16a34a; /* Crisp Nature Green */
            color: #ffffff;
            width: 100%;
            margin-top: 8px;
            transition: all 0.2s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        }

        .btn-agri:hover {
            background: #15803d;
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(22, 163, 74, 0.4);
        }

        .btn-agri:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            background-color: rgba(254, 242, 242, 0.9);
            color: #991b1b;
            padding: 14px;
        }

        .footer-note {
            text-align: center;
            margin-top: 32px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 500;
            letter-spacing: 0.2px;
        }

        /* Responsive balancing for mobile devices */
        @media(max-width: 768px) {
            body {
                justify-content: center;
                padding: 20px;
            }
            body::before {
                background: radial-gradient(circle at center, rgba(11, 27, 22, 0.5) 0%, rgba(11, 27, 22, 0.9) 100__);
            }
        }
    </style>    
</head>

<body>

    <div class="login-container">
        <div class="brand-wrapper">
            <i class="fa-solid fa-chart-simple" style="color: #4ade80;"></i>
        </div>

        <h4>Bliss Monk</h4>
        <p class="subtitle">Management Gateway</p>

        @if (session('error'))
            <div class="alert alert-danger mb-4">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="form-group-custom">
                <label for="email">Email Address</label>
                <div class="input-field-wrapper">
                    <input type="email" name="email" id="email" class="form-control" placeholder="admin@company.com" required autocomplete="email">
                    <i class="fa-regular fa-envelope input-icon"></i>
                </div>
            </div>

            <div class="form-group-custom">
                <label for="password">Password</label>
                <div class="input-field-wrapper">
                    <input type="password" name="password" id="password" class="form-control pe-5" placeholder="••••••••" required>
                    <i class="fa-solid fa-lock input-icon"></i>
                    <i class="fa-regular fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-agri">
                Access Dashboard <i class="fa-solid fa-arrow-right ms-1"></i>
            </button>
        </form>

        <div class="footer-note">
            Secure Admin Gateway &bull; Powered by Green System
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            const icon = document.querySelector(".toggle-password");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                password.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Target the body element since it carries the background styles directly now
        const bodyElement = document.body;
        if (bodyElement) {
            const img = new Image();
            img.src = "{{ asset('asset/img/4.webp') }}";
            
            img.onerror = function() {
                bodyElement.classList.add('fallback-active');
            };
        }
    });
    </script>
</body>
</html>