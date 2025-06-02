@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' .  __('common.score-game-reports'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.score-game-reports') }}</li>
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
                        <i class="fa-duotone fa-hundred-points fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.score-game-reports') }}</h1>
                        <p class="hero-subtitle">{{ __('common.score-game-reports-description') ?? 'Puan oyunları sonuçlarını ve oyuncu performanslarını görüntüleyin.' }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-trophy me-1"></i>
                                {{ $score_games->total() }} {{ __('common.total-games') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-toggle-on me-1"></i>
                                {{ $score_games->where('status', true)->count() }} {{ __('common.active') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Score Games Report Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-gamepad-modern me-2"></i>
                        {{ __('common.score-games-management') }}
                    </h3>
                    <div class="header-actions">
                        <span class="badge bg-success">
                            <i class="fa-regular fa-trophy me-1"></i>
                            {{ $score_games->total() }} {{ __('common.games') }}
                        </span>
                    </div>
                </div>
                
                @if($score_games->count() > 0)
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-image me-2"></i>
                                            {{ __('common.logo') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-signature me-2"></i>
                                            {{ __('common.title') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-arrow-up me-2"></i>
                                            {{ __('common.start-at') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-arrow-down me-2"></i>
                                            {{ __('common.finish-at') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-toggle-large-on me-2"></i>
                                            {{ __('common.status') }}
                                        </th>
                                        <th class="text-center">
                                            <i class="fa-regular fa-cogs me-2"></i>
                                            {{ __('common.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($score_games as $score_game)
                                        <tr>
                                            <td>
                                                <div class="item-info">
                                                    @if($score_game->logo)
                                                        <img src="{{ $score_game->logo }}" 
                                                             alt="{{ $score_game->title }}" 
                                                             class="item-logo" 
                                                             style="width: 40px; height: 40px; object-fit: cover;" />
                                                    @else
                                                        <div class="logo-placeholder" style="width: 40px; height: 40px;">
                                                            <i class="fa-duotone fa-image"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="item-name">{{ $score_game->title }}</div>
                                            </td>
                                            <td>
                                                @if($score_game->start_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($score_game->start_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($score_game->finish_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($score_game->finish_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $score_game->status ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $score_game->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $score_game->status ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a class="btn btn-outline-primary btn-sm" 
                                                       href="{{ route("portal.meeting.report.score-game.show", ['score_game' => $score_game->id, 'meeting' => $meeting->id]) }}" 
                                                       title="{{ __('common.show') }}"
                                                       data-bs-toggle="tooltip">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    @if($score_games->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $score_games->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-hundred-points"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-score-games-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-score-games-description') ?? 'Henüz hiç puan oyunu bulunmuyor.' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
