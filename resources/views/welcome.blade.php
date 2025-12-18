<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Starter Kit</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ffd700;
        }
        .btn-custom {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-light-custom {
            background: white;
            color: #667eea;
        }
        .btn-light-custom:hover {
            background: #f8f9fa;
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(255, 255, 255, 0.3);
        }
        .btn-outline-custom {
            border: 2px solid white;
            color: white;
            background: transparent;
        }
        .btn-outline-custom:hover {
            background: white;
            color: #667eea;
            transform: scale(1.05);
        }
        .logo-text {
            font-size: 3.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
        }
        .auth-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        @media (max-width: 768px) {
            .logo-text {
                font-size: 2.5rem;
            }
            .subtitle {
                font-size: 1.1rem;
            }
            .auth-buttons {
                position: relative;
                top: 0;
                right: 0;
                text-align: center;
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Auth Buttons -->
    @if (Route::has('login'))
        <div class="auth-buttons">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-light-custom btn-custom">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-custom btn-custom me-2">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-light-custom btn-custom">
                        <i class="bi bi-person-plus"></i> Register
                    </a>
                @endif
            @endauth
        </div>
    @endif

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h1 class="logo-text mb-3">
                        <i class="bi bi-rocket-takeoff"></i> Laravel Starter Kit
                    </h1>
                    <p class="subtitle mb-4">
                        Production-Ready • Secure • Feature-Rich
                    </p>
                    <p class="lead mb-5">
                        A complete Laravel boilerplate with authentication, MFA, user management, and essential services
                    </p>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <i class="bi bi-shield-lock feature-icon"></i>
                        <h4>Advanced Security</h4>
                        <p class="mb-0">Multi-factor authentication, super password, and role-based permissions</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <i class="bi bi-people feature-icon"></i>
                        <h4>User Management</h4>
                        <p class="mb-0">Complete CRUD, soft deletes, impersonation, and activity logging</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <i class="bi bi-gear feature-icon"></i>
                        <h4>Essential Services</h4>
                        <p class="mb-0">OTP, notifications, file upload, image resize, and more</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <i class="bi bi-file-text feature-icon"></i>
                        <h4>Log Viewer</h4>
                        <p class="mb-0">View and filter Laravel logs with sensitive data masking</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <i class="bi bi-bootstrap feature-icon"></i>
                        <h4>Bootstrap UI</h4>
                        <p class="mb-0">Modern, responsive design with Bootstrap 5 and icons</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center h-100">
                        <i class="bi bi-lightning feature-icon"></i>
                        <h4>Ready to Deploy</h4>
                        <p class="mb-0">Production-ready code with comprehensive documentation</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <h3 class="mb-4">Get Started in Minutes</h3>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-light-custom btn-custom btn-lg">
                                <i class="bi bi-rocket"></i> Create Account
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-custom btn-custom btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Sign In
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="btn btn-light-custom btn-custom btn-lg">
                                <i class="bi bi-speedometer2"></i> Go to Dashboard
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
