@extends('layout.portal.meeting-detail')
@section('title', __('common.hall') . ' | ' . $hall->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $hall->meeting->id) }}" class="text-decoration-none">{{ $hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $hall->title }}</li>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/meeting-pages-theme.css') }}">
@endpush

@section('meeting_content')
    <!-- Modern Hero Section for Hall Detail -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-hotel fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $hall->title }}</h1>
                        <p class="hero-subtitle">{{ __('common.hall-management-subtitle') }} - {{ $hall->meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-calendar-week me-1"></i>
                                {{ $hall->programs->count() }} {{ __('common.programs') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-{{ $hall->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                {{ $hall->status ? __('common.active') : __('common.inactive') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-calendar me-1"></i>
                                {{ $hall->created_at->format('d.m.Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <a href="{{ route('portal.meeting.hall.index', ['meeting' => $hall->meeting->id]) }}" class="btn btn-hero-create">
                            <i class="fa-solid fa-arrow-left me-2"></i>{{ __('common.back-to-halls') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Quick Actions Card - Now on the left -->
        <div class="col-lg-4">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-bolt me-2"></i>
                        {{ __('common.quick-actions') }}
                    </h3>
                </div>
                <div class="card-body p-3">
                    <!-- Management Actions -->
                    <div class="mb-3">
                        <h6 class="text-muted mb-2 fs-7">
                            <i class="fa-regular fa-gear me-1"></i>{{ __('common.management') }}
                        </h6>
                        <div class="d-grid gap-1">
                            <a href="{{ route('portal.meeting.hall.program.index', ['meeting' => $hall->meeting->id, 'hall' => $hall->id]) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fa-regular fa-calendar-week me-2"></i>{{ __('common.programs') }}
                                <span class="badge bg-primary ms-auto">{{ $hall->programs->count() }}</span>
                            </a>
                            <a href="{{ route('portal.meeting.hall.screen.index', ['meeting' => $hall->meeting->id, 'hall' => $hall->id]) }}" class="btn btn-outline-warning btn-sm">
                                <i class="fa-regular fa-tv me-2"></i>{{ __('common.screens') }}
                            </a>
                            <a href="{{ route('portal.meeting.hall.report.session.index', ['meeting' => $hall->meeting->id, 'hall' => $hall->id]) }}" class="btn btn-outline-info btn-sm">
                                <i class="fa-regular fa-chart-bar me-2"></i>{{ __('common.reports') }}
                            </a>
                        </div>
                    </div>
                    
                    <!-- External Boards -->
                    <div>
                        <h6 class="text-muted mb-2 fs-7">
                            <i class="fa-regular fa-external-link me-1"></i>{{ __('common.external-boards') }}
                        </h6>
                        <div class="row g-1">
                            <div class="col-4">
                                <a href="{{ route('service.operator-board.start', ['code' => $hall->code, 'program_order' => 0]) }}" class="btn btn-outline-success btn-sm w-100 py-2" target="_blank" title="{{ __('common.operator-board') }}" data-bs-toggle="tooltip">
                                    <i class="fa-regular fa-rectangles-mixed d-block"></i>
                                    <small>Operator</small>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="{{ route('service.screen-board.start', ['code' => $hall->code]) }}" class="btn btn-outline-secondary btn-sm w-100 py-2" target="_blank" title="{{ __('common.screen-board') }}" data-bs-toggle="tooltip">
                                    <i class="fa-regular fa-screen-users d-block"></i>
                                    <small>Screen</small>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="{{ route('service.question-board.start', ['code' => $hall->code]) }}" class="btn btn-outline-dark btn-sm w-100 py-2" target="_blank" title="{{ __('common.question-board') }}" data-bs-toggle="tooltip">
                                    <i class="fa-regular fa-question d-block"></i>
                                    <small>Question</small>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hall Info Summary -->
                    <div class="mt-3 pt-3 border-top">
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <div class="text-muted">
                                    <i class="fa-regular fa-user d-block mb-1"></i>
                                    <small>{{ $hall->created_by_name }}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">
                                    <i class="fa-regular fa-calendar d-block mb-1"></i>
                                    <small>{{ $hall->created_at->format('d.m.Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hall Details Card - Now on the right with better spacing -->
        <div class="col-lg-8">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-info-circle me-2"></i>
                        {{ __('common.hall-details') }}
                    </h3>
                </div>
                <div class="card-body p-4">
                    <!-- Main Information Table -->
                    <div class="detail-table">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="detail-item-table">
                                    <label class="detail-label-table">
                                        <i class="fa-regular fa-signature me-2"></i>{{ __('common.title') }}
                                    </label>
                                    <div class="detail-value-table">{{ $hall->title }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item-table">
                                    <label class="detail-label-table">
                                        <i class="fa-regular fa-code me-2"></i>{{ __('common.hall-code') }}
                                    </label>
                                    <div class="detail-value-table">
                                        <span class="id-badge">{{ $hall->code }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="detail-item-table">
                                    <label class="detail-label-table">
                                        <i class="fa-regular fa-toggle-large-on me-2"></i>{{ __('common.status') }}
                                    </label>
                                    <div class="detail-value-table">
                                        <span class="status-badge {{ $hall->status ? 'status-active' : 'status-inactive' }}">
                                            <i class="fa-regular fa-{{ $hall->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                            {{ $hall->status ? __('common.active') : __('common.inactive') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item-table">
                                    <label class="detail-label-table">
                                        <i class="fa-regular fa-calendar-week me-2"></i>{{ __('common.programs-count') }}
                                    </label>
                                    <div class="detail-value-table">
                                        <span class="theme-badge">{{ $hall->programs->count() }} {{ __('common.programs') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="detail-item-table">
                                    <label class="detail-label-table">
                                        <i class="fa-regular fa-building me-2"></i>{{ __('common.meeting-title') }}
                                    </label>
                                    <div class="detail-value-table">{{ $hall->meeting->title }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Settings Section -->
                        <hr class="my-4">
                        <h6 class="text-muted mb-3">
                            <i class="fa-regular fa-gear me-2"></i>{{ __('common.settings') }}
                        </h6>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="detail-setting-item">
                                    <div class="setting-header">
                                        <i class="fa-regular fa-calendar-check me-2"></i>
                                        <span>{{ __('common.show-on-session') }}</span>
                                        <span class="status-badge ms-auto {{ $hall->show_on_session ? 'status-active' : 'status-inactive' }}">
                                            <i class="fa-regular fa-{{ $hall->show_on_session ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-setting-item">
                                    <div class="setting-header">
                                        <i class="fa-regular fa-comment-question me-2"></i>
                                        <span>{{ __('common.show-on-ask-question') }}</span>
                                        <span class="status-badge ms-auto {{ $hall->show_on_ask_question ? 'status-active' : 'status-inactive' }}">
                                            <i class="fa-regular fa-{{ $hall->show_on_ask_question ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-setting-item">
                                    <div class="setting-header">
                                        <i class="fa-regular fa-calendar-days me-2"></i>
                                        <span>{{ __('common.show-on-view-program') }}</span>
                                        <span class="status-badge ms-auto {{ $hall->show_on_view_program ? 'status-active' : 'status-inactive' }}">
                                            <i class="fa-regular fa-{{ $hall->show_on_view_program ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-setting-item">
                                    <div class="setting-header">
                                        <i class="fa-regular fa-envelope me-2"></i>
                                        <span>{{ __('common.show-on-send-mail') }}</span>
                                        <span class="status-badge ms-auto {{ $hall->show_on_send_mail ? 'status-active' : 'status-inactive' }}">
                                            <i class="fa-regular fa-{{ $hall->show_on_send_mail ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

