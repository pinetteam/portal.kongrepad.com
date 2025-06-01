@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.documents'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.documents') }}</li>
@endsection
@section('meeting_content')
    <!-- Modern Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-documents-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-folder-open fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.documents') }}</h1>
                        <p class="hero-subtitle">{{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-files me-1"></i>
                                {{ $documents->total() }} {{ __('common.documents') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#document-create-modal" data-route="{{ route('portal.meeting.document.store', ['meeting' => $meeting->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-document') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Documents Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-documents-card">
                <div class="card-header">
                    <h3 class="mb-0">
                        <i class="fa-duotone fa-folder-open me-2"></i>
                        {{ __('common.documents') }}
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($documents->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-documents-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-input-text me-2"></i>
                                            {{ __('common.title') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-toggle-large-on me-2"></i>
                                            {{ __('common.allowed-to-review') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-envelope me-2"></i>
                                            {{ __('common.sharing-via-email') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-toggle-large-on me-2"></i>
                                            {{ __('common.status') }}
                                        </th>
                                        <th class="text-center">
                                            <i class="fa-regular fa-gear me-2"></i>
                                            {{ __('common.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="document-table-container">
                                    @foreach($documents as $document)
                                        <tr id="document-row-{{ $document->id }}">
                                            <td>
                                                <div class="document-title">
                                                    <a href="{{ route('portal.meeting.document.download', ['meeting' => $meeting->id, 'document' => $document->file_name]) }}" class="download-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.download') }}">
                                                        <i class="fa-regular fa-file-arrow-down me-2"></i>
                                                        {{ $document->title }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $document->allowed_to_review ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $document->allowed_to_review ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $document->allowed_to_review ? __('common.allowed') : __('common.not-allowed') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $document->sharing_via_email ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $document->sharing_via_email ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $document->sharing_via_email ? __('common.allowed') : __('common.not-allowed') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $document->status ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $document->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $document->status ? __('common.active') : __('common.passive') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.actions') }}">
                                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('portal.meeting.document.show', ['meeting' => $meeting->id, 'document' => $document->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#document-edit-modal" data-route="{{ route('portal.meeting.document.update', ['meeting' => $meeting->id, 'document' => $document->id]) }}" data-resource="{{ route('portal.meeting.document.edit', ['meeting' => $meeting->id, 'document' => $document->id]) }}" data-id="{{ $document->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#document-delete-modal" data-route="{{ route('portal.meeting.document.destroy', ['meeting' => $meeting->id, 'document' => $document->id]) }}" data-record="{{ $document->title }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                        <i class="fa-regular fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-folder-open"></i>
                            </div>
                            <h4 class="empty-state-title">Döküman Bulunamadı</h4>
                            <p class="empty-state-text">Bu toplantı için henüz hiçbir döküman eklenmemiş.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#document-create-modal" data-route="{{ route('portal.meeting.document.store', ['meeting' => $meeting->id]) }}">
                                <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-document') }}
                            </button>
                        </div>
                    @endif
                </div>
                @if($documents->count() > 0)
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                {{ __('common.total') }}: {{ $documents->total() }} {{ __('common.documents') }}
                            </span>
                            <div>
                                {{ $documents->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- CRUD Modals -->
    <x-crud.form.common.create name="document">
        @section('document-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.file method="c" name="file" title="file" icon="file-import" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.radio method="c" name="allowed_to_review" title="allowed-to-review" :options="$sharing_via_emails" option_value="value" option_name="title" icon="envelope" />
            <x-input.radio method="c" name="sharing_via_email" title="sharing-via-email" :options="$sharing_via_emails" option_value="value" option_name="title" icon="envelope" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete name="document"/>
    <x-crud.form.common.edit name="document">
        @section('document-edit-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.file method="e" name="file" title="file" icon="file-import" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.radio method="e" name="allowed_to_review" title="allowed-to-review" :options="$sharing_via_emails" option_value="value" option_name="title" icon="envelope" />
            <x-input.radio method="e" name="sharing_via_email" title="sharing-via-email" :options="$sharing_via_emails" option_value="value" option_name="title" icon="envelope" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>

    <style>
        /* Modern Documents Page Styles - Congress Theme */
        .modern-documents-hero-card {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-accent) 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(var(--kongre-primary-rgb), 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .modern-documents-hero-card::before {
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

        .btn-hero-create {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .btn-hero-create:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            color: white;
        }

        .modern-documents-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(var(--kongre-primary-rgb), 0.1);
            overflow: hidden;
        }

        .modern-documents-card .card-header {
            background: linear-gradient(135deg, var(--kongre-primary) 0%, var(--kongre-secondary) 100%);
            color: white;
            padding: 1.5rem 2rem;
            border: none;
        }

        .modern-documents-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .modern-documents-table thead th {
            background: var(--kongre-primary);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border: none;
            text-align: left;
        }

        .modern-documents-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }

        .modern-documents-table tbody tr:hover {
            background: rgba(var(--kongre-primary-rgb), 0.05);
        }

        .modern-documents-table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
        }

        .document-title {
            font-weight: 500;
        }

        .download-link {
            color: var(--kongre-primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .download-link:hover {
            color: var(--kongre-accent);
            text-decoration: none;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
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

        .modern-documents-card .card-footer {
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
            margin-bottom: 2rem;
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

            .btn-hero-create {
                width: 100%;
            }

            .modern-documents-table thead th,
            .modern-documents-table tbody td {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }

            .btn-group .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
            }
        }
    </style>
@endsection
