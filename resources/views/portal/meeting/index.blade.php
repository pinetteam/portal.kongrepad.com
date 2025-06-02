@extends('layout.portal.common')
@section('title', __('common.meetings'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.meetings') }}</li>
@endsection

@section('body')
    <!-- Breadcrumb Navigation -->
    <div class="breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('common.meetings') }}</li>
            </ol>
        </nav>
    </div>

    <!-- Meetings Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="meetings-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <div class="hero-details">
                        <h1 class="hero-title">{{ __('common.meetings') }}</h1>
                        <p class="hero-subtitle">Manage all your congress meetings and events</p>
                        <div class="hero-meta">
                            <span class="meta-item">
                                <i class="fa-solid fa-chart-bar me-1"></i>
                                {{ $meetings->total() }} {{ __('common.total') }} {{ __('common.meetings') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#meeting-create-modal" data-route="{{ route('portal.meeting.store') }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-meeting') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Meetings Content -->
    <div class="row">
        <div class="col-12">
            @if($meetings->count() > 0)
                <div class="card modern-meetings-card">
                    <div class="card-header modern-header">
                        <h5 class="card-title mb-0">
                            <i class="fa-solid fa-list me-2"></i>{{ __('common.meetings') }} {{ __('common.list') }}
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover modern-meetings-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <i class="fa-solid fa-code me-1"></i>{{ __('common.code') }}
                                        </th>
                                        <th scope="col">
                                            <i class="fa-solid fa-heading me-1"></i>{{ __('common.title') }}
                                        </th>
                                        <th scope="col">
                                            <i class="fa-solid fa-tag me-1"></i>{{ __('common.type') }}
                                        </th>
                                        <th scope="col">
                                            <i class="fa-solid fa-play me-1"></i>{{ __('common.start-at') }}
                                        </th>
                                        <th scope="col">
                                            <i class="fa-solid fa-stop me-1"></i>{{ __('common.finish-at') }}
                                        </th>
                                        <th scope="col">
                                            <i class="fa-solid fa-toggle-on me-1"></i>{{ __('common.status') }}
                                        </th>
                                        <th scope="col" class="text-end">{{ __('common.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($meetings as $meeting)
                                        <tr>
                                            <td>
                                                <span class="code-badge">{{ $meeting->code }}</span>
                                            </td>
                                            <td class="fw-bold">{{ $meeting->title }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ __('common.' . $meeting->type) }}</span>
                                            </td>
                                            <td>
                                                @if($meeting->start_at)
                                                    <span class="date-text">
                                                        <i class="fa-solid fa-calendar me-1"></i>
                                                        {{ $meeting->start_at }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($meeting->finish_at)
                                                    <span class="date-text">
                                                        <i class="fa-solid fa-calendar me-1"></i>
                                                        {{ $meeting->finish_at }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($meeting->status)
                                                    <span class="status-badge status-active">
                                                        <i class="fa-solid fa-check-circle me-1"></i>{{ __('common.active') }}
                                                    </span>
                                                @else
                                                    <span class="status-badge status-inactive">
                                                        <i class="fa-solid fa-times-circle me-1"></i>{{ __('common.passive') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-outline-info btn-sm" 
                                                       href="{{ route('portal.meeting.show', $meeting->id) }}" 
                                                       title="{{ __('common.show') }}" 
                                                       data-bs-toggle="tooltip" 
                                                       data-bs-placement="top">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning btn-sm" 
                                                            title="{{ __('common.edit') }}" 
                                                            data-bs-toggle="offcanvas" 
                                                            data-bs-target="#meeting-edit-modal" 
                                                            data-route="{{ route('portal.meeting.update', $meeting->id) }}" 
                                                            data-resource="{{ route('portal.meeting.edit', $meeting->id) }}" 
                                                            data-id="{{ $meeting->id }}"
                                                            data-bs-tooltip="tooltip" 
                                                            data-bs-placement="top">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" 
                                                            title="{{ __('common.delete') }}" 
                                                            data-bs-toggle="offcanvas" 
                                                            data-bs-target="#meeting-delete-modal" 
                                                            data-route="{{ route('portal.meeting.destroy', $meeting->id) }}" 
                                                            data-record="{{ $meeting->title }}"
                                                            data-bs-tooltip="tooltip" 
                                                            data-bs-placement="top">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $meetings->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fa-solid fa-calendar-days fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No meetings found</h5>
                        <p class="text-muted">Start by creating your first meeting</p>
                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="offcanvas" data-bs-target="#meeting-create-modal" data-route="{{ route('portal.meeting.store') }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-meeting') }}
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- CRUD Modals -->
    <x-crud.form.common.create name="meeting">
        @section('meeting-create-form')
            <x-input.file method="c" name="banner" title="banner" icon="image"/>
            <x-input.text method="c" name="code" title="code" icon="code-simple" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.select method="c" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing" />
            <x-input.date method="c" name="start_at" title="start-at" icon="calendar-arrow-up" />
            <x-input.date method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>

    <x-crud.form.common.delete name="meeting" />
    
    <x-crud.form.common.edit name="meeting" >
        @section('meeting-edit-form')
            <x-input.file method="e" name="banner" title="banner" icon="image"/>
            <x-input.text method="e" name="code" title="code" icon="code-simple" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.date method="e" name="start_at" title="start-at" icon="calendar-arrow-up" />
            <x-input.date method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>

    <style>
    /* Meetings Hero Section - Kongre Theme Compatible */
    .meetings-hero-card {
        background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-accent) 100%);
        border-radius: 16px;
        padding: 2rem;
        color: white;
        box-shadow: 0 10px 30px rgba(var(--kongre-primary-rgb), 0.25);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .meetings-hero-card::before {
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
        border-radius: 16px;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hero-details {
        flex: 1;
    }

    .hero-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }

    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }

    .meta-item {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        opacity: 0.9;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-hero-create {
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .btn-hero-create:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
        color: white;
        border-color: rgba(255, 255, 255, 0.5);
    }

    /* Modern Cards - Kongre Theme */
    .modern-meetings-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        overflow: hidden;
        border: 1px solid rgba(var(--kongre-primary-rgb), 0.1);
    }

    .modern-header {
        background: var(--kongre-secondary);
        color: white;
        border-bottom: none;
        padding: 1.2rem 1.5rem;
    }

    /* Modern Table - Kongre Colors */
    .modern-meetings-table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-meetings-table thead th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 2px solid var(--kongre-primary);
        font-weight: 600;
        color: var(--kongre-primary);
        padding: 1rem 0.75rem;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .modern-meetings-table tbody td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid rgba(var(--kongre-primary-rgb), 0.1);
        vertical-align: middle;
    }

    .modern-meetings-table tbody tr:hover {
        background-color: rgba(var(--kongre-primary-rgb), 0.05);
    }

    /* Table Elements - Kongre Style */
    .code-badge {
        background: linear-gradient(135deg, var(--kongre-accent) 0%, var(--kongre-primary) 100%);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-family: monospace;
        font-size: 0.85rem;
        color: white;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(var(--kongre-primary-rgb), 0.2);
    }

    .date-text {
        color: #6c757d;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
    }

    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }

    .status-active {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border: 1px solid #b8daff;
    }

    .status-inactive {
        background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%);
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* Button Groups - Kongre Style */
    .btn-group .btn {
        margin: 0 2px;
        border-radius: 8px !important;
        transition: all 0.3s ease;
    }

    .btn-outline-info:hover {
        background: var(--kongre-accent);
        border-color: var(--kongre-accent);
        transform: translateY(-1px);
    }

    .btn-outline-warning:hover {
        background: #ffc107;
        border-color: #ffc107;
        transform: translateY(-1px);
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        border-color: #dc3545;
        transform: translateY(-1px);
    }

    /* Empty State - Kongre Style */
    .empty-state {
        padding: 3rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        border: 2px dashed var(--kongre-accent);
    }

    /* Card Footer */
    .card-footer {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-top: 1px solid rgba(var(--kongre-primary-rgb), 0.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-content {
            flex-direction: column;
            text-align: center;
        }
        
        .hero-action {
            width: 100%;
        }
        
        .btn-hero-create {
            width: 100%;
        }
        
        .modern-meetings-table {
            font-size: 0.85rem;
        }
        
        .modern-meetings-table thead th,
        .modern-meetings-table tbody td {
            padding: 0.5rem 0.25rem;
        }

        .meta-item {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
    }
    </style>
@endsection
