@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.halls'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.halls') }}</li>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/meeting-pages-theme.css') }}">
@endpush

@section('meeting_content')
    <!-- Modern Hero Section for Halls -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-hotel fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.halls') }}</h1>
                        <p class="hero-subtitle">{{ __('common.manage-halls-subtitle') }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-hotel me-1"></i>
                                {{ $halls->total() }} {{ __('common.halls') }}
                            </span>
                            <span class="badge-status status-active">
                                <i class="fa-regular fa-toggle-on me-1"></i>
                                {{ $halls->where('status', true)->count() }} {{ __('common.active') }}
                            </span>
                            @if($halls->where('status', false)->count() > 0)
                                <span class="badge-status status-inactive">
                                    <i class="fa-regular fa-toggle-off me-1"></i>
                                    {{ $halls->where('status', false)->count() }} {{ __('common.inactive') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#hall-create-modal" data-route="{{ route('portal.meeting.hall.store', ['meeting' => $meeting->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-hall') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Halls Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-list me-2"></i>
                        {{ __('common.halls-list') }}
                        <span class="count-badge ms-2">{{ $halls->total() }}</span>
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($halls->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-signature me-2"></i>
                                            {{ __('common.title') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-check me-2"></i>
                                            {{ __('common.show-on-session') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-comment-question me-2"></i>
                                            {{ __('common.show-on-ask-question') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-days me-2"></i>
                                            {{ __('common.show-on-view-program') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-envelope me-2"></i>
                                            {{ __('common.show-on-send-mail') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-toggle-large-on me-2"></i>
                                            {{ __('common.status') }}
                                        </th>
                                        <th class="text-center">
                                            <i class="fa-regular fa-gear me-2"></i>
                                            {{ __('common.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($halls as $hall)
                                        <tr>
                                            <td>
                                                <div class="item-info">
                                                    <div class="item-title">{{ $hall->title }}</div>
                                                    <small class="text-muted">
                                                        <i class="fa-regular fa-code me-1"></i>
                                                        {{ $hall->code }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $hall->show_on_session ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $hall->show_on_session ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $hall->show_on_session ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $hall->show_on_ask_question ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $hall->show_on_ask_question ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $hall->show_on_ask_question ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $hall->show_on_view_program ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $hall->show_on_view_program ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $hall->show_on_view_program ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $hall->show_on_send_mail ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $hall->show_on_send_mail ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $hall->show_on_send_mail ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $hall->status ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $hall->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $hall->status ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.actions') }}">
                                                    <div class="btn-group me-2" role="group">
                                                        <a class="btn btn-outline-info btn-sm" href="{{ route('service.operator-board.start', ['code' => $hall->code, 'program_order' => 0]) }}" target="_blank" title="{{ __('common.operator-board') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.operator-board') }}">
                                                            <i class="fa-regular fa-rectangles-mixed"></i>
                                                        </a>
                                                        <a class="btn btn-outline-warning btn-sm" href="{{ route('service.screen-board.start', ['code' => $hall->code]) }}" target="_blank" title="{{ __('common.screen-board') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.screen-board') }}">
                                                            <i class="fa-regular fa-screen-users"></i>
                                                        </a>
                                                        <a class="btn btn-outline-success btn-sm" href="{{ route('service.question-board.start', ['code' => $hall->code]) }}" target="_blank" title="{{ __('common.question-board') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.question-board') }}">
                                                            <i class="fa-regular fa-question"></i>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group" role="group">
                                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('portal.meeting.hall.show', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                            <i class="fa-regular fa-eye"></i>
                                                        </a>
                                                        <button class="btn btn-outline-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#hall-edit-modal" data-route="{{ route('portal.meeting.hall.update', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" data-resource="{{ route('portal.meeting.hall.edit', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" data-id="{{ $hall->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#hall-delete-modal" data-route="{{ route('portal.meeting.hall.destroy', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" data-record="{{ $hall->title }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                            <i class="fa-regular fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($halls->hasPages())
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    {{ $halls->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-hotel"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-halls-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-halls-message') }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#hall-create-modal" data-route="{{ route('portal.meeting.hall.store', ['meeting' => $meeting->id]) }}">
                                <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-first-hall') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- CRUD Forms -->
    <x-crud.form.common.create name="hall">
        @section('hall-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="c" name="title" title="title" icon="signature" />
            <x-input.radio method="c" name="show_on_session" title="show-on-session" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            <x-input.radio method="c" name="show_on_ask_question" title="show-on-ask-question" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            <x-input.radio method="c" name="show_on_view_program" title="show-on-view-program" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            <x-input.radio method="c" name="show_on_send_mail" title="show-on-send-mail" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    
    <x-crud.form.common.edit name="hall">
        @section('hall-edit-form')
            <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="e" name="title" title="title" icon="signature" />
            <x-input.radio method="e" name="show_on_session" title="show-on-session" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            <x-input.radio method="e" name="show_on_ask_question" title="show-on-ask-question" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            <x-input.radio method="e" name="show_on_view_program" title="show-on-view-program" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            <x-input.radio method="e" name="show_on_send_mail" title="show-on-send-mail" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
    
    <x-crud.form.common.delete name="hall" />
@endsection
