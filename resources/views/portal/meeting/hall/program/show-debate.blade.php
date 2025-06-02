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
    <link rel="stylesheet" href="{{ asset('css/meeting-pages-theme.css') }}">
@endpush

@section('meeting_content')
    <!-- Modern Hero Section for Debate Program -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-face-party fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $program->title }}</h1>
                        <p class="hero-subtitle">{{ __('common.debate') }} {{ __('common.program') }} - {{ $program->hall->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-code me-1"></i>
                                {{ $program->code }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-face-party me-1"></i>
                                {{ $debates->count() }} {{ __('common.debates') }}
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
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#debate-create-modal" data-route="{{ route('portal.meeting.hall.program.debate.store', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.add-new-debate') }}
                        </button>
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

    <!-- Chairs Card -->
    <div class="row mb-4">
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

    <!-- Debates Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-face-party me-2"></i>
                        {{ __('common.debates') }}
                        <span class="count-badge ms-2">{{ $debates->count() }}</span>
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($debates->count() > 0)
                        <div class="modern-table-container">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th><i class="fa-regular fa-circle-sort me-1"></i>{{ __('common.sort') }}</th>
                                        <th><i class="fa-regular fa-code-simple me-1"></i>{{ __('common.code') }}</th>
                                        <th><i class="fa-regular fa-input-text me-1"></i>{{ __('common.title') }}</th>
                                        <th><i class="fa-regular fa-comment-dots me-1"></i>{{ __('common.description') }}</th>
                                        <th><i class="fa-regular fa-calendar-arrow-up me-1"></i>{{ __('common.voting-started-at') }}</th>
                                        <th><i class="fa-regular fa-calendar-arrow-down me-1"></i>{{ __('common.voting-finished-at') }}</th>
                                        <th><i class="fa-regular fa-toggle-large-on me-1"></i>{{ __('common.status') }}</th>
                                        <th class="text-end">{{ __('common.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($debates as $debate)
                                        <tr>
                                            <td>
                                                @if($debate->sort_order)
                                                    <span class="id-badge">{{ $debate->sort_order }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($debate->code)
                                                    <span class="id-badge">{{ $debate->code }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $debate->title }}</td>
                                            <td>
                                                @if($debate->description)
                                                    {{ Str::limit($debate->description, 30) }}
                                                @else
                                                    <span class="text-muted">{{ __('common.not-specified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($debate->voting_started_at)
                                                    <span class="date-badge">{{ \Carbon\Carbon::parse($debate->voting_started_at)->format('d M Y, H:i') }}</span>
                                                @else
                                                    <span class="text-muted">{{ __('common.not-specified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($debate->voting_finished_at)
                                                    <span class="date-badge">{{ \Carbon\Carbon::parse($debate->voting_finished_at)->format('d M Y, H:i') }}</span>
                                                @else
                                                    <span class="text-muted">{{ __('common.not-specified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="status-dot {{ $debate->status ? 'status-active' : 'status-inactive' }}"></span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                    <a class="btn btn-outline-info btn-sm" href="{{ route('portal.meeting.hall.program.debate.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" title="{{ __('common.show') }}">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#debate-edit-modal" data-route="{{ route('portal.meeting.hall.program.debate.update', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-resource="{{ route('portal.meeting.hall.program.debate.edit', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-id="{{ $debate->id }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#debate-delete-modal" data-route="{{ route('portal.meeting.hall.program.debate.destroy', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-record="{{ $debate->title }}">
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
                                <i class="fa-duotone fa-face-party"></i>
                            </div>
                            <p class="empty-state-text">{{ __('common.no-debates-found') }}</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="offcanvas" data-bs-target="#debate-create-modal" data-route="{{ route('portal.meeting.hall.program.debate.store', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id]) }}">
                        <i class="fa-solid fa-plus"></i> {{ __('common.add-new-debate') }}
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

    <!-- Debate Create Modal -->
    <div class="offcanvas offcanvas-end modern-offcanvas" tabindex="-1" id="debate-create-modal">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <i class="fa-duotone fa-plus me-2"></i>{{ __('common.add-new-debate') }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="debate-create-form" method="POST">
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
                        <i class="fa-regular fa-calendar-arrow-up me-2"></i>{{ __('common.voting-started-at') }}
                    </label>
                    <input type="datetime-local" name="voting_started_at" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-calendar-arrow-down me-2"></i>{{ __('common.voting-finished-at') }}
                    </label>
                    <input type="datetime-local" name="voting_finished_at" class="form-control">
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

    <!-- Debate Edit Modal -->
    <div class="offcanvas offcanvas-end modern-offcanvas" tabindex="-1" id="debate-edit-modal">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <i class="fa-duotone fa-pen-to-square me-2"></i>{{ __('common.edit-debate') }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="debate-edit-form" method="POST">
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
                        <i class="fa-regular fa-calendar-arrow-up me-2"></i>{{ __('common.voting-started-at') }}
                    </label>
                    <input type="datetime-local" name="voting_started_at" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-regular fa-calendar-arrow-down me-2"></i>{{ __('common.voting-finished-at') }}
                    </label>
                    <input type="datetime-local" name="voting_finished_at" class="form-control">
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

    <!-- Debate Delete Modal -->
    <div class="offcanvas offcanvas-end modern-offcanvas" tabindex="-1" id="debate-delete-modal">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <i class="fa-duotone fa-trash me-2"></i>{{ __('common.delete-debate') }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                {{ __('common.delete-confirmation') }}
            </div>
            <form id="debate-delete-form" method="POST">
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
@endsection
