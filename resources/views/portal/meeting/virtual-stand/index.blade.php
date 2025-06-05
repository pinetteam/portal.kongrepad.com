@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.virtual-stands'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.virtual-stands') }}</li>
@endsection

@push('styles')
    @vite(['resources/css/meeting-pages-theme.css'])
@endpush

@section('meeting_content')
    <!-- Modern Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-browser fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.virtual-stands') }}</h1>
                        <p class="hero-subtitle">{{ __('common.virtual-stands-management-subtitle') }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-browser me-1"></i>
                                {{ $virtual_stands->total() }} {{ __('common.total-virtual-stands') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-toggle-on me-1"></i>
                                {{ $virtual_stands->where('status', true)->count() }} {{ __('common.active') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#virtual-stand-create-modal" data-route="{{ route('portal.meeting.virtual-stand.store', ['meeting' => $meeting->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-virtual-stand') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Virtual Stands Management Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-browser me-2"></i>
                        {{ __('common.virtual-stands-management') }}
                    </h3>
                    <div class="header-actions">
                        <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="offcanvas" data-bs-target="#virtual-stand-create-modal" data-route="{{ route('portal.meeting.virtual-stand.store', ['meeting' => $meeting->id]) }}">
                            <i class="fa-solid fa-plus me-1"></i>
                            {{ __('common.create-virtual-stand') }}
                        </button>
                    </div>
                </div>
                
                @if($virtual_stands->count() > 0)
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-image me-2"></i>
                                            {{ __('common.logo') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-signature me-2"></i>
                                            {{ __('common.title') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-toggle-large-on me-2"></i>
                                            {{ __('common.status') }}
                                        </th>
                                        <th class="text-center">
                                            <i class="fa-regular fa-cogs me-2"></i>
                                            {{ __('common.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($virtual_stands as $virtual_stand)
                                        <tr>
                                            <td>
                                                <div class="item-info">
                                                    @if(isset($virtual_stand->file_name))
                                                        <img src="{{ asset('storage/virtual-stands/' . $virtual_stand->file_name . '.' . $virtual_stand->file_extension) }}" 
                                                             alt="{{ $virtual_stand->title }}" 
                                                             class="item-logo" />
                                                    @else
                                                        <div class="logo-placeholder">
                                                            <i class="fa-duotone fa-image"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="item-name">{{ $virtual_stand->title }}</div>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $virtual_stand->status ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $virtual_stand->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $virtual_stand->status ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a class="btn btn-outline-primary btn-sm" 
                                                       href="{{ route('portal.meeting.virtual-stand.show', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" 
                                                       title="{{ __('common.show') }}"
                                                       data-bs-toggle="tooltip">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning btn-sm" 
                                                            title="{{ __('common.edit') }}"
                                                            data-bs-toggle="offcanvas tooltip" 
                                                            data-bs-target="#virtual-stand-edit-modal" 
                                                            data-route="{{ route('portal.meeting.virtual-stand.update', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" 
                                                            data-resource="{{ route('portal.meeting.virtual-stand.edit', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" 
                                                            data-id="{{ $virtual_stand->id }}">
                                                        <i class="fa-regular fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" 
                                                            title="{{ __('common.delete') }}"
                                                            data-bs-toggle="offcanvas tooltip" 
                                                            data-bs-target="#virtual-stand-delete-modal" 
                                                            data-route="{{ route('portal.meeting.virtual-stand.destroy', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" 
                                                            data-record="{{ $virtual_stand->title }}">
                                                        <i class="fa-regular fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    @if($virtual_stands->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $virtual_stands->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-browser"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-virtual-stands-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-virtual-stands-found-description') ?? 'Henüz hiç sanal stand oluşturulmamış. İlk sanal standı oluşturmak için aşağıdaki butona tıklayın.' }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#virtual-stand-create-modal" data-route="{{ route('portal.meeting.virtual-stand.store', ['meeting' => $meeting->id]) }}">
                                <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-first-virtual-stand') }}
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- CRUD Modals -->
    <x-crud.form.common.create name="virtual-stand">
        @section('virtual-stand-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.file method="c" name="file" title="file" icon="file-import" />
            <x-input.file method="c" name="pdf" title="pdf" icon="file-import" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete name="virtual-stand"/>
    <x-crud.form.common.edit name="virtual-stand">
        @section('virtual-stand-edit-form')
            <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
            <x-input.file method="e" name="file" title="file" icon="file-import" />
            <x-input.file method="e" name="pdf" title="pdf" icon="file-import" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
