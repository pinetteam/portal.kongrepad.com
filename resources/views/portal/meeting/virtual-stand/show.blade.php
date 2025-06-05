@extends('layout.portal.meeting-detail')
@section('title', $virtual_stand->title . ' | ' . __('common.virtual-stand'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $virtual_stand->meeting->id) }}" class="text-decoration-none">{{ $virtual_stand->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.virtual-stand.index', ['meeting' => $virtual_stand->meeting->id]) }}" class="text-decoration-none">{{ __('common.virtual-stands') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $virtual_stand->title }}</li>
@endsection

@push('styles')
    @vite(['resources/css/meeting-pages-theme.css'])
@endpush

@section('meeting_content')
    <!-- Modern Virtual Stand Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-browser fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $virtual_stand->title }}</h1>
                        <p class="hero-subtitle">{{ __('common.virtual-stand-details') }} - {{ $virtual_stand->meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-{{ $virtual_stand->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                {{ $virtual_stand->status ? __('common.active') : __('common.inactive') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($virtual_stand->created_at)->format('d.m.Y H:i') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <a href="{{ route('portal.meeting.virtual-stand.index', ['meeting' => $virtual_stand->meeting->id]) }}" class="btn btn-hero-create">
                            <i class="fa-solid fa-arrow-left me-2"></i>{{ __('common.back-to-virtual-stands') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Virtual Stand Details Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-info-circle me-2"></i>
                        {{ __('common.virtual-stand-details') }}
                    </h3>
                    <div class="header-actions">
                        <span class="status-badge {{ $virtual_stand->status ? 'status-active' : 'status-inactive' }}">
                            <i class="fa-regular fa-{{ $virtual_stand->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                            {{ $virtual_stand->status ? __('common.active') : __('common.inactive') }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="meeting-details-grid">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-regular fa-image me-2"></i>
                                {{ __('common.logo') }}
                            </div>
                            <div class="detail-value">
                                @if(isset($virtual_stand->file_name))
                                    <img src="{{ asset('storage/virtual-stands/' . $virtual_stand->file_name . '.' . $virtual_stand->file_extension) }}" 
                                         alt="{{ $virtual_stand->title }}" 
                                         class="item-logo" 
                                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px;" />
                                @else
                                    <div class="logo-placeholder" style="width: 100px; height: 100px;">
                                        <i class="fa-duotone fa-image"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-regular fa-signature me-2"></i>
                                {{ __('common.title') }}
                            </div>
                            <div class="detail-value">{{ $virtual_stand->title }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-regular fa-toggle-large-on me-2"></i>
                                {{ __('common.status') }}
                            </div>
                            <div class="detail-value">
                                <span class="status-badge {{ $virtual_stand->status ? 'status-active' : 'status-inactive' }}">
                                    <i class="fa-regular fa-{{ $virtual_stand->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                    {{ $virtual_stand->status ? __('common.active') : __('common.inactive') }}
                                </span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-regular fa-calendar-days me-2"></i>
                                {{ __('common.meeting') }}
                            </div>
                            <div class="detail-value">{{ $meeting->title }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-regular fa-user me-2"></i>
                                {{ __('common.created-by') }}
                            </div>
                            <div class="detail-value">{{ $virtual_stand->created_by_name }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-regular fa-clock me-2"></i>
                                {{ __('common.created-at') }}
                            </div>
                            <div class="detail-value">
                                <span class="date-badge">
                                    <i class="fa-regular fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($virtual_stand->created_at)->format('d.m.Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Viewer Card -->
    <div class="row">
        <div class="col-12">
            @if(isset($virtual_stand->pdf_name))
                <div class="modern-main-card">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            <i class="fa-duotone fa-file-pdf me-2"></i>
                            {{ __('common.pdf-document') }}
                        </h3>
                        <div class="header-actions">
                            <a href="{{ asset('storage/virtual-stand-pdfs/' . $virtual_stand->pdf_name . '.pdf') }}" 
                               target="_blank" 
                               class="btn btn-outline-light btn-sm">
                                <i class="fa-solid fa-external-link me-1"></i>
                                {{ __('common.open-in-new-tab') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ asset('storage/virtual-stand-pdfs/' . $virtual_stand->pdf_name . '.pdf') }}" 
                                    class="rounded"
                                    style="border: none;"></iframe>
                        </div>
                    </div>
                </div>
            @else
                <div class="modern-main-card">
                    <div class="card-header">
                        <h3 class="card-header-title">
                            <i class="fa-duotone fa-file-pdf me-2"></i>
                            {{ __('common.pdf-document') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-file-pdf"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-pdf-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-pdf-message') ?? 'Bu sanal stand için henüz PDF belgesi yüklenmemiş.' }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
