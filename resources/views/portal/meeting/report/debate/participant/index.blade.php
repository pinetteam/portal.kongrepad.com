@extends('layout.portal.meeting-detail')
@section('title', $title->title . ' | ' . __('common.participants'))

@push('styles')
    <link href="{{ asset('css/meeting-pages-theme.css') }}" rel="stylesheet">
@endpush

@section('breadcrumb')
    <div class="breadcrumb-container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb bg-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('portal.dashboard.index') }}" class="breadcrumb-link">
                        <i class="fas fa-home me-1"></i>{{ __('common.dashboard') }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route("portal.meeting.index") }}" class="breadcrumb-link">{{ __('common.meetings') }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('portal.meeting.show', $title->program->hall->meeting->id) }}" class="breadcrumb-link">
                        {{ $title->program->hall->meeting->title }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('portal.meeting.report.debate.index', ['meeting' => $title->program->hall->meeting->id]) }}" class="breadcrumb-link">
                        {{ __('common.debate-reports') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ '"' . $title->title. '" ' . __('common.participants') }}
                </li>
            </ol>
        </nav>
    </div>
@endsection

@section('meeting_content')
    <div class="hero-section mb-4">
        <div class="hero-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="hero-title mb-2">
                            <i class="fas fa-users-viewfinder text-primary me-2"></i>
                            {{ __('common.debate-participants') }}
                        </h1>
                        <p class="hero-subtitle text-muted mb-0">
                            "{{ $title->title }}" {{ __('common.participants-who-voted') }}
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="stats-card">
                            <div class="stat-item">
                                <i class="fas fa-vote-yea text-success"></i>
                                <span class="stat-number">{{ $votes->total() }}</span>
                                <span class="stat-label">{{ __('common.total-participants') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modern-table-container">
        <div class="table-card">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-list-check me-2"></i>
                    {{ __('common.debate-vote-results') }}
                </h3>
                <div class="table-actions">
                    <span class="badge bg-primary">
                        {{ $votes->total() }} {{ __('common.participants') }}
                    </span>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                    <tr>
                        <th scope="col">
                            <i class="fas fa-user me-2"></i>{{ __('common.participant') }}
                        </th>
                        <th scope="col">
                            <i class="fas fa-flag me-2"></i>{{ __('common.vote') }}
                        </th>
                        <th scope="col" class="text-end">
                            <i class="fas fa-clock me-2"></i>{{ __('common.voted-at') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($votes as $vote)
                        <tr class="table-row">
                            <td>
                                <div class="participant-info">
                                    @if($vote->participant->activity_status)
                                        <span class="status-indicator online" title="{{ __('common.online') }}"></span>
                                    @else
                                        <span class="status-indicator offline" title="{{ __('common.offline') }}"></span>
                                    @endif
                                    <span class="participant-name">{{ $vote->participant->full_name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="vote-badge">
                                    <i class="fas fa-circle-dot me-1"></i>
                                    {{ $vote->team->title }}
                                </span>
                            </td>
                            <td class="text-end">
                                <span class="vote-time">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $vote->created_at->format('d.m.Y H:i') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-user-slash text-muted fa-3x mb-3"></i>
                                    <h5 class="text-muted">{{ __('common.no-participants-found') }}</h5>
                                    <p class="text-muted">{{ __('common.no-participants-voted-yet') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($votes->hasPages())
                <div class="table-footer">
                    <div class="pagination-wrapper">
                        {{ $votes->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
