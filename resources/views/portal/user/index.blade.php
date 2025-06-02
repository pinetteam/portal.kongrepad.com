@extends('layout.portal.common')
@section('title', __('common.users'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.users') }}</li>
@endsection

@section('body')
<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('common.users') }}</li>
        </ol>
    </nav>
</div>

<!-- Modern Hero Card -->
<div class="modern-hero-card">
    <div class="hero-content">
        <div class="hero-icon">
            <i class="fa-duotone fa-users"></i>
        </div>
        <div class="hero-text">
            <h1 style="color: white; margin-bottom: 0.5rem; font-size: 2rem; font-weight: 700;">{{ __('common.users') }}</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1.1rem;">{{ __('common.manage-system-users-and-permissions') }}</p>
        </div>
        <div class="hero-stats">
            <div class="badge-status">
                <i class="fa-duotone fa-users"></i>
                {{ __('common.total') }}: {{ $users->total() }}
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="modern-main-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fa-duotone fa-list me-2"></i>{{ __('common.users') }}</h4>
        <button type="button" class="btn btn-kongre-accent" 
                data-bs-toggle="modal" 
                data-bs-target="#user-create-modal" 
                data-route="{{ route('portal.user.store') }}">
            <i class="fa-duotone fa-plus me-2"></i>{{ __('common.create-new-user') }}
        </button>
    </div>
    <div class="card-body p-0">
        <div class="modern-table-container">
            <table class="modern-table w-100">
                <thead>
                    <tr>
                        <th><i class="fa-duotone fa-person-military-pointing me-2"></i>{{ __('common.user-role') }}</th>
                        <th><i class="fa-duotone fa-id-card-clip me-2"></i>{{ __('common.username') }}</th>
                        <th><i class="fa-duotone fa-id-card me-2"></i>{{ __('common.name') }}</th>
                        <th><i class="fa-duotone fa-envelope me-2"></i>{{ __('common.email') }}</th>
                        <th><i class="fa-duotone fa-mobile-screen me-2"></i>{{ __('common.phone') }}</th>
                        <th><i class="fa-duotone fa-toggle-large-on me-2"></i>{{ __('common.status') }}</th>
                        <th><i class="fa-duotone fa-right-to-bracket me-2"></i>{{ __('common.last-login') }}</th>
                        <th class="text-end" style="width: 150px;">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <span class="badge bg-kongre-primary text-white">
                                {{ $user->userRole->title }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($user->activity_status)
                                    <div class="status-indicator online me-2" title="{{ __('common.online') }}"></div>
                                @else
                                    <div class="status-indicator offline me-2" title="{{ __('common.offline') }}"></div>
                                @endif
                                <div class="fw-semibold text-kongre-primary">{{ $user->username }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $user->full_name }}</div>
                        </td>
                        <td>
                            <span class="text-muted">{{ $user->email }}</span>
                        </td>
                        <td>
                            <span class="badge bg-kongre-secondary text-white">{{ $user->full_phone }}</span>
                        </td>
                        <td>
                            @if($user->status)
                                <span class="badge bg-success">
                                    <i class="fa-duotone fa-check me-1"></i>{{ __('common.active') }}
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fa-duotone fa-xmark me-1"></i>{{ __('common.inactive') }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info text-white">
                                @if($user->last_login)
                                    @php
                                        // Check if last_login is already a localized string or a parseable date
                                        $lastLoginText = $user->last_login;
                                        if (is_string($lastLoginText) && (
                                            strpos($lastLoginText, 'önce') !== false || 
                                            strpos($lastLoginText, 'ago') !== false ||
                                            strpos($lastLoginText, 'saat') !== false ||
                                            strpos($lastLoginText, 'dakika') !== false ||
                                            strpos($lastLoginText, 'gün') !== false ||
                                            strpos($lastLoginText, 'hour') !== false ||
                                            strpos($lastLoginText, 'minute') !== false ||
                                            strpos($lastLoginText, 'day') !== false
                                        )) {
                                            // Already localized, display as is
                                            echo $lastLoginText;
                                        } else {
                                            try {
                                                // Try to parse as datetime
                                                echo \Carbon\Carbon::parse($lastLoginText)->diffForHumans();
                                            } catch (\Exception $e) {
                                                // If parsing fails, display as is
                                                echo $lastLoginText;
                                            }
                                        }
                                    @endphp
                                @else
                                    {{ __('common.never') }}
                                @endif
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a class="btn btn-info btn-sm" 
                                   href="{{ route('portal.user.show', $user->id) }}" 
                                   title="{{ __('common.show') }}"
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="top" 
                                   data-bs-title="{{ __('common.show') }}">
                                    <i class="fa-duotone fa-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-sm" 
                                        title="{{ __('common.edit') }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#user-edit-modal" 
                                        data-route="{{ route('portal.user.update', $user->id) }}" 
                                        data-resource="{{ route('portal.user.edit', $user->id) }}" 
                                        data-id="{{ $user->id }}"
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="top" 
                                        data-bs-title="{{ __('common.edit') }}">
                                    <i class="fa-duotone fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" 
                                        title="{{ __('common.delete') }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#user-delete-modal" 
                                        data-route="{{ route('portal.user.destroy', $user->id) }}" 
                                        data-record="{{ $user->full_name }}"
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
        
        @if($users->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modals -->
<x-crud.form.common.create name="user">
    @section('user-create-form')
        <x-input.select method="c" name="user_role_id" title="user-role" :options="$user_roles" option_value="id" option_name="title" icon="person-military-pointing" />
        <x-input.text method="c" name="username" title="username" icon="user" />
        <x-input.text method="c" name="first_name" title="first-name" icon="id-card" />
        <x-input.text method="c" name="last_name" title="last-name" icon="id-card" />
        <x-input.email method="c" name="email" title="email" icon="envelope" />
        <x-input.select method="c" name="phone_country_id" title="phone-country" :options="$phone_countries" option_value="id" option_name="NameAndCode" icon="flag" :searchable="true" />
        <x-input.number method="c" name="phone" title="phone" icon="mobile-screen" />
        <x-input.password method="c" name="password" title="password" icon="lock" />
        <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
    @endsection
</x-crud.form.common.create>

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
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    flex-shrink: 0;
}

.status-indicator.online {
    background-color: #28a745;
    box-shadow: 0 0 6px rgba(40, 167, 69, 0.6);
}

.status-indicator.offline {
    background-color: #dc3545;
    box-shadow: 0 0 6px rgba(220, 53, 69, 0.6);
}

.status-indicator::before {
    content: '';
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: inherit;
    animation: pulse 2s infinite;
}

@keyframes pulse {
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

.status-indicator.offline::before {
    animation-name: pulse-red;
}

@keyframes pulse-red {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
    }
    
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
    }
    
    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
    }
}
</style>
@endsection
