@extends('layout.portal.common')
@section('title', __('common.user-roles'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.user-roles') }}</li>
@endsection

@section('body')
<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('common.user-roles') }}</li>
        </ol>
    </nav>
</div>

<!-- Modern Hero Card -->
<div class="modern-hero-card">
    <div class="hero-content">
        <div class="hero-icon">
            <i class="fa-duotone fa-users-gear"></i>
        </div>
        <div class="hero-text">
            <h1 style="color: white; margin-bottom: 0.5rem; font-size: 2rem; font-weight: 700;">{{ __('common.user-roles') }}</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1.1rem;">{{ __('common.manage-user-roles-and-permissions') }}</p>
        </div>
        <div class="hero-stats">
            <div class="badge-status">
                <i class="fa-duotone fa-users"></i>
                {{ __('common.total') }}: {{ $user_roles->total() }}
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="modern-main-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fa-duotone fa-list me-2"></i>{{ __('common.user-roles') }}</h4>
        <button type="button" class="btn btn-kongre-accent" 
                data-bs-toggle="modal" 
                data-bs-target="#user-role-create-modal" 
                data-route="{{ route('portal.user-role.store') }}">
            <i class="fa-duotone fa-plus me-2"></i>{{ __('common.create-new-user-role') }}
        </button>
    </div>
    <div class="card-body p-0">
        <div class="modern-table-container">
            <table class="modern-table w-100">
                <thead>
                    <tr>
                        <th><i class="fa-duotone fa-input-text me-2"></i>{{ __('common.title') }}</th>
                        <th><i class="fa-duotone fa-shield-check me-2"></i>{{ __('common.total-access-scopes') }}</th>
                        <th><i class="fa-duotone fa-toggle-large-on me-2"></i>{{ __('common.status') }}</th>
                        <th class="text-end" style="width: 150px;">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user_roles as $user_role)
                    <tr>
                        <td>
                            <div class="fw-semibold text-kongre-primary">{{ $user_role->title }}</div>
                        </td>
                        <td>
                            <span class="badge bg-kongre-secondary text-white">
                                {{ count($user_role->routes) }} {{ __('common.permissions') }}
                            </span>
                        </td>
                        <td>
                            @if($user_role->status)
                                <span class="badge bg-success">
                                    <i class="fa-duotone fa-check me-1"></i>{{ __('common.active') }}
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fa-duotone fa-xmark me-1"></i>{{ __('common.inactive') }}
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a class="btn btn-info btn-sm" 
                                   href="{{ route('portal.user-role.show', $user_role->id) }}" 
                                   title="{{ __('common.show') }}"
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="top" 
                                   data-bs-title="{{ __('common.show') }}">
                                    <i class="fa-duotone fa-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-sm" 
                                        title="{{ __('common.edit') }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#user-role-edit-modal" 
                                        data-route="{{ route('portal.user-role.update', $user_role->id) }}" 
                                        data-resource="{{ route('portal.user-role.edit', $user_role->id) }}" 
                                        data-id="{{ $user_role->id }}"
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        data-bs-title="{{ __('common.edit') }}">
                                    <i class="fa-duotone fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" 
                                        title="{{ __('common.delete') }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#user-role-delete-modal" 
                                        data-route="{{ route('portal.user-role.destroy', $user_role->id) }}" 
                                        data-record="{{ $user_role->title}}"
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        data-bs-title="{{ __('common.delete') }}">
                                    <i class="fa-duotone fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($user_roles->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $user_roles->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modals -->
<x-crud.form.common.create name="user-role" >
    @section('user-role-create-form')
        <x-input.text method="c" name="title" title="title" icon="input-text" />
        <x-input.checkbox method="c" name="routes" title="access-scopes" :options="$routes" option_value="route" option_name="code" icon="ballot-check" />
        <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
    @endsection
</x-crud.form.common.create>

<x-crud.form.common.delete name="user-role" />

<x-crud.form.common.edit name="user-role" >
    @section('user-role-edit-form')
        <x-input.text method="e" name="title" title="title" icon="input-text" />
        <x-input.checkbox method="e" name="routes" title="access-scopes" :options="$routes" option_value="route" option_name="code" icon="ballot-check" />
        <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
    @endsection
</x-crud.form.common.edit>
@endsection
