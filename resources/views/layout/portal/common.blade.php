<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
    <style>
        :root {
            --kongre-primary: #2c3e50;
            --kongre-secondary: #34495e;
            --kongre-accent: #3498db;
            --kongre-accent-hover: #2980b9;
            --kongre-light: #ecf0f1;
            --kongre-dark: #1a2530;
            --kongre-success: #27ae60;
            --kongre-danger: #e74c3c;
            --kongre-warning: #f39c12;
            --kongre-info: #3498db;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .bg-kongre-primary {
            background-color: var(--kongre-primary) !important;
        }
        
        .bg-kongre-secondary {
            background-color: var(--kongre-secondary) !important;
        }
        
        .bg-kongre-dark {
            background-color: var(--kongre-dark) !important;
        }
        
        .text-kongre-light {
            color: var(--kongre-light) !important;
        }
        
        .border-kongre {
            border-color: rgba(255, 255, 255, 0.15) !important;
        }
        
        .btn-kongre-accent {
            background-color: var(--kongre-accent);
            border-color: var(--kongre-accent);
            color: white;
        }
        
        .btn-kongre-accent:hover {
            background-color: var(--kongre-accent-hover);
            border-color: var(--kongre-accent-hover);
            color: white;
        }
        
        .stats-card {
            background-color: var(--kongre-secondary);
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            color: white;
        }
        
        .stats-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .card-header {
            background-color: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem;
            color: white !important;
        }
        
        .card-header i, 
        .card-header span, 
        .card-header .fa-duotone, 
        .card-header .fa-fade {
            color: white !important;
        }
        
        .card-header h1, 
        .card-header h2, 
        .card-header h3, 
        .card-header h4, 
        .card-header h5, 
        .card-header h6,
        .card-header a,
        .card-header * {
            color: white !important;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<div id="kp-loading" class="d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-success" role="status">
        <span class="visually-hidden">{{ __('common.loading') }}</span>
    </div>
</div>
<header class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" id="kp-header">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 overflow-hidden text-center" href="{{ route("portal.dashboard.index") }}">
        @if(Auth()->check() && isset(Auth()->user()->customer->title))
            {{ Auth()->user()->customer->title }}
        @else
            {{ config('app.name') }}
        @endif
    </a>
    <button id="toggle-main-menu" class="btn btn-sm btn-link text-light d-none d-md-block" title="{{ __('common.toggle_menu') }}">
        <i class="fa-duotone fa-bars-staggered"></i>
    </button>
    <div class="w-100">
        @yield('search_bar')
    </div>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kp-menu" aria-controls="kp-menu" aria-expanded="false">
        <i class="fa-regular fa-bars" id="kp-navbar-icon"></i>
    </button>
    <div class="navbar-nav d-flex">
        <form action="{{ route('change.locale') }}" method="POST">
            @csrf
            <select class="bg-color2 text-light mx-4 mx-lg-3 mt-lg-0 mt-2 mb-2 mb-lg-0" name="locale" onchange="this.form.submit()">
                <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>EN</option>
                <option value="tr" {{ session('locale') == 'tr' ? 'selected' : '' }}>TR</option>
            </select>
        </form>
    </div>
    <div class="navbar-nav d-none d-md-flex">
        <div class="nav-item text-nowrap"><a class="nav-link px-3" href="{{ route('auth.logout.store') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa-regular fa-power-off"></i></a></div>
    </div>
</header>
<div class="container-fluid h-100">
    <div class="row h-100">
        <nav id="kp-menu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse overflow-auto">
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route("portal.dashboard.index") }}">
                        <span class="nav-icon fa-duotone fa-clone fa-fade"></span>
                        {{ __('common.dashboard') }}
                    </a>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" aria-current="page" href="{{ route("portal.meeting.index") }}">
                        <span class="nav-icon fa-duotone fa-bee fa-fade"></span>
                        {{ __('common.meetings') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <span class="nav-icon fa-duotone fa-arrow-turn-down-right"></span> {{ __('common.statistic') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("portal.live-stats.index") }}">
                        <span class="nav-icon fa-duotone fa-wave-pulse fa-fade"></span>
                        {{ __('common.live-stats') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <span class="nav-icon fa-duotone fa-arrow-turn-down-right"></span> {{ __('common.system') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("portal.user.index") }}">
                        <span class="nav-icon fa-duotone fa-users fa-fade"></span>
                        {{ __('common.users') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("portal.user-role.index") }}">
                        <span class="nav-icon fa-duotone fa-person-military-pointing fa-fade"></span>
                        {{ __('common.user-roles') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("portal.setting.index") }}">
                        <span class="nav-icon fa-duotone fa-gears fa-fade"></span>
                        {{ __('common.settings') }}
                    </a>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('auth.logout.store') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>
        <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 flex-shrink-0" id="kp-main">
           
            @yield('body')
        </main>
    </div>
</div>
<x-common.popup.default />
@yield('footer')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll(".nav-link").forEach((link) => {
            if (link.href == window.location.href) {
                link.classList.add("active");
            }
        });
        
        // Tüm kart başlıklarını ve içindeki öğeleri beyaz yapın
        document.querySelectorAll('.card-header').forEach(header => {
            header.style.color = 'white';
            header.querySelectorAll('h1, h2, h3, h4, h5, h6, span, i, a').forEach(element => {
                element.style.color = 'white';
            });
        });
        
        // Toggle main menu functionality
        const toggleMainMenuBtn = document.getElementById('toggle-main-menu');
        const mainMenu = document.getElementById('kp-menu');
        const mainContent = document.getElementById('kp-main');
        
        // Check if menu state is stored in localStorage
        const menuHidden = localStorage.getItem('kp_main_menu_hidden') === 'true';
        
        // Apply initial state
        if (menuHidden) {
            mainMenu.classList.add('d-none');
            mainMenu.classList.remove('d-md-block');
            mainContent.classList.add('col-md-12');
            mainContent.classList.remove('col-md-9', 'col-lg-10', 'ms-sm-auto');
        }
        
        toggleMainMenuBtn.addEventListener('click', function() {
            if (mainMenu.classList.contains('d-none')) {
                // Show menu
                mainMenu.classList.remove('d-none');
                mainMenu.classList.add('d-md-block');
                mainContent.classList.remove('col-md-12');
                mainContent.classList.add('col-md-9', 'col-lg-10', 'ms-sm-auto');
                localStorage.setItem('kp_main_menu_hidden', 'false');
            } else {
                // Hide menu
                mainMenu.classList.add('d-none');
                mainMenu.classList.remove('d-md-block');
                mainContent.classList.add('col-md-12');
                mainContent.classList.remove('col-md-9', 'col-lg-10', 'ms-sm-auto');
                localStorage.setItem('kp_main_menu_hidden', 'true');
            }
        });
    });
</script>
</body>
</html>
