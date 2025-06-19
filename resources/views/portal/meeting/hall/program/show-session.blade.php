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
    <!-- Modern Hero Section for Session Program -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-presentation-screen fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $program->title }}</h1>
                        <p class="hero-subtitle">{{ __('common.session') }} {{ __('common.program') }} - {{ $program->hall->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-code me-1"></i>
                                {{ $program->code }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-presentation-screen me-1"></i>
                                {{ $program_sessions->count() }} {{ __('common.sessions') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-user-tie me-1"></i>
                                {{ $program_chairs->count() }} {{ __('common.chairs') }}
                            </span>
                            <span class="stat-item status-badge {{ $program->status ? 'status-active' : 'status-inactive' }}">
                                <i class="fa-regular fa-{{ $program->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                {{ $program->status ? __('common.active') : __('common.inactive') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#session-create-modal" data-route="{{ route('portal.meeting.hall.program.session.store', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.add-new-session') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Program Details and Chairs Row -->
    <div class="row mb-4">
        <!-- Program Details Card -->
        <div class="col-lg-6 mb-4">
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
        </div>

        <!-- Chairs Card -->
        <div class="col-lg-6 mb-4">
            <div class="modern-main-card h-100">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-user-tie me-2"></i>
                        {{ __('common.chairs') }}
                        <span class="count-badge ms-2">{{ $program_chairs->count() }}</span>
                    </h3>
                </div>
                <div class="card-body p-0 flex-grow-1">
                    @if($program_chairs->count() > 0)
                        <div class="modern-table-container">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th><i class="fa-regular fa-id-card me-1"></i>{{ __('common.name') }}</th>
                                        <th><i class="fa-regular fa-person-military-pointing me-1"></i>{{ __('common.type') }}</th>
                                        <th class="text-end">{{ __('common.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($program_chairs as $program_chair)
                                        <tr>
                                            <td>{{ $program_chair->chair->full_name }}</td>
                                            <td>
                                                <span class="theme-badge">{{ __('common.'.$program_chair->type) }}</span>
                                            </td>
                                            <td class="text-end">
                                                <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#chair-delete-modal" data-route="{{ route('portal.meeting.hall.program.chair.destroy', ['meeting' => $program_chair->program->hall->meeting_id, 'hall' => $program_chair->program->hall->id, 'program' => $program_chair->program->id, 'chair' => $program_chair->id ]) }}" data-record="{{ $program_chair->chair->full_name }}">
                                                    <i class="fa-regular fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state-small d-flex flex-column justify-content-center align-items-center h-100">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-user-tie"></i>
                            </div>
                            <p class="empty-state-text">{{ __('common.no-chairs-found') }}</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer mt-auto">
                    <button type="button" class="btn btn-success w-100" data-bs-toggle="offcanvas" data-bs-target="#chair-create-modal" data-route="{{ route('portal.meeting.hall.program.chair.store' , ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id]) }}">
                        <i class="fa-solid fa-plus me-2"></i>{{ __('common.add-new-chair') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sessions Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-presentation-screen me-2"></i>
                        {{ __('common.sessions') }}
                        <span class="count-badge ms-2">{{ $program_sessions->count() }}</span>
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($program_sessions->count() > 0)
                        <div class="modern-table-container">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th><i class="fa-regular fa-person-chalkboard me-1"></i>{{ __('common.speaker') }}</th>
                                        <th><i class="fa-regular fa-folder-open me-1"></i>{{ __('common.document') }}</th>
                                        <th><i class="fa-regular fa-circle-sort me-1"></i>{{ __('common.sort') }}</th>
                                        <th><i class="fa-regular fa-code-simple me-1"></i>{{ __('common.code') }}</th>
                                        <th><i class="fa-regular fa-input-text me-1"></i>{{ __('common.title') }}</th>
                                        <th><i class="fa-regular fa-calendar-arrow-up me-1"></i>{{ __('common.start-at') }}</th>
                                        <th><i class="fa-regular fa-calendar-arrow-down me-1"></i>{{ __('common.finish-at') }}</th>
                                        <th><i class="fa-regular fa-block-question me-1"></i>{{ __('common.questions') }}</th>
                                        <th><i class="fa-regular fa-circle-1 me-1"></i>{{ __('common.question-limit') }}</th>
                                        <th><i class="fa-regular fa-toggle-large-on me-1"></i>{{ __('common.status') }}</th>
                                        <th class="text-end">{{ __('common.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($program_sessions as $program_session)
                                        <tr>
                                            <td>
                                                @if($program_session->speaker)
                                                    {{ $program_session->speaker->full_name }}
                                                @else
                                                    <span class="text-muted">{{ __('common.not-specified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($program_session->document_id)
                                                    <a href="{{ route('portal.meeting.document.download', ['meeting' => $program->hall->meeting_id, 'document' => $program_session->document->file_name]) }}" class="btn btn-sm btn-outline-info" title="{{ __('common.view') }}">
                                                        <i class="fa-regular fa-file-arrow-down me-1"></i>{{ Str::limit($program_session->document->title, 20) }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">{{ __('common.not-specified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($program_session->sort_order)
                                                    <span class="id-badge">{{ $program_session->sort_order }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($program_session->code)
                                                    <span class="id-badge">{{ $program_session->code }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $program_session->title }}</td>
                                            <td>
                                                @if($program_session->start_at)
                                                    <span class="date-badge">{{ \Carbon\Carbon::parse($program_session->start_at)->format('H:i') }}</span>
                                                @else
                                                    <span class="text-muted">{{ __('common.not-specified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($program_session->finish_at)
                                                    <span class="date-badge">{{ \Carbon\Carbon::parse($program_session->finish_at)->format('H:i') }}</span>
                                                @else
                                                    <span class="text-muted">{{ __('common.not-specified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="status-dot {{ $program_session->questions_allowed ? 'status-active' : 'status-inactive' }}"></span>
                                            </td>
                                            <td>
                                                @if($program_session->questions_limit)
                                                    <span class="id-badge">{{ $program_session->questions_limit }}</span>
                                                @else
                                                    <span class="text-muted">∞</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="status-dot {{ $program_session->status ? 'status-active' : 'status-inactive' }}"></span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                    <a class="btn btn-outline-info btn-sm" href="{{ route('portal.meeting.hall.program.session.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $program_session->id]) }}" title="{{ __('common.show') }}">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#session-edit-modal" data-route="{{ route('portal.meeting.hall.program.session.update', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $program_session->id]) }}" data-resource="{{ route('portal.meeting.hall.program.session.edit', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $program_session->id]) }}" data-id="{{ $program_session->id }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#session-delete-modal" data-route="{{ route('portal.meeting.hall.program.session.destroy', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $program_session->id]) }}" data-record="{{ $program_session->title }}">
                                                        <i class="fa-regular fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state-small">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-presentation-screen"></i>
                            </div>
                            <p class="empty-state-text">{{ __('common.no-sessions-found') }}</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="offcanvas" data-bs-target="#session-create-modal" data-route="{{ route('portal.meeting.hall.program.session.store', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id]) }}">
                        <i class="fa-solid fa-plus"></i> {{ __('common.add-new-session') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- CRUD Modals -->
    <!-- Chair Create Modal -->
    <div class="offcanvas offcanvas-end modern-offcanvas" tabindex="-1" id="chair-create-modal">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <i class="fa-duotone fa-plus me-2"></i>{{ __('common.add-new-chair') }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="chair-create-form" method="POST">
                @csrf
                <input type="hidden" name="program_id" value="{{ $program->id }}">
                
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-id-card me-2"></i>{{ __('common.chair') }}
                    </label>
                    <select name="chair_id" class="form-select" required>
                        <option value="">{{ __('common.select-chair') }}</option>
                        @foreach($chairs as $chair)
                            <option value="{{ $chair->id }}">{{ $chair->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-person-military-pointing me-2"></i>{{ __('common.type') }}
                    </label>
                    <select name="type" class="form-select" required>
                        @foreach($chair_types as $type)
                            <option value="{{ $type['value'] }}">{{ $type['title'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-save me-2"></i>{{ __('common.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Chair Delete Modal -->
    <div class="offcanvas offcanvas-end modern-offcanvas" tabindex="-1" id="chair-delete-modal">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <i class="fa-duotone fa-trash me-2"></i>{{ __('common.delete-chair') }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                {{ __('common.delete-confirmation') }}
            </div>
            <form id="chair-delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash me-2"></i>{{ __('common.delete') }}
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">
                        {{ __('common.cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Session Create Modal -->
    <div class="offcanvas offcanvas-end modern-offcanvas" tabindex="-1" id="session-create-modal">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <i class="fa-duotone fa-plus me-2"></i>{{ __('common.add-new-session') }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="session-create-form" method="POST">
                @csrf
                <input type="hidden" name="program_id" value="{{ $program->id }}">
                
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-circle-sort me-2"></i>{{ __('common.sort') }}
                    </label>
                    <input type="number" name="sort_order" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-person-chalkboard me-2"></i>{{ __('common.speaker') }}
                    </label>
                    <select name="speaker_id" class="form-select">
                        <option value="">{{ __('common.select-speaker') }}</option>
                        @foreach($speakers as $speaker)
                            <option value="{{ $speaker->id }}">{{ $speaker->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-presentation-screen me-2"></i>{{ __('common.document') }}
                    </label>
                    <select name="document_id" class="form-select">
                        <option value="">{{ __('common.select-document') }}</option>
                        @foreach($documents as $document)
                            <option value="{{ $document->id }}">{{ $document->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-code-simple me-2"></i>{{ __('common.code') }}
                    </label>
                    <input type="text" name="code" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-input-text me-2"></i>{{ __('common.title') }}
                    </label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-comment-dots me-2"></i>{{ __('common.description') }}
                    </label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-calendar-arrow-down me-2"></i>{{ __('common.start-at') }}
                    </label>
                    <input type="datetime-local" name="start_at" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-calendar-arrow-down me-2"></i>{{ __('common.finish-at') }}
                    </label>
                    <input type="datetime-local" name="finish_at" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-block-question me-2"></i>{{ __('common.questions') }}
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions_allowed" value="1" id="c-questions-yes">
                        <label class="form-check-label" for="c-questions-yes">{{ __('common.yes') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions_allowed" value="0" id="c-questions-no" checked>
                        <label class="form-check-label" for="c-questions-no">{{ __('common.no') }}</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-circle-1 me-2"></i>{{ __('common.question-limit') }}
                    </label>
                    <input type="number" name="questions_limit" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-block-question me-2"></i>{{ __('common.questions-auto-start') }}
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions_auto_start" value="1" id="c-auto-start-yes">
                        <label class="form-check-label" for="c-auto-start-yes">{{ __('common.yes') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions_auto_start" value="0" id="c-auto-start-no" checked>
                        <label class="form-check-label" for="c-auto-start-no">{{ __('common.no') }}</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-toggle-large-on me-2"></i>{{ __('common.status') }}
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="1" id="c-status-active" checked>
                        <label class="form-check-label" for="c-status-active">{{ __('common.active') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="0" id="c-status-inactive">
                        <label class="form-check-label" for="c-status-inactive">{{ __('common.inactive') }}</label>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-save me-2"></i>{{ __('common.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Session Edit Modal -->
    <div class="offcanvas offcanvas-end modern-offcanvas" tabindex="-1" id="session-edit-modal">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <i class="fa-duotone fa-pen-to-square me-2"></i>{{ __('common.edit-session') }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="session-edit-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="program_id" value="{{ $program->id }}">
                
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-circle-sort me-2"></i>{{ __('common.sort') }}
                    </label>
                    <input type="number" name="sort_order" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-person-chalkboard me-2"></i>{{ __('common.speaker') }}
                    </label>
                    <select name="speaker_id" class="form-select">
                        <option value="">{{ __('common.select-speaker') }}</option>
                        @foreach($speakers as $speaker)
                            <option value="{{ $speaker->id }}">{{ $speaker->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-presentation-screen me-2"></i>{{ __('common.document') }}
                    </label>
                    <select name="document_id" class="form-select">
                        <option value="">{{ __('common.select-document') }}</option>
                        @foreach($documents as $document)
                            <option value="{{ $document->id }}">{{ $document->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-code-simple me-2"></i>{{ __('common.code') }}
                    </label>
                    <input type="text" name="code" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-input-text me-2"></i>{{ __('common.title') }}
                    </label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-comment-dots me-2"></i>{{ __('common.description') }}
                    </label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-calendar-arrow-down me-2"></i>{{ __('common.start-at') }}
                    </label>
                    <input type="datetime-local" name="start_at" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-calendar-arrow-down me-2"></i>{{ __('common.finish-at') }}
                    </label>
                    <input type="datetime-local" name="finish_at" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-block-question me-2"></i>{{ __('common.questions') }}
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions_allowed" value="1" id="e-questions-yes">
                        <label class="form-check-label" for="e-questions-yes">{{ __('common.yes') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions_allowed" value="0" id="e-questions-no">
                        <label class="form-check-label" for="e-questions-no">{{ __('common.no') }}</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-circle-1 me-2"></i>{{ __('common.question-limit') }}
                    </label>
                    <input type="number" name="questions_limit" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-block-question me-2"></i>{{ __('common.questions-auto-start') }}
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions_auto_start" value="1" id="e-auto-start-yes">
                        <label class="form-check-label" for="e-auto-start-yes">{{ __('common.yes') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="questions_auto_start" value="0" id="e-auto-start-no">
                        <label class="form-check-label" for="e-auto-start-no">{{ __('common.no') }}</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-toggle-large-on me-2"></i>{{ __('common.status') }}
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="1" id="e-status-active">
                        <label class="form-check-label" for="e-status-active">{{ __('common.active') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="0" id="e-status-inactive">
                        <label class="form-check-label" for="e-status-inactive">{{ __('common.inactive') }}</label>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-warning">
                        <i class="fa-solid fa-save me-2"></i>{{ __('common.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Session Delete Modal -->
    <div class="offcanvas offcanvas-end modern-offcanvas" tabindex="-1" id="session-delete-modal">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <i class="fa-duotone fa-trash me-2"></i>{{ __('common.delete-session') }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                {{ __('common.delete-confirmation') }}
            </div>
            <form id="session-delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash me-2"></i>{{ __('common.delete') }}
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">
                        {{ __('common.cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script type="module">
        // Handle session create modal
        const sessionCreateModal = document.getElementById('session-create-modal');
        if (sessionCreateModal) {
            sessionCreateModal.addEventListener('show.bs.offcanvas', event => {
                const button = event.relatedTarget;
                if(button && button.hasAttribute('data-route')) {
                    const routeUrl = button.getAttribute('data-route');
                    document.getElementById('session-create-form').action = routeUrl;
                }
            });
        }

        // Handle session edit modal
        const sessionEditModal = document.getElementById('session-edit-modal');
        if (sessionEditModal) {
            sessionEditModal.addEventListener('show.bs.offcanvas', event => {
                const button = event.relatedTarget;
                if(button && button.hasAttribute('data-resource')) {
                    const resourceUrl = button.getAttribute('data-resource');
                    console.log('Resource URL:', resourceUrl);
                    
                    // Get the form specifically
                    const form = document.getElementById('session-edit-form');
                    if (!form) {
                        console.error('Session edit form not found!');
                        return;
                    }
                    
                    // Clear all fields first
                    form.reset();
                    
                    // Fetch session data via AJAX
                    fetch(resourceUrl)
                        .then(response => {
                            console.log('Response status:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Session data received:', data);
                            
                            // Update form action
                            if (data.route) {
                                form.action = data.route;
                                console.log('Form action set to:', data.route);
                            }
                            
                            // Populate all form fields
                            Object.keys(data).forEach(key => {
                                if (key === 'route') return; // Skip route field
                                
                                const fieldData = data[key];
                                console.log(`Processing field ${key}:`, fieldData);
                                
                                if (fieldData && fieldData.value !== null && fieldData.value !== undefined) {
                                    
                                    if (fieldData.type === 'text' || fieldData.type === 'number' || fieldData.type === 'hidden') {
                                        // Handle input fields
                                        const input = form.querySelector(`input[name="${key}"]`);
                                        if (input) {
                                            input.value = fieldData.value || '';
                                            console.log(`Set ${key} to:`, fieldData.value);
                                        } else {
                                            console.log(`Input field ${key} not found`);
                                        }
                                    } else if (fieldData.type === 'datetime') {
                                        // Handle datetime fields
                                        const input = form.querySelector(`input[name="${key}"][type="datetime-local"]`);
                                        if (input) {
                                            input.value = fieldData.value || '';
                                            console.log(`Set datetime ${key} to:`, fieldData.value);
                                        } else {
                                            console.log(`Datetime field ${key} not found`);
                                        }
                                    } else if (fieldData.type === 'textarea') {
                                        // Handle textarea fields
                                        const textarea = form.querySelector(`textarea[name="${key}"]`);
                                        if (textarea) {
                                            textarea.value = fieldData.value || '';
                                            console.log(`Set textarea ${key} to:`, fieldData.value);
                                        } else {
                                            console.log(`Textarea field ${key} not found`);
                                        }
                                    } else if (fieldData.type === 'select') {
                                        // Handle select fields
                                        const select = form.querySelector(`select[name="${key}"]`);
                                        if (select) {
                                            select.value = fieldData.value || '';
                                            console.log(`Set select ${key} to:`, fieldData.value);
                                        } else {
                                            console.log(`Select field ${key} not found`);
                                        }
                                    } else if (fieldData.type === 'radio') {
                                        // Handle radio fields
                                        const radio = form.querySelector(`input[name="${key}"][value="${fieldData.value}"]`);
                                        if (radio) {
                                            radio.checked = true;
                                            console.log(`Set radio ${key} to:`, fieldData.value);
                                        } else {
                                            console.log(`Radio field ${key} with value ${fieldData.value} not found`);
                                        }
                                    }
                                } else {
                                    console.log(`Field ${key} has no value or null value`);
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching session data:', error);
                        });
                }
            });
        }

        // Handle session delete modal
        const sessionDeleteModal = document.getElementById('session-delete-modal');
        if (sessionDeleteModal) {
            sessionDeleteModal.addEventListener('show.bs.offcanvas', event => {
                const button = event.relatedTarget;
                if(button && button.hasAttribute('data-route')) {
                    const routeUrl = button.getAttribute('data-route');
                    document.getElementById('session-delete-form').action = routeUrl;
                }
            });
        }
    </script>
@endsection
