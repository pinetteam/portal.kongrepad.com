@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' .  __('common.attendance-reports'))

@section('breadcrumb')
    <div class="breadcrumb-container px-0 py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}">{{ __('common.meetings') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}">{{ $meeting->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.attendance-reports') }}</li>
            </ol>
        </nav>
    </div>
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
                        <i class="fa-duotone fa-hundred-points fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.attendance-reports') }}</h1>
                        <p class="hero-subtitle">{{ __('common.attendance-reports-description') ?? 'Katılımcıların toplantıdaki katılım sürelerini ve puanlarını görüntüleyin.' }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-users me-1"></i>
                                {{ $participant_logs->total() }} {{ __('common.total-participants') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-clock me-1"></i>
                                {{ __('common.attendance-tracking') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Attendance Report Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-chart-line me-2"></i>
                        {{ __('common.attendance-details') }}
                    </h3>
                    <div class="header-actions">
                        <span class="badge bg-primary">
                            <i class="fa-regular fa-users me-1"></i>
                            {{ $participant_logs->total() }} {{ __('common.participants') }}
                        </span>
                    </div>
                </div>
                
                @if($participant_logs->count() > 0)
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-user me-2"></i>
                                            {{ __('common.participant') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-clock me-2"></i>
                                            {{ __('common.point-hours-minutes') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participant_logs as $participant_log)
                                        @php
                                            $time = \Carbon\Carbon::createFromTime(0, 0)->addMinutes(round($participant_log->total_actions*20/60));
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="item-name">{{ $participant_log->participant->full_name }}</div>
                                            </td>
                                            <td>
                                                <span class="time-badge">
                                                    <i class="fa-regular fa-clock me-1"></i>
                                                    {{ $time->format('H:i') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    @if($participant_logs->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $participant_logs->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-hundred-points"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-attendance-data') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-attendance-description') ?? 'Henüz katılım verisi bulunmuyor.' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
