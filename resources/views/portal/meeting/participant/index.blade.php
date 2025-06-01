@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.participants'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.participants') }}</li>
@endsection
@section('meeting_content')
    <!-- Modern Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-participants-hero-card">
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
            <div class="modern-participants-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-screen-users me-2"></i>
                        {{ __('common.participants') }}
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($participants->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-participants-table">
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
                                                <div class="participant-info">
                                                    <div class="activity-indicator">
                                                        @if($participant->activity_status)
                                                            <div class="status-dot status-active" title="{{ __('common.active') }}"></div>
                                                        @else
                                                            <div class="status-dot status-inactive" title="{{ __('common.passive') }}"></div>
                                                        @endif
                                                    </div>
                                                    <div class="participant-name">
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

    <style>
        /* Modern Participants Page Styles - Congress Theme */
        .modern-participants-hero-card {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-accent) 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(var(--kongre-primary-rgb), 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .modern-participants-hero-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .hero-content {
            display: flex;
            align-items: center;
            gap: 2rem;
            position: relative;
            z-index: 1;
        }

        .hero-icon {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-text {
            flex: 1;
            color: white;
        }

        .hero-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .btn-hero-create {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .btn-hero-create:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            color: white;
        }

        .modern-participants-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(var(--kongre-primary-rgb), 0.1);
            overflow: hidden;
        }

        .modern-participants-card .card-header {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-secondary) 100%);
            color: white;
            padding: 1.5rem 2rem;
            border: none;
        }

        .modern-participants-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .modern-participants-table thead th {
            background: var(--kongre-primary);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border: none;
            text-align: left;
        }

        .modern-participants-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }

        .modern-participants-table tbody tr:hover {
            background: rgba(var(--kongre-primary-rgb), 0.05);
        }

        .modern-participants-table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
        }

        .participant-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .activity-indicator {
            display: flex;
            align-items: center;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-dot.status-active {
            background: #28a745;
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
        }

        .status-dot.status-inactive {
            background: #dc3545;
            box-shadow: 0 0 10px rgba(220, 53, 69, 0.5);
        }

        .participant-name {
            font-weight: 500;
        }

        .id-badge {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-accent) 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            font-family: 'Monaco', monospace;
        }

        .email-link {
            color: var(--kongre-primary);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .email-link:hover {
            color: var(--kongre-accent);
            text-decoration: underline;
        }

        .phone-text {
            font-family: 'Monaco', monospace;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .status-badges {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .status-badge {
            padding: 0.2rem 0.6rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-inactive {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .modern-participants-card .card-footer {
            background: #f8f9fa;
            padding: 1.5rem 2rem;
            border: none;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: var(--kongre-primary);
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }

        .empty-state-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--kongre-primary);
        }

        .empty-state-text {
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .hero-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .hero-title {
                font-size: 1.5rem;
            }

            .hero-stats {
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn-hero-create {
                width: 100%;
            }

            .modern-participants-table thead th,
            .modern-participants-table tbody td {
                padding: 0.75rem 0.5rem;
                font-size: 0.8rem;
            }

            .btn-group .btn {
                padding: 0.25rem 0.4rem;
                font-size: 0.7rem;
            }

            .status-badges {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .participant-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>

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
