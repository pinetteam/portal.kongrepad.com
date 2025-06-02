@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . $participant->full_name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.participant.index', $meeting->id) }}" class="text-decoration-none">{{ __('common.participants') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $participant->full_name }}</li>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/meeting-pages-theme.css') }}">
@endpush

@section('meeting_content')
    <!-- Modern Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-participant-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-id-card fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $participant->full_name }}</h1>
                        <p class="hero-subtitle">{{ __('common.participant') }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                @if($participant->activity_status)
                                    <div class="status-dot status-active me-2"></div>
                                    {{ __('common.active') }}
                                @else
                                    <div class="status-dot status-inactive me-2"></div>
                                    {{ __('common.passive') }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <a href="{{ route('portal.meeting.participant.index', $meeting->id) }}" class="btn btn-hero-back">
                            <i class="fa-solid fa-arrow-left me-2"></i>{{ __('common.participants') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Participant Details Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-participant-details-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-user-circle me-2"></i>
                        {{ __('common.participant-details') }}
                    </h3>
                </div>
                <div class="card-body px-4 py-4">
                    <div class="row">
                        <div class="col-md-6 px-3">
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.title') }}:</span>
                                <span class="detail-value">{{ $participant->title ?? '-' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.identification-number') }}:</span>
                                <span class="detail-value">{{ $participant->identification_number_show }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.organisation') }}:</span>
                                <span class="detail-value">{{ $participant->organisation_show }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.phone') }}:</span>
                                <span class="detail-value">{{ $participant->full_phone }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 px-3">
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.meeting') }}:</span>
                                <span class="detail-value">{{ $participant->meeting->title }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.email') }}:</span>
                                <span class="detail-value">
                                    <a href="mailto:{{ $participant->email }}" class="email-link">{{ $participant->email }}</a>
                                </span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.status') }}:</span>
                                <span class="detail-value">
                                    <span class="status-badge {{ $participant->status ? 'status-active' : 'status-inactive' }}">
                                        <i class="fa-regular fa-{{ $participant->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                        {{ $participant->status ? __('common.active') : __('common.passive') }}
                                    </span>
                                </span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.created-at') }}:</span>
                                <span class="detail-value">{{ $participant->created_at }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Cards Grid -->
    <div class="row g-4">
        <!-- Surveys Card -->
        <div class="col-lg-6">
            <div class="modern-activity-card">
                <div class="card-header">
                    <h4 class="card-header-title">
                        <i class="fa-duotone fa-clipboard-question me-2"></i>
                        {{ __('common.surveys') }}
                    </h4>
                </div>
                <div class="card-body p-0">
                    @if($survey_votes->count() > 0)
                        <div class="table-responsive">
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.date') }}</th>
                                        <th>{{ __('common.title') }}</th>
                                        <th class="text-center">{{ __('common.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($survey_votes as $vote)
                                        <tr>
                                            <td>{{ is_string($vote->created_at) ? $vote->created_at : $vote->created_at->format('d.m.Y H:i') }}</td>
                                            <td>{{ $vote->survey->title }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-outline-primary btn-sm" href="{{ route('portal.meeting.participant.survey',['meeting'=> $participant->meeting->id, 'participant' => $participant->id, 'survey' => $vote->survey->id]) }}">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-activity">
                            <i class="fa-duotone fa-clipboard-question"></i>
                            <p>{{ __('common.no-surveys-found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Debates Card -->
        <div class="col-lg-6">
            <div class="modern-activity-card">
                <div class="card-header">
                    <h4 class="card-header-title">
                        <i class="fa-duotone fa-comments me-2"></i>
                        {{ __('common.debates') }}
                    </h4>
                </div>
                <div class="card-body p-0">
                    @if($debate_votes->count() > 0)
                        <div class="table-responsive">
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.date') }}</th>
                                        <th>{{ __('common.debate') }}</th>
                                        <th>{{ __('common.team') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($debate_votes as $vote)
                                        <tr>
                                            <td>{{ is_string($vote->created_at) ? $vote->created_at : $vote->created_at->format('d.m.Y H:i') }}</td>
                                            <td>{{ $vote->debate->title }}</td>
                                            <td>{{ $vote->team->title }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-activity">
                            <i class="fa-duotone fa-comments"></i>
                            <p>{{ __('common.no-debates-found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Keypads Card -->
        <div class="col-lg-6">
            <div class="modern-activity-card">
                <div class="card-header">
                    <h4 class="card-header-title">
                        <i class="fa-duotone fa-keyboard me-2"></i>
                        {{ __('common.keypads') }}
                    </h4>
                </div>
                <div class="card-body p-0">
                    @if($keypad_votes->count() > 0)
                        <div class="table-responsive">
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.date') }}</th>
                                        <th>{{ __('common.keypad') }}</th>
                                        <th>{{ __('common.option') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($keypad_votes as $vote)
                                        <tr>
                                            <td>{{ is_string($vote->created_at) ? $vote->created_at : $vote->created_at->format('d.m.Y H:i') }}</td>
                                            <td>{{ $vote->keypad->keypad }}</td>
                                            <td>{{ $vote->option->option }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-activity">
                            <i class="fa-duotone fa-keyboard"></i>
                            <p>{{ __('common.no-keypads-found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Requested Documents Card -->
        <div class="col-lg-6">
            <div class="modern-activity-card">
                <div class="card-header">
                    <h4 class="card-header-title">
                        <i class="fa-duotone fa-folder-arrow-down me-2"></i>
                        {{ __('common.requested-documents') }}
                    </h4>
                </div>
                <div class="card-body p-0">
                    @if($requested_documents->count() > 0)
                        <div class="table-responsive">
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.date') }}</th>
                                        <th>{{ __('common.document') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requested_documents as $request)
                                        <tr>
                                            <td>{{ is_string($request->created_at) ? $request->created_at : $request->created_at->format('d.m.Y H:i') }}</td>
                                            <td>{{ $request->document->file_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-activity">
                            <i class="fa-duotone fa-folder-arrow-down"></i>
                            <p>{{ __('common.no-documents-found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Score Game Points Card -->
        <div class="col-lg-6">
            <div class="modern-activity-card">
                <div class="card-header">
                    <h4 class="card-header-title">
                        <i class="fa-duotone fa-trophy me-2"></i>
                        {{ __('common.score-game-points') }}
                    </h4>
                </div>
                <div class="card-body p-0">
                    @if($score_game_points->count() > 0)
                        <div class="table-responsive">
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.date') }}</th>
                                        <th>{{ __('common.qr-code') }}</th>
                                        <th>{{ __('common.point') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($score_game_points as $score_game_point)
                                        <tr>
                                            <td>{{ is_string($score_game_point->created_at) ? $score_game_point->created_at : $score_game_point->created_at->format('d.m.Y H:i') }}</td>
                                            <td>{{ $score_game_point->qrCode->title }}</td>
                                            <td>
                                                <span class="point-badge">{{ $score_game_point->point }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-activity">
                            <i class="fa-duotone fa-trophy"></i>
                            <p>{{ __('common.no-points-found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Participant Logs Card -->
        <div class="col-lg-6">
            <div class="modern-activity-card">
                <div class="card-header">
                    <h4 class="card-header-title">
                        <i class="fa-duotone fa-chart-user me-2"></i>
                        {{ __('common.participant-logs') }}
                    </h4>
                </div>
                <div class="card-body p-0">
                    @if($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="activity-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.action') }}</th>
                                        <th>{{ __('common.time') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs->take(10) as $log)
                                        <tr>
                                            <td>
                                                <span class="action-badge">{{ $log->action }}</span>
                                            </td>
                                            <td>{{ is_string($log->created_at) ? $log->created_at : $log->created_at->format('d.m.Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($logs->count() > 10)
                            <div class="card-footer">
                                <a href="{{ route('portal.meeting.log.participant.show', ['meeting' => $meeting->id, 'participant' => $participant->id]) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fa-regular fa-arrow-right me-2"></i>{{ __('common.view-all') }}
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="empty-activity">
                            <i class="fa-duotone fa-chart-user"></i>
                            <p>{{ __('common.no-logs-found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Modern Participant Show Page Styles - Congress Theme */
        .modern-participant-hero-card {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-accent) 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(var(--kongre-primary-rgb), 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .modern-participant-hero-card::before {
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

        .btn-hero-back {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-hero-back:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            color: white;
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

        .modern-participant-details-card,
        .modern-activity-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(var(--kongre-primary-rgb), 0.1);
            overflow: hidden;
        }

        .modern-participant-details-card .card-header,
        .modern-activity-card .card-header {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-secondary) 100%);
            color: white;
            padding: 1.5rem 2rem;
            border: none;
        }

        .card-header-title {
            margin: 0;
            color: white !important;
            font-weight: 600;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 1rem 1.5rem;
            margin: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
            flex-wrap: wrap;
            gap: 0.5rem;
            background: rgba(var(--kongre-primary-rgb), 0.02);
            border-radius: 8px;
            border-left: 3px solid var(--kongre-primary);
        }

        .detail-item:last-child {
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
            flex: 0 0 45%;
            min-width: 140px;
            padding-right: 1rem;
        }

        .detail-value {
            flex: 1;
            text-align: right;
            word-break: break-word;
            padding-left: 1rem;
        }

        .email-link {
            color: var(--kongre-primary);
            text-decoration: none;
        }

        .email-link:hover {
            color: var(--kongre-accent);
            text-decoration: underline;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
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

        .activity-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .activity-table thead th {
            background: var(--kongre-primary);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border: none;
            text-align: left;
            font-size: 0.9rem;
        }

        .activity-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }

        .activity-table tbody tr:hover {
            background: rgba(var(--kongre-primary-rgb), 0.05);
        }

        .activity-table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .action-badge {
            background: linear-gradient(135deg, var(--kongre-accent) 0%, var(--kongre-primary) 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .point-badge {
            background: linear-gradient(135deg, #ffd700 0%, #ffa500 100%);
            color: #333;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .empty-activity {
            text-align: center;
            padding: 3rem 2rem;
            color: #6c757d;
        }

        .empty-activity i {
            font-size: 3rem;
            color: var(--kongre-primary);
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .empty-activity p {
            margin: 0;
            font-size: 0.95rem;
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

            .btn-hero-back {
                width: 100%;
            }

            .detail-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .detail-label {
                flex: none;
            }

            .detail-value {
                text-align: left;
            }

            .activity-table thead th,
            .activity-table tbody td {
                padding: 0.75rem 1rem;
                font-size: 0.8rem;
            }
        }
    </style>
@endsection
