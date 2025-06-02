@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.participants'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.participants') }}</li>
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
                        <i class="fa-duotone fa-screen-users fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.participants') }}</h1>
                        <p class="hero-subtitle">{{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-users me-1"></i>
                                {{ $participants->total() }} {{ __('common.participants') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-circle-dot me-1 text-success"></i>
                                {{ $participants->where('activity_status', true)->count() }} {{ __('common.active') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#participant-create-modal" data-route="{{ route('portal.meeting.participant.store', ['meeting' => $meeting->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-participant') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Participants Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-screen-users me-2"></i>
                        {{ __('common.participants') }}
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($participants->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-id-card me-2"></i>
                                            {{ __('common.name') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-fingerprint me-2"></i>
                                            {{ __('common.identification-number') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-building-columns me-2"></i>
                                            {{ __('common.organisation') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-envelope me-2"></i>
                                            {{ __('common.email') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-mobile-screen me-2"></i>
                                            {{ __('common.phone') }}
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
                                    @foreach($participants as $participant)
                                        <tr>
                                            <td>
                                                <div class="item-info">
                                                    <div class="activity-indicator">
                                                        @if($participant->activity_status)
                                                            <div class="status-dot status-active" title="{{ __('common.active') }}"></div>
                                                        @else
                                                            <div class="status-dot status-inactive" title="{{ __('common.passive') }}"></div>
                                                        @endif
                                                    </div>
                                                    <div class="item-name">
                                                        {{ $participant->last_name }}, {{ $participant->first_name }}
                                                        <small class="text-muted d-block">{{ __('common.'.$participant->type) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="id-badge">{{ $participant->identification_number_show }}</span>
                                            </td>
                                            <td>{{ $participant->organisation_show }}</td>
                                            <td>
                                                <a href="mailto:{{ $participant->email }}" class="email-link">{{ $participant->email }}</a>
                                            </td>
                                            <td>
                                                <span class="phone-text">{{ $participant->full_phone }}</span>
                                            </td>
                                            <td>
                                                <div class="status-badges">
                                                    <span class="status-badge {{ $participant->enrolled ? 'status-active' : 'status-inactive' }}" title="{{ __('common.enrollment') }}">
                                                        <i class="fa-regular fa-{{ $participant->enrolled ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                        {{ $participant->enrolled ? __('common.enrolled') : __('common.not-enrolled') }}
                                                    </span>
                                                    <span class="status-badge {{ $participant->status ? 'status-active' : 'status-inactive' }}" title="{{ __('common.status') }}">
                                                        <i class="fa-regular fa-{{ $participant->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                        {{ $participant->status ? __('common.active') : __('common.passive') }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.actions') }}">
                                                    <button class="btn btn-outline-success btn-sm" title="{{ __('common.show-qr-code') }}" onclick="showQRCode({{ $participant->id }})" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show-qr-code') }}">
                                                        <i class="fa-regular fa-qrcode"></i>
                                                    </button>
                                                    <a class="btn btn-outline-info btn-sm" href="{{ route('portal.meeting.participant.send-code-by-email', ['meeting' => $meeting->id, 'participant' => $participant->id]) }}" title="{{ __('common.send-code-by-email') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.send-code-by-email') }}">
                                                        <i class="fa-regular fa-envelope"></i>
                                                    </a>
                                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('portal.meeting.participant.show', ['meeting' => $meeting->id, 'participant' => $participant->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('portal.meeting.log.participant.show', ['meeting' => $meeting->id, 'participant' => $participant->id]) }}" title="{{ __('common.logs') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.logs') }}">
                                                        <i class="fa-regular fa-chart-user"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#participant-edit-modal" data-route="{{ route('portal.meeting.participant.update', ['meeting' => $meeting->id, 'participant' => $participant->id]) }}" data-resource="{{ route('portal.meeting.participant.edit', ['meeting' => $meeting->id, 'participant' => $participant->id]) }}" data-id="{{ $participant->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#participant-delete-modal" data-route="{{ route('portal.meeting.participant.destroy', ['meeting' => $meeting, 'participant' => $participant->id]) }}" data-record="{{ $participant->full_name }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
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
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-screen-users"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-participants-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-participants-message') }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#participant-create-modal" data-route="{{ route('portal.meeting.participant.store', ['meeting' => $meeting->id]) }}">
                                <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-participant') }}
                            </button>
                        </div>
                    @endif
                </div>
                @if($participants->count() > 0)
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                {{ __('common.total') }}: {{ $participants->total() }} {{ __('common.participants') }}
                            </span>
                            <div>
                                {{ $participants->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">
                        <i class="fa-regular fa-qrcode me-2"></i>
                        {{ __('common.show-qr-code') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="qrCodeContent">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- CRUD Modals -->
    <x-crud.form.common.create name="participant" >
        @section('participant-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.text method="c" name="first_name" title="first-name" icon="id-card" />
            <x-input.text method="c" name="last_name" title="last-name" icon="id-card" />
            <x-input.text method="c" name="identification_number" title="identification-number" icon="fingerprint" />
            <x-input.text method="c" name="organisation" title="organisation" icon="building-columns" />
            <x-input.email method="c" name="email" title="email" icon="envelope" />
            <x-input.select method="c" name="phone_country_id" title="phone-country" :options="$phone_countries" option_value="id" option_name="NameAndCode" icon="flag" :searchable="true"/>
            <x-input.text method="c" name="phone" title="phone" icon="mobile-screen" />
            <x-input.text method="c" name="password" title="password" icon="lock" />
            <x-input.select method="c" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete name="participant" />
    <x-crud.form.common.edit name="participant" >
        @section('participant-edit-form')
            <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.text method="e" name="first_name" title="first-name" icon="id-card" />
            <x-input.text method="e" name="last_name" title="last-name" icon="id-card" />
            <x-input.text method="e" name="identification_number" title="identification-number" icon="fingerprint" />
            <x-input.text method="e" name="organisation" title="organisation" icon="building-columns" />
            <x-input.email method="e" name="email" title="email" icon="envelope" />
            <x-input.select method="e" name="phone_country_id" title="phone-country" :options="$phone_countries" option_value="id" option_name="NameAndCode" icon="flag" :searchable="true"/>
            <x-input.text method="e" name="phone" title="phone" icon="mobile-screen" />
            <x-input.text method="e" name="password" title="password" icon="lock" />
            <x-input.select method="e" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>

    <script>
        function showQRCode(participantId) {
            const modal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
            const content = document.getElementById('qrCodeContent');
            
            // Show loading spinner
            content.innerHTML = `
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            `;
            
            modal.show();
            
            // Fetch QR code
            fetch(`{{ route('portal.meeting.participant.qr-code', ['meeting' => $meeting->id, 'participant' => 'PARTICIPANT_ID']) }}`.replace('PARTICIPANT_ID', participantId))
                .then(response => response.text())
                .then(data => {
                    content.innerHTML = data;
                })
                .catch(error => {
                    content.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fa-regular fa-circle-exclamation me-2"></i>
                            QR kod yüklenirken bir hata oluştu.
                        </div>
                    `;
                });
        }
    </script>
@endsection
