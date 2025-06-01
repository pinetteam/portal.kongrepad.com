@extends('layout.portal.meeting-detail')
@section('title', $hall->title . ' | ' . __('common.programs'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $hall->meeting->id) }}">{{ $hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $hall->meeting->id]) }}">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $hall->meeting->id, 'hall' => $hall->id]) }}">{{ $hall->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.programs') }}</li>
@endsection
@section('meeting_content')

<!-- Modern Hero Section -->
<div class="hero-section mb-4">
    <div class="hero-content p-4 text-white d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="hero-icon me-3">
                <i class="fa-solid fa-calendar-week fa-2x"></i>
            </div>
            <div>
                <h2 class="mb-1">{{ $hall->title }} Programs</h2>
                <p class="mb-0 opacity-75">{{ __('common.programs') }} Management</p>
            </div>
        </div>
        <div class="stats-badge">
            <span class="badge bg-white text-primary rounded-pill px-3 py-2 fs-6">
                <i class="fa-solid fa-calendar me-1"></i>{{ $programs->count() }} Programs
            </span>
        </div>
    </div>
</div>

<!-- Programs Timeline -->
<div class="programs-container">
    @forelse($programs as $index => $program)
        <div class="program-timeline-item" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
            <!-- Program Header -->
            <div class="program-header">
                <div class="program-icon">
                    @if($program->type == 'session')
                        <i class="fa-solid fa-presentation-screen"></i>
                    @elseif($program->type == 'debate')
                        <i class="fa-solid fa-comments"></i>
                    @else
                        <i class="fa-solid fa-calendar-day"></i>
                    @endif
                </div>
                <div class="program-details flex-grow-1">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <h4 class="program-title">{{ $program->title }}</h4>
                            <div class="program-meta">
                                <span class="badge bg-{{ $program->type == 'session' ? 'info' : 'warning' }} me-2">{{ __('common.'.$program->type) }}</span>
                                <span class="text-muted me-3">
                                    <i class="fa-regular fa-code me-1"></i>{{ $program->code }}
                                </span>
                                <span class="text-muted me-3">
                                    <i class="fa-regular fa-sort me-1"></i>{{ $program->sort_order ?? 'N/A' }}
                                </span>
                                @if($program->status)
                                    <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i>Active</span>
                                @else
                                    <span class="badge bg-danger"><i class="fa-solid fa-times me-1"></i>Inactive</span>
                                @endif
                            </div>
                            @if($program->start_at && $program->finish_at)
                                <div class="program-time">
                                    <i class="fa-regular fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($program->start_at)->format('d M Y, H:i') }} - 
                                    {{ \Carbon\Carbon::parse($program->finish_at)->format('H:i') }}
                                </div>
                            @endif
                        </div>
                        <div class="program-actions">
                            @if($program->type == "session")
                                <button type="button" class="btn btn-success btn-sm me-1" data-bs-toggle="offcanvas" data-bs-target="#session-create-modal" data-route="{{ route('portal.meeting.hall.program.session.store', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id]) }}" title="{{ __('common.add-session') }}">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            @elseif($program->type == "debate")
                                <button type="button" class="btn btn-success btn-sm me-1" data-bs-toggle="offcanvas" data-bs-target="#debate-create-modal" data-route="{{ route('portal.meeting.hall.program.debate.store', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id]) }}" title="{{ __('common.add-debate') }}">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            @endif
                            <a class="btn btn-info btn-sm me-1" href="{{ route('portal.meeting.hall.program.show', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'program' => $program->id]) }}" title="{{ __('common.show') }}">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                            <button class="btn btn-warning btn-sm me-1" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#program-edit-modal" data-route="{{ route('portal.meeting.hall.program.update', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'program' => $program->id]) }}" data-resource="{{ route('portal.meeting.hall.program.edit', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'program' => $program->id]) }}" data-id="{{ $program->id }}">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#program-delete-modal" data-route="{{ route('portal.meeting.hall.program.destroy', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'program' => $program->id]) }}" data-record="{{ $program->title }}">
                                <i class="fa-regular fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sessions/Debates -->
            @if($program->sessions()->count() > 0 || $program->debates()->count() > 0)
                <div class="program-content">
                    @if($program->sessions()->count() > 0)
                        <div class="sessions-container">
                            <h6 class="content-title">
                                <i class="fa-solid fa-presentation-screen me-2"></i>Sessions ({{ $program->sessions()->count() }})
                            </h6>
                            @foreach($program->sessions()->get() as $session)
                                <div class="session-item">
                                    <div class="session-indicator"></div>
                                    <div class="session-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="session-title">{{ $session->title }}</h6>
                                                <div class="session-meta">
                                                    @if($session->speaker)
                                                        <span class="speaker-tag">
                                                            <i class="fa-solid fa-user me-1"></i>{{ $session->speaker->full_name }}
                                                        </span>
                                                    @endif
                                                    @if($session->document_id)
                                                        <a href="{{ route('portal.meeting.document.download', ['meeting' => $program->hall->meeting_id, 'document' => $session->document->file_name ] ) }}" class="document-link">
                                                            <i class="fa-solid fa-file me-1"></i>{{ $session->document->title }}
                                                        </a>
                                                    @endif
                                                </div>
                                                @if($session->start_at && $session->finish_at)
                                                    <div class="session-time">
                                                        <i class="fa-regular fa-clock me-1"></i>
                                                        {{ \Carbon\Carbon::parse($session->start_at)->format('H:i') }} - 
                                                        {{ \Carbon\Carbon::parse($session->finish_at)->format('H:i') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="session-actions">
                                                <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.program.session.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id]) }}">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="offcanvas" data-bs-target="#session-edit-modal" data-route="{{ route('portal.meeting.hall.program.session.update', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id]) }}" data-resource="{{ route('portal.meeting.hall.program.session.edit', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id]) }}" data-id="{{ $session->id }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="offcanvas" data-bs-target="#session-delete-modal" data-route="{{ route('portal.meeting.hall.program.session.destroy', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id]) }}" data-record="{{ $session->title }}">
                                                    <i class="fa-regular fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($program->debates()->count() > 0)
                        <div class="debates-container">
                            <h6 class="content-title">
                                <i class="fa-solid fa-comments me-2"></i>Debates ({{ $program->debates()->count() }})
                            </h6>
                            @foreach($program->debates()->get() as $debate)
                                <div class="debate-item">
                                    <div class="debate-indicator"></div>
                                    <div class="debate-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="debate-title">{{ $debate->title }}</h6>
                                                <p class="debate-description">{{ $debate->description }}</p>
                                                @if($debate->voting_started_at)
                                                    <div class="debate-time">
                                                        <i class="fa-regular fa-clock me-1"></i>
                                                        Voting: {{ \Carbon\Carbon::parse($debate->voting_started_at)->format('d M Y, H:i') }}
                                                        @if($debate->voting_finished_at)
                                                            - {{ \Carbon\Carbon::parse($debate->voting_finished_at)->format('H:i') }}
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="debate-actions">
                                                <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.program.debate.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="offcanvas" data-bs-target="#debate-edit-modal" data-route="{{ route('portal.meeting.hall.program.debate.update', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-resource="{{ route('portal.meeting.hall.program.debate.edit', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-id="{{ $debate->id }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="offcanvas" data-bs-target="#debate-delete-modal" data-route="{{ route('portal.meeting.hall.program.debate.destroy', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-record="{{ $debate->title }}">
                                                    <i class="fa-regular fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa-regular fa-calendar-xmark fa-4x"></i>
            </div>
            <h4>No Programs Yet</h4>
            <p class="text-muted">Get started by creating your first program</p>
            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="offcanvas" data-bs-target="#program-create-modal" data-route="{{ route('portal.meeting.hall.program.store', ['meeting' => $hall->meeting_id, 'hall' => $hall->id]) }}">
                <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-program') }}
            </button>
        </div>
    @endforelse
</div>

<!-- Add Program Button -->
@if($programs->count() > 0)
    <div class="floating-add-btn">
        <button type="button" class="btn btn-success btn-lg rounded-circle" data-bs-toggle="offcanvas" data-bs-target="#program-create-modal" data-route="{{ route('portal.meeting.hall.program.store', ['meeting' => $hall->meeting_id, 'hall' => $hall->id]) }}" title="{{ __('common.create-new-program') }}">
            <i class="fa-solid fa-plus fa-xl"></i>
        </button>
    </div>
@endif

<style>
.hero-section {
    background: linear-gradient(135deg, var(--kongre-primary), var(--kongre-secondary));
    border-radius: 1rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.hero-icon {
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.programs-container {
    position: relative;
}

.programs-container::before {
    content: '';
    position: absolute;
    left: 30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #e9ecef, #dee2e6);
}

.program-timeline-item {
    position: relative;
    margin-bottom: 2rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
}

.program-timeline-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.program-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 1.5rem;
    display: flex;
    align-items: flex-start;
    position: relative;
}

.program-header::before {
    content: '';
    position: absolute;
    left: -1.25rem;
    top: 1.5rem;
    width: 12px;
    height: 12px;
    background: var(--kongre-primary);
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 3px var(--kongre-primary);
}

.program-icon {
    background: linear-gradient(135deg, var(--kongre-primary), var(--kongre-secondary));
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.2rem;
}

.program-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.25rem;
}

.program-meta {
    margin-bottom: 0.5rem;
}

.program-time {
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
}

.program-actions {
    display: flex;
    gap: 0.25rem;
}

.program-content {
    padding: 1.5rem;
    background: #f8f9fa;
}

.content-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #dee2e6;
}

.session-item, .debate-item {
    background: white;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
}

.session-indicator, .debate-indicator {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, #3498db, #2ecc71);
}

.session-content, .debate-content {
    padding: 1rem 1rem 1rem 1.5rem;
}

.session-title, .debate-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.session-meta {
    margin-bottom: 0.5rem;
}

.speaker-tag {
    background: #e3f2fd;
    color: #1976d2;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.8rem;
    margin-right: 0.5rem;
}

.document-link {
    background: #f3e5f5;
    color: #7b1fa2;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    text-decoration: none;
    font-size: 0.8rem;
}

.document-link:hover {
    background: #e1bee7;
    color: #6a1b9a;
}

.session-time, .debate-time {
    color: #6c757d;
    font-size: 0.85rem;
}

.session-actions, .debate-actions {
    display: flex;
    gap: 0.25rem;
}

.debate-description {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.empty-icon {
    color: #dee2e6;
    margin-bottom: 1.5rem;
}

.floating-add-btn {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 1000;
}

.floating-add-btn .btn {
    width: 60px;
    height: 60px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

@media (max-width: 768px) {
    .programs-container::before {
        left: 15px;
    }
    
    .program-header::before {
        left: -1.75rem;
    }
    
    .program-header {
        padding: 1rem;
    }
    
    .program-content {
        padding: 1rem;
    }
    
    .floating-add-btn {
        bottom: 1rem;
        right: 1rem;
    }
}

/* Modern CRUD Modal Styles */
.offcanvas {
    border: none !important;
    box-shadow: -8px 0 32px rgba(0, 0, 0, 0.15) !important;
    max-width: 700px !important;
    width: 700px !important;
}

.offcanvas-header {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
    color: white !important;
    padding: 1.5rem !important;
    border-bottom: none !important;
    border-radius: 0 !important;
}

.offcanvas-title {
    font-weight: 600 !important;
    font-size: 1.3rem !important;
    margin: 0 !important;
}

.btn-close {
    color: white !important;
    opacity: 0.8 !important;
    font-size: 1.2rem !important;
}

.btn-close:hover {
    opacity: 1 !important;
    color: white !important;
}

.offcanvas-body {
    background: #f8fafc !important;
    color: #1e293b !important;
    padding: 0 !important;
}

/* Form Container */
.offcanvas-body form {
    height: 100% !important;
    display: flex !important;
    flex-direction: column !important;
}

.offcanvas-body .flex-grow-1 {
    padding: 2rem !important;
    overflow-y: auto !important;
}

/* Form Groups */
.offcanvas-body .col-12 {
    margin-bottom: 1.5rem !important;
}

.offcanvas-body .form-label {
    font-weight: 600 !important;
    color: #1f2937 !important;
    margin-bottom: 0.5rem !important;
    font-size: 0.95rem !important;
}

.offcanvas-body .form-control,
.offcanvas-body .form-select {
    border: 2px solid #e5e7eb !important;
    border-radius: 8px !important;
    padding: 0.75rem 1rem !important;
    font-size: 0.95rem !important;
    transition: all 0.2s ease !important;
    background: white !important;
    color: #1e293b !important;
}

.offcanvas-body .form-control:focus,
.offcanvas-body .form-select:focus {
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
    outline: none !important;
}

.offcanvas-body .form-control:hover,
.offcanvas-body .form-select:hover {
    border-color: #9ca3af !important;
}

/* Radio Buttons */
.offcanvas-body .form-check {
    margin-bottom: 0.75rem !important;
}

.offcanvas-body .form-check-input {
    width: 1.2em !important;
    height: 1.2em !important;
    border: 2px solid #d1d5db !important;
    margin-top: 0.1em !important;
}

.offcanvas-body .form-check-input:checked {
    background-color: #4f46e5 !important;
    border-color: #4f46e5 !important;
}

.offcanvas-body .form-check-label {
    font-weight: 500 !important;
    color: #1f2937 !important;
    margin-left: 0.5rem !important;
}

/* Date/Time Inputs */
.offcanvas-body input[type="date"],
.offcanvas-body input[type="time"],
.offcanvas-body input[type="datetime-local"] {
    border: 2px solid #e5e7eb !important;
    border-radius: 8px !important;
    padding: 0.75rem 1rem !important;
    background: white !important;
    color: #1e293b !important;
}

/* File Upload */
.offcanvas-body input[type="file"] {
    border: 2px dashed #d1d5db !important;
    border-radius: 8px !important;
    padding: 1rem !important;
    background: #f9fafb !important;
    transition: all 0.2s ease !important;
}

.offcanvas-body input[type="file"]:hover {
    border-color: #4f46e5 !important;
    background: #f0f7ff !important;
}

/* Error States */
.offcanvas-body .is-invalid {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
}

.offcanvas-body .invalid-feedback {
    color: #ef4444 !important;
    font-size: 0.875rem !important;
    margin-top: 0.5rem !important;
    display: block !important;
}

/* Button Section */
.offcanvas-body .border-top {
    border-top: 1px solid #e5e7eb !important;
    padding: 1.5rem 2rem !important;
    background: white !important;
    margin-top: 0 !important;
}

.offcanvas-body .btn-group {
    gap: 0.75rem !important;
    width: 100% !important;
}

.offcanvas-body .btn-group .btn {
    border-radius: 8px !important;
    padding: 0.75rem 1.5rem !important;
    font-weight: 600 !important;
    border: none !important;
    transition: all 0.2s ease !important;
}

.offcanvas-body .btn-danger {
    background: #ef4444 !important;
    color: white !important;
    flex: 0 0 auto !important;
    width: auto !important;
    min-width: 120px !important;
}

.offcanvas-body .btn-danger:hover {
    background: #dc2626 !important;
    transform: translateY(-1px) !important;
}

.offcanvas-body .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    color: white !important;
    flex: 1 !important;
    width: auto !important;
}

.offcanvas-body .btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
    transform: translateY(-1px) !important;
}

/* Textarea */
.offcanvas-body textarea.form-control {
    min-height: 100px !important;
    resize: vertical !important;
}

/* Grid Layout for Forms */
.offcanvas-body .row {
    gap: 0 !important;
    margin: 0 !important;
}

.offcanvas-body .col-12 {
    padding: 0 !important;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .offcanvas {
        max-width: 100% !important;
        width: 100% !important;
    }
    
    .offcanvas-body .flex-grow-1 {
        padding: 1rem !important;
    }
    
    .offcanvas-body .border-top {
        padding: 1rem !important;
    }
    
    .offcanvas-body .btn-group {
        flex-direction: column !important;
    }
    
    .offcanvas-body .btn-group .btn {
        width: 100% !important;
        margin-bottom: 0.5rem !important;
    }
}

/* Loading States */
.offcanvas-body .form-control:disabled {
    background-color: #f3f4f6 !important;
    opacity: 0.7 !important;
}

/* Success States */
.offcanvas-body .is-valid {
    border-color: #10b981 !important;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
}

/* Select Dropdown Styling */
.offcanvas-body .form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e") !important;
    background-position: right 0.75rem center !important;
    background-repeat: no-repeat !important;
    background-size: 16px 12px !important;
    padding-right: 3rem !important;
}

/* Smooth Animations */
.offcanvas.showing,
.offcanvas.show,
.offcanvas.hiding {
    transition: transform 0.3s ease-in-out !important;
}

/* Better Scrollbar */
.offcanvas-body .flex-grow-1::-webkit-scrollbar {
    width: 6px;
}

.offcanvas-body .flex-grow-1::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.offcanvas-body .flex-grow-1::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.offcanvas-body .flex-grow-1::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

<x-crud.form.common.create name="session" method="c-s">
    @section('session-create-form')
        <x-input.hidden method="c-s" name="program_id" :value="1"/>
        <x-input.select method="c-s" name="speaker_id" title="speaker" :options="$speakers" option_value="id" option_name="full_name" icon="person-chalkboard" :searchable="true" />
        <x-input.select method="c-s" name="document_id" title="document" :options="$documents" option_value="id" option_name="title" icon="speakation-screen" :searchable="true" />
        <x-input.number method="c-s" name="sort_order" title="sort" icon="circle-sort"/>
        <x-input.text method="c-s" name="code" title="code" icon="code-simple"/>
        <x-input.text method="c-s" name="title" title="title" icon="input-text"/>
        <x-input.text method="c-s" name="description" title="description" icon="comment-dots"/>
        <x-input.datetime method="c-s" name="start_at" title="start-at" icon="calendar-arrow-down"/>
        <x-input.datetime method="c-s" name="finish_at" title="finish-at" icon="calendar-arrow-down"/>
        <x-input.radio method="c-s" name="questions_allowed" title="questions" :options="$questions" option_value="value" option_name="title" icon="block-question"/>
        <x-input.radio method="c-s" name="questions_auto_start" title="questions-auto-start" :options="$questions_auto_start" option_value="value" option_name="title" icon="block-question"/>
        <x-input.number method="c-s" name="questions_limit" title="question-limit" icon="circle-1"/>
        <x-input.radio method="c-s" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
    @endsection
</x-crud.form.common.create>
<x-crud.form.common.delete name="session"/>
<x-crud.form.common.edit name="session" method="e-s">
    @section('session-edit-form')
        <x-input.hidden method="e-s" name="program_id" :value="1"/>
        <x-input.select method="e-s" name="speaker_id" title="speaker" :options="$speakers" option_value="id" option_name="full_name" icon="person-chalkboard" :searchable="true"/>
        <x-input.select method="e-s" name="document_id" title="document" :options="$documents" option_value="id" option_name="file_name" icon="speakation-screen" :searchable="true"/>
        <x-input.number method="e-s" name="sort_order" title="sort" icon="circle-sort"/>
        <x-input.text method="e-s" name="code" title="code" icon="code-simple"/>
        <x-input.text method="e-s" name="title" title="title" icon="input-text"/>
        <x-input.text method="e-s" name="description" title="description" icon="comment-dots"/>
        <x-input.datetime method="e-s" name="start_at" title="start-at" icon="calendar-arrow-down"/>
        <x-input.datetime method="e-s" name="finish_at" title="finish-at" icon="calendar-arrow-down"/>
        <x-input.radio method="e-s" name="questions_allowed" title="questions" :options="$questions" option_value="value" option_name="title" icon="block-question"/>
        <x-input.radio method="e-s" name="questions_auto_start" title="questions-auto-start" :options="$questions_auto_start" option_value="value" option_name="title" icon="block-question"/>
        <x-input.number method="e-s" name="questions_limit" title="question-limit" icon="circle-1"/>
        <x-input.radio method="e-s" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
    @endsection
</x-crud.form.common.edit>
<x-crud.form.common.create name="debate" method="c-d">
    @section('debate-create-form')
        <x-input.hidden method="c-d" name="program_id" :value="1"/>
        <x-input.number method="c-d" name="sort_order" title="sort" icon="circle-sort"/>
        <x-input.text method="c-d" name="code" title="code" icon="code-simple"/>
        <x-input.text method="c-d" name="title" title="title" icon="input-text"/>
        <x-input.text method="c-d" name="description" title="description" icon="comment-dots"/>
        <x-input.radio method="c-d" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
    @endsection
</x-crud.form.common.create>
<x-crud.form.common.delete name="debate"/>
<x-crud.form.common.edit name="debate" method="e-d">
    @section('debate-edit-form')
        <x-input.hidden method="e-d" name="program_id" :value="1"/>
        <x-input.number method="e-d" name="sort_order" title="sort" icon="circle-sort"/>
        <x-input.text method="e-d" name="code" title="code" icon="code-simple"/>
        <x-input.text method="e-d" name="title" title="title" icon="input-text"/>
        <x-input.text method="e-d" name="description" title="description" icon="comment-dots"/>
        <x-input.radio method="e-d" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
    @endsection
</x-crud.form.common.edit>
<x-crud.form.common.create name="program">
    @section('program-create-form')
        <x-input.hidden method="c" name="hall_id" :value="$hall->id"/>
        <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort"/>
        <x-input.text method="c" name="code" title="code" icon="code-simple"/>
        <x-input.text method="c" name="title" title="title" icon="input-text"/>
        <x-input.text method="c" name="description" title="description" icon="comment-dots"/>
        <x-input.file method="c" name="logo" title="logo" icon="image"/>
        <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar-arrow-down"/>
        <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down"/>
        <x-input.select method="c" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing"/>
        <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
    @endsection
</x-crud.form.common.create>
<x-crud.form.common.delete name="program" />
<x-crud.form.common.edit name="program" >
    @section('program-edit-form')
        <x-input.hidden method="e" name="hall_id" :value="$hall->id"/>
        <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort"/>
        <x-input.text method="e" name="code" title="code" icon="code-simple"/>
        <x-input.text method="e" name="title" title="title" icon="input-text"/>
        <x-input.text method="e" name="description" title="description" icon="comment-dots"/>
        <x-input.file method="e" name="logo" title="logo" icon="image"/>
        <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar-arrow-down"/>
        <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down"/>
        <x-input.select method="e" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing"/>
        <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
    @endsection
</x-crud.form.common.edit>
@endsection
