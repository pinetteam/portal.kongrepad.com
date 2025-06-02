@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' .  __('common.debate-reports'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.debate-reports') }}</li>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/meeting-pages-theme.css') }}">
@endpush

@section('meeting_content')
    <!-- Modern Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-podium-star fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.debate-reports') }}</h1>
                        <p class="hero-subtitle">{{ __('common.debate-reports-description') ?? 'Tartışma oylama sonuçlarını ve katılım istatistiklerini görüntüleyin.' }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-podium me-1"></i>
                                {{ count($debates) }} {{ __('common.total-debates') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-vote-yea me-1"></i>
                                {{ $debates->sum(function($debate) { return $debate->votes->count(); }) }} {{ __('common.total-votes') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Debate Reports Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-users-viewfinder me-2"></i>
                        {{ __('common.debate-sessions') }}
                    </h3>
                    <div class="header-actions">
                        <span class="badge bg-danger">
                            <i class="fa-regular fa-podium me-1"></i>
                            {{ count($debates) }} {{ __('common.debates') }}
                        </span>
                    </div>
                </div>
                
                @if(count($debates) > 0)
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-calendar-days me-2"></i>
                                            {{ __('common.debate-program') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-podium me-2"></i>
                                            {{ __('common.debate') }}
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
                                    @foreach($debates as $debate)
                                        <tr>
                                            <td>
                                                <div class="item-name">{{ $debate->program->title }}</div>
                                            </td>
                                            <td>
                                                <div class="item-name">{{ $debate->title }}</div>
                                            </td>
                                            <td>
                                                @if($debate->voting_started_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($debate->voting_started_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($debate->voting_finished_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($debate->voting_finished_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="count-badge">{{ $debate->votes->count() }}</span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $debate->on_vote ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $debate->on_vote ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $debate->on_vote ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a class="btn btn-outline-info btn-sm" 
                                                       href="{{ route("portal.meeting.report.debate.participants",['debate'=>$debate->id, 'meeting'=> $meeting->id]) }}" 
                                                       title="{{ __('common.participants') }}"
                                                       data-bs-toggle="tooltip">
                                                        <i class="fa-regular fa-user"></i>
                                                    </a>
                                                    <a class="btn btn-outline-success btn-sm" 
                                                       href="{{ route("portal.meeting.report.debate",['debate'=>$debate->id, 'meeting'=> $meeting->id]) }}" 
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
                                <i class="fa-duotone fa-podium-star"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-debates-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-debates-description') ?? 'Henüz hiç tartışma oturumu bulunmuyor.' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection



