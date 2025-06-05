@extends('layout.portal.meeting-detail')
@section('title', $session->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $session->program->hall->meeting->id) }}" class="text-decoration-none">{{ $session->program->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $session->program->hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id]) }}" class="text-decoration-none">{{ $session->program->hall->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.program.index', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id]) }}" class="text-decoration-none">{{ __('common.programs') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.program.show', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id, 'program' => $session->program->id]) }}" class="text-decoration-none">{{ $session->program->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $session->title }}</li>
@endsection

@push('styles')
    @vite(['resources/css/meeting-pages-theme.css'])
@endpush

@section('meeting_content')
    <!-- Modern Hero Section for Session -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-presentation-screen fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $session->title }}</h1>
                        <p class="hero-subtitle">{{ __('common.session-details') }} - {{ $session->program->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-code me-1"></i>
                                {{ $session->code }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-tablet me-1"></i>
                                {{ $session->keypads->count() }} {{ __('common.keypads') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-{{ $session->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                {{ $session->status ? __('common.active') : __('common.inactive') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#keypad-create-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.store', ['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-keypad') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Details Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-info-circle me-2"></i>
                        {{ __('common.session-details') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">{{ __('common.title') }}</div>
                                <div class="detail-value">{{ $session->title }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">{{ __('common.code') }}</div>
                                <div class="detail-value">{{ $session->code }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">{{ __('common.program') }}</div>
                                <div class="detail-value">{{ $session->program->title }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">{{ __('common.status') }}</div>
                                <div class="detail-value">
                                    <span class="status-badge {{ $session->status ? 'status-active' : 'status-inactive' }}">
                                        <i class="fa-regular fa-{{ $session->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                        {{ $session->status ? __('common.active') : __('common.inactive') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="detail-label">{{ __('common.start-at') }}</div>
                                <div class="detail-value">
                                    @if($session->start_at)
                                        <i class="fa-regular fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($session->start_at)->format('d M Y, H:i') }}
                                    @else
                                        <span class="text-muted">{{ __('common.not-specified') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">{{ __('common.finish-at') }}</div>
                                <div class="detail-value">
                                    @if($session->finish_at)
                                        <i class="fa-regular fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($session->finish_at)->format('d M Y, H:i') }}
                                    @else
                                        <span class="text-muted">{{ __('common.not-specified') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">{{ __('common.created-by') }}</div>
                                <div class="detail-value">{{ $session->created_by_name }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">{{ __('common.created-at') }}</div>
                                <div class="detail-value">
                                    <i class="fa-regular fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($session->created_at)->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keypads Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-tablet me-2"></i>
                        {{ __('common.keypads') }}
                        <span class="count-badge ms-2">{{ $session->keypads->count() }}</span>
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($session->keypads->count() > 0)
                        <div class="keypads-container">
                            @foreach($session->keypads as $keypad)
                                <div class="keypad-item">
                                    <div class="keypad-header">
                                        <div class="keypad-info">
                                            <h5 class="keypad-title">{{ $keypad->title }}</h5>
                                            <div class="keypad-meta">
                                                <span class="theme-badge me-2">{{ $keypad->keypad }}</span>
                                                <span class="id-badge me-2">{{ __('common.sort') }}: {{ $keypad->sort_order }}</span>
                                                <span class="text-muted">
                                                    <i class="fa-regular fa-list me-1"></i>
                                                    {{ $keypad->options->count() }} {{ __('common.options') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="keypad-actions">
                                            <button type="button" class="btn btn-outline-success btn-sm me-1" data-bs-toggle="offcanvas" data-bs-target="#option-create-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.option.store',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}" title="{{ __('common.add-option') }}">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                            <a class="btn btn-outline-info btn-sm me-1" href="{{ route('portal.meeting.hall.program.session.keypad.show',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}" title="{{ __('common.show') }}">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <button class="btn btn-outline-warning btn-sm me-1" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#keypad-edit-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.update',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}" data-resource="{{ route('portal.meeting.hall.program.session.keypad.edit',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}" data-id="{{ $keypad->id }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#keypad-delete-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.destroy',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}" data-record="{{ $keypad->keypad }}">
                                                <i class="fa-regular fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    @if($keypad->options->count() > 0)
                                        <div class="options-container">
                                            <h6 class="options-title">
                                                <i class="fa-duotone fa-list me-2"></i>
                                                {{ __('common.options') }} ({{ $keypad->options->count() }})
                                            </h6>
                                            <div class="options-grid">
                                                @foreach($keypad->options as $option)
                                                    <div class="option-card">
                                                        <div class="option-content">
                                                            <div class="option-text">{{ $option->option }}</div>
                                                            <div class="option-meta">
                                                                <span class="text-muted">{{ __('common.sort') }}: {{ $option->sort_order }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="option-actions">
                                                            <button class="btn btn-outline-warning btn-sm me-1" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#option-edit-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.option.update',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id, 'option'=>$option->id]) }}" data-resource="{{ route('portal.meeting.hall.program.session.keypad.option.edit',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id, 'option'=>$option->id]) }}" data-id="{{ $option->id }}">
                                                                <i class="fa-regular fa-pen-to-square"></i>
                                                            </button>
                                                            <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#option-delete-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.option.destroy',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id, 'option'=>$option->id]) }}" data-record="{{ $option->option }}">
                                                                <i class="fa-regular fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="no-options-message">
                                            <i class="fa-duotone fa-list-ul text-muted me-2"></i>
                                            <span class="text-muted">{{ __('common.no-options-message') }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-tablet-screen-button"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-keypads-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-keypads-description') }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#keypad-create-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.store', ['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id]) }}">
                                <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-keypad') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- CRUD Modals -->
    <x-crud.form.common.create name="option">
        @section('option-create-form')
            <x-input.hidden method="c" name="keypad_id" :value="1"/>
            <x-input.text method="c" name="option" title="option" icon="list-dropdown"/>
            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort"/>
        @endsection
    </x-crud.form.common.create>
    
    <x-crud.form.common.delete name="option"/>
    
    <x-crud.form.common.edit name="option">
        @section('option-edit-form')
            <x-input.hidden method="e" name="keypad_id" :value="1"/>
            <x-input.text method="e" name="option" title="option" icon="list-dropdown"/>
            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort"/>
        @endsection
    </x-crud.form.common.edit>
    
    <x-crud.form.common.create name="keypad">
        @section('keypad-create-form')
            <x-input.hidden method="c" name="session_id" :value="$session->id"/>
            <x-input.text method="c" name="title" title="title" icon="input-text"/>
            <x-input.text method="c" name="keypad" title="keypad" icon="messages-question"/>
            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort"/>
        @endsection
    </x-crud.form.common.create>

    <x-crud.form.common.delete name="keypad"/>
    
    <x-crud.form.common.edit name="keypad">
        @section('keypad-edit-form')
            <x-input.hidden method="e" name="session_id" :value="$session->id"/>
            <x-input.text method="e" name="title" title="title" icon="input-text"/>
            <x-input.text method="e" name="keypad" title="keypad" icon="messages-question"/>
            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort"/>
        @endsection
    </x-crud.form.common.edit>
@endsection
