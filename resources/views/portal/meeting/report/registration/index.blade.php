@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' .  __('common.registration-reports'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.registration-reports') }}</li>
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
                        <i class="fa-duotone fa-chart-user fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.registration-reports') }}</h1>
                        <p class="hero-subtitle">{{ __('common.registration-reports-description') ?? 'Toplantıya kayıt olan katılımcıların detaylı listesini görüntüleyin.' }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-users me-1"></i>
                                {{ $participants->total() }} {{ __('common.total-participants') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-user-check me-1"></i>
                                {{ $participants->where('enrolled', 1)->count() }} {{ __('common.enrolled') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Registration Report Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-user-group me-2"></i>
                        {{ __('common.registered-participants') }}
                    </h3>
                    <div class="header-actions">
                        <span class="badge bg-success">
                            <i class="fa-regular fa-user-check me-1"></i>
                            {{ $participants->where('enrolled', 1)->count() }} {{ __('common.enrolled') }}
                        </span>
                    </div>
                </div>
                
                @php
                    $enrolledParticipants = $participants->filter(function($participant) {
                        return $participant->enrolled == 1;
                    });
                @endphp
                
                @if($enrolledParticipants->count() > 0)
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-user me-2"></i>
                                            {{ __('common.name') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-check me-2"></i>
                                            {{ __('common.enrolled-at') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participants as $participant)
                                        @if($participant->enrolled == 1)
                                            <tr>
                                                <td>
                                                    <div class="item-name">{{ $participant->full_name }}</div>
                                                </td>
                                                <td>
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($participant->enrolled_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    @if($participants->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $participants->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-chart-user"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-registrations') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-registrations-description') ?? 'Henüz hiç katılımcı kaydı bulunmuyor.' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
