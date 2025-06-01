@extends('layout.portal.meeting-detail')
@section('title', $hall->title . ' | ' . __('common.session-reports'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $hall->meeting->id) }}" class="text-decoration-none">{{ $hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $hall->meeting->id, 'hall' => $hall->id]) }}" class="text-decoration-none">{{ $hall->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.session-reports') }}</li>
@endsection
@section('meeting_content')
    <!-- Session Reports Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="session-reports-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div class="hero-details">
                        <h1 class="hero-title">{{ __('common.session-reports') }}</h1>
                        <p class="hero-subtitle">{{ $hall->title }}</p>
                        <div class="hero-meta">
                            <span class="meta-item">
                                <i class="fa-solid fa-list me-1"></i>
                                {{ $programs->count() }} {{ __('common.programs') }}
                            </span>
                            <span class="meta-item">
                                <i class="fa-solid fa-users me-1"></i>
                                {{ $programs->sum(function($program) { return $program->sessions()->count(); }) }} {{ __('common.sessions') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Programs and Sessions -->
    <div class="row">
        <div class="col-12">
            @if($programs->count() > 0)
                @foreach($programs as $program)
                    <div class="card modern-card mb-4">
                        <div class="card-header modern-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fa-solid fa-calendar-days me-2"></i>
                                    {{ $program->title }}
                                </h5>
                                <div class="program-meta">
                                    @if($program->sort_order)
                                        <span class="badge bg-light text-dark me-2">#{{ $program->sort_order }}</span>
                                    @endif
                                    <span class="badge bg-light text-dark">{{ __('common.'.$program->type) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Program Details Row -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="program-detail">
                                        <label class="detail-label">{{ __('common.start-at') }}</label>
                                        <div class="detail-value">
                                            <i class="fa-solid fa-clock me-1"></i>
                                            {{ $program->start_at ?: __('common.unspecified') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="program-detail">
                                        <label class="detail-label">{{ __('common.finish-at') }}</label>
                                        <div class="detail-value">
                                            <i class="fa-solid fa-clock me-1"></i>
                                            {{ $program->finish_at ?: __('common.unspecified') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="program-detail">
                                        <label class="detail-label">{{ __('common.sessions') }}</label>
                                        <div class="detail-value">
                                            <i class="fa-solid fa-users me-1"></i>
                                            {{ $program->sessions()->count() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="program-detail">
                                        <label class="detail-label">{{ __('common.logo') }}</label>
                                        <div class="detail-value">
                                            @if(isset($program->logo_name))
                                                <img src="{{ asset('storage/program-logos/' . $program->logo_name . '.' . $program->logo_extension) }}" 
                                                     alt="{{ $program->title }}" class="program-logo"/>
                                            @else
                                                <span class="text-muted">{{ __('common.unspecified') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sessions Table -->
                            @if($program->sessions()->count() > 0)
                                <div class="sessions-section">
                                    <h6 class="section-title">
                                        <i class="fa-solid fa-presentation-screen me-2"></i>
                                        {{ __('common.sessions') }}
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover modern-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-user me-1"></i>{{ __('common.speaker') }}
                                                    </th>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-sort me-1"></i>{{ __('common.sort') }}
                                                    </th>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-heading me-1"></i>{{ __('common.title') }}
                                                    </th>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-play me-1"></i>{{ __('common.started-at') }}
                                                    </th>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-stop me-1"></i>{{ __('common.finished-at') }}
                                                    </th>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-clock me-1"></i>{{ __('common.duration') }}
                                                    </th>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-question me-1"></i>{{ __('common.questions') }}
                                                    </th>
                                                    <th scope="col" class="text-end">{{ __('common.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($program->sessions()->get() as $program_session)
                                                    <tr>
                                                        <td>
                                                            @if($program_session->speaker)
                                                                <div class="speaker-info">
                                                                    <i class="fa-solid fa-user-tie me-1"></i>
                                                                    {{ $program_session->speaker->full_name }}
                                                                </div>
                                                            @else
                                                                <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-secondary">{{ $program_session->sort_order }}</span>
                                                        </td>
                                                        <td class="fw-medium">{{ $program_session->title }}</td>
                                                        <td>
                                                            @if($program_session->logs()->where('action', 'start')->count() > 0)
                                                                <span class="text-success">
                                                                    <i class="fa-solid fa-check-circle me-1"></i>
                                                                    {{ $program_session->logs()->where('action','start')->first()->created_at->format('d.m.Y H:i') }}
                                                                </span>
                                                            @else
                                                                <span class="text-warning">
                                                                    <i class="fa-solid fa-clock me-1"></i>
                                                                    {{ __('common.not-started-yet') }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($program_session->logs()->where('action', 'stop')->count() > 0)
                                                                <span class="text-danger">
                                                                    <i class="fa-solid fa-stop-circle me-1"></i>
                                                                    {{ $program_session->logs()->latest()->where('action','stop')->first()->created_at->format('d.m.Y H:i') }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">
                                                                    <i class="fa-solid fa-minus me-1"></i>
                                                                    {{ __('common.not-finished-yet') }}
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="duration-badge">
                                                                <i class="fa-solid fa-hourglass-half me-1"></i>
                                                                {{ $program_session->duration ?: __('common.unspecified') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-primary rounded-pill">
                                                                {{ $program_session->questions()->count() }}
                                                            </span>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="btn-group" role="group">
                                                                <a class="btn btn-outline-warning btn-sm" 
                                                                   href="{{ route('portal.meeting.hall.report.session.question.index', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'session' => $program_session->id]) }}" 
                                                                   title="{{ __('common.questions') }}" 
                                                                   data-bs-toggle="tooltip" 
                                                                   data-bs-placement="top">
                                                                    <i class="fa-solid fa-question"></i>
                                                                </a>
                                                                <a class="btn btn-outline-info btn-sm" 
                                                                   href="{{ route('portal.meeting.hall.report.session.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'session' => $program_session->id]) }}" 
                                                                   title="{{ __('common.show') }}" 
                                                                   data-bs-toggle="tooltip" 
                                                                   data-bs-placement="top">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <!-- Debates Section -->
                            @if($program->debates()->count() > 0)
                                <div class="debates-section mt-4">
                                    <h6 class="section-title">
                                        <i class="fa-solid fa-gavel me-2"></i>
                                        {{ __('common.debates') }}
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover modern-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-sort me-1"></i>{{ __('common.sort') }}
                                                    </th>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-heading me-1"></i>{{ __('common.title') }}
                                                    </th>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-play me-1"></i>{{ __('common.voting-started-at') }}
                                                    </th>
                                                    <th scope="col">
                                                        <i class="fa-solid fa-stop me-1"></i>{{ __('common.voting-finished-at') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($program->debates()->get() as $debate)
                                                    <tr>
                                                        <td>
                                                            <span class="badge bg-secondary">{{ $debate->sort_order }}</span>
                                                        </td>
                                                        <td class="fw-medium">{{ $debate->title }}</td>
                                                        <td>
                                                            @if($debate->voting_started_at)
                                                                <span class="text-success">
                                                                    <i class="fa-solid fa-check-circle me-1"></i>
                                                                    {{ $debate->voting_started_at }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($debate->voting_finished_at)
                                                                <span class="text-danger">
                                                                    <i class="fa-solid fa-stop-circle me-1"></i>
                                                                    {{ $debate->voting_finished_at }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fa-solid fa-chart-line fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">{{ __('common.no-programs-found') }}</h5>
                        <p class="text-muted">{{ __('common.no-programs-available-for-this-hall') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
    /* Session Reports Hero Section */
    .session-reports-hero-card {
        background: linear-gradient(135deg, var(--kongre-accent) 0%, var(--kongre-primary) 100%);
        border-radius: 12px;
        padding: 2rem;
        color: white;
        box-shadow: 0 8px 25px rgba(52, 152, 219, 0.15);
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
        margin-bottom: 0.3rem;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0.8rem;
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

    .program-meta .badge {
        font-size: 0.75rem;
    }

    /* Program Details */
    .program-detail {
        margin-bottom: 1rem;
    }

    .detail-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 0.3rem;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 0.9rem;
        color: #2c3e50;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .program-logo {
        height: 32px;
        border-radius: 4px;
    }

    /* Section Titles */
    .section-title {
        color: var(--kongre-primary);
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
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
        padding: 0.75rem;
        font-size: 0.85rem;
    }

    .modern-table tbody td {
        padding: 0.75rem;
        border-bottom: 1px solid #f1f3f4;
        vertical-align: middle;
    }

    .modern-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .speaker-info {
        display: flex;
        align-items: center;
        color: var(--kongre-primary);
    }

    .duration-badge {
        background: #e9ecef;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.8rem;
        color: #495057;
        display: inline-flex;
        align-items: center;
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
        
        .modern-header {
            flex-direction: column;
            gap: 0.5rem;
            text-align: center;
        }

        .program-meta {
            margin-top: 0.5rem;
        }
    }
    </style>
@endsection
