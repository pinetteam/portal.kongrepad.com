@php
    $meetingId = request()->route('meeting') ?? request()->segment(3);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name', 'Portal') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('header')
</head>
<body class="d-flex flex-column h-100">
<div id="kp-loading" class="d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status">
        <span class="visually-hidden">{{ __('common.loading') }}</span>
    </div>
</div>

<!-- Üst Navbar (Basitleştirilmiş) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-kongre-primary fixed-top" id="kp-header">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route("portal.dashboard.index") }}">
            @if(Auth()->check() && isset(Auth()->user()->customer->title))
                {{ Auth()->user()->customer->title }}
            @else
                {{ config('app.name') }}
            @endif
        </a>

        <!-- Right Side Items -->
        <div class="d-flex align-items-center">
            <!-- Language Selector -->
            <form action="{{ route('change.locale') }}" method="POST" class="me-3">
                @csrf
                <select class="form-select form-select-sm bg-kongre-secondary text-light border-0" name="locale" onchange="this.form.submit()">
                    <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>EN</option>
                    <option value="tr" {{ session('locale') == 'tr' ? 'selected' : '' }}>TR</option>
                </select>
            </form>
            
            <!-- User Dropdown -->
            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user-circle fa-lg"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">{{ Auth()->user()->full_name ?? 'User' }}</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('auth.logout.store') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-power-off me-2"></i>{{ __('common.logout') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Sol Sidebar - SABİT -->
<div class="sidebar-fixed bg-kongre-secondary" id="sidebar">
    <div class="sidebar-header border-bottom border-kongre">
        <h5 class="sidebar-title text-white">
            <i class="fa-solid fa-clipboard-list me-2"></i>Meeting Panel
        </h5>
    </div>
    <div class="sidebar-body">
        <nav class="nav flex-column">
            <!-- Dashboard -->
            <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/dashboard*') ? 'active bg-kongre-primary' : '' }}" href="{{ route("portal.dashboard.index") }}">
                <i class="fa-solid fa-house me-3"></i>{{ __('common.dashboard') }}
            </a>
            
            <!-- Meeting Overview -->
            <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId) ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.show', ['meeting' => $meetingId]) }}">
                <i class="fa-solid fa-circle-info me-3"></i>{{ __('common.overview') }}
            </a>

            <!-- Preparation Section -->
            <div class="nav-section">
                <h6 class="nav-section-title px-3 py-2 mb-0 text-white-50 text-uppercase fw-semibold">
                    <i class="fa-solid fa-clipboard-list me-2"></i>{{ __('common.preparation') }}
                </h6>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/document*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.document.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-folder-open me-3 ms-3"></i>{{ __('common.documents') }}
                </a>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/participant*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.participant.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-users me-3 ms-3"></i>{{ __('common.participants') }}
                </a>
            </div>

            <!-- Events & Activities Section -->
            <div class="nav-section">
                <h6 class="nav-section-title px-3 py-2 mb-0 text-white-50 text-uppercase fw-semibold">
                    <i class="fa-solid fa-calendar-star me-2"></i>{{ __('common.event-and-activity') }}
                </h6>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/announcement*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.announcement.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-megaphone me-3 ms-3"></i>{{ __('common.announcements') }}
                </a>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/score-game*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.score-game.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-gamepad me-3 ms-3"></i>{{ __('common.score-games') }}
                </a>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/survey*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.survey.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-poll me-3 ms-3"></i>{{ __('common.surveys') }}
                </a>
            </div>

            <!-- Environment Section -->
            <div class="nav-section">
                <h6 class="nav-section-title px-3 py-2 mb-0 text-white-50 text-uppercase fw-semibold">
                    <i class="fa-solid fa-building me-2"></i>{{ __('common.environment') }}
                </h6>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/hall*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.hall.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-door-open me-3 ms-3"></i>{{ __('common.halls') }}
                </a>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/virtual-stand*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.virtual-stand.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-store me-3 ms-3"></i>{{ __('common.virtual-stands') }}
                </a>
            </div>

            <!-- Reports Section -->
            <div class="nav-section">
                <h6 class="nav-section-title px-3 py-2 mb-0 text-white-50 text-uppercase fw-semibold">
                    <i class="fa-solid fa-chart-mixed me-2"></i>{{ __('common.reports') }}
                </h6>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/report/attendance*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.report.attendance.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-chart-user me-3 ms-3"></i>{{ __('common.attendance-reports') }}
                </a>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/log/participant*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.log.participant.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-list me-3 ms-3"></i>{{ __('common.participant-logs') }}
                </a>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/report/registration*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.report.registration.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-user-plus me-3 ms-3"></i>{{ __('common.registration-reports') }}
                </a>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/report/survey*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.report.survey.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-chart-bar me-3 ms-3"></i>{{ __('common.survey-reports') }}
                </a>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/report/keypad*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.report.keypad.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-chart-pie me-3 ms-3"></i>{{ __('common.keypad-reports') }}
                </a>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/report/debate*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.report.debate.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-balance-scale me-3 ms-3"></i>{{ __('common.debate-reports') }}
                </a>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/report/score-game*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.report.score-game.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-trophy me-3 ms-3"></i>{{ __('common.score-game-reports') }}
                </a>
                <a class="nav-link text-white border-bottom border-kongre {{ request()->is('portal/meeting/'.$meetingId.'/report/question*') ? 'active bg-kongre-primary' : '' }}" href="{{ route('portal.meeting.report.question.index', ['meeting' => $meetingId]) }}">
                    <i class="fa-solid fa-question-circle me-3 ms-3"></i>{{ __('common.question-reports') }}
                </a>
            </div>
        </nav>
    </div>
