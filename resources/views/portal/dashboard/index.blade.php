@extends('layout.portal.common')
@section('title', __('common.dashboard'))
@section('body')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="display-5 fw-bold text-center mb-4">
                    <i class="fa-duotone fa-gauge-high fa-fade me-2"></i> {{ __('common.dashboard') }}
                </h1>
            </div>
        </div>

        <!-- Create New Meeting CTA -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="create-meeting-cta">
                    <div class="cta-content">
                        <div class="cta-icon">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="cta-text">
                            <h3 class="cta-title">{{ __('common.create-new-meeting') }}</h3>
                            <p class="cta-subtitle">{{ __('common.start-organizing-subtitle') }}</p>
                        </div>
                        <div class="cta-action">
                            <a href="{{ route('portal.meeting.index') }}" class="btn btn-create-meeting">
                                <i class="fa-solid fa-rocket me-2"></i>{{ __('common.goto-meetings') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($meetings) && $meetings->count() > 0)
                    @foreach($meetings as $meeting)
                <div class="card bg-kongre-secondary shadow-sm mb-4">
                    <div class="card-header bg-kongre-primary d-flex justify-content-between align-items-center py-3">
                        <h3 class="m-0 text-white">
                            <i class="fa-duotone fa-calendar-star me-2"></i> {{ $meeting->title }}
                        </h3>
                        <a href="{{ route('portal.meeting.show', $meeting->id) }}" class="btn btn-kongre-accent btn-sm">
                            <i class="fa-regular fa-eye me-1"></i> {{ __('common.view_details') }}
                        </a>
                        </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Meeting Stats -->
                            <div class="col-lg-8">
                                <div class="row g-4">
                                    <!-- Documents -->
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ route('portal.meeting.document.index', $meeting->id) }}" class="text-decoration-none">
                                            <div class="stats-card h-100">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="stats-label">{{ __('common.documents') }}</span>
                                                    <i class="fa-duotone fa-folder-open fa-fade" style="color: var(--kongre-accent);"></i>
                                                            </div>
                                                <div class="stats-value">{{ isset($meeting->documents) ? $meeting->documents->count() : 0 }}</div>
                                                        </div>
                                        </a>
                                    </div>
                                    
                                    <!-- Participants -->
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ route('portal.meeting.participant.index', $meeting->id) }}" class="text-decoration-none">
                                            <div class="stats-card h-100">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="stats-label">{{ __('common.participants') }}</span>
                                                    <i class="fa-duotone fa-screen-users fa-fade" style="color: var(--kongre-accent);"></i>
                                                </div>
                                                <div class="stats-value">{{ isset($meeting->participants) ? $meeting->participants->count() : 0 }}</div>
                                            </div>
                                        </a>
                                    </div>
                                    
                                    <!-- Announcements -->
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ route('portal.meeting.announcement.index', $meeting->id) }}" class="text-decoration-none">
                                            <div class="stats-card h-100">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="stats-label">{{ __('common.announcements') }}</span>
                                                    <i class="fa-duotone fa-megaphone fa-fade" style="color: var(--kongre-accent);"></i>
                                                            </div>
                                                <div class="stats-value">{{ isset($meeting->announcements) ? $meeting->announcements->count() : 0 }}</div>
                                                        </div>
                                        </a>
                                    </div>
                                    
                                    <!-- Surveys -->
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ route('portal.meeting.survey.index', $meeting->id) }}" class="text-decoration-none">
                                            <div class="stats-card h-100">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="stats-label">{{ __('common.surveys') }}</span>
                                                    <i class="fa-duotone fa-square-poll-horizontal fa-fade" style="color: var(--kongre-accent);"></i>
                                                </div>
                                                <div class="stats-value">{{ isset($meeting->surveys) ? $meeting->surveys->count() : 0 }}</div>
                                            </div>
                                        </a>
                                                            </div>
                                    
                                    <!-- Score Games -->
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ route('portal.meeting.score-game.index', $meeting->id) }}" class="text-decoration-none">
                                            <div class="stats-card h-100">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="stats-label">{{ __('common.score-games') }}</span>
                                                    <i class="fa-duotone fa-hundred-points fa-fade" style="color: var(--kongre-accent);"></i>
                                                        </div>
                                                <div class="stats-value">{{ isset($meeting->scoreGames) ? $meeting->scoreGames->count() : 0 }}</div>
                                            </div>
                                        </a>
                                                            </div>
                                    
                                    <!-- Halls -->
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ route('portal.meeting.hall.index', $meeting->id) }}" class="text-decoration-none">
                                            <div class="stats-card h-100">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="stats-label">{{ __('common.halls') }}</span>
                                                    <i class="fa-duotone fa-hotel fa-fade" style="color: var(--kongre-accent);"></i>
                                                        </div>
                                                <div class="stats-value">{{ isset($meeting->halls) ? $meeting->halls->count() : 0 }}</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Halls Quick Access -->
                            <div class="col-lg-4">
                                <div class="card bg-kongre-primary h-100">
                                    <div class="card-header bg-kongre-dark">
                                        <h5 class="m-0 text-white">
                                            <i class="fa-duotone fa-hotel me-2"></i> {{ __('common.halls') }}
                                        </h5>
                                                            </div>
                                    <div class="card-body p-0">
                                        <div class="list-group list-group-flush">
                                            @if(isset($meeting->halls) && $meeting->halls->count() > 0)
                                                @foreach($meeting->halls as $hall)
                                                    <div class="list-group-item bg-kongre-primary border-kongre text-light">
                                                        <h6 class="mb-2">{{ $hall->title }}</h6>
                                                        <div class="btn-group btn-group-sm">
                                                            <a class="btn btn-kongre-accent" href="{{ route('service.operator-board.start', ['code' => $hall->code, 'program_order' => 0]) }}" title="{{ __('common.operator-board') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.operator-board') }}">
                                                                <i class="fa-regular fa-rectangles-mixed"></i>
                                                            </a>
                                                            <a class="btn btn-warning" href="{{ route('service.screen-board.start', ['code' => $hall->code]) }}" title="{{ __('common.screen-board') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.screen-board') }}">
                                                                <i class="fa-regular fa-screen-users"></i>
                                                            </a>
                                                            <a class="btn btn-success" href="{{ route('service.question-board.start', ['code' => $hall->code]) }}" title="{{ __('common.question-board') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.question-board') }}">
                                                                <i class="fa-regular fa-question"></i>
                                                            </a>
                                                            <a class="btn btn-kongre-accent" href="{{ route('portal.meeting.hall.screen.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" title="{{ __('common.screens') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.screens') }}">
                                                                <i class="fa-duotone fa-presentation-screen"></i>
                                                            </a>
                                                            <a class="btn btn-kongre-accent" href="{{ route('portal.meeting.hall.program.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" title="{{ __('common.programs') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.programs') }}">
                                                                <i class="fa-regular fa-calendar-week"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="list-group-item bg-kongre-primary text-light text-center">
                                                    {{ __('common.no_halls_found') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                             </div>
                    <div class="card-footer bg-kongre-primary">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fa-regular fa-calendar-days me-2 text-kongre-accent"></i>
                                    <span class="text-light">
                                        {{ __('common.created_at') }}: 
                                        {{ isset($meeting->created_at) ? $meeting->created_at->format('d.m.Y') : __('common.unspecified') }}
                                                  </span>
                                                 </div>
                                         </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('portal.meeting.show', $meeting->id) }}" class="btn btn-sm btn-kongre-accent">
                                    <i class="fa-solid fa-arrow-right me-1"></i> {{ __('common.manage_meeting') }}
                                </a>
                                     </div>
                                 </div>
                             </div>
                         </div>
                    @endforeach
        @else
            <div class="card bg-kongre-secondary">
                <div class="card-body text-center p-5">
                    <h3 class="text-light mb-4"><i class="fa-duotone fa-empty-set me-2"></i> {{ __('common.no_meetings_found') }}</h3>
                    <p class="text-light">{{ __('common.start_by_creating_a_meeting') }}</p>
                    <div class="mt-4">
                        <a href="{{ route('portal.meeting.index') }}" class="btn btn-kongre-accent btn-lg">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-meeting') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
    /* Create Meeting CTA Styles - Kongre Theme Compatible */
    .create-meeting-cta {
        background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-accent) 100%);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(var(--kongre-primary-rgb), 0.3);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .create-meeting-cta::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .cta-content {
        display: flex;
        align-items: center;
        gap: 2rem;
        position: relative;
        z-index: 1;
    }

    .cta-icon {
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

    .cta-text {
        flex: 1;
        color: white;
    }

    .cta-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: white;
    }

    .cta-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .btn-create-meeting {
        background: var(--kongre-accent);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: 0 8px 20px rgba(var(--kongre-accent-rgb), 0.4);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-decoration: none;
    }

    .btn-create-meeting::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-create-meeting:hover::before {
        left: 100%;
    }

    .btn-create-meeting:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(var(--kongre-accent-rgb), 0.5);
        background: var(--kongre-accent);
        color: white;
        text-decoration: none;
        border-color: rgba(255, 255, 255, 0.5);
    }

    .btn-create-meeting:active {
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .cta-content {
            flex-direction: column;
            text-align: center;
        }
        
        .cta-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
        
        .cta-title {
            font-size: 1.3rem;
        }
        
        .btn-create-meeting {
            width: 100%;
            margin-top: 1rem;
        }
    }

    /* Stats Card Improvements */
    .stats-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(var(--kongre-primary-rgb), 0.1);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(var(--kongre-primary-rgb), 0.15);
        border-color: var(--kongre-accent);
    }

    .stats-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }

    .stats-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--kongre-primary);
        margin-top: 0.5rem;
    }
    </style>
@endsection
