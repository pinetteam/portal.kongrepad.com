@extends('layout.portal.meeting-detail')
@section('title', $document->title . ' | ' . __('common.document'))

@section('breadcrumb')
    <div class="breadcrumb-container px-0 py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}">{{ __('common.meetings') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}">{{ $meeting->title }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('portal.meeting.document.index', ['meeting' => $meeting->id]) }}">{{ __('common.documents') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $document->title }}</li>
            </ol>
        </nav>
    </div>
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
                        <i class="fa-duotone fa-file-pdf fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $document->title }}</h1>
                        <p class="hero-subtitle">{{ __('common.document') }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-calendar me-1"></i>
                                {{ $document->created_at->format('d.m.Y H:i') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-user me-1"></i>
                                {{ $document->created_by_name }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <a href="{{ route('portal.meeting.document.download', ['meeting' => $meeting->id, 'document' => $document->file_name]) }}" class="btn btn-hero-create">
                            <i class="fa-solid fa-download me-2"></i>{{ __('common.download') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Details Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-info-circle me-2"></i>
                        {{ __('common.document-details') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa-regular fa-input-text me-2"></i>
                                    {{ __('common.title') }}
                                </div>
                                <div class="info-value">{{ $document->title }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa-regular fa-calendar-check me-2"></i>
                                    {{ __('common.meeting') }}
                                </div>
                                <div class="info-value">{{ $meeting->title }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa-regular fa-toggle-large-on me-2"></i>
                                    {{ __('common.status') }}
                                </div>
                                <div class="info-value">
                                    <span class="status-badge {{ $document->status ? 'status-active' : 'status-inactive' }}">
                                        <i class="fa-regular fa-{{ $document->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                        {{ $document->status ? __('common.active') : __('common.passive') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa-regular fa-envelope me-2"></i>
                                    {{ __('common.sharing-via-email') }}
                                </div>
                                <div class="info-value">
                                    <span class="status-badge {{ $document->sharing_via_email ? 'status-active' : 'status-inactive' }}">
                                        <i class="fa-regular fa-{{ $document->sharing_via_email ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                        {{ $document->sharing_via_email ? __('common.allowed') : __('common.not-allowed') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa-regular fa-user me-2"></i>
                                    {{ __('common.created-by') }}
                                </div>
                                <div class="info-value">{{ $document->created_by_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fa-regular fa-calendar me-2"></i>
                                    {{ __('common.created-at') }}
                                </div>
                                <div class="info-value">{{ $document->created_at->format('d.m.Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Preview Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-file-pdf me-2"></i>
                        {{ __('common.document-preview') }}
                    </h3>
                    <div class="header-actions">
                        <button class="btn btn-outline-light btn-sm me-2" onclick="toggleFullscreen()">
                            <i class="fa-regular fa-expand me-1"></i>
                            {{ __('common.fullscreen') ?? 'Tam Ekran' }}
                        </button>
                        <a href="{{ route('portal.meeting.document.download', ['meeting' => $meeting->id, 'document' => $document->file_name]) }}" class="btn btn-outline-light btn-sm">
                            <i class="fa-regular fa-download me-1"></i>
                            {{ __('common.download') }}
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($document->file_name) && isset($document->file_extension))
                        <div class="document-preview-container">
                            <iframe src="{{ asset('storage/meetings/' . $meeting->id . '/documents/' . $document->file_name) }}" 
                                    class="document-iframe"
                                    title="{{ $document->title }}">
                            </iframe>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-file-slash"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.unspecified') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-file-available') ?? 'Görüntülenecek dosya yok' }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

<script>
function toggleFullscreen() {
    const iframe = document.querySelector('.document-iframe');
    if (iframe) {
        if (iframe.requestFullscreen) {
            iframe.requestFullscreen();
        } else if (iframe.webkitRequestFullscreen) {
            iframe.webkitRequestFullscreen();
        } else if (iframe.msRequestFullscreen) {
            iframe.msRequestFullscreen();
        }
    }
}
</script>

<style>
/* Document Show Page Styles */
.info-item {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
    height: 100%;
}

.info-label {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.info-value {
    font-size: 1rem;
    color: #333;
    font-weight: 500;
}

.document-preview-container {
    background: #f8f9fa;
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.document-iframe {
    border: none;
    width: 100%;
    height: 80vh;
    min-height: 600px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.header-actions {
    display: flex;
    align-items: center;
}

.header-actions .btn {
    font-size: 0.875rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .document-iframe {
        height: 60vh !important;
        min-height: 400px !important;
    }
    
    .hero-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .hero-action {
        width: 100%;
    }
    
    .btn-hero-create {
        width: 100%;
    }
    
    .header-actions {
        flex-direction: column;
        gap: 0.5rem;
        width: 100%;
    }
    
    .header-actions .btn {
        width: 100%;
    }
}
</style>
@endsection
