@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' .  __('common.keypad-reports'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.keypad-reports') }}</li>
@endsection

@push('styles')
    @vite(['resources/css/meeting-pages-theme.css'])
@endpush

@section('meeting_content')
    <!-- Modern Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-chart-pie fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.keypad-reports') }}</h1>
                        <p class="hero-subtitle">{{ __('common.keypad-reports-description') ?? 'Keypad oylama sonuçlarını ve katılım istatistiklerini görüntüleyin.' }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-gamepad me-1"></i>
                                {{ count($keypads) }} {{ __('common.total-keypads') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-vote-yea me-1"></i>
                                {{ $keypads->sum(function($keypad) { return $keypad->votes->count(); }) }} {{ __('common.total-votes') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Keypad Reports Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-gamepad me-2"></i>
                        {{ __('common.keypad-sessions') }}
                    </h3>
                    <div class="header-actions">
                        <span class="badge bg-warning">
                            <i class="fa-regular fa-gamepad me-1"></i>
                            {{ count($keypads) }} {{ __('common.sessions') }}
                        </span>
                    </div>
                </div>
                
                @if(count($keypads) > 0)
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-layer-group me-2"></i>
                                            {{ __('common.keypad-session') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-gamepad me-2"></i>
                                            {{ __('common.keypad') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-arrow-up me-2"></i>
                                            {{ __('common.voting-started-at') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-arrow-down me-2"></i>
                                            {{ __('common.voting-finished-at') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-vote-yea me-2"></i>
                                            {{ __('common.vote-count') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-toggle-large-on me-2"></i>
                                            {{ __('common.on_vote') }}
                                        </th>
                                        <th class="text-center">
                                            <i class="fa-regular fa-cogs me-2"></i>
                                            {{ __('common.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($keypads as $keypad)
                                        <tr>
                                            <td>
                                                <div class="item-name">{{ $keypad->session->title }}</div>
                                            </td>
                                            <td>
                                                <div class="item-name">{{ $keypad->keypad }}</div>
                                            </td>
                                            <td>
                                                @if($keypad->voting_started_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($keypad->voting_started_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($keypad->voting_finished_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($keypad->voting_finished_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="count-badge">{{ $keypad->votes->count() }}</span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $keypad->on_vote ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $keypad->on_vote ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $keypad->on_vote ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a class="btn btn-outline-info btn-sm" 
                                                       href="{{ route("portal.meeting.report.keypad.participants",['keypad'=>$keypad->id, 'meeting'=>$meeting->id]) }}" 
                                                       title="{{ __('common.participants') }}"
                                                       data-bs-toggle="tooltip">
                                                        <i class="fa-regular fa-user"></i>
                                                    </a>
                                                    <a class="btn btn-outline-success btn-sm" 
                                                       href="{{ route("portal.meeting.report.keypad.question",['keypad'=>$keypad->id, 'meeting'=>$meeting->id]) }}" 
                                                       title="{{ __('common.report') }}"
                                                       data-bs-toggle="tooltip">
                                                        <i class="fa-regular fa-chart-bar"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-chart-pie"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-keypads-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-keypads-description') ?? 'Henüz hiç keypad oturumu bulunmuyor.' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
