@extends('layout.portal.meeting-detail')
@section('title', $announcement->title . ' | ' . __('common.announcement'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.announcement.index', ['meeting' => $meeting->id]) }}" class="text-decoration-none">{{ __('common.announcements') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $announcement->title }}</li>
@endsection
@section('meeting_content')
    <!-- Modern Announcement Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-announcement-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-megaphone fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $announcement->title }}</h1>
                        <p class="hero-subtitle">{{ $meeting->title }}</p>
                        <div class="hero-status">
                            <span class="status-badge {{ $announcement->status ? 'status-active' : 'status-inactive' }}">
                                <i class="fa-regular fa-{{ $announcement->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                {{ $announcement->status ? __('common.active') : __('common.passive') }}
                            </span>
                            <span class="status-badge {{ $announcement->is_published ? 'status-published' : 'status-unpublished' }}">
                                <i class="fa-regular fa-{{ $announcement->is_published ? 'eye' : 'eye-slash' }} me-1"></i>
                                {{ $announcement->is_published ? __('common.published') : __('common.unpublished') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <a href="{{ route('portal.meeting.announcement.index', ['meeting' => $meeting->id]) }}" class="btn btn-hero-back">
                            <i class="fa-solid fa-arrow-left me-2"></i>{{ __('common.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcement Details Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-announcement-details-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-circle-info me-2"></i>
                        {{ __('common.announcement-details') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.meeting') }}:</span>
                                <span class="detail-value">{{ $meeting->title }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.title') }}:</span>
                                <span class="detail-value">{{ $announcement->title }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.status') }}:</span>
                                <span class="detail-value">
                                    <span class="status-badge {{ $announcement->status ? 'status-active' : 'status-inactive' }}">
                                        <i class="fa-regular fa-{{ $announcement->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                        {{ $announcement->status ? __('common.active') : __('common.passive') }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.created-by') }}:</span>
                                <span class="detail-value">{{ $announcement->created_by_name }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.created-at') }}:</span>
                                <span class="detail-value">{{ $announcement->created_at }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">{{ __('common.publish-at') }}:</span>
                                <span class="detail-value">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="status-badge {{ $announcement->is_published ? 'status-published' : 'status-unpublished' }}">
                                            <i class="fa-regular fa-{{ $announcement->is_published ? 'eye' : 'eye-slash' }} me-1"></i>
                                            {{ $announcement->is_published ? __('common.published') : __('common.unpublished') }}
                                        </span>
                                        <span class="text-muted">{{ $announcement->publish_at }}</span>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Modern Announcement Show Page Styles - Congress Theme */
        .modern-announcement-hero-card {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-accent) 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(var(--kongre-primary-rgb), 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .modern-announcement-hero-card::before {
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

        .hero-status {
            display: flex;
            gap: 1rem;
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

        .modern-announcement-details-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(var(--kongre-primary-rgb), 0.1);
            overflow: hidden;
        }

        .modern-announcement-details-card .card-header {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-secondary) 100%);
            color: white;
            padding: 1.5rem 2rem;
            border: none;
        }

        .card-header-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .modern-announcement-details-card .card-body {
            padding: 2rem;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            margin: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
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
            flex: 0 0 40%;
            min-width: 120px;
        }

        .detail-value {
            flex: 1;
            text-align: right;
            word-break: break-word;
        }

        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            white-space: nowrap;
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

        .status-published {
            background: rgba(0, 123, 255, 0.1);
            color: #007bff;
            border: 1px solid rgba(0, 123, 255, 0.2);
        }

        .status-unpublished {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.2);
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

            .hero-status {
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .btn-hero-back {
                width: 100%;
            }

            .detail-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
                text-align: left;
            }

            .detail-label {
                flex: none;
                font-size: 0.9rem;
            }

            .detail-value {
                text-align: left;
                width: 100%;
            }

            .modern-announcement-details-card .card-body {
                padding: 1.5rem;
            }
        }
    </style>
@endsection
