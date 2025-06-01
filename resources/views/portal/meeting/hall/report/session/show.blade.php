@extends('layout.portal.meeting-detail')
@section('title', $session->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $session->program->hall->meeting->id) }}" class="text-decoration-none">{{ $session->program->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $session->program->hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id]) }}" class="text-decoration-none">{{ $session->program->hall->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.report.session.index', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id]) }}" class="text-decoration-none">{{ __('common.session-reports') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $session->title }}</li>
@endsection
@section('meeting_content')
    <!-- Session Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="session-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-solid fa-presentation-screen"></i>
                    </div>
                    <div class="hero-details">
                        <h1 class="hero-title">{{ $session->title }}</h1>
                        <div class="hero-meta">
                            <span class="meta-item">
                                <i class="fa-solid fa-code me-1"></i>
                                {{ $session->code }}
                            </span>
                            <span class="meta-item">
                                <i class="fa-solid fa-calendar me-1"></i>
                                {{ $session->program->title }}
                            </span>
                            <span class="status-badge {{ $session->status ? 'status-active' : 'status-inactive' }}">
                                <i class="fa-solid fa-circle"></i>
                                {{ $session->status ? __('common.active') : __('common.passive') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stats-card-modern">
                <div class="stats-icon stats-icon-primary">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="stats-details">
                    <div class="stats-value">{{ $session->duration ?: __('common.unspecified') }}</div>
                    <div class="stats-label">{{ __('common.duration') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stats-card-modern">
                <div class="stats-icon stats-icon-success">
                    <i class="fa-solid fa-question-circle"></i>
                </div>
                <div class="stats-details">
                    <div class="stats-value">{{ $session->questions()->count() }}</div>
                    <div class="stats-label">{{ __('common.questions') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stats-card-modern">
                <div class="stats-icon stats-icon-info">
                    <i class="fa-solid fa-calendar-plus"></i>
                </div>
                <div class="stats-details">
                    <div class="stats-value">{{ $session->started_at ? \Carbon\Carbon::parse($session->started_at)->format('H:i') : __('common.unspecified') }}</div>
                    <div class="stats-label">{{ __('common.started-at') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stats-card-modern">
                <div class="stats-icon stats-icon-warning">
                    <i class="fa-solid fa-calendar-minus"></i>
                </div>
                <div class="stats-details">
                    <div class="stats-value">{{ $session->finished_at ? \Carbon\Carbon::parse($session->finished_at)->format('H:i') : __('common.unspecified') }}</div>
                    <div class="stats-label">{{ __('common.finished-at') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Details Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card modern-card">
                <div class="card-header modern-header">
                    <h5 class="card-title mb-0">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        {{ __('common.session-details') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">{{ __('common.title') }}</label>
                                <div class="detail-value">{{ $session->title }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">{{ __('common.code') }}</label>
                                <div class="detail-value">{{ $session->code }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">{{ __('common.program') }}</label>
                                <div class="detail-value">{{ $session->program->title }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">{{ __('common.created-by') }}</label>
                                <div class="detail-value">{{ $session->created_by_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">{{ __('common.created-at') }}</label>
                                <div class="detail-value">{{ $session->created_at ? \Carbon\Carbon::parse($session->created_at)->format('d.m.Y H:i') : __('common.unspecified') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">{{ __('common.status') }}</label>
                                <div class="detail-value">
                                    <span class="badge {{ $session->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $session->status ? __('common.active') : __('common.passive') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keypad Reports Card -->
    <div class="row">
        <div class="col-12">
            <div class="card modern-card">
                <div class="card-header modern-header">
                    <h5 class="card-title mb-0">
                        <i class="fa-solid fa-chart-pie me-2"></i>
                        {{ __('common.keypad-reports') }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($session->keypads->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 modern-table">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <i class="fa-solid fa-gamepad me-1"></i>{{ __('common.keypad') }}
                                        </th>
                                        <th scope="col">
                                            <i class="fa-solid fa-play me-1"></i>{{ __('common.voting-started-at') }}
                                        </th>
                                        <th scope="col">
                                            <i class="fa-solid fa-stop me-1"></i>{{ __('common.voting-finished-at') }}
                                        </th>
                                        <th scope="col">
                                            <i class="fa-solid fa-vote-yea me-1"></i>{{ __('common.vote-count') }}
                                        </th>
                                        <th scope="col" class="text-end">{{ __('common.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($session->keypads as $keypad)
                                        <tr>
                                            <td class="fw-medium">{{ $keypad->keypad }}</td>
                                            <td>
                                                @if($keypad->voting_started_at)
                                                    <span class="text-success">
                                                        <i class="fa-solid fa-clock me-1"></i>
                                                        {{ \Carbon\Carbon::parse($keypad->voting_started_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="fa-solid fa-minus me-1"></i>
                                                        {{ __('common.unspecified') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($keypad->voting_finished_at)
                                                    <span class="text-danger">
                                                        <i class="fa-solid fa-clock me-1"></i>
                                                        {{ \Carbon\Carbon::parse($keypad->voting_finished_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="fa-solid fa-minus me-1"></i>
                                                        {{ __('common.unspecified') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary rounded-pill">
                                                    {{ $keypad->votes->count() }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-outline-info btn-sm" 
                                                       href="{{ route("portal.meeting.report.keypad.participants",['keypad'=>$keypad->id, 'meeting'=>$meeting->id]) }}" 
                                                       title="{{ __('common.participants') }}" 
                                                       data-bs-toggle="tooltip" 
                                                       data-bs-placement="top">
                                                        <i class="fa-solid fa-users"></i>
                                                    </a>
                                                    <a class="btn btn-outline-success btn-sm" 
                                                       href="{{ route("portal.meeting.report.keypad.question",['keypad'=>$keypad->id, 'meeting'=>$meeting->id]) }}" 
                                                       title="{{ __('common.report') }}" 
                                                       data-bs-toggle="tooltip" 
                                                       data-bs-placement="top">
                                                        <i class="fa-solid fa-chart-bar"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fa-solid fa-chart-pie fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">{{ __('common.no-keypad-found') }}</h5>
                                <p class="text-muted">{{ __('common.no-keypad-reports-available') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Session Hero Section */
    .session-hero-card {
        background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-secondary) 100%);
        border-radius: 12px;
        padding: 2rem;
        color: white;
        box-shadow: 0 8px 25px rgba(44, 62, 80, 0.15);
    }

    .hero-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .hero-icon {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 1.5rem;
        font-size: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }

    .meta-item {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .status-active {
        background: rgba(39, 174, 96, 0.2);
        color: #27ae60;
        border: 1px solid rgba(39, 174, 96, 0.3);
    }

    .status-inactive {
        background: rgba(149, 165, 166, 0.2);
        color: #95a5a6;
        border: 1px solid rgba(149, 165, 166, 0.3);
    }

    /* Modern Stats Cards */
    .stats-card-modern {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        border: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .stats-card-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
    }

    .stats-icon-primary { background: linear-gradient(135deg, #3498db, #2980b9); }
    .stats-icon-success { background: linear-gradient(135deg, #27ae60, #229954); }
    .stats-icon-info { background: linear-gradient(135deg, #17a2b8, #138496); }
    .stats-icon-warning { background: linear-gradient(135deg, #f39c12, #e67e22); }

    .stats-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50 !important;
        line-height: 1.2;
    }

    .stats-label {
        font-size: 0.85rem;
        color: #6c757d !important;
        font-weight: 500;
    }

    /* Modern Cards */
    .modern-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }

    .modern-header {
        background: var(--kongre-secondary);
        color: white;
        border-bottom: none;
        padding: 1.2rem 1.5rem;
    }

    .card-title {
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    /* Detail Items */
    .detail-item {
        margin-bottom: 1.2rem;
    }

    .detail-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 0.3rem;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 0.95rem;
        color: #2c3e50;
        font-weight: 500;
    }

    /* Modern Table */
    .modern-table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-table thead th {
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        padding: 1rem;
        font-size: 0.9rem;
    }

    .modern-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #f1f3f4;
        vertical-align: middle;
    }

    .modern-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Empty State */
    .empty-state {
        padding: 2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-content {
            flex-direction: column;
            text-align: center;
        }
        
        .hero-meta {
            justify-content: center;
        }
        
        .stats-card-modern {
            text-align: center;
            flex-direction: column;
        }
    }
    </style>
@endsection
