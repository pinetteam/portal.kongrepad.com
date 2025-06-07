<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KongrePad') }} - Conference Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-kongrepad navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-users-cog me-2 icon-gradient"></i>
                KongrePad
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">
                            <i class="fal fa-star me-1" data-icon-animate="spin"></i> Features
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#demo">
                            <i class="fal fa-play me-1" data-icon-animate="bounce"></i> Demo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">
                            <i class="fal fa-envelope me-1" data-icon-animate="shake"></i> Contact
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fad fa-globe me-1 pro-icon-duotone"></i> Language
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?lang=tr">🇹🇷 Türkçe</a></li>
                            <li><a class="dropdown-item" href="?lang=en">🇬🇧 English</a></li>
                            <li><a class="dropdown-item" href="?lang=de">🇩🇪 Deutsch</a></li>
                            <li><a class="dropdown-item" href="?lang=ar">🇸🇦 العربية</a></li>
                            <li><a class="dropdown-item" href="?lang=ru">🇷🇺 Русский</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section bg-gradient-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Professional Conference Management Platform
                    </h1>
                    <p class="lead mb-4">
                        Manage conferences, engage participants, and create memorable events with our comprehensive platform. 
                        Built with Laravel 12, UUID7 optimization, and multi-tenant architecture.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#demo" class="btn btn-light btn-lg" data-loading-text="Loading Demo...">
                            <i class="fas fa-rocket me-2"></i>
                            Start Demo
                        </a>
                        <a href="#features" class="btn btn-outline-light btn-lg">
                            <i class="fal fa-info-circle me-2"></i>
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image text-center">
                        <i class="fad fa-users-cog display-1 opacity-75 pro-icon-duotone icon-bounce"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card p-4 text-center">
                        <div class="stats-icon bg-primary text-white mx-auto mb-3">
                            <i class="fad fa-database pro-icon-duotone"></i>
                        </div>
                        <h3 class="h4 fw-bold text-primary">42</h3>
                        <p class="mb-0">Optimized Tables</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card p-4 text-center">
                        <div class="stats-icon bg-success text-white mx-auto mb-3">
                            <i class="fad fa-globe pro-icon-duotone"></i>
                        </div>
                        <h3 class="h4 fw-bold text-success">162</h3>
                        <p class="mb-0">Supported Countries</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card p-4 text-center">
                        <div class="stats-icon bg-info text-white mx-auto mb-3">
                            <i class="fad fa-language pro-icon-duotone"></i>
                        </div>
                        <h3 class="h4 fw-bold text-info">5</h3>
                        <p class="mb-0">Languages (with RTL)</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card p-4 text-center">
                        <div class="stats-icon bg-warning text-white mx-auto mb-3">
                            <i class="fad fa-tachometer-alt pro-icon-duotone"></i>
                        </div>
                        <h3 class="h4 fw-bold text-warning">70%</h3>
                        <p class="mb-0">Performance Boost</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="display-5 fw-bold">Powerful Features</h2>
                    <p class="lead text-muted">
                        Everything you need to manage professional conferences and engage participants
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Conference Management -->
                <div class="col-lg-4 col-md-6">
                    <div class="conference-card card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fad fa-calendar-alt fa-3x text-primary pro-icon-duotone icon-shadow"></i>
                            </div>
                            <h5 class="card-title">Conference Management</h5>
                            <p class="card-text text-muted">
                                Complete conference lifecycle management with venues, programs, sessions, and speakers.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Participant Engagement -->
                <div class="col-lg-4 col-md-6">
                    <div class="conference-card card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fad fa-users fa-3x text-success pro-icon-duotone icon-shadow"></i>
                            </div>
                            <h5 class="card-title">Participant Engagement</h5>
                            <p class="card-text text-muted">
                                Interactive polls, Q&A sessions, debates, and real-time participant engagement tools.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Multi-tenant Architecture -->
                <div class="col-lg-4 col-md-6">
                    <div class="conference-card card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fad fa-building fa-3x text-info pro-icon-duotone icon-shadow"></i>
                            </div>
                            <h5 class="card-title">Multi-tenant</h5>
                            <p class="card-text text-muted">
                                Secure multi-tenant architecture supporting multiple organizations on one platform.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- API Integration -->
                <div class="col-lg-4 col-md-6">
                    <div class="conference-card card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fad fa-plug fa-3x text-warning pro-icon-duotone icon-shadow"></i>
                            </div>
                            <h5 class="card-title">API Integration</h5>
                            <p class="card-text text-muted">
                                Comprehensive REST API with Sanctum authentication for mobile apps and integrations.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Analytics & Reporting -->
                <div class="col-lg-4 col-md-6">
                    <div class="conference-card card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fad fa-chart-line fa-3x text-danger pro-icon-duotone icon-shadow"></i>
                            </div>
                            <h5 class="card-title">Analytics & Reporting</h5>
                            <p class="card-text text-muted">
                                Detailed analytics, performance tracking, and comprehensive reporting tools.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- International Support -->
                <div class="col-lg-4 col-md-6">
                    <div class="conference-card card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fad fa-globe-americas fa-3x text-secondary pro-icon-duotone icon-shadow"></i>
                            </div>
                            <h5 class="card-title">International Support</h5>
                            <p class="card-text text-muted">
                                Support for 162 countries, 5 languages including RTL support for Arabic.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technical Stack Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="display-5 fw-bold">Technical Excellence</h2>
                    <p class="lead text-muted">
                        Built with modern technologies and best practices
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-3 fa-lg icon-shadow"></i>
                        <span><strong>Laravel 12</strong> - Latest framework with UUID7 support</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-3 fa-lg icon-shadow"></i>
                        <span><strong>Bootstrap 5</strong> - Modern, responsive UI framework</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-3 fa-lg icon-shadow"></i>
                        <span><strong>UUID7 Optimization</strong> - Chronological sorting performance</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-3 fa-lg icon-shadow"></i>
                        <span><strong>Sanctum API</strong> - Secure authentication system</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-3 fa-lg icon-shadow"></i>
                        <span><strong>Production Ready</strong> - 30-70% performance improvements</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-3 fa-lg icon-shadow"></i>
                        <span><strong>Essential Indexing</strong> - Memory usage reduced by 40-60%</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-3 fa-lg icon-shadow"></i>
                        <span><strong>42 Optimized Tables</strong> - Complete conference management</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-check-circle text-success me-3 fa-lg icon-shadow"></i>
                        <span><strong>Clean Architecture</strong> - Maintainable and scalable code</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FontAwesome Pro Demo Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="display-5 fw-bold">
                        <i class="fad fa-sparkles text-primary me-3 pro-icon-duotone"></i>
                        FontAwesome Pro Integration
                    </h2>
                    <p class="lead text-muted">
                        Experience the power of professional icons with animations and effects
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="card p-4 h-100">
                        <i class="fad fa-wand fa-3x text-primary mb-3 pro-icon-duotone" data-icon-animate="spin"></i>
                        <h5>Duotone Icons</h5>
                        <p class="small text-muted">Two-color icons with customizable colors</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="card p-4 h-100">
                        <i class="fal fa-feather fa-3x text-success mb-3 pro-icon-light" data-icon-animate="bounce"></i>
                        <h5>Light Icons</h5>
                        <p class="small text-muted">Thin, elegant icon style</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="card p-4 h-100">
                        <i class="fat fa-code fa-3x text-info mb-3 pro-icon-thin" data-icon-animate="pulse"></i>
                        <h5>Thin Icons</h5>
                        <p class="small text-muted">Ultra-thin professional icons</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="card p-4 h-100">
                        <i class="fas fa-gem fa-3x text-warning mb-3 icon-gradient" data-icon-animate="flash"></i>
                        <h5>Solid Icons</h5>
                        <p class="small text-muted">Classic filled icons with effects</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="lead">
                    <i class="fad fa-info-circle text-info me-2 pro-icon-duotone"></i>
                    <strong>7 Pro Icon Sets</strong> - Solid, Regular, Light, Thin, Duotone with animations and effects
                </p>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="display-5 fw-bold mb-4">
                        <i class="fad fa-rocket text-primary me-3 pro-icon-duotone"></i>
                        Ready to Get Started?
                    </h2>
                    <p class="lead text-muted mb-5">
                        Experience the power of KongrePad Conference Management System
                    </p>
                    
                    <div class="alert alert-info d-inline-block">
                        <i class="fad fa-info-circle me-2 pro-icon-duotone"></i>
                        Database setup required. Run migrations and seeders to begin.
                    </div>
                    
                    <div class="mt-4">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fal fa-terminal text-primary me-2"></i>
                                            Quick Setup Commands
                                        </h5>
                                        <div class="text-start">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-database text-success me-2"></i>
                                                <code>php artisan migrate</code>
                                                <button class="btn btn-sm btn-outline-secondary ms-auto" data-copy="php artisan migrate">
                                                    <i class="far fa-copy"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-seedling text-success me-2"></i>
                                                <code>php artisan db:seed</code>
                                                <button class="btn btn-sm btn-outline-secondary ms-auto" data-copy="php artisan db:seed">
                                                    <i class="far fa-copy"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fab fa-npm text-danger me-2"></i>
                                                <code>npm run dev</code>
                                                <button class="btn btn-sm btn-outline-secondary ms-auto" data-copy="npm run dev">
                                                    <i class="far fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <i class="fad fa-users-cog me-2 pro-icon-duotone"></i>
                        KongrePad
                    </h5>
                    <small class="text-muted">Professional Conference Management System</small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        Built with <i class="fas fa-heart text-danger"></i> using Laravel 12, Bootstrap 5 & FontAwesome Pro
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Custom Styles -->
    <style>
        .hero-section {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }
        
        .min-vh-75 {
            min-height: 75vh;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }
        
        .hero-image i {
            font-size: 8rem;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</body>
</html>
