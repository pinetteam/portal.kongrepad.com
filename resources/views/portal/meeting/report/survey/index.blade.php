@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' .  __('common.survey-reports'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.survey-reports') }}</li>
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
                        <i class="fa-duotone fa-square-poll-horizontal fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.survey-reports') }}</h1>
                        <p class="hero-subtitle">{{ __('common.survey-reports-description') ?? 'Toplantıdaki anket sonuçlarını ve katılım istatistiklerini görüntüleyin.' }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-poll me-1"></i>
                                {{ $surveys->total() }} {{ __('common.total-surveys') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-toggle-on me-1"></i>
                                {{ $surveys->where('status', true)->count() }} {{ __('common.active') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Survey Reports Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-chart-bar me-2"></i>
                        {{ __('common.survey-management') }}
                    </h3>
                    <div class="header-actions">
                        <span class="badge bg-primary">
                            <i class="fa-regular fa-poll me-1"></i>
                            {{ $surveys->total() }} {{ __('common.surveys') }}
                        </span>
                    </div>
                </div>
                
                @if($surveys->count() > 0)
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-calendar-days me-2"></i>
                                            {{ __('common.meeting') }}
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
                                            <i class="fa-regular fa-question me-2"></i>
                                            {{ __('common.question-count') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-users me-2"></i>
                                            {{ __('common.total-participants') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-vote-yea me-2"></i>
                                            {{ __('common.on_vote') }}
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
                                    @foreach($surveys as $survey)
                                        <tr>
                                            <td>
                                                <div class="item-name">{{ $survey->meeting->title }}</div>
                                            </td>
                                            <td>
                                                <div class="item-name">{{ $survey->title }}</div>
                                            </td>
                                            <td>
                                                @if($survey->start_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($survey->start_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($survey->finish_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($survey->finish_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="count-badge">{{ $survey->questions->count() }}</span>
                                            </td>
                                            <td>
                                                <span class="count-badge">{{ $survey->votes->groupBy('participant_id')->count() }}</span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $survey->on_vote ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $survey->on_vote ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $survey->on_vote ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $survey->status ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $survey->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $survey->status ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a class="btn btn-outline-info btn-sm" 
                                                       href="{{ route("portal.meeting.report.survey.participants",['survey'=>$survey->id, 'meeting'=>$survey->meeting->id]) }}" 
                                                       title="{{ __('common.participants') }}"
                                                       data-bs-toggle="tooltip">
                                                        <i class="fa-regular fa-user"></i>
                                                    </a>
                                                    <a class="btn btn-outline-success btn-sm" 
                                                       href="{{ route("portal.meeting.report.survey",['survey'=>$survey->id, 'meeting'=>$survey->meeting->id]) }}" 
                                                       title="{{ __('common.report') }}"
                                                       data-bs-toggle="tooltip">
                                                        <i class="fa-regular fa-chart-bar"></i>
                                                    </a>
                                                    <a class="btn btn-outline-primary btn-sm" 
                                                       href="{{ route("service.survey-report.start",['survey'=>$survey->id]) }}" 
                                                       title="{{ __('common.screen') }}"
                                                       data-bs-toggle="tooltip">
                                                        <i class="fa-regular fa-presentation-screen"></i>
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
                    @if($surveys->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $surveys->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-square-poll-horizontal"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-surveys-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-surveys-description') ?? 'Henüz hiç anket bulunmuyor.' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection



