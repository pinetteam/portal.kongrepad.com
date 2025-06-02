@extends('layout.portal.common')
@section('title', __('common.languages'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.languages') }}</li>
@endsection

@section('body')
<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('common.languages') }}</li>
        </ol>
    </nav>
</div>

<!-- Hero Card -->
<div class="modern-hero-card">
    <div class="hero-content">
        <div class="hero-icon">
            <i class="fa-duotone fa-language"></i>
        </div>
        <div class="hero-text">
            <h1 style="color: white; margin-bottom: 0.5rem; font-size: 2rem; font-weight: 700;">{{ __('common.languages') }}</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1.1rem;">{{ __('common.manage-your-language-settings') }}</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('portal.language.create') }}" class="btn btn-light btn-icon">
                <i class="fa-duotone fa-plus me-2"></i>{{ __('common.add-new-language') }}
            </a>
        </div>
    </div>
</div>

<!-- Languages Table -->
<div class="modern-main-card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fa-duotone fa-language me-2"></i>{{ __('common.available-languages') }}</h4>
    </div>
    <div class="card-body p-0">
        <div class="modern-table-container">
            <table class="modern-table w-100">
                <thead>
                    <tr>
                        <th><i class="fa-duotone fa-flag me-2"></i>{{ __('common.name') }}</th>
                        <th><i class="fa-duotone fa-code me-2"></i>{{ __('common.code') }}</th>
                        <th><i class="fa-duotone fa-check-circle me-2"></i>{{ __('common.status') }}</th>
                        <th class="text-end" style="width: 180px;">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($languages as $language)
                    <tr>
                        <td>
                            <div class="fw-semibold text-kongre-primary">
                                {{ $language->name }}
                                @if($language->is_default)
                                    <span class="badge bg-success ms-2">{{ __('common.default') }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-kongre-secondary text-white">{{ $language->code }}</span>
                        </td>
                        <td>
                            @if($language->is_active)
                                <span class="badge bg-success">{{ __('common.active') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('common.passive') }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('portal.language.translations', $language->id) }}" class="btn btn-primary btn-sm" title="{{ __('common.translations') }}">
                                <i class="fa-duotone fa-globe"></i>
                            </a>
                            <a href="{{ route('portal.language.export', $language->id) }}" class="btn btn-info btn-sm" title="{{ __('common.export') }}">
                                <i class="fa-duotone fa-file-export"></i>
                            </a>
                            <a href="{{ route('portal.language.import', $language->id) }}" class="btn btn-success btn-sm" title="{{ __('common.import') }}">
                                <i class="fa-duotone fa-file-import"></i>
                            </a>
                            <a href="{{ route('portal.language.edit', $language->id) }}" class="btn btn-warning btn-sm" title="{{ __('common.edit') }}">
                                <i class="fa-duotone fa-pen-to-square"></i>
                            </a>
                            @if(!$language->is_default)
                            <button class="btn btn-danger btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#delete-modal-{{ $language->id }}" 
                                    title="{{ __('common.delete') }}">
                                <i class="fa-duotone fa-trash"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modals -->
@foreach($languages as $language)
@if(!$language->is_default)
<div class="modal fade" id="delete-modal-{{ $language->id }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="delete-modal-label-{{ $language->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-modal-label-{{ $language->id }}">
                    <i class="fa-duotone fa-trash me-2"></i>{{ __('common.delete') . " " . $language->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('common.are-you-sure-you-want-to-delete') }} <strong>{{ $language->name }}</strong>?</p>
                <p class="text-danger">{{ __('common.this-action-cannot-be-undone') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fa-duotone fa-xmark me-2"></i>{{ __('common.close') }}
                </button>
                <form action="{{ route('portal.language.destroy', $language->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-duotone fa-trash me-2"></i>{{ __('common.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showAlert('success', '{{ session('success') }}');
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showAlert('error', '{{ session('error') }}');
    });
</script>
@endif
@endsection 