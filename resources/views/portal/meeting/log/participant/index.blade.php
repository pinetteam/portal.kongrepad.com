@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.participant-logs'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.participant-logs') }}</li>
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
                        <h1 class="hero-title">{{ __('common.participant-logs') }}</h1>
                        <p class="hero-subtitle">{{ __('common.participant-logs-description') ?? 'Katılımcıların toplantıdaki aktivitelerini ve hareketlerini izleyin.' }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-list me-1"></i>
                                {{ $logs->total() }} {{ __('common.total-logs') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-clock me-1"></i>
                                {{ __('common.real-time-tracking') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Participant Logs Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-list-timeline me-2"></i>
                        {{ __('common.activity-logs') }}
                    </h3>
                    <div class="header-actions">
                        <span class="badge bg-info">
                            <i class="fa-regular fa-list me-1"></i>
                            {{ $logs->total() }} {{ __('common.entries') }}
                        </span>
                    </div>
                </div>
                
                @if($logs->count() > 0)
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
                                            <i class="fa-regular fa-bolt me-2"></i>
                                            {{ __('common.action') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-clock me-2"></i>
                                            {{ __('common.time') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>
                                                <div class="item-name">{{ $log->participant->full_name }}</div>
                                            </td>
                                            <td>
                                                <span class="action-badge">
                                                    <i class="fa-regular fa-bolt me-1"></i>
                                                    {{ __('common.'.$log->action) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="date-badge">
                                                    <i class="fa-regular fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($log->created_at)->format('d.m.Y H:i:s') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    @if($logs->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $logs->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-screen-users"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-logs-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-logs-description') ?? 'Henüz hiç aktivite kaydı bulunmuyor.' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
