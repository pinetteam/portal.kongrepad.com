@extends('layout.portal.meeting-detail')
@section('title', $program->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $program->hall->meeting->id) }}" class="text-decoration-none">{{ $program->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $program->hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $program->hall->meeting->id, 'hall' => $program->hall->id]) }}" class="text-decoration-none">{{ $program->hall->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.program.index', ['meeting' => $program->hall->meeting->id, 'hall' => $program->hall->id]) }}" class="text-decoration-none">{{ __('common.programs') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $program->title }}</li>
@endsection

@push('styles')
    @vite(['resources/css/meeting-pages-theme.css'])
@endpush

@section('meeting_content')
    <!-- Modern Hero Section for Other Program -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-newspaper fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $program->title }}</h1>
                        <p class="hero-subtitle">{{ __('common.other') }} {{ __('common.program') }} - {{ $program->hall->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-code me-1"></i>
                                {{ $program->code }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-tag me-1"></i>
                                {{ __('common.other') }}
                            </span>
                            <span class="stat-item status-badge {{ $program->status ? 'status-active' : 'status-inactive' }}">
                                <i class="fa-regular fa-{{ $program->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                {{ $program->status ? __('common.active') : __('common.inactive') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Program Details Card -->
    <div class="program-details-modern">
        <div class="program-details-header">
            <h5 class="program-details-title">
                <i class="fas fa-info-circle"></i>
                {{ __('common.program-details') }}
            </h5>
            @if($program->logo)
                <div class="program-logo-container">
                    <img src="{{ asset('storage/' . $program->logo) }}" alt="{{ $program->title }}" />
                </div>
            @endif
        </div>
        
        <div class="program-details-grid">
            <div class="program-detail-item">
                <div class="program-detail-icon">
                    <i class="fas fa-heading"></i>
                </div>
                <div class="program-detail-content">
                    <div class="program-detail-label">{{ __('common.title') }}</div>
                    <div class="program-detail-value">{{ $program->title }}</div>
                </div>
            </div>
            
            <div class="program-detail-item">
                <div class="program-detail-icon">
                    <i class="fas fa-code"></i>
                </div>
                <div class="program-detail-content">
                    <div class="program-detail-label">{{ __('common.code') }}</div>
                    <div class="program-detail-value">{{ $program->code }}</div>
                </div>
            </div>
            
            <div class="program-detail-item">
                <div class="program-detail-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="program-detail-content">
                    <div class="program-detail-label">{{ __('common.hall') }}</div>
                    <div class="program-detail-value">{{ $program->hall->title }}</div>
                </div>
            </div>
            
            <div class="program-detail-item">
                <div class="program-detail-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="program-detail-content">
                    <div class="program-detail-label">{{ __('common.type') }}</div>
                    <div class="program-detail-value">
                        <span class="badge badge-info">{{ ucfirst($program->type) }}</span>
                    </div>
                </div>
            </div>
            
            @if($program->start_at)
            <div class="program-detail-item">
                <div class="program-detail-icon">
                    <i class="fas fa-play"></i>
                </div>
                <div class="program-detail-content">
                    <div class="program-detail-label">{{ __('common.start-time') }}</div>
                    <div class="program-detail-value">{{ \Carbon\Carbon::parse($program->start_at)->format('d.m.Y H:i') }}</div>
                </div>
            </div>
            @endif
            
            @if($program->finish_at)
            <div class="program-detail-item">
                <div class="program-detail-icon">
                    <i class="fas fa-stop"></i>
                </div>
                <div class="program-detail-content">
                    <div class="program-detail-label">{{ __('common.finish-time') }}</div>
                    <div class="program-detail-value">{{ \Carbon\Carbon::parse($program->finish_at)->format('d.m.Y H:i') }}</div>
                </div>
            </div>
            @endif
            
            <div class="program-detail-item">
                <div class="program-detail-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="program-detail-content">
                    <div class="program-detail-label">{{ __('common.created-by') }}</div>
                    <div class="program-detail-value">{{ $program->created_by_name }}</div>
                </div>
            </div>
            
            <div class="program-detail-item">
                <div class="program-detail-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="program-detail-content">
                    <div class="program-detail-label">{{ __('common.created-at') }}</div>
                    <div class="program-detail-value">{{ \Carbon\Carbon::parse($program->created_at)->format('d.m.Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
