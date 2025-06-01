@extends('layout.portal.common')
@section('title', $meeting->title . ' | ' . __('common.participant-logs'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.participant.index', ['meeting' => $meeting->id]) }}" class="text-decoration-none">{{ __('common.participants') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $participant->full_name . ' | ' . __('common.participant-logs') }}</li>
@endsection

@section('body')
    <div class="container-fluid py-4">
        <!-- Modern Hero Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="modern-logs-hero-card">
                    <div class="hero-content">
                        <div class="hero-icon">
                            <i class="fa-duotone fa-chart-user fa-fade"></i>
                        </div>
                        <div class="hero-text">
                            <h1 class="hero-title">{{ __('common.participant-logs') }}</h1>
                            <p class="hero-subtitle">{{ $participant->full_name }} - {{ $meeting->title }}</p>
                            <div class="hero-stats">
                                <span class="stat-item">
                                    <i class="fa-regular fa-list-timeline me-1"></i>
                                    {{ $logs->count() }} {{ __('common.logs') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Logs Card -->
        <div class="row">
            <div class="col-12">
                <div class="modern-logs-card">
                    <div class="card-header">
                        <h3 class="mb-0">
                            <i class="fa-duotone fa-list-timeline me-2"></i>
                            {{ __('common.participant-logs') }}
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        @if($logs->count() > 0)
                            <div class="table-responsive">
                                <table class="modern-logs-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <i class="fa-regular fa-globe-pointer me-2"></i>
                                                {{ __('common.action') }}
                                            </th>
                                            <th>
                                                <i class="fa-regular fa-object-group me-2"></i>
                                                {{ __('common.object') }}
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
                                                    <span class="action-badge">
                                                        {{ $log->action }}
                                                    </span>
                                                </td>
                                                <td>{{ $log->object }}</td>
                                                <td>
                                                    <span class="time-text">
                                                        {{ $log->created_at }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fa-duotone fa-chart-user"></i>
                                </div>
                                <h4 class="empty-state-title">{{ __('common.no-logs-found') }}</h4>
                                <p class="empty-state-text">Bu katılımcı için henüz hiçbir log kaydı bulunamadı.</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                {{ __('common.total') }}: {{ $logs->count() }} {{ __('common.logs') }}
                            </span>
                            <a href="{{ route('portal.meeting.participant.index', $meeting->id) }}" class="btn btn-outline-primary">
                                <i class="fa-regular fa-arrow-left me-2"></i>
                                {{ __('common.participants') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Modern Logs Page Styles - Congress Theme */
        .modern-logs-hero-card {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-accent) 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(var(--kongre-primary-rgb), 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .modern-logs-hero-card::before {
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

        .modern-logs-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(var(--kongre-primary-rgb), 0.1);
            overflow: hidden;
        }

        .modern-logs-card .card-header {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-secondary) 100%);
            color: white;
            padding: 1.5rem 2rem;
            border: none;
        }

        .modern-logs-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .modern-logs-table thead th {
            background: var(--kongre-primary);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border: none;
            text-align: left;
        }

        .modern-logs-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }

        .modern-logs-table tbody tr:hover {
            background: rgba(var(--kongre-primary-rgb), 0.05);
        }

        .modern-logs-table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
        }

        .action-badge {
            background: linear-gradient(135deg, var(--kongre-accent) 0%, var(--kongre-primary) 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .time-text {
            color: #6c757d;
            font-family: 'Monaco', monospace;
            font-size: 0.9rem;
        }

        .modern-logs-card .card-footer {
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
            margin-bottom: 0;
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
            }

            .modern-logs-table thead th,
            .modern-logs-table tbody td {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
@endsection
