@extends('layout.portal.meeting-detail')
@section('title', $hall->title . ' | ' . __('common.programs'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $hall->meeting->id) }}" class="text-decoration-none">{{ $hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $hall->meeting->id, 'hall' => $hall->id]) }}" class="text-decoration-none">{{ $hall->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.programs') }}</li>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/meeting-pages-theme.css') }}">
@endpush

@section('meeting_content')
    <!-- Modern Hero Section for Programs -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-calendar-week fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.programs') }}</h1>
                        <p class="hero-subtitle">{{ __('common.programs-management-subtitle') }} - {{ $hall->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-calendar-week me-1"></i>
                                {{ $programs->count() }} {{ __('common.programs') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-hotel me-1"></i>
                                {{ $hall->title }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-calendar me-1"></i>
                                {{ now()->format('d.m.Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#program-create-modal" data-route="{{ route('portal.meeting.hall.program.store', ['meeting' => $hall->meeting_id, 'hall' => $hall->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-program') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Programs Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-list me-2"></i>
                        {{ __('common.programs-list') }}
                        <span class="count-badge ms-2">{{ $programs->count() }}</span>
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($programs->count() > 0)
                        <div class="programs-timeline">
                            @foreach($programs as $index => $program)
                                <div class="program-timeline-item">
                                    <!-- Program Header -->
                                    <div class="program-header">
                                        <div class="program-icon">
                                            @if($program->type == 'session')
                                                <i class="fa-duotone fa-presentation-screen"></i>
                                            @elseif($program->type == 'debate')
                                                <i class="fa-duotone fa-comments"></i>
                                            @else
                                                <i class="fa-duotone fa-calendar-day"></i>
                                            @endif
                                        </div>
                                        <div class="program-details">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <div class="flex-grow-1">
                                                    <h4 class="program-title">{{ $program->title }}</h4>
                                                    <div class="program-meta">
                                                        <span class="theme-badge me-2">{{ __('common.'.$program->type) }}</span>
                                                        <span class="id-badge me-2">{{ $program->code }}</span>
                                                        @if($program->sort_order)
                                                            <span class="text-muted me-3">
                                                                <i class="fa-regular fa-sort me-1"></i>{{ $program->sort_order }}
                                                            </span>
                                                        @endif
                                                        <span class="status-badge {{ $program->status ? 'status-active' : 'status-inactive' }}">
                                                            <i class="fa-regular fa-{{ $program->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                            {{ $program->status ? __('common.active') : __('common.inactive') }}
                                                        </span>
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
                                                        <button type="button" class="btn btn-outline-success btn-sm me-1" data-bs-toggle="offcanvas" data-bs-target="#session-create-modal" data-route="{{ route('portal.meeting.hall.program.session.store', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id]) }}" title="{{ __('common.add-session') }}">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    @elseif($program->type == "debate")
                                                        <button type="button" class="btn btn-outline-success btn-sm me-1" data-bs-toggle="offcanvas" data-bs-target="#debate-create-modal" data-route="{{ route('portal.meeting.hall.program.debate.store', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id]) }}" title="{{ __('common.add-debate') }}">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    @endif
                                                    <a class="btn btn-outline-info btn-sm me-1" href="{{ route('portal.meeting.hall.program.show', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'program' => $program->id]) }}" title="{{ __('common.show') }}">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning btn-sm me-1" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#program-edit-modal" data-route="{{ route('portal.meeting.hall.program.update', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'program' => $program->id]) }}" data-resource="{{ route('portal.meeting.hall.program.edit', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'program' => $program->id]) }}" data-id="{{ $program->id }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#program-delete-modal" data-route="{{ route('portal.meeting.hall.program.destroy', ['meeting' => $hall->meeting_id, 'hall' => $hall->id, 'program' => $program->id]) }}" data-record="{{ $program->title }}">
                                                        <i class="fa-regular fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sessions/Debates Content -->
                                    @if($program->sessions()->count() > 0 || $program->debates()->count() > 0)
                                        <div class="program-content">
                                            @if($program->sessions()->count() > 0)
                                                <div class="sessions-container mb-4">
                                                    <h6 class="content-section-title">
                                                        <i class="fa-duotone fa-presentation-screen me-2"></i>
                                                        {{ __('common.sessions') }} ({{ $program->sessions()->count() }})
                                                    </h6>
                                                    <div class="sessions-grid">
                                                        @foreach($program->sessions()->get() as $session)
                                                            <div class="session-card">
                                                                <div class="session-header">
                                                                    <h6 class="session-title">{{ $session->title }}</h6>
                                                                    <div class="session-actions">
                                                                        <a class="btn btn-outline-info btn-sm" href="{{ route('portal.meeting.hall.program.session.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id]) }}" title="{{ __('common.show') }}">
                                                                            <i class="fa-regular fa-eye"></i>
                                                                        </a>
                                                                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="offcanvas" data-bs-target="#session-edit-modal" data-route="{{ route('portal.meeting.hall.program.session.update', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id]) }}" data-resource="{{ route('portal.meeting.hall.program.session.edit', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id]) }}" data-id="{{ $session->id }}" title="{{ __('common.edit') }}">
                                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                                        </button>
                                                                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="offcanvas" data-bs-target="#session-delete-modal" data-route="{{ route('portal.meeting.hall.program.session.destroy', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id]) }}" data-record="{{ $session->title }}" title="{{ __('common.delete') }}">
                                                                            <i class="fa-regular fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="session-meta">
                                                                    @if($session->speaker)
                                                                        <div class="session-speaker">
                                                                            <i class="fa-regular fa-user me-1"></i>
                                                                            {{ $session->speaker->full_name }}
                                                                        </div>
                                                                    @endif
                                                                    @if($session->document_id)
                                                                        <div class="session-document">
                                                                            <a href="{{ route('portal.meeting.document.download', ['meeting' => $program->hall->meeting_id, 'document' => $session->document->file_name ] ) }}" class="document-link">
                                                                                <i class="fa-regular fa-file me-1"></i>{{ $session->document->title }}
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                    @if($session->start_at && $session->finish_at)
                                                                        <div class="session-time">
                                                                            <i class="fa-regular fa-clock me-1"></i>
                                                                            {{ \Carbon\Carbon::parse($session->start_at)->format('H:i') }} - 
                                                                            {{ \Carbon\Carbon::parse($session->finish_at)->format('H:i') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            @if($program->debates()->count() > 0)
                                                <div class="debates-container">
                                                    <h6 class="content-section-title">
                                                        <i class="fa-duotone fa-comments me-2"></i>
                                                        {{ __('common.debates') }} ({{ $program->debates()->count() }})
                                                    </h6>
                                                    <div class="debates-grid">
                                                        @foreach($program->debates()->get() as $debate)
                                                            <div class="debate-card">
                                                                <div class="debate-header">
                                                                    <h6 class="debate-title">{{ $debate->title }}</h6>
                                                                    <div class="debate-actions">
                                                                        <a class="btn btn-outline-info btn-sm" href="{{ route('portal.meeting.hall.program.debate.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" title="{{ __('common.show') }}">
                                                                            <i class="fa-regular fa-eye"></i>
                                                                        </a>
                                                                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="offcanvas" data-bs-target="#debate-edit-modal" data-route="{{ route('portal.meeting.hall.program.debate.update', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-resource="{{ route('portal.meeting.hall.program.debate.edit', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-id="{{ $debate->id }}" title="{{ __('common.edit') }}">
                                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                                        </button>
                                                                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="offcanvas" data-bs-target="#debate-delete-modal" data-route="{{ route('portal.meeting.hall.program.debate.destroy', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-record="{{ $debate->title }}" title="{{ __('common.delete') }}">
                                                                            <i class="fa-regular fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="debate-meta">
                                                                    @if($debate->description)
                                                                        <p class="debate-description">{{ $debate->description }}</p>
                                                                    @endif
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
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-calendar-xmark"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-programs-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-programs-message') }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#program-create-modal" data-route="{{ route('portal.meeting.hall.program.store', ['meeting' => $hall->meeting_id, 'hall' => $hall->id]) }}">
                                <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-first-program') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- CRUD Modals -->
    <x-crud.form.common.create name="program">
        @section('program-create-form')
            <x-input.hidden method="c" name="hall_id" :value="$hall->id"/>
            <x-input.text method="c" name="title" title="title" icon="input-text"/>
            <x-input.text method="c" name="code" title="code" icon="code"/>
            <div class="col form-group mb-3">
                <label for="c-type" class="form-label">
                    <i class="fa-regular fa-list-dropdown"></i> {{ __('common.type') }}
                </label>
                <select name="type" class="form-select" id="c-type">
                    <option selected value="">{{ __('common.choose') }}</option>
                    <option value="session">{{ __('common.session') }}</option>
                    <option value="debate">{{ __('common.debate') }}</option>
                </select>
            </div>
            <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar"/>
            <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar"/>
            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort"/>
            <div class="col form-group mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="status" class="form-check-input" id="c-status" value="1" checked>
                    <label class="form-check-label" for="c-status">
                        <i class="fa-regular fa-toggle-large-on me-1"></i>{{ __('common.status') }}
                    </label>
                </div>
            </div>
        @endsection
    </x-crud.form.common.create>

    <x-crud.form.common.delete name="program"/>

    <x-crud.form.common.edit name="program">
        @section('program-edit-form')
            <x-input.hidden method="e" name="hall_id" :value="$hall->id"/>
            <x-input.text method="e" name="title" title="title" icon="input-text"/>
            <x-input.text method="e" name="code" title="code" icon="code"/>
            <div class="col form-group mb-3">
                <label for="e-type" class="form-label">
                    <i class="fa-regular fa-list-dropdown"></i> {{ __('common.type') }}
                </label>
                <select name="type" class="form-select" id="e-type">
                    <option selected value="">{{ __('common.choose') }}</option>
                    <option value="session">{{ __('common.session') }}</option>
                    <option value="debate">{{ __('common.debate') }}</option>
                </select>
            </div>
            <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar"/>
            <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar"/>
            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort"/>
            <div class="col form-group mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="status" class="form-check-input" id="e-status" value="1">
                    <label class="form-check-label" for="e-status">
                        <i class="fa-regular fa-toggle-large-on me-1"></i>{{ __('common.status') }}
                    </label>
                </div>
            </div>
        @endsection
    </x-crud.form.common.edit>

    <!-- Session Modals -->
    <x-crud.form.common.create name="session">
        @section('session-create-form')
            <x-input.hidden method="c" name="program_id" :value="1"/>
            <x-input.text method="c" name="title" title="title" icon="input-text"/>
            <x-input.text method="c" name="code" title="code" icon="code"/>
            <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar"/>
            <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar"/>
            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort"/>
            <div class="col form-group mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="status" class="form-check-input" id="c-session-status" value="1" checked>
                    <label class="form-check-label" for="c-session-status">
                        <i class="fa-regular fa-toggle-large-on me-1"></i>{{ __('common.status') }}
                    </label>
                </div>
            </div>
        @endsection
    </x-crud.form.common.create>

    <x-crud.form.common.delete name="session"/>

    <x-crud.form.common.edit name="session">
        @section('session-edit-form')
            <x-input.hidden method="e" name="program_id" :value="1"/>
            <x-input.text method="e" name="title" title="title" icon="input-text"/>
            <x-input.text method="e" name="code" title="code" icon="code"/>
            <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar"/>
            <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar"/>
            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort"/>
            <div class="col form-group mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="status" class="form-check-input" id="e-session-status" value="1">
                    <label class="form-check-label" for="e-session-status">
                        <i class="fa-regular fa-toggle-large-on me-1"></i>{{ __('common.status') }}
                    </label>
                </div>
            </div>
        @endsection
    </x-crud.form.common.edit>

    <!-- Debate Modals -->
    <x-crud.form.common.create name="debate">
        @section('debate-create-form')
            <x-input.hidden method="c" name="program_id" :value="1"/>
            <x-input.text method="c" name="title" title="title" icon="input-text"/>
            <x-input.text method="c" name="description" title="description" icon="text"/>
            <x-input.datetime method="c" name="voting_started_at" title="voting-started-at" icon="calendar"/>
            <x-input.datetime method="c" name="voting_finished_at" title="voting-finished-at" icon="calendar"/>
            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort"/>
            <div class="col form-group mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="status" class="form-check-input" id="c-debate-status" value="1" checked>
                    <label class="form-check-label" for="c-debate-status">
                        <i class="fa-regular fa-toggle-large-on me-1"></i>{{ __('common.status') }}
                    </label>
                </div>
            </div>
        @endsection
    </x-crud.form.common.create>

    <x-crud.form.common.delete name="debate"/>

    <x-crud.form.common.edit name="debate">
        @section('debate-edit-form')
            <x-input.hidden method="e" name="program_id" :value="1"/>
            <x-input.text method="e" name="title" title="title" icon="input-text"/>
            <x-input.text method="e" name="description" title="description" icon="text"/>
            <x-input.datetime method="e" name="voting_started_at" title="voting-started-at" icon="calendar"/>
            <x-input.datetime method="e" name="voting_finished_at" title="voting-finished-at" icon="calendar"/>
            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort"/>
            <div class="col form-group mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="status" class="form-check-input" id="e-debate-status" value="1">
                    <label class="form-check-label" for="e-debate-status">
                        <i class="fa-regular fa-toggle-large-on me-1"></i>{{ __('common.status') }}
                    </label>
                </div>
            </div>
        @endsection
    </x-crud.form.common.edit>
@endsection
