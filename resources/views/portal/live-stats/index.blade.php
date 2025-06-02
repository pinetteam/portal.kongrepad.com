@extends('layout.portal.common')
@section('title', __('common.live-stats'))

@section('body')
<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}">{{ __('common.meetings') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('common.live-stats') }}</li>
        </ol>
    </nav>
</div>

@foreach($meetings as $meeting)
<!-- Ana Meeting Kartı -->
<div class="modern-main-card mb-4">
    <!-- Meeting Hero Header -->
    <div class="modern-hero-card-header">
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fa-duotone fa-screen-users fa-fade"></i>
            </div>
            <div class="hero-text">
                <h1 style="color: white; margin-bottom: 0.5rem; font-size: 2rem; font-weight: 700;">{{ $meeting->title }}</h1>
                <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1.1rem;">{{ __('common.live-stats') }} - {{ __('common.real-time-monitoring') }}</p>
            </div>
            <div class="hero-stats">
                <div class="badge-status">
                    <i class="fa-duotone fa-chart-line"></i>
                    {{ __('common.live') }}
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <!-- First Group: Enrollment Stats -->
            <div class="col-12 mb-4">
                <div class="stats-section">
                    <h5 class="stats-section-title">
                        <i class="fa-duotone fa-users-gear me-2"></i>{{ __('common.enrollment-statistics') }}
                    </h5>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-3">
                            <div class="modern-stats-card">
                                <div class="stats-icon bg-kongre-primary">
                                    <i class="fa-duotone fa-user-check"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-value">{{ $meeting->participants->where('enrolled', 1)->count() }} / {{ $meeting->participants->count() }}</div>
                                    <div class="stats-label">{{ __('common.enrolled-participants') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 mb-3">
                            <div class="modern-stats-card">
                                <div class="stats-icon bg-kongre-accent">
                                    <i class="fa-duotone fa-right-to-bracket"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-value">{{ $personal_access_tokens->count() }} / {{ $meeting->participants->count() }}</div>
                                    <div class="stats-label">{{ __('common.logged-in-participants') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Group: Activity Stats -->
            <div class="col-12 mb-4">
                <div class="stats-section">
                    <h5 class="stats-section-title">
                        <i class="fa-duotone fa-chart-line-up me-2"></i>{{ __('common.activity-statistics') }}
                    </h5>
                    <div class="row">
                        <div class="col-12">
                            <div class="modern-stats-card">
                                <div class="stats-icon bg-success">
                                    <i class="fa-duotone fa-wifi"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-value">{{ $meeting->participantLogs->where('created_at', '>=', \Carbon\Carbon::now()->subMinutes(15))->groupBy('participant_id')->count() }} / {{ $meeting->participants->count() }}</div>
                                    <div class="stats-label">{{ __('common.online-participants') }} <small class="text-muted">({{ __('common.last-15-minutes') }})</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Participants Table Section -->
        <div class="table-section">
            <h5 class="stats-section-title mb-3">
                <i class="fa-duotone fa-screen-users fa-fade me-2"></i>{{ __('common.logged-in-participants') }}
            </h5>
            <div class="modern-table-container">
                <table class="modern-table w-100">
                    <thead>
                        <tr>
                            <th><i class="fa-duotone fa-id-card me-2"></i>{{ __('common.name') }}</th>
                            <th><i class="fa-duotone fa-envelope me-2"></i>{{ __('common.email') }}</th>
                            <th><i class="fa-duotone fa-clock me-2"></i>{{ __('common.last-login') }}</th>
                            <th><i class="fa-duotone fa-user-tag me-2"></i>{{ __('common.type') }}</th>
                            <th><i class="fa-duotone fa-toggle-large-on me-2"></i>{{ __('common.status') }}</th>
                            <th class="text-end" style="width: 100px;">{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personal_access_tokens as $personal_access_token)
                        <tr>
                            <td>
                                <div class="fw-semibold text-kongre-primary">
                                    {{ $personal_access_token->participant->last_name }}, {{ $personal_access_token->participant->first_name }}
                                </div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $personal_access_token->participant->email }}</span>
                            </td>
                            <td>
                                <span class="badge bg-kongre-secondary text-white">
                                    @php
                                        $lastActivity = $personal_access_token->participant->last_user_activity;
                                        $activityText = __('common.never');
                                        
                                        if ($lastActivity && $lastActivity !== 'Henüz giriş yapılmadı!' && $lastActivity !== 'Never logged in') {
                                            try {
                                                $activityText = \Carbon\Carbon::parse($lastActivity)->diffForHumans();
                                            } catch (\Exception $e) {
                                                $activityText = $lastActivity;
                                            }
                                        }
                                    @endphp
                                    {{ $activityText }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info text-white">
                                    {{ __('common.'.$personal_access_token->participant->type) }}
                                </span>
                            </td>
                            <td>
                                @if($personal_access_token->participant->status)
                                    <span class="badge bg-success">
                                        <i class="fa-duotone fa-check me-1"></i>{{ __('common.active') }}
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fa-duotone fa-xmark me-1"></i>{{ __('common.inactive') }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a class="btn btn-info btn-sm" 
                                   href="{{ route('portal.meeting.participant.show', ['meeting' => $meeting->id, 'participant' => $personal_access_token->participant->id]) }}" 
                                   title="{{ __('common.show') }}"
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="top" 
                                   data-bs-title="{{ __('common.show') }}">
                                    <i class="fa-duotone fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fa-duotone fa-users-slash"></i>
                                    </div>
                                    <h5 class="text-muted">{{ __('common.no-logged-in-participants') }}</h5>
                                    <p class="text-muted">{{ __('common.no-participants-currently-logged-in') }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach

@if(!count($meetings))
<div class="empty-state-card">
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fa-duotone fa-calendar-xmark"></i>
        </div>
        <h4>{{ __('common.no-meetings-found') }}</h4>
        <p class="text-muted">{{ __('common.no-meetings-available-for-stats') }}</p>
        <a href="{{ route('portal.meeting.index') }}" class="btn btn-kongre-accent">
            <i class="fa-duotone fa-plus me-2"></i>{{ __('common.create-meeting') }}
        </a>
    </div>
</div>
@endif

<style>
.modern-hero-card-header {
    background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-secondary) 100%);
    border-radius: 12px 12px 0 0;
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.modern-hero-card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 40%, rgba(255,255,255,0.1) 0%, transparent 50%);
    pointer-events: none;
}

.hero-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    position: relative;
    z-index: 1;
}

.hero-icon {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    flex-shrink: 0;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
}

.hero-text {
    flex: 1;
}

.badge-status {
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.875rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.stats-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
}

.stats-section-title {
    color: var(--kongre-primary);
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.table-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
}

.modern-stats-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    height: 100%;
}

.modern-stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.stats-content {
    flex: 1;
}

.stats-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--kongre-primary);
    line-height: 1.2;
    margin-bottom: 0.25rem;
}

.stats-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

.empty-state-card {
    background: white;
    border-radius: 12px;
    padding: 3rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
    text-align: center;
}

.empty-state {
    text-align: center;
    padding: 2rem;
}

.empty-state-icon {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1.5rem;
}

.bg-kongre-primary {
    background-color: var(--kongre-primary) !important;
}

.bg-kongre-accent {
    background-color: var(--kongre-accent) !important;
}

@media (max-width: 768px) {
    .hero-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .hero-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .modern-stats-card {
        padding: 1rem;
    }
    
    .stats-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    
    .stats-value {
        font-size: 1.5rem;
    }
    
    .modern-hero-card-header {
        padding: 1.5rem;
    }
    
    .stats-section,
    .table-section {
        padding: 1rem;
    }
}
</style>
@endsection
