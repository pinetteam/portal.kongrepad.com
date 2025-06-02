@extends('layout.portal.common')
@section('title', $user_role->title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.user-role.index") }}" class="text-decoration-none">{{ __('common.user-roles') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $user_role->title }}</li>
@endsection

@section('body')
<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @yield('breadcrumb')
        </ol>
    </nav>
</div>

<!-- Modern Hero Card -->
<div class="modern-hero-card">
    <div class="hero-content">
        <div class="hero-icon">
            <i class="fa-duotone fa-user-gear"></i>
        </div>
        <div class="hero-text">
            <h1 style="color: white; margin-bottom: 0.5rem; font-size: 2rem; font-weight: 700;">{{ $user_role->title }}</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1.1rem;">{{ __('common.user-role-details-and-permissions') }}</p>
        </div>
        <div class="hero-stats">
            @if($user_role->status)
                <div class="badge-status bg-success">
                    <i class="fa-duotone fa-check"></i>
                    {{ __('common.active') }}
                </div>
            @else
                <div class="badge-status bg-danger">
                    <i class="fa-duotone fa-xmark"></i>
                    {{ __('common.inactive') }}
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <!-- Role Information -->
    <div class="col-lg-4 col-md-12 mb-4">
        <!-- Basic Info Card -->
        <div class="modern-main-card mb-4">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-duotone fa-info-circle me-2"></i>{{ __('common.role-information') }}</h4>
            </div>
            <div class="card-body">
                <div class="info-item mb-3">
                    <div class="info-label">{{ __('common.title') }}</div>
                    <div class="info-value">{{ $user_role->title }}</div>
                </div>
                
                <div class="info-item mb-3">
                    <div class="info-label">{{ __('common.status') }}</div>
                    <div class="info-value">
                        @if($user_role->status)
                            <span class="badge bg-success">
                                <i class="fa-duotone fa-check me-1"></i>{{ __('common.active') }}
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="fa-duotone fa-xmark me-1"></i>{{ __('common.inactive') }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="info-item mb-3">
                    <div class="info-label">{{ __('common.total-permissions') }}</div>
                    <div class="info-value">
                        <span class="badge bg-kongre-primary text-white">
                            {{ count($user_role->routes) }} {{ __('common.permissions') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timestamps Card -->
        <div class="modern-main-card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-duotone fa-clock me-2"></i>{{ __('common.timestamps') }}</h4>
            </div>
            <div class="card-body">
                <div class="info-item mb-3">
                    <div class="info-label">{{ __('common.created_at') }}</div>
                    <div class="info-value">
                        <span class="badge bg-kongre-secondary text-white">
                            {{ $user_role->created_at ? $user_role->created_at->format('d.m.Y H:i:s') : '-' }}
                        </span>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">{{ __('common.updated_at') }}</div>
                    <div class="info-value">
                        <span class="badge bg-kongre-secondary text-white">
                            {{ $user_role->updated_at ? $user_role->updated_at->format('d.m.Y H:i:s') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Section -->
    <div class="col-lg-8 col-md-12">
        <div class="modern-main-card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-duotone fa-shield-check me-2"></i>{{ __('common.access-scopes') }}</h4>
            </div>
            <div class="card-body p-0">
                <div class="modern-table-container">
                    <table class="modern-table w-100">
                        <thead>
                            <tr>
                                <th><i class="fa-duotone fa-route me-2"></i>{{ __('common.route') }}</th>
                                <th><i class="fa-duotone fa-code me-2"></i>{{ __('common.code') }}</th>
                                <th><i class="fa-duotone fa-shield-check me-2"></i>{{ __('common.access') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $assignedRoutes = collect();
                                $availableRoutes = collect();
                            @endphp
                            
                            @foreach($routes as $route)
                                @if(in_array($route['route'], $user_role->routes))
                                    @php $assignedRoutes->push($route); @endphp
                                @else
                                    @php $availableRoutes->push($route); @endphp
                                @endif
                            @endforeach
                            
                            @foreach($assignedRoutes as $route)
                            <tr class="table-success">
                                <td>
                                    <div class="fw-semibold text-kongre-primary">{{ $route['route'] }}</div>
                                </td>
                                <td>
                                    <code class="text-success">{{ $route['code'] }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fa-duotone fa-check me-1"></i>{{ __('common.granted') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($availableRoutes->count() > 0)
                                <tr>
                                    <td colspan="3" class="text-center py-2">
                                        <strong class="text-muted">{{ __('common.available-permissions') }}</strong>
                                    </td>
                                </tr>
                                @foreach($availableRoutes->take(5) as $route)
                                <tr class="table-light">
                                    <td>
                                        <div class="text-muted">{{ $route['route'] }}</div>
                                    </td>
                                    <td>
                                        <code class="text-muted">{{ $route['code'] }}</code>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <i class="fa-duotone fa-xmark me-1"></i>{{ __('common.not-granted') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @if($availableRoutes->count() > 5)
                                <tr>
                                    <td colspan="3" class="text-center py-2">
                                        <small class="text-muted">{{ __('common.and') }} {{ $availableRoutes->count() - 5 }} {{ __('common.more-permissions') }}</small>
                                    </td>
                                </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="modern-main-card mt-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('portal.user-role.index') }}" class="btn btn-outline-secondary">
                <i class="fa-duotone fa-arrow-left me-2"></i>{{ __('common.back') }}
            </a>
            
            <div class="btn-group">
                <button class="btn btn-warning" 
                        data-bs-toggle="modal" 
                        data-bs-target="#user-role-edit-modal" 
                        data-route="{{ route('portal.user-role.update', $user_role->id) }}" 
                        data-resource="{{ route('portal.user-role.edit', $user_role->id) }}">
                    <i class="fa-duotone fa-pen-to-square me-2"></i>{{ __('common.edit') }}
                </button>
                <button class="btn btn-danger" 
                        data-bs-toggle="modal" 
                        data-bs-target="#user-role-delete-modal" 
                        data-route="{{ route('portal.user-role.destroy', $user_role->id) }}" 
                        data-record="{{ $user_role->title}}">
                    <i class="fa-duotone fa-trash me-2"></i>{{ __('common.delete') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<x-crud.form.common.delete name="user-role" />
<x-crud.form.common.edit name="user-role">
    @section('user-role-edit-form')
        <x-input.text method="e" name="title" title="title" icon="input-text" />
        <x-input.checkbox method="e" name="routes" title="access-scopes" :options="$routes" option_value="route" option_name="code" icon="ballot-check" />
        <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
    @endsection
</x-crud.form.common.edit>

<style>
.info-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.info-value {
    font-size: 1rem;
    font-weight: 600;
    color: #212529;
}

.table-success {
    background-color: rgba(25, 135, 84, 0.05) !important;
}

.table-light {
    background-color: rgba(108, 117, 125, 0.05) !important;
}

code {
    font-size: 0.875rem;
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
    background-color: rgba(108, 117, 125, 0.1);
}

.badge-status.bg-success {
    background-color: #198754 !important;
}

.badge-status.bg-danger {
    background-color: #dc3545 !important;
}
</style>
@endsection 