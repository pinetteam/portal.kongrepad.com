@extends('layout.portal.meeting-detail')
@section('title', $question->title . ' | ' . __('common.report'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $question->session->program->hall->meeting->id) }}" class="text-decoration-none">{{ $question->session->program->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.report.keypad.index', ['meeting' => $question->session->program->hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.keypad-reports') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $question->title }}</li>
@endsection
@section('meeting_content')
    <!-- Keypad Report Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="keypad-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-solid fa-chart-bar"></i>
                    </div>
                    <div class="hero-details">
                        <h1 class="hero-title">{{ $question->title }}</h1>
                        <p class="hero-subtitle">{{ __('common.keypad-report') }}</p>
                        <div class="hero-meta">
                            <span class="meta-item">
                                <i class="fa-solid fa-vote-yea me-1"></i>
                                {{ $question->votes->count() }} {{ __('common.total-votes') }}
                            </span>
                            <span class="meta-item">
                                <i class="fa-solid fa-users me-1"></i>
                                {{ $options->count() }} {{ __('common.options') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Voting Results Card -->
    <div class="row">
        <div class="col-12">
            <div class="card modern-card">
                <div class="card-header modern-header">
                    <h5 class="card-title mb-0">
                        <i class="fa-solid fa-chart-column me-2"></i>
                        {{ __('common.voting-results') }}
                    </h5>
                    <div class="header-actions">
                        <span class="badge bg-light text-dark">{{ $question->votes->count() }} {{ __('common.votes') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($question->votes->count() > 0)
                        <div class="question-title mb-4">
                            <h6 class="text-muted mb-2">{{ __('common.question') }}:</h6>
                            <p class="fs-5 mb-0">{{ $question->title }}</p>
                        </div>
                        
                        <div class="voting-results">
                            @foreach($options as $option)
                                @php
                                    $percentage = $question->votes->count() > 0 ? round(($option->votes->count() / $question->votes->count()) * 100, 2) : 0;
                                    $voteCount = $option->votes->count();
                                @endphp
                                <div class="result-item mb-3">
                                    <div class="result-header d-flex justify-content-between align-items-center mb-2">
                                        <span class="option-text fw-medium">{{ $option->option }}</span>
                                        <div class="result-stats">
                                            <span class="vote-count me-2">
                                                <i class="fa-solid fa-users me-1"></i>{{ $voteCount }}
                                            </span>
                                            <span class="percentage-badge">{{ $percentage }}%</span>
                                        </div>
                                    </div>
                                    <div class="progress modern-progress" style="height: 30px;">
                                        <div class="progress-bar progress-bar-animated progress-bar-striped bg-gradient" 
                                             style="width: {{ $percentage }}%; background: linear-gradient(90deg, var(--kongre-accent), var(--kongre-primary));" 
                                             role="progressbar" 
                                             aria-valuenow="{{ $percentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            <span class="progress-text">{{ $percentage }}%</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fa-solid fa-vote-yea fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">{{ __('common.no-votes-found') }}</h5>
                                <p class="text-muted">{{ __('common.no-votes-available-for-this-question') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Keypad Hero Section */
    .keypad-hero-card {
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

    /* Question Title */
    .question-title {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        border-left: 4px solid var(--kongre-accent);
    }

    /* Voting Results */
    .result-item {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
    }

    .option-text {
        color: var(--kongre-primary);
        font-size: 1rem;
    }

    .vote-count {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .percentage-badge {
        background: var(--kongre-accent);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .modern-progress {
        border-radius: 15px;
        background-color: #e9ecef;
        overflow: hidden;
    }

    .progress-text {
        color: white;
        font-weight: 600;
        line-height: 30px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
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

        .result-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 0.5rem;
        }
    }
    </style>
@endsection
