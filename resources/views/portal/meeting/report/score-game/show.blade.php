@extends('layout.portal.meeting-detail')
@section('title', __('common.score-game') . ' | ' . $score_game->title)

@section('breadcrumb')
    <div class="breadcrumb-container px-0 py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}">{{ __('common.meetings') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $score_game->meeting->id) }}">{{ $score_game->meeting->title }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('portal.meeting.report.score-game.index', ['meeting' => $score_game->meeting->id]) }}">{{ __('common.score-game-reports') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $score_game->title }}</li>
            </ol>
        </nav>
    </div>
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
                        <i class="fa-duotone fa-trophy fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $score_game->title }}</h1>
                        <p class="hero-subtitle">{{ __('common.score-game-participants-results') ?? 'Puan oyunu katılımcı sonuçlarını ve sıralamalarını görüntüleyin.' }} - {{ $score_game->meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-users me-1"></i>
                                {{ $score_game_points->total() }} {{ __('common.participants') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-chart-line me-1"></i>
                                {{ __('common.score-results') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-actions">
                        <a href="{{ route('portal.meeting.report.score-game.index', ['meeting' => $score_game->meeting->id]) }}" 
                           class="btn btn-outline-light">
                            <i class="fa-regular fa-arrow-left me-2"></i>
                            {{ __('common.back-to-list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Score Game Results Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-ranking-star me-2"></i>
                        {{ __('common.participant-scores') }}
                    </h3>
                    <div class="header-actions">
                        <span class="badge bg-warning">
                            <i class="fa-regular fa-trophy me-1"></i>
                            {{ $score_game_points->total() }} {{ __('common.participants') }}
                        </span>
                    </div>
                </div>
                
                @if($score_game_points->count() > 0)
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-ranking me-2"></i>
                                            {{ __('common.rank') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-user me-2"></i>
                                            {{ __('common.participant') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-hundred-points me-2"></i>
                                            {{ __('common.total-points') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($score_game_points as $index => $score_game_point)
                                        @php
                                            $participant = \App\Models\Meeting\Participant\Participant::findOrFail($score_game_point->participant_id);
                                            $rank = ($score_game_points->currentPage() - 1) * $score_game_points->perPage() + $index + 1;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="rank-badge rank-{{ $rank <= 3 ? $rank : 'other' }}">
                                                    @if($rank == 1)
                                                        <i class="fa-solid fa-trophy text-warning me-1"></i>
                                                    @elseif($rank == 2)
                                                        <i class="fa-solid fa-medal text-secondary me-1"></i>
                                                    @elseif($rank == 3)
                                                        <i class="fa-solid fa-award text-warning me-1"></i>
                                                    @else
                                                        <i class="fa-regular fa-hashtag me-1"></i>
                                                    @endif
                                                    {{ $rank }}
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('portal.meeting.participant.show', ['meeting' => $score_game->meeting->id, 'participant' => $participant->id]) }}" 
                                                   class="participant-link">
                                                    <div class="item-name">{{ $participant->full_name }}</div>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="score-badge">
                                                    <i class="fa-regular fa-hundred-points me-1"></i>
                                                    {{ number_format($score_game_point->total_points) }} {{ __('common.points') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    @if($score_game_points->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $score_game_points->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-trophy"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-scores-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-scores-description') ?? 'Henüz hiç puan kaydı bulunmuyor.' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
