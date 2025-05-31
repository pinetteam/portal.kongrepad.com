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
        
        #kp-menu {
            background-color: var(--kongre-primary) !important;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .meeting-sidebar {
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            height: calc(100vh - 100px);
            overflow-y: auto;
            background-color: var(--kongre-secondary);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
        }
        
        .meeting-sidebar .nav-link {
            border-radius: 0;
            padding: 0.75rem 1rem;
            color: var(--kongre-light);
            border-left: 4px solid transparent;
            transition: all 0.2s ease-in-out;
            margin-bottom: 2px;
        }
        
        .meeting-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--kongre-accent);
            color: white;
        }
        
        .meeting-sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid var(--kongre-accent);
            color: white;
            font-weight: 500;
        }
        
        .meeting-sidebar .sidebar-heading {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: bold;
            padding: 1rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.2);
        }
        
        .meeting-sidebar .nav-icon {
            margin-right: 0.5rem;
            width: 1.5rem;
            text-align: center;
            color: var(--kongre-accent);
        }
        
        .meeting-info-banner {
            background: linear-gradient(45deg, var(--kongre-primary), var(--kongre-secondary));
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            border: none;
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
<header class="navbar navbar-dark fixed-top bg-kongre-primary flex-md-nowrap p-0 shadow" id="kp-header">
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
            <select class="bg-kongre-secondary text-light mx-4 mx-lg-3 mt-lg-0 mt-2 mb-2 mb-lg-0" name="locale" onchange="this.form.submit()">
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
        <!-- Main Sidebar -->
        <nav id="kp-menu" class="col-md-3 col-lg-2 d-md-block bg-kongre-primary sidebar collapse overflow-auto">
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
        
        <!-- Main Content Area -->
        <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 flex-shrink-0" id="kp-main">
            <div class="breadcrumb-container mt-3">
                <ol class="breadcrumb m-0 text-kongre-light">
                    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><span class="nav-icon fa-duotone fa-house"></span></a></li>
                    @yield('breadcrumb')
                </ol>
            </div>
            
            <!-- Meeting Content Area with Sidebar -->
            <div class="row mt-3">
                <!-- Meeting Sidebar -->
                <div class="col-md-3" id="meeting-sidebar-column">
                    <div class="meeting-sidebar p-0" id="meeting-sidebar">
                        <div class="sidebar-heading">
                            <span class="nav-icon fa-duotone fa-clipboard-list"></span> {{ __('common.meeting') }}
                        </div>
                        
                        <!-- Meeting Info -->
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id) ? 'active' : '' }}" href="{{ route('portal.meeting.show', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-circle-info"></span>
                                    {{ __('common.overview') }}
                                </a>
                            </li>
                        </ul>
                        
                        <!-- Preparation -->
                        <div class="sidebar-heading">
                            <span class="nav-icon fa-duotone fa-clipboard-list"></span> {{ __('common.preparation') }}
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/document*') ? 'active' : '' }}" href="{{ route('portal.meeting.document.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-folder-open"></span>
                                    {{ __('common.documents') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/participant*') ? 'active' : '' }}" href="{{ route('portal.meeting.participant.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-screen-users"></span>
                                    {{ __('common.participants') }}
                                </a>
                            </li>
                        </ul>
                        
                        <!-- Events & Activities -->
                        <div class="sidebar-heading">
                            <span class="nav-icon fa-duotone fa-calendar-star"></span> {{ __('common.event-and-activity') }}
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/announcement*') ? 'active' : '' }}" href="{{ route('portal.meeting.announcement.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-megaphone"></span>
                                    {{ __('common.announcements') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/score-game*') ? 'active' : '' }}" href="{{ route('portal.meeting.score-game.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-hundred-points"></span>
                                    {{ __('common.score-games') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/survey*') ? 'active' : '' }}" href="{{ route('portal.meeting.survey.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-square-poll-horizontal"></span>
                                    {{ __('common.surveys') }}
                                </a>
                            </li>
                        </ul>
                        
                        <!-- Environment -->
                        <div class="sidebar-heading">
                            <span class="nav-icon fa-duotone fa-building"></span> {{ __('common.environment') }}
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/hall*') ? 'active' : '' }}" href="{{ route('portal.meeting.hall.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-hotel"></span>
                                    {{ __('common.halls') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/virtual-stand*') ? 'active' : '' }}" href="{{ route('portal.meeting.virtual-stand.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-browser"></span>
                                    {{ __('common.virtual-stands') }}
                                </a>
                            </li>
                        </ul>
                        
                        <!-- Reports -->
                        <div class="sidebar-heading">
                            <span class="nav-icon fa-duotone fa-chart-mixed"></span> {{ __('common.reports') }}
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/report/attendance*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.attendance.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-chart-user"></span>
                                    {{ __('common.attendance-reports') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/log/participant*') ? 'active' : '' }}" href="{{ route('portal.meeting.log.participant.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-chart-user"></span>
                                    {{ __('common.participant-logs') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/report/registration*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.registration.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-chart-user"></span>
                                    {{ __('common.registration-reports') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/report/survey*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.survey.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-option"></span>
                                    {{ __('common.survey-reports') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/report/keypad*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.keypad.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-chart-pie"></span>
                                    {{ __('common.keypad-reports') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/report/debate*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.debate.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-podium-star"></span>
                                    {{ __('common.debate-reports') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/report/score-game*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.score-game.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-hundred-points"></span>
                                    {{ __('common.score-game-reports') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('portal/meeting/'.$meeting->id.'/report/question*') ? 'active' : '' }}" href="{{ route('portal.meeting.report.question.index', ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-question"></span>
                                    {{ __('common.question-reports') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Meeting Content -->
                <div class="col-md-9">
                    @yield('meeting_content')
                </div>
            </div>
        </main>
    </div>
</div>
<x-common.popup.default />
@yield('footer')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Highlight active menu item in the main sidebar
        document.querySelectorAll("#kp-menu .nav-link").forEach((link) => {
            if (link.href == window.location.href) {
                link.classList.add("active");
            }
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
