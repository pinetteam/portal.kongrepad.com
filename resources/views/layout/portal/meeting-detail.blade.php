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
            padding-top: 60px;
        }
        
        .bg-kongre-primary {
            background-color: var(--kongre-primary) !important;
        }
        
        .bg-kongre-secondary {
            background-color: var(--kongre-secondary) !important;
        }
        
        .text-kongre-light {
            color: var(--kongre-light) !important;
        }
        
        .border-kongre {
            border-color: rgba(255, 255, 255, 0.15) !important;
        }
        
        #kp-header {
            background-color: var(--kongre-primary) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-dark .dropdown-menu {
            background-color: var(--kongre-secondary);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-dark .dropdown-item {
            color: var(--kongre-light);
        }

        .navbar-dark .dropdown-item:hover, 
        .navbar-dark .dropdown-item:focus {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .navbar-dark .dropdown-header {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
        }

        .nav-icon {
            margin-right: 0.5rem;
            width: 1.5rem;
            text-align: center;
            color: var(--kongre-accent);
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
        
        .breadcrumb-container {
            background-color: var(--kongre-secondary);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .breadcrumb-item a {
            color: var(--kongre-accent);
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: var(--kongre-light);
        }
        
        .btn-kongre-primary {
            background-color: var(--kongre-primary);
            border-color: var(--kongre-primary);
            color: white;
        }
        
        .btn-kongre-primary:hover {
            background-color: var(--kongre-dark);
            border-color: var(--kongre-dark);
            color: white;
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
        
        .text-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        
        .text-value {
            color: white;
            font-size: 1.1rem;
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
        
        .nav-tabs .nav-link {
            color: var(--kongre-light);
            border: none;
            border-bottom: 2px solid transparent;
            border-radius: 0;
        }
        
        .nav-tabs .nav-link:hover {
            border-color: transparent;
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .nav-tabs .nav-link.active {
            background-color: transparent;
            border-bottom: 2px solid var(--kongre-accent);
            color: white;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<div id="kp-loading" class="d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status">
        <span class="visually-hidden">{{ __('common.loading') }}</span>
    </div>
</div>

<!-- Üst Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-kongre-primary fixed-top" id="kp-header">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route("portal.dashboard.index") }}">
            @if(Auth()->check() && isset(Auth()->user()->customer->title))
                {{ Auth()->user()->customer->title }}
            @else
                {{ config('app.name') }}
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('portal/dashboard*') ? 'active' : '' }}" href="{{ route("portal.dashboard.index") }}">
                        <span class="nav-icon fa-duotone fa-house"></span> {{ __('common.dashboard') }}
                    </a>
                </li>

                <!-- Meeting Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-icon fa-duotone fa-clipboard-list"></span> {{ __('common.meeting') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id) ? 'active' : '' }}" href="{{ route('portal.meeting.show', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-circle-info"></span> {{ __('common.overview') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Preparation Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-icon fa-duotone fa-clipboard-list"></span> {{ __('common.preparation') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/document*') ? 'active' : '' }}" href="{{ route('portal.meeting.document.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-folder-open"></span> {{ __('common.documents') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/participant*') ? 'active' : '' }}" href="{{ route('portal.meeting.participant.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-screen-users"></span> {{ __('common.participants') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Events & Activities Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-icon fa-duotone fa-calendar-star"></span> {{ __('common.event-and-activity') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/announcement*') ? 'active' : '' }}" href="{{ route('portal.meeting.announcement.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-megaphone"></span> {{ __('common.announcements') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/score-game*') ? 'active' : '' }}" href="{{ route('portal.meeting.score-game.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-hundred-points"></span> {{ __('common.score-games') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/survey*') ? 'active' : '' }}" href="{{ route('portal.meeting.survey.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-square-poll-horizontal"></span> {{ __('common.surveys') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Environment Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-icon fa-duotone fa-building"></span> {{ __('common.environment') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/hall*') ? 'active' : '' }}" href="{{ route('portal.meeting.hall.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-hotel"></span> {{ __('common.halls') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/virtual-stand*') ? 'active' : '' }}" href="{{ route('portal.meeting.virtual-stand.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-browser"></span> {{ __('common.virtual-stands') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Reports Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nav-icon fa-duotone fa-chart-mixed"></span> {{ __('common.reports') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/report/attendance*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.attendance.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-chart-user"></span> {{ __('common.attendance-reports') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/log/participant*') ? 'active' : '' }}" href="{{ route('portal.meeting.log.participant.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-chart-user"></span> {{ __('common.participant-logs') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/report/registration*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.registration.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-chart-user"></span> {{ __('common.registration-reports') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/report/survey*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.survey.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-option"></span> {{ __('common.survey-reports') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/report/keypad*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.keypad.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-chart-pie"></span> {{ __('common.keypad-reports') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/report/debate*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.debate.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-podium-star"></span> {{ __('common.debate-reports') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/report/score-game*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.score-game.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-hundred-points"></span> {{ __('common.score-game-reports') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is('portal/meeting/'.$meeting->id.'/report/question*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.question.index', ['meeting' => $meeting->id]) }}">
                                <span class="nav-icon fa-duotone fa-question"></span> {{ __('common.question-reports') }}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- Dil Seçimi -->
                <li class="nav-item">
                    <form action="{{ route('change.locale') }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        <select class="form-select form-select-sm bg-kongre-secondary text-light" name="locale" onchange="this.form.submit()">
                            <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>EN</option>
                            <option value="tr" {{ session('locale') == 'tr' ? 'selected' : '' }}>TR</option>
                        </select>
                    </form>
                </li>
                <!-- Çıkış Butonu -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.logout.store') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <span class="nav-icon fa-regular fa-power-off"></span> {{ __('common.logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('auth.logout.store') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Ana İçerik Alanı -->
<div class="container-fluid mt-3">
    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <ol class="breadcrumb m-0 text-kongre-light">
            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><span class="nav-icon fa-duotone fa-house"></span></a></li>
            @yield('breadcrumb')
        </ol>
    </div>

    <!-- İçerik -->
    <div class="row mt-3">
        <div class="col-12">
            @yield('meeting_content')
        </div>
    </div>
</div>

<x-common.popup.default />
@yield('footer')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Highlight active menu items
        document.querySelectorAll(".navbar-nav .dropdown-item").forEach((link) => {
            if (link.href == window.location.href) {
                link.classList.add("active");
                // Ebeveyn dropdown'ı aktif et
                link.closest('.dropdown').querySelector('.nav-link').classList.add('active');
            }
        });
        
        // Highlight active nav links
        document.querySelectorAll(".navbar-nav .nav-link").forEach((link) => {
            if (!link.classList.contains('dropdown-toggle') && link.href == window.location.href) {
                link.classList.add("active");
            }
        });
    });
</script>
</body>
</html> 
