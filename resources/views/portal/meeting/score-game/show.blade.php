@extends('layout.portal.meeting-detail')
@section('title', $score_game->title . ' | ' . __('common.score-game'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.score-game.index', ['meeting' => $meeting->id]) }}" class="text-decoration-none">{{ __('common.score-games') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $score_game->title }}</li>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/meeting-pages-theme.css') }}">
@endpush

@section('meeting_content')
    <!-- Modern Hero Section for Score Game Detail -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        @if($score_game->logo)
                            <img src="{{ $score_game->logo }}" alt="{{ $score_game->title }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <i class="fa-duotone fa-hundred-points fa-fade"></i>
                        @endif
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $score_game->title }}</h1>
                        <p class="hero-subtitle">{{ __('common.score-game') }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-qrcode me-1"></i>
                                {{ $score_game->qrCodes->count() }} {{ __('common.qr-codes') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-hundred-points me-1"></i>
                                {{ $score_game->qrCodes->sum('point') }} {{ __('common.total-points') }}
                            </span>
                            <span class="badge-status {{ $score_game->status ? 'status-active' : 'status-inactive' }}">
                                <i class="fa-regular fa-{{ $score_game->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                {{ $score_game->status ? __('common.active') : __('common.inactive') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#qr-code-create-modal" data-route="{{ route('portal.meeting.score-game.qr-code.store', ['meeting' => $meeting->id, 'score_game' => $score_game->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.add-new-qr-code') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Score Game Details Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-info-circle me-2"></i>
                        {{ __('common.score-game-details') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">
                                    <i class="fa-regular fa-signature me-2"></i>{{ __('common.title') }}
                                </label>
                                <div class="detail-value">{{ $score_game->title }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">
                                    <i class="fa-regular fa-palette me-2"></i>{{ __('common.theme') }}
                                </label>
                                <div class="detail-value">
                                    <span class="theme-badge">{{ $score_game->theme }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">
                                    <i class="fa-regular fa-calendar-arrow-up me-2"></i>{{ __('common.start-at') }}
                                </label>
                                <div class="detail-value">
                                    @if($score_game->start_at)
                                        <span class="date-badge">
                                            <i class="fa-regular fa-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($score_game->start_at)->format('d.m.Y H:i') }}
                                        </span>
                                    @else
                                        <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">
                                    <i class="fa-regular fa-calendar-arrow-down me-2"></i>{{ __('common.finish-at') }}
                                </label>
                                <div class="detail-value">
                                    @if($score_game->finish_at)
                                        <span class="date-badge">
                                            <i class="fa-regular fa-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($score_game->finish_at)->format('d.m.Y H:i') }}
                                        </span>
                                    @else
                                        <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">
                                    <i class="fa-regular fa-user me-2"></i>{{ __('common.created-by') }}
                                </label>
                                <div class="detail-value">{{ $score_game->created_by_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">
                                    <i class="fa-regular fa-toggle-large-on me-2"></i>{{ __('common.status') }}
                                </label>
                                <div class="detail-value">
                                    <span class="status-badge {{ $score_game->status ? 'status-active' : 'status-inactive' }}">
                                        <i class="fa-regular fa-{{ $score_game->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                        {{ $score_game->status ? __('common.active') : __('common.inactive') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Codes Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-qrcode me-2"></i>
                        {{ __('common.qr-codes') }}
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($score_game->qrCodes->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-signature me-2"></i>
                                            {{ __('common.title') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-arrow-up me-2"></i>
                                            {{ __('common.start-at') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-arrow-down me-2"></i>
                                            {{ __('common.finish-at') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-hundred-points me-2"></i>
                                            {{ __('common.point') }}
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
                                    @foreach($score_game->qrCodes as $qr_code)
                                        <tr>
                                            <td>
                                                <div class="item-info">
                                                    <div class="item-title">{{ $qr_code->title }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($qr_code->start_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($qr_code->start_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($qr_code->finish_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($qr_code->finish_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="id-badge">
                                                    <i class="fa-regular fa-hundred-points me-1"></i>
                                                    {{ $qr_code->point }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $qr_code->status ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $qr_code->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $qr_code->status ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.actions') }}">
                                                    <button class="btn btn-outline-success btn-sm" title="{{ __('common.show-qr-code') }}" onclick="showQRCode({{ $qr_code->id }})" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show-qr-code') }}">
                                                        <i class="fa-regular fa-qrcode"></i>
                                                    </button>
                                                    <a class="btn btn-outline-info btn-sm" href="{{ route('portal.meeting.score-game.qr-code-download', ['meeting' => $meeting->id, 'score_game' => $score_game->id, 'qr_code' => $qr_code->id]) }}" title="{{ __('common.download') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.download') }}">
                                                        <i class="fa-regular fa-file-arrow-down"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#qr-code-edit-modal" data-route="{{ route('portal.meeting.score-game.qr-code.update', ['meeting' => $meeting->id, 'score_game' => $score_game->id, 'qr_code' =>$qr_code->id]) }}" data-resource="{{ route('portal.meeting.score-game.qr-code.edit', ['meeting' => $meeting->id, 'score_game' => $score_game->id, 'qr_code' =>$qr_code->id]) }}" data-id="{{ $qr_code->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#qr-code-delete-modal" data-route="{{ route('portal.meeting.score-game.qr-code.destroy', ['meeting' => $meeting->id, 'score_game' => $score_game->id, 'qr_code' =>$qr_code->id]) }}" data-record="{{ $qr_code->title }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
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
                                <i class="fa-duotone fa-qrcode"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-qr-codes-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-qr-codes-message') }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#qr-code-create-modal" data-route="{{ route('portal.meeting.score-game.qr-code.store', ['meeting' => $meeting->id, 'score_game' => $score_game->id]) }}">
                                <i class="fa-solid fa-plus me-2"></i>{{ __('common.add-first-qr-code') }}
                            </button>
                        </div>
                    @endif
                </div>
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
    <x-crud.form.common.create name="qr-code">
        @section('qr-code-create-form')
            <x-input.hidden method="c" name="score_game_id" :value="$score_game->id" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.number method="c" name="point" title="point" icon="hundred-points" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    
    <x-crud.form.common.delete name="qr-code" />
    
    <x-crud.form.common.edit name="qr-code">
        @section('qr-code-edit-form')
            <x-input.hidden method="e" name="score_game_id" :value="$score_game->id" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.number method="e" name="point" title="point" icon="hundred-points" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>

    <script>
        function showQRCode(qrCodeId) {
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
            fetch(`{{ route('portal.meeting.score-game.qr-code.qr-code', ['meeting' => $meeting->id, 'score_game' => $score_game->id, 'qr_code' => 'QR_CODE_ID']) }}`.replace('QR_CODE_ID', qrCodeId))
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
