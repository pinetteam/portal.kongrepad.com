@php
    $meetingId = request()->route('meeting') ?? request()->segment(3);
@endphp
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
    
    <!-- Meeting Styles - Consolidated CSS -->
    @vite(['resources/css/meeting-pages-theme.css'])
    
  
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
                @foreach($activeLanguages as $language)
                    <option value="{{ $language->code }}" {{ session('locale') == $language->code ? 'selected' : '' }}>
                        {{ strtoupper($language->code) }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="navbar-nav d-none d-md-flex">
        <div class="nav-item text-nowrap"><a class="nav-link px-3" href="{{ route('auth.logout.store') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa-regular fa-power-off"></i></a></div>
    </div>
</header>
<div class="container-fluid h-100">
    <div class="row h-100">
        <nav id="kp-menu" class="col-md-3 col-lg-2 d-md-block  collapse overflow-auto">
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route("portal.dashboard.index") }}">
                        <span class="nav-icon fa-duotone fa-clone fa-fade"></span>
                        {{ __('common.dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route("portal.meeting.index") }}">
                        <span class="nav-icon fa-duotone fa-calendar-days fa-fade"></span>
                        {{ __('common.meetings') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('portal.meeting.show', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-circle-info fa-fade"></span>
                        {{ __('common.overview') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <span class="nav-icon fa-duotone fa-arrow-turn-down-right"></span> {{ __('common.preparation') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.document.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-folder-open fa-fade"></span>
                        {{ __('common.documents') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.participant.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-users fa-fade"></span>
                        {{ __('common.participants') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <span class="nav-icon fa-duotone fa-arrow-turn-down-right"></span> {{ __('common.event-and-activity') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.announcement.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-megaphone fa-fade"></span>
                        {{ __('common.announcements') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.score-game.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-gamepad fa-fade"></span>
                        {{ __('common.score-games') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.survey.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-poll fa-fade"></span>
                        {{ __('common.surveys') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <span class="nav-icon fa-duotone fa-arrow-turn-down-right"></span> {{ __('common.environment') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.hall.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-door-open fa-fade"></span>
                        {{ __('common.halls') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.virtual-stand.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-store fa-fade"></span>
                        {{ __('common.virtual-stands') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-heading">
                <span class="nav-icon fa-duotone fa-arrow-turn-down-right"></span> {{ __('common.reports') }}
            </div>
            <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.report.attendance.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-chart-user fa-fade"></span>
                        {{ __('common.attendance-reports') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.log.participant.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-list fa-fade"></span>
                        {{ __('common.participant-logs') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.report.registration.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-user-plus fa-fade"></span>
                        {{ __('common.registration-reports') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.report.survey.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-chart-bar fa-fade"></span>
                        {{ __('common.survey-reports') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.report.keypad.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-chart-pie fa-fade"></span>
                        {{ __('common.keypad-reports') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.report.debate.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-balance-scale fa-fade"></span>
                        {{ __('common.debate-reports') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.report.score-game.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-trophy fa-fade"></span>
                        {{ __('common.score-game-reports') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.meeting.report.question.index', ['meeting' => $meetingId]) }}">
                        <span class="nav-icon fa-duotone fa-question-circle fa-fade"></span>
                        {{ __('common.question-reports') }}
                    </a>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('auth.logout.store') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>
        <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 flex-shrink-0" id="kp-main">
            <!-- Breadcrumb -->
            @if(View::hasSection('breadcrumb'))
                <div class="breadcrumb-container px-0 py-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
            @else
                <!-- Default Breadcrumb for Meeting Pages -->
                <div class="breadcrumb-container px-0 py-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}">{{ __('common.meetings') }}</a></li>
                            @if(isset($meeting))
                                <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}">{{ $meeting->title }}</a></li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">{{ View::yieldContent('title') }}</li>
                        </ol>
                    </nav>
                </div>
            @endif

            @yield('meeting_content')
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
    });
</script>
</body>
</html> 
