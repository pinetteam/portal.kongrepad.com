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
                </div>
            </div>
        @endif
    </div>
@endsection
