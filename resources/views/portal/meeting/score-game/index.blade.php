@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.score-games'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.score-games') }}</li>
@endsection

@push('styles')
    @vite(['resources/css/meeting-pages-theme.css'])
@endpush

@section('meeting_content')
    <!-- Modern Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-hundred-points fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.score-games') }}</h1>
                        <p class="hero-subtitle">{{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-hundred-points me-1"></i>
                                {{ $score_games->count() }} {{ __('common.score-games') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-qrcode me-1 text-success"></i>
                                {{ $score_games->sum(function($game) { return $game->qrCodes->count(); }) }} {{ __('common.qr-codes') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#score-game-create-modal" data-route="{{ route('portal.meeting.score-game.store', ['meeting' => $meeting->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-score-game') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Score Games Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-list me-2"></i>
                        {{ __('common.score-games') }}
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($score_games->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-image me-2"></i>
                                            {{ __('common.logo') }}
                                        </th>
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
                                            <i class="fa-regular fa-palette me-2"></i>
                                            {{ __('common.theme') }}
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
                                    @foreach($score_games as $score_game)
                                        <tr>
                                            <td>
                                                <div class="item-info">
                                                    @if($score_game->logo)
                                                        <img src="{{ $score_game->logo }}" alt="{{ $score_game->title }}" class="item-logo" />
                                                    @else
                                                        <div class="item-logo bg-light d-flex align-items-center justify-content-center">
                                                            <i class="fa-duotone fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="item-info">
                                                    <div class="item-title">
                                                        {{ $score_game->title }}
                                                        <small class="text-muted d-block">{{ $score_game->qrCodes->count() }} {{ __('common.qr-codes') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($score_game->start_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($score_game->start_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($score_game->finish_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($score_game->finish_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="theme-badge">{{ $score_game->theme }}</span>
                                            </td>
                                            <td>
                                                <span class="status-toggle {{ $score_game->status ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $score_game->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $score_game->status ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.actions') }}">
                                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('portal.meeting.score-game.show', ['meeting' => $meeting->id, 'score_game' => $score_game->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#score-game-edit-modal" data-route="{{ route('portal.meeting.score-game.update', ['meeting' => $meeting->id, 'score_game' => $score_game->id]) }}" data-resource="{{ route('portal.meeting.score-game.edit', ['meeting' => $meeting->id, 'score_game' => $score_game->id]) }}" data-id="{{ $score_game->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#score-game-delete-modal" data-route="{{ route('portal.meeting.score-game.destroy', ['meeting' => $meeting->id, 'score_game' => $score_game->id]) }}" data-record="{{ $score_game->title }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
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
                                <i class="fa-duotone fa-hundred-points"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-score-games-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-score-games-message') }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#score-game-create-modal" data-route="{{ route('portal.meeting.score-game.store', ['meeting' => $meeting->id]) }}">
                                <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-first-score-game') }}
                            </button>
                        </div>
                    @endif
                </div>
                @if($score_games->count() > 0 && $score_games->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                {{ __('common.total') }}: {{ $score_games->count() }} {{ __('common.score-games') }}
                            </span>
                            <div>
                                {{ $score_games->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- CRUD Modals -->
    <x-crud.form.common.create name="score-game" >
        @section('score-game-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.file method="c" name="logo" title="logo" icon="image" />
            <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.select method="c" name="theme" title="theme" :options="$themes" option_value="value" option_name="title" icon="image-landscape" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    
    <x-crud.form.common.delete name="score-game" />
    
    <x-crud.form.common.edit name="score-game" >
        @section('score-game-edit-form')
            <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.file method="e" name="logo" title="logo" icon="image" />
            <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.select method="e" name="theme" title="theme" :options="$themes" option_value="value" option_name="title" icon="image-landscape" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
