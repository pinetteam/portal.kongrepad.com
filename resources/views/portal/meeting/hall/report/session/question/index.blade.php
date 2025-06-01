@extends('layout.portal.meeting-detail')
@section('title', $session->title . ' | ' .  __('common.question-reports'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $session->program->hall->meeting->id) }}" class="text-decoration-none">{{ $session->program->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $session->program->hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id]) }}" class="text-decoration-none">{{ $session->program->hall->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.report.session.index', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id]) }}" class="text-decoration-none">{{ __('common.session-reports') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $session->title . ' ' . __('common.question-reports') }}</li>
@endsection
@section('meeting_content')
    <!-- Question Reports Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="question-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-solid fa-comment-question"></i>
                    </div>
                    <div class="hero-details">
                        <h1 class="hero-title">{{ $session->title }}</h1>
                        <p class="hero-subtitle">{{ __('common.question-reports') }}</p>
                        <div class="hero-meta">
                            <span class="meta-item">
                                <i class="fa-solid fa-hashtag me-1"></i>
                                {{ $questions->total() }} {{ __('common.questions') }}
                            </span>
                            <span class="meta-item">
                                <i class="fa-solid fa-clock me-1"></i>
                                {{ __('common.session') }}: {{ $session->code }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card modern-card">
                <div class="card-header modern-header">
                    <h5 class="card-title mb-0">
                        <i class="fa-solid fa-list me-2"></i>
                        {{ __('common.question-list') }}
                    </h5>
                    <div class="header-actions">
                        <span class="badge bg-light text-dark">{{ $questions->total() }} {{ __('common.total') }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($questions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 modern-table">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <i class="fa-solid fa-user me-1"></i>{{ __('common.questioner') }}
                                        </th>
                                        <th scope="col">
                                            <i class="fa-solid fa-comment me-1"></i>{{ __('common.question') }}
                                        </th>
                                        <th scope="col" class="text-center">
                                            <i class="fa-solid fa-user-secret me-1"></i>{{ __('common.is-hidden-name') }}
                                        </th>
                                        <th scope="col" class="text-center">
                                            <i class="fa-solid fa-check me-1"></i>{{ __('common.is-selected') }}
                                        </th>
                                        <th scope="col" class="text-center">
                                            <i class="fa-solid fa-times me-1"></i>{{ __('common.is-deselected') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                        <tr>
                                            <td class="fw-medium">
                                                <div class="user-info">
                                                    <i class="fa-solid fa-user-circle me-2 text-primary"></i>
                                                    {{ $question->questioner->full_name }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="question-text">
                                                    {{ $question->question }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($question->is_hidden_name)
                                                    <span class="status-badge status-success">
                                                        <i class="fa-solid fa-toggle-on"></i>
                                                        <small>{{ __('common.yes') }}</small>
                                                    </span>
                                                @else
                                                    <span class="status-badge status-danger">
                                                        <i class="fa-solid fa-toggle-off"></i>
                                                        <small>{{ __('common.no') }}</small>
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($question->logs()->where('action', 'select')->count() > 0)
                                                    <span class="status-badge status-success">
                                                        <i class="fa-solid fa-toggle-on"></i>
                                                        <small>{{ __('common.yes') }}</small>
                                                    </span>
                                                @else
                                                    <span class="status-badge status-secondary">
                                                        <i class="fa-solid fa-toggle-off"></i>
                                                        <small>{{ __('common.no') }}</small>
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($question->logs()->where('action', 'deselect')->count() > 0)
                                                    <span class="status-badge status-warning">
                                                        <i class="fa-solid fa-toggle-on"></i>
                                                        <small>{{ __('common.yes') }}</small>
                                                    </span>
                                                @else
                                                    <span class="status-badge status-secondary">
                                                        <i class="fa-solid fa-toggle-off"></i>
                                                        <small>{{ __('common.no') }}</small>
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        @if($questions->hasPages())
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-center">
                                    {{ $questions->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fa-solid fa-comment-slash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">{{ __('common.no-questions-found') }}</h5>
                                <p class="text-muted">{{ __('common.no-questions-available-for-this-session') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Question Hero Section */
    .question-hero-card {
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
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-weight: 600;
        display: flex;
        align-items: center;
        margin: 0;
    }

    .header-actions .badge {
        font-size: 0.8rem;
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

    /* User Info */
    .user-info {
        display: flex;
        align-items: center;
    }

    /* Question Text */
    .question-text {
        max-width: 300px;
        word-wrap: break-word;
        line-height: 1.4;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.6rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-success {
        background: rgba(39, 174, 96, 0.1);
        color: #27ae60;
        border: 1px solid rgba(39, 174, 96, 0.2);
    }

    .status-danger {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
        border: 1px solid rgba(231, 76, 60, 0.2);
    }

    .status-warning {
        background: rgba(243, 156, 18, 0.1);
        color: #f39c12;
        border: 1px solid rgba(243, 156, 18, 0.2);
    }

    .status-secondary {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.2);
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

        .question-text {
            max-width: 200px;
        }
    }
    </style>
@endsection
