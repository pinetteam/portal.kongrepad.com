@extends('layout.portal.meeting-detail')
@section('title', $meeting->title .' | ' . __('common.announcements'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.announcements') }}</li>
@endsection
@section('meeting_content')
    <!-- Modern Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-announcements-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-megaphone fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.announcements') }}</h1>
                        <p class="hero-subtitle">{{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-solid fa-bullhorn me-2"></i>
                                {{ $announcements->total() }} {{ __('common.total-announcements') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-primary" data-bs-toggle="offcanvas" data-bs-target="#announcement-create-modal" data-route="{{ route('portal.meeting.announcement.store', ['meeting' => $meeting->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-announcement') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Announcements Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-announcements-card">
                <div class="card-header">
                    <h3 class="mb-0">
                        <i class="fa-duotone fa-list me-2"></i>
                        {{ __('common.announcements-list') }}
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($announcements->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-announcements-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-input-text me-2"></i>
                                            {{ __('common.title') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-arrow-down me-2"></i>
                                            {{ __('common.publish-at') }}
                                        </th>
                                        <th class="text-center">
                                            <i class="fa-regular fa-toggle-large-on me-2"></i>
                                            {{ __('common.is-published') }}
                                        </th>
                                        <th class="text-center">
                                            <i class="fa-regular fa-toggle-large-on me-2"></i>
                                            {{ __('common.status') }}
                                        </th>
                                        <th class="text-center">{{ __('common.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($announcements as $announcement)
                                        <tr>
                                            <td>
                                                <div class="announcement-title">
                                                    <span class="title-text">{{ $announcement->title }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="date-badge">
                                                    <i class="fa-regular fa-calendar me-1"></i>
                                                    {{ $announcement->publish_at }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="status-toggle {{ $announcement->is_published ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $announcement->is_published ? 'toggle-on' : 'toggle-off' }}"></i>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="status-toggle {{ $announcement->status ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $announcement->status ? 'toggle-on' : 'toggle-off' }}"></i>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-buttons">
                                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('portal.meeting.announcement.show', ['meeting' => $announcement->meeting->id, 'announcement' => $announcement->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#announcement-edit-modal" data-route="{{ route('portal.meeting.announcement.update', ['meeting' => $announcement->meeting->id, 'announcement' => $announcement->id]) }}" data-resource="{{ route('portal.meeting.announcement.edit', ['meeting' => $announcement->meeting->id, 'announcement' => $announcement->id]) }}" data-id="{{ $announcement->id }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#announcement-delete-modal" data-route="{{ route('portal.meeting.announcement.destroy', ['meeting' => $announcement->meeting->id, 'announcement' => $announcement->id]) }}" data-record="{{ $announcement->title }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                        <i class="fa-regular fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($announcements->hasPages())
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    {{ $announcements->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fa-duotone fa-megaphone"></i>
                            </div>
                            <h4>{{ __('common.no-announcements-found') }}</h4>
                            <p>{{ __('common.no-announcements-message') }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#announcement-create-modal" data-route="{{ route('portal.meeting.announcement.store', ['meeting' => $meeting->id]) }}">
                                <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-first-announcement') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- CRUD Modals -->
    <x-crud.form.common.create name="announcement" >
        @section('announcement-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.datetime method="c" name="publish_at" title="publish-at" icon="calendar-arrow-down" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete name="announcement" />
    <x-crud.form.common.edit name="announcement" >
        @section('announcement-edit-form')
            <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.datetime method="e" name="publish_at" title="publish-at" icon="calendar-arrow-down" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>

    <style>
        /* Modern Announcements Page Styles - Congress Theme */
        .modern-announcements-hero-card {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-accent) 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(var(--kongre-primary-rgb), 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .modern-announcements-hero-card::before {
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

        .btn-hero-primary {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .btn-hero-primary:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            color: white;
        }

        .modern-announcements-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(var(--kongre-primary-rgb), 0.1);
            overflow: hidden;
        }

        .modern-announcements-card .card-header {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-secondary) 100%);
            color: white;
            padding: 1.5rem 2rem;
            border: none;
        }

        .modern-announcements-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .modern-announcements-table thead th {
            background: var(--kongre-primary);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border: none;
            text-align: left;
            font-size: 0.9rem;
        }

        .modern-announcements-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }

        .modern-announcements-table tbody tr:hover {
            background: rgba(var(--kongre-primary-rgb), 0.05);
        }

        .modern-announcements-table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
        }

        .announcement-title {
            display: flex;
            align-items: center;
        }

        .title-text {
            font-weight: 500;
            color: #333;
        }

        .date-badge {
            background: rgba(var(--kongre-primary-rgb), 0.1);
            color: var(--kongre-primary);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid rgba(var(--kongre-primary-rgb), 0.2);
        }

        .status-toggle {
            font-size: 1.2rem;
            padding: 0.25rem;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .status-toggle.status-active {
            color: #28a745;
        }

        .status-toggle.status-inactive {
            color: #dc3545;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .action-buttons .btn {
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .action-buttons .btn:hover {
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--kongre-primary);
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }

        .empty-state h4 {
            color: #333;
            margin-bottom: 1rem;
        }

        .empty-state p {
            margin-bottom: 2rem;
            font-size: 1rem;
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

            .btn-hero-primary {
                width: 100%;
            }

            .modern-announcements-table thead th,
            .modern-announcements-table tbody td {
                padding: 0.75rem 1rem;
                font-size: 0.8rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.25rem;
            }

            .action-buttons .btn {
                width: 100%;
            }

            .hero-stats {
                justify-content: center;
            }
        }
    </style>
@endsection
