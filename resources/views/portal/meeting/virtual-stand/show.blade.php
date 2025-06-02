@extends('layout.portal.meeting-detail')
@section('title', $virtual_stand->title . ' | ' . __('common.virtual-stand'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $virtual_stand->meeting->id) }}" class="text-decoration-none">{{ $virtual_stand->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.virtual-stand.index', ['meeting' => $virtual_stand->meeting->id]) }}" class="text-decoration-none">{{ __('common.virtual-stands') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $virtual_stand->title }}</li>
@endsection
@section('meeting_content')
    <!-- Modern Virtual Stand Hero Card -->
    <div class="modern-virtual-stand-hero-card mb-4">
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fa-duotone fa-browser fa-fade"></i>
            </div>
            <div class="hero-text">
                <h1 class="hero-title">{{ $virtual_stand->title }}</h1>
                <p class="hero-subtitle">{{ __('common.virtual-stand-details') }}</p>
                <div class="hero-badges">
                    <span class="badge-{{ $virtual_stand->status ? 'success' : 'warning' }}">
                        <i class="fa-duotone fa-{{ $virtual_stand->status ? 'toggle-on' : 'toggle-off' }}"></i>
                        {{ $virtual_stand->status ? __('common.active') : __('common.inactive') }}
                    </span>
                    <span class="badge-info">
                        <i class="fa-duotone fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($virtual_stand->created_at)->format('d.m.Y H:i') }}
                    </span>
                </div>
            </div>
            <div class="hero-action">
                <a href="{{ route('portal.meeting.virtual-stand.index', ['meeting' => $virtual_stand->meeting->id]) }}" class="btn-hero-back">
                    <i class="fa-solid fa-arrow-left"></i> {{ __('common.back-to-virtual-stands') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Virtual Stand Details Card -->
    <div class="modern-virtual-stand-details-card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fa-duotone fa-info-circle"></i> {{ __('common.virtual-stand-details') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="virtual-stand-details-grid">
                <div class="detail-item">
                    <div class="detail-label">{{ __('common.logo') }}</div>
                    <div class="detail-value">
                        @if(isset($virtual_stand->file_name))
                            <img src="{{ asset('storage/virtual-stands/' . $virtual_stand->file_name . '.' . $virtual_stand->file_extension) }}" alt="{{ $virtual_stand->title }}" class="virtual-stand-logo" />
                        @else
                            <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                        @endif
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">{{ __('common.title') }}</div>
                    <div class="detail-value">{{ $virtual_stand->title }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">{{ __('common.status') }}</div>
                    <div class="detail-value">
                        <span class="status-badge {{ $virtual_stand->status ? 'status-active' : 'status-inactive' }}">
                            <i class="fa-duotone fa-{{ $virtual_stand->status ? 'toggle-on' : 'toggle-off' }}"></i>
                            {{ $virtual_stand->status ? __('common.active') : __('common.inactive') }}
                        </span>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">{{ __('common.meeting') }}</div>
                    <div class="detail-value">{{ $meeting->title }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">{{ __('common.created-by') }}</div>
                    <div class="detail-value">{{ $virtual_stand->created_by_name }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">{{ __('common.created-at') }}</div>
                    <div class="detail-value">
                        <span class="date-display">
                            <i class="fa-duotone fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($virtual_stand->created_at)->format('d.m.Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Viewer Card -->
    @if(isset($virtual_stand->pdf_name))
        <div class="modern-pdf-viewer-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fa-duotone fa-file-pdf"></i> {{ __('common.pdf-document') }}
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe src="{{ asset('storage/virtual-stand-pdfs/' . $virtual_stand->pdf_name . '.pdf') }}" class="rounded"></iframe>
                </div>
            </div>
        </div>
    @else
        <div class="modern-pdf-viewer-card">
            <div class="card-body">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-duotone fa-file-pdf fa-4x"></i>
                    </div>
                    <h4>{{ __('common.no-pdf-found') }}</h4>
                    <p>{{ __('common.no-pdf-message') }}</p>
                </div>
            </div>
        </div>
    @endif
@endsection
