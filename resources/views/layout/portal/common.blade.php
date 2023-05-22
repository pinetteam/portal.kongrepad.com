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
</head>
<body class="d-flex flex-column h-100">
<header class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" id="kp-header">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 overflow-hidden text-center" href="{{ route("portal.dashboard.index") }}">
        @if(Auth()->check() && isset(Auth()->user()->customer->title))
            {{ Auth()->user()->customer->title }}
        @else
            {{ config('app.name') }}
        @endif
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kp-menu" aria-controls="kp-menu" aria-expanded="false" aria-label="KongrePad Navigation">
        <i class="fa-regular fa-bars" id="kp-navbar-icon"></i>
    </button>
    <input class="form-control w-100" id="kp-search-box" type="text" placeholder="Search..." aria-label="Search"/>
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
                        <i class="nav-icon fa-duotone fa-clone"></i>
                        {{ __('common.dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">
                        <i class="nav-icon fa-duotone fa-users-rectangle"></i>
                        {{ __('common.operator-board') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route("portal.meeting.index") }}">
                        <i class="nav-icon fa-duotone fa-bee"></i>
                        {{ __('common.meetings') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <i class="nav-icon fa-duotone fa-arrow-turn-down-right"></i> {{ __('common.preparation') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route("portal.participant.index") }}">
                        <i class="nav-icon fa-duotone fa-screen-users"></i>
                        {{ __('common.participants') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route("portal.document.index") }}">
                        <i class="nav-icon fa-duotone fa-presentation-screen"></i>
                        {{ __('common.documents') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route("portal.program.index") }}">
                        <i class="nav-icon fa-duotone fa-newspaper"></i>
                        {{ __('common.programs') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <i class="nav-icon fa-duotone fa-arrow-turn-down-right"></i> {{ __('common.event-and-activity') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-duotone fa-face-party"></i>
                        {{ __('common.debates') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("portal.score-game.index") }}">
                        <i class="nav-icon fa-duotone fa-hundred-points"></i>
                        {{ __('common.score-game') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-duotone fa-square-poll-horizontal"></i>
                        {{ __('common.surveys') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-duotone fa-tablet"></i>
                        {{ __('common.keypads') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <i class="nav-icon fa-duotone fa-arrow-turn-down-right"></i> {{ __('common.environment') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("portal.meeting-hall.index") }}">
                        <i class="nav-icon fa-duotone fa-hotel"></i>
                        {{ __('common.meeting-halls') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <i class="nav-icon fa-duotone fa-arrow-turn-down-right"></i> {{ __('common.application') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-duotone fa-brush"></i>
                        {{ __('common.template-and-design') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-duotone fa-browser"></i>
                        {{ __('common.virtual-stands') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-duotone fa-rectangle-ad"></i>
                        {{ __('common.advertisements') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <i class="nav-icon fa-duotone fa-arrow-turn-down-right"></i> {{ __('common.statistic-and-report') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-duotone fa-wave-pulse"></i>
                        {{ __('common.live-stats') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-duotone fa-chart-user"></i>
                        {{ __('common.registration-reports') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa-duotone fa-option"></i>
                        {{ __('common.survey-reports') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <i class="nav-icon fa-duotone fa-arrow-turn-down-right"></i> {{ __('common.system') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("portal.user.index") }}">
                        <i class="nav-icon fa-duotone fa-users"></i>
                        {{ __('common.users') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("portal.user-role.index") }}">
                        <i class="nav-icon fa-duotone fa-person-military-pointing"></i>
                        {{ __('common.user-roles') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("portal.setting.index") }}">
                        <i class="nav-icon fa-duotone fa-gears"></i>
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
        <footer class="bg-dark text-light col-12 px-md-4 ms-sm-auto px-md-4 shadow" id="kp-footer">
            Copyright © 2017-{{ date('Y') }} {{ config('app.name') }}
        </footer>
    </div>
</div>
<x-common.popup.default />
@yield('footer')
<script>
    document.querySelectorAll(".nav-link").forEach((link) => {
        if (link.href == window.location.href) {
            link.classList.add("active")
        }
    });
</script>
</body>
</html>