</div>

<!-- Ana İçerik Alanı -->
<div class="main-content">
    <!-- Breadcrumb -->
    <div class="breadcrumb-container px-4 py-2 bg-light border-bottom">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
            @yield('breadcrumb')
        </ol>
    </div>

    <!-- İçerik -->
    <div class="row g-0">
        <div class="col-12">
            <div class="p-4">
                @yield('meeting_content')
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for logout -->
<form id="logout-form" action="{{ route('auth.logout.store') }}" method="POST" class="d-none">
    @csrf
</form>

<x-common.popup.default />
@yield('footer')

<style>
/* CSS Variables */
:root {
    --kongre-primary: #2c3e50;
    --kongre-secondary: #34495e;
    --kongre-accent: #3498db;
    --kongre-accent-hover: #2980b9;
    --kongre-light: #ecf0f1;
    --kongre-dark: #1a2530;
    --kongre-border: rgba(255, 255, 255, 0.15);
    --kongre-success: #27ae60;
    --kongre-danger: #e74c3c;
    --kongre-warning: #f39c12;
    --kongre-info: #3498db;
}

/* Base Styles */
body {
    background-color: #f8f9fa;
    padding-top: 56px; /* Bootstrap navbar standard height */
}

/* Navbar Styles */
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
    border-color: var(--kongre-border) !important;
}

#kp-header {
    background-color: var(--kongre-primary) !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    height: 56px; /* Fixed navbar height */
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

/* Sidebar Styles */
.nav-section-title {
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.nav-link {
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
}

.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
}

.nav-link.active {
    border-left: 4px solid var(--kongre-accent) !important;
}

/* Breadcrumb Styles */
.breadcrumb-container {
    background-color: #ffffff;
    border-bottom: 1px solid #dee2e6;
}

.breadcrumb-item a {
    color: var(--kongre-accent);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #6c757d;
}

/* Card Styles */
.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
    overflow: hidden;
    border: none;
}

.card-header {
    background-color: var(--kongre-secondary);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 1rem;
    color: white !important;
}

/* Button Styles */
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

/* Text Styles */
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

/* Stats Card Styles */
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

/* Fixed Sidebar Layout */
.sidebar-fixed {
    position: fixed !important;
    top: 56px !important;
    left: 0 !important;
    height: calc(100vh - 56px) !important;
    width: 280px !important;
    z-index: 1000 !important;
    border-right: 1px solid var(--kongre-border) !important;
    overflow-y: auto !important;
}

.sidebar-header {
    padding: 1rem 1.5rem !important;
    background-color: var(--kongre-secondary) !important;
}

.sidebar-title {
    font-size: 1.1rem !important;
    font-weight: 600 !important;
    margin: 0 !important;
}

.sidebar-body {
    padding: 0 !important;
    height: calc(100% - 60px) !important;
    overflow-y: auto !important;
}

.main-content {
    margin-left: 280px !important;
    width: calc(100% - 280px) !important;
    min-height: calc(100vh - 56px) !important;
}

/* Mobile Responsive */
@media (max-width: 991.98px) {
    .sidebar-fixed {
        transform: translateX(-100%) !important;
    }
    
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
    }
}
</style>

<script>
// Fixed sidebar - no JavaScript needed
</script>
</body>
</html> 
