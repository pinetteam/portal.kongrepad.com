@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.virtual-stands'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.virtual-stands') }}</li>
@endsection
@section('meeting_content')
    <!-- Modern Hero Section -->
    <div class="modern-virtual-stands-hero-card mb-4">
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fa-duotone fa-browser fa-fade"></i>
            </div>
            <div class="hero-text">
                <h1 class="hero-title">{{ __('common.virtual-stands') }}</h1>
                <p class="hero-subtitle">{{ __('common.manage-virtual-stands-subtitle') }}</p>
                <div class="hero-badges">
                    <span class="badge-info">
                        <i class="fa-duotone fa-browser"></i>
                        {{ $virtual_stands->total() }} {{ __('common.virtual-stands') }}
                    </span>
                    <span class="badge-success">
                        <i class="fa-duotone fa-toggle-on"></i>
                        {{ $virtual_stands->where('status', true)->count() }} {{ __('common.active') }}
                    </span>
                </div>
            </div>
            <div class="hero-action">
                <button type="button" class="btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#virtual-stand-create-modal" data-route="{{ route('portal.meeting.virtual-stand.store', ['meeting' => $meeting->id]) }}">
                    <i class="fa-solid fa-plus"></i> {{ __('common.create-new-virtual-stand') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Modern Virtual Stands Card -->
    <div class="modern-virtual-stands-card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fa-duotone fa-list"></i> {{ __('common.virtual-stands-list') }}
            </h5>
        </div>
        
        @if($virtual_stands->count() > 0)
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="modern-virtual-stands-table">
                        <thead>
                            <tr>
                                <th><i class="fa-duotone fa-image"></i> {{ __('common.logo') }}</th>
                                <th><i class="fa-duotone fa-signature"></i> {{ __('common.title') }}</th>
                                <th><i class="fa-duotone fa-toggle-on"></i> {{ __('common.status') }}</th>
                                <th class="text-end">{{ __('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($virtual_stands as $virtual_stand)
                                <tr>
                                    <td>
                                        @if(isset($virtual_stand->file_name))
                                            <img src="{{ asset('storage/virtual-stands/' . $virtual_stand->file_name . '.' . $virtual_stand->file_extension) }}" alt="{{ $virtual_stand->title }}" class="virtual-stand-logo" />
                                        @else
                                            <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="virtual-stand-title">{{ $virtual_stand->title }}</div>
                                    </td>
                                    <td>
                                        <span class="status-toggle {{ $virtual_stand->status ? 'status-active' : 'status-inactive' }}">
                                            <i class="fa-duotone fa-{{ $virtual_stand->status ? 'toggle-on' : 'toggle-off' }}"></i>
                                            {{ $virtual_stand->status ? __('common.active') : __('common.inactive') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a class="btn btn-primary btn-sm" href="{{ route('portal.meeting.virtual-stand.show', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" title="{{ __('common.show') }}">
                                                <i class="fa-duotone fa-eye"></i>
                                            </a>
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#virtual-stand-edit-modal" data-route="{{ route('portal.meeting.virtual-stand.update', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" data-resource="{{ route('portal.meeting.virtual-stand.edit', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" data-id="{{ $virtual_stand->id }}">
                                                <i class="fa-duotone fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#virtual-stand-delete-modal" data-route="{{ route('portal.meeting.virtual-stand.destroy', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" data-record="{{ $virtual_stand->title }}">
                                                <i class="fa-duotone fa-trash"></i>
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
                    <div class="empty-icon">
                        <i class="fa-duotone fa-browser fa-4x"></i>
                    </div>
                    <h4>{{ __('common.no-virtual-stands-found') }}</h4>
                    <p>{{ __('common.no-virtual-stands-message') }}</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#virtual-stand-create-modal" data-route="{{ route('portal.meeting.virtual-stand.store', ['meeting' => $meeting->id]) }}">
                        <i class="fa-solid fa-plus"></i> {{ __('common.create-first-virtual-stand') }}
                    </button>
                </div>
            </div>
        @endif
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
