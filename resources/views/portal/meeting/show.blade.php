@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.meeting'))

<!-- Modern Head section with stylesheet -->
@section('head')
@vite(['resources/css/meeting-pages-theme.css'])
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $meeting->title }}</li>
@endsection

@section('meeting_content')
    <!-- Modern Hero Section -->
    <div class="modern-hero-card">
        <div class="hero-content">
            <div class="hero-icon">
                @if(isset($meeting->banner_name) && isset($meeting->banner_extension))
                    <img src="{{ asset('storage/meeting-banners/' . $meeting->banner_name . '.' . $meeting->banner_extension) }}" 
                         alt="{{ $meeting->title }}" class="w-100 h-100 object-fit-cover rounded">
                @else
                    <i class="fa-duotone fa-calendar-check"></i>
                @endif
            </div>
            <div class="hero-text">
                <h1 class="hero-title">{{ $meeting->title }}</h1>
                <p class="hero-subtitle">
                    <i class="fa-regular fa-calendar me-2"></i>{{ $meeting->start_at }} - {{ $meeting->finish_at }}
                </p>
                <div class="hero-badges">
                    @if($meeting->status)
                        <div class="badge-status">
                            <i class="fa-solid fa-broadcast-tower me-1"></i>
                            {{ __('common.live') }}
                        </div>
                    @else
                        <div class="badge-status">
                            <i class="fa-solid fa-clock me-1"></i>
                            {{ __('common.offline') }}
                        </div>
                    @endif
                    <div class="badge-questions">
                        <i class="fa-regular fa-calendar-days me-1"></i>
                        {{ __('common.' . $meeting->type) }}
                    </div>
                </div>
            </div>
            <div class="hero-action">
                <a href="{{ route('portal.meeting.participant.index', $meeting->id) }}" class="btn-hero-create">
                    <i class="fa-regular fa-users me-1"></i>
                    {{ __('common.participants') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Modern Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="modern-stat-card">
                <div class="stat-content">
                    <div class="stat-icon bg-primary">
                        <i class="fa-duotone fa-users"></i>
                    </div>
                    <div class="stat-number">{{ $meeting->participants->count() }}</div>
                    <div class="stat-label">{{ __('common.participants') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="modern-stat-card">
                <div class="stat-content">
                    <div class="stat-icon bg-success">
                        <i class="fa-duotone fa-building"></i>
                    </div>
                    <div class="stat-number">{{ $meeting->halls->count() }}</div>
                    <div class="stat-label">{{ __('common.halls') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="modern-stat-card">
                <div class="stat-content">
                    <div class="stat-icon bg-info">
                        <i class="fa-duotone fa-file-text"></i>
                    </div>
                    <div class="stat-number">{{ $meeting->documents->count() }}</div>
                    <div class="stat-label">{{ __('common.documents') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="modern-stat-card">
                <div class="stat-content">
                    <div class="stat-icon bg-warning">
                        <i class="fa-duotone fa-poll"></i>
                    </div>
                    <div class="stat-number">{{ $meeting->surveys->count() ?? 0 }}</div>
                    <div class="stat-label">{{ __('common.surveys') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Details Section -->
    <div class="row">
        <div class="col-lg-8">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-circle-info me-2"></i>
                        {{ __('common.meeting_info') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="meeting-details-grid">
                        <div class="detail-item">
                            <label class="detail-label">{{ __('common.meeting-title') }}</label>
                            <div class="detail-value">{{ $meeting->title }}</div>
                        </div>
                        <div class="detail-item">
                            <label class="detail-label">{{ __('common.type') }}</label>
                            <div class="detail-value">
                                <span class="theme-badge">
                                    <i class="fa-regular fa-tag me-1"></i>
                                    {{ __('common.' . $meeting->type) }}
                                </span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <label class="detail-label">{{ __('common.start-at') }}</label>
                            <div class="detail-value">
                                <span class="date-badge">
                                    <i class="fa-regular fa-calendar-plus me-1"></i>
                                    {{ $meeting->start_at }}
                                </span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <label class="detail-label">{{ __('common.finish-at') }}</label>
                            <div class="detail-value">
                                <span class="date-badge">
                                    <i class="fa-regular fa-calendar-minus me-1"></i>
                                    {{ $meeting->finish_at }}
                                </span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <label class="detail-label">{{ __('common.status') }}</label>
                            <div class="detail-value">
                                @if($meeting->status)
                                    <span class="status-active">
                                        <i class="fa-solid fa-broadcast-tower me-1"></i>
                                        {{ __('common.active') }}
                                    </span>
                                @else
                                    <span class="status-inactive">
                                        <i class="fa-solid fa-pause me-1"></i>
                                        {{ __('common.inactive') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-user-gear me-2"></i>
                        {{ __('common.creation_details') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="creation-details">
                        <div class="detail-item">
                            <label class="detail-label">{{ __('common.created-by') }}</label>
                            <div class="detail-value">
                                <span class="id-badge">
                                    <i class="fa-regular fa-user me-1"></i>
                                    {{ $meeting->created_by }}
                                </span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <label class="detail-label">{{ __('common.created-at') }}</label>
                            <div class="detail-value">
                                <span class="date-badge">
                                    <i class="fa-regular fa-clock me-1"></i>
                                    {{ $meeting->created_at }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
