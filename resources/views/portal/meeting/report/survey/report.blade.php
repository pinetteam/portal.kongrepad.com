@extends('layout.portal.meeting-detail')
@section('title', $survey->title . ' | ' . __('common.report'))

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
                    <a href="{{ route('portal.meeting.show', $survey->meeting->id) }}" class="breadcrumb-link">
                        {{ $survey->meeting->title }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('portal.meeting.report.survey.index', ['meeting' => $survey->meeting->id]) }}" class="breadcrumb-link">
                        {{ __('common.survey-reports') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $survey->title }}
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
                            <i class="fas fa-square-poll-vertical text-primary me-2"></i>
                            {{ __('common.survey-reports') }}
                        </h1>
                        <p class="hero-subtitle text-muted mb-0">
                            "{{ $survey->title }}" {{ __('common.report') }}
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="stats-card">
                            <div class="stat-item">
                                <i class="fas fa-chart-bar text-info"></i>
                                <span class="stat-number">{{ $survey->questions->count() }}</span>
                                <span class="stat-label">{{ __('common.questions') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="survey-details-card mb-4">
        <div class="card modern-card">
            <div class="card-header bg-light">
                <h3 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    {{ __('common.survey-information') }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">{{ __('common.survey') }}:</label>
                            <div class="info-value">
                                @if($survey->status)
                                    <span class="badge bg-success me-2">
                                        <i class="fas fa-toggle-on"></i> {{ __('common.active') }}
                                    </span>
                                @else
                                    <span class="badge bg-danger me-2">
                                        <i class="fas fa-toggle-off"></i> {{ __('common.passive') }}
                                    </span>
                                @endif
                                {{ $survey->title }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">{{ __('common.description') }}:</label>
                            <div class="info-value">
                                {{ $survey->description ?? __('common.no-description-found') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">{{ __('common.start-at') }}:</label>
                            <div class="info-value">
                                <i class="fas fa-calendar-start me-1 text-success"></i>
                                {{ $survey->start_at ? \Carbon\Carbon::parse($survey->start_at)->format('d.m.Y H:i') : __('common.not-started-yet') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">{{ __('common.finish-at') }}:</label>
                            <div class="info-value">
                                <i class="fas fa-calendar-check me-1 text-warning"></i>
                                {{ $survey->finish_at ? \Carbon\Carbon::parse($survey->finish_at)->format('d.m.Y H:i') : __('common.not-finished-yet') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="questions-results">
        @forelse($survey->questions as $index => $question)
            <div class="question-card mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="question-title mb-0">
                            <span class="question-number">{{ $index + 1 }}.</span>
                            <i class="fas fa-question-circle me-2 text-primary"></i>
                            {{ $question->title }}
                        </h4>
                        <div class="question-stats">
                            <span class="badge bg-info">
                                {{ $question->votes->count() }} {{ __('common.votes') }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        @forelse($question->options as $option)
                            @php
                                $totalVotes = $question->votes->count();
                                $optionVotes = $option->votes->count();
                                $percentage = $totalVotes > 0 ? round(($optionVotes / $totalVotes) * 100, 2) : 0;
                            @endphp
                            <div class="option-result mb-3">
                                <div class="option-header d-flex justify-content-between align-items-center mb-2">
                                    <span class="option-text">{{ $option->option }}</span>
                                    <span class="option-stats">
                                        <span class="votes-count">{{ $optionVotes }} {{ __('common.votes') }}</span>
                                        <span class="percentage badge bg-primary">{{ $percentage }}%</span>
                                    </span>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                                         role="progressbar" 
                                         style="width: {{ $percentage }}%"
                                         aria-valuenow="{{ $percentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state text-center py-3">
                                <i class="fas fa-list-ul text-muted fa-2x mb-2"></i>
                                <p class="text-muted mb-0">{{ __('common.no-options-message') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state-card">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-question-circle text-muted fa-4x mb-3"></i>
                        <h4 class="text-muted">{{ __('common.no-questions-found') }}</h4>
                        <p class="text-muted">{{ __('common.no-questions-message') }}</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection
