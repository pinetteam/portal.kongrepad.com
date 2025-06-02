@extends('layout.portal.common')
@section('title', $user->full_name)

@section('body')
<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route("portal.user.index") }}">{{ __('common.users') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $user->full_name }}</li>
        </ol>
    </nav>
</div>

<!-- Modern Hero Card -->
<div class="modern-hero-card">
    <div class="hero-content">
        <div class="hero-icon">
            <i class="fa-duotone fa-user-circle"></i>
        </div>
        <div class="hero-text">
            <h1 style="color: white; margin-bottom: 0.5rem; font-size: 2rem; font-weight: 700;">{{ $user->full_name }}</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1.1rem;">
                <i class="fa-duotone fa-id-card-clip me-2"></i>{{ $user->username }}
                <span class="mx-2">•</span>
                <span class="badge bg-kongre-accent text-white">{{ $user->userRole->title }}</span>
            </p>
        </div>
        <div class="hero-stats">
            <div class="badge-status">
                @if($user->status)
                    <i class="fa-duotone fa-check-circle text-success"></i>
                    {{ __('common.active') }}
                @else
                    <i class="fa-duotone fa-x-circle text-danger"></i>
                    {{ __('common.inactive') }}
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row g-4">
    <!-- User Information Card -->
    <div class="col-lg-8">
        <div class="modern-main-card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-duotone fa-info-circle me-2"></i>{{ __('common.user-information') }}</h4>
            </div>
            <div class="card-body">
                <div class="modern-table-container">
                    <table class="modern-table w-100">
                        <tbody>
                            <tr>
                                <td class="fw-semibold" style="width: 200px;">
                                    <i class="fa-duotone fa-id-card me-2 text-kongre-primary"></i>{{ __('common.title') }}
                                </td>
                                <td>{{ $user->userRole->title }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">
                                    <i class="fa-duotone fa-user me-2 text-kongre-primary"></i>{{ __('common.name') }}
                                </td>
                                <td>{{ $user->full_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">
                                    <i class="fa-duotone fa-envelope me-2 text-kongre-primary"></i>{{ __('common.email') }}
                                </td>
                                <td>
                                    <a href="mailto:{{ $user->email }}" class="text-kongre-accent text-decoration-none">
                                        {{ $user->email }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">
                                    <i class="fa-duotone fa-id-badge me-2 text-kongre-primary"></i>{{ __('common.identification-number') }}
                                </td>
                                <td>{{ $user->identification_number }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">
                                    <i class="fa-duotone fa-mobile-screen me-2 text-kongre-primary"></i>{{ __('common.phone') }}
                                </td>
                                <td>
                                    <a href="tel:{{ $user->full_phone }}" class="text-kongre-accent text-decoration-none">
                                        {{ $user->full_phone }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">
                                    <i class="fa-duotone fa-toggle-large-on me-2 text-kongre-primary"></i>{{ __('common.status') }}
                                </td>
                                <td>
                                    @if($user->status)
                                        <span class="badge bg-success fs-6">
                                            <i class="fa-duotone fa-check me-1"></i>{{ __('common.active') }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger fs-6">
                                            <i class="fa-duotone fa-xmark me-1"></i>{{ __('common.inactive') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">
                                    <i class="fa-duotone fa-wifi me-2 text-kongre-primary"></i>{{ __('common.activity-status') }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($user->activity_status)
                                            <div class="status-indicator online me-2"></div>
                                            <span class="badge bg-success fs-6">{{ __('common.online') }}</span>
                                        @else
                                            <div class="status-indicator offline me-2"></div>
                                            <span class="badge bg-secondary fs-6">{{ __('common.offline') }}</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">
                                    <i class="fa-duotone fa-user-plus me-2 text-kongre-primary"></i>{{ __('common.created-by') }}
                                </td>
                                <td>{{ $user->createdBy?->full_name ?? __('common.system') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">
                                    <i class="fa-duotone fa-calendar-plus me-2 text-kongre-primary"></i>{{ __('common.created-at') }}
                                </td>
                                <td>
                                    <span class="badge bg-info text-white fs-6">
                                        {{ $user->created_at ? $user->created_at->format('d.m.Y H:i') : __('common.unknown') }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity & Stats Card -->
    <div class="col-lg-4">
        <div class="modern-main-card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-duotone fa-chart-line me-2"></i>{{ __('common.activity-stats') }}</h4>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div class="stat-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-kongre-primary">
                                    <i class="fa-duotone fa-right-to-bracket text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="fw-semibold">{{ __('common.last-login') }}</div>
                                    <small class="text-muted">{{ __('common.last-activity') }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                @if($user->last_login)
                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($user->last_login)->format('d.m.Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($user->last_login)->format('H:i') }}</small>
                                @else
                                    <span class="badge bg-warning text-dark">{{ __('common.never') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="stat-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-kongre-secondary">
                                    <i class="fa-duotone fa-shield-check text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="fw-semibold">{{ __('common.role-permissions') }}</div>
                                    <small class="text-muted">{{ __('common.access-level') }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-semibold">{{ $user->userRole->title }}</div>
                                <small class="text-muted">{{ $user->userRole->description ?? __('common.no-description') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="stat-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-kongre-accent">
                                    <i class="fa-duotone fa-calendar text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="fw-semibold">{{ __('common.member-since') }}</div>
                                    <small class="text-muted">{{ __('common.account-age') }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-semibold">{{ $user->created_at ? $user->created_at->diffForHumans() : __('common.unknown') }}</div>
                                <small class="text-muted">{{ $user->created_at ? $user->created_at->format('d.m.Y') : __('common.unknown') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="modern-main-card mt-4">
    <div class="card-body">
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('portal.user.index') }}" class="btn btn-kongre-secondary">
                <i class="fa-duotone fa-arrow-left me-2"></i>{{ __('common.back') }}
            </a>
            <button class="btn btn-warning" 
                    data-bs-toggle="modal" 
                    data-bs-target="#user-edit-modal" 
                    data-route="{{ route('portal.user.update', $user->id) }}" 
                    data-resource="{{ route('portal.user.edit', $user->id) }}" 
                    data-id="{{ $user->id }}">
                <i class="fa-duotone fa-pen-to-square me-2"></i>{{ __('common.edit') }}
            </button>
            <button class="btn btn-danger" 
                    data-bs-toggle="modal" 
                    data-bs-target="#user-delete-modal" 
                    data-route="{{ route('portal.user.destroy', $user->id) }}" 
                    data-record="{{ $user->full_name }}">
                <i class="fa-duotone fa-trash me-2"></i>{{ __('common.delete') }}
            </button>
        </div>
    </div>
</div>

<!-- Include modals for edit and delete -->
<x-crud.form.common.delete name="user"/>

<x-crud.form.common.edit name="user">
    @section('user-edit-form')
        <x-input.select method="e" name="user_role_id" title="user-role" :options="$user_roles" option_value="id" option_name="title" icon="person-military-pointing" />
        <x-input.text method="e" name="username" title="username" icon="user" />
        <x-input.text method="e" name="first_name" title="first-name" icon="id-card" />
        <x-input.text method="e" name="last_name" title="last-name" icon="id-card" />
        <x-input.email method="e" name="email" title="email" icon="envelope" />
        <x-input.select method="e" name="phone_country_id" title="phone-country" :options="$phone_countries" option_value="id" option_name="NameAndCode" icon="flag" :searchable="true" />
        <x-input.number method="e" name="phone" title="phone" icon="mobile-screen" />
        <x-input.password method="e" name="password" title="password" icon="lock" />
        <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
    @endsection
</x-crud.form.common.edit>

<style>
.status-indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
    flex-shrink: 0;
}

.status-indicator.online {
    background-color: #28a745;
    box-shadow: 0 0 8px rgba(40, 167, 69, 0.6);
    animation: pulse-green 2s infinite;
}

.status-indicator.offline {
    background-color: #dc3545;
    box-shadow: 0 0 8px rgba(220, 53, 69, 0.6);
}

@keyframes pulse-green {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
    }
    
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
    }
    
    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
    }
}

.stat-item {
    padding: 1rem;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
</style>
@endsection
