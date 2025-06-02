@extends('layout.portal.common')
@section('title', __('common.settings'))

@section('body')
<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('common.settings') }}</li>
        </ol>
    </nav>
</div>

<!-- Modern Hero Card -->
<div class="modern-hero-card">
    <div class="hero-content">
        <div class="hero-icon">
            <i class="fa-duotone fa-gears"></i>
        </div>
        <div class="hero-text">
            <h1 style="color: white; margin-bottom: 0.5rem; font-size: 2rem; font-weight: 700;">{{ __('common.settings') }}</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1.1rem;">{{ __('common.manage-your-system-settings') }}</p>
        </div>
        <div class="hero-stats">
            <div class="badge-status">
                <i class="fa-duotone fa-credit-card"></i>
                {{ __('common.credit') }}: {{ $customer->credit }}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Credit and Logo Section -->
    <div class="col-lg-4 col-md-12 mb-4">
        <!-- Credit Card -->
        <div class="modern-main-card mb-4">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-duotone fa-credit-card me-2"></i>{{ __('common.credit') }}</h4>
            </div>
            <div class="card-body text-center">
                <div class="stats-value mb-3" style="color: var(--kongre-primary);">{{ $customer->credit }}</div>
                <button class="btn btn-kongre-accent w-100" disabled>
                    <i class="fa-duotone fa-shopping-cart me-2"></i>{{ __('common.purchase') }}
                </button>
            </div>
        </div>

        <!-- Logo Upload Card -->
        <div class="modern-main-card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-duotone fa-image me-2"></i>{{ __('common.edit-logo') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('portal.setting.update', $customer->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input name="_method" type="hidden" value="PATCH" />
                    
                    <div class="text-center mb-3">
                        @if($customer->logo)
                            <img src="{{ $customer->logo }}" alt="Logo" class="img-thumbnail" style="max-width: 200px; max-height: 200px; border-radius: 8px;" />
                        @else
                            <div class="empty-state-icon mb-3">
                                <i class="fa-duotone fa-image"></i>
                            </div>
                            <p class="text-muted">{{ __('common.no-logo-uploaded') }}</p>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label for="logo" class="form-label">{{ __('common.select-logo') }}</label>
                        <input type="file" name="logo" class="form-control" id="logo" accept="image/png">
                        <div class="form-text">{{ __('common.only-png-files-allowed') }}</div>
                    </div>
                    
                    <button type="submit" class="btn btn-kongre-accent w-100">
                        <i class="fa-duotone fa-upload me-2"></i>{{ __('common.edit-logo') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Settings Section -->
    <div class="col-lg-8 col-md-12">
        @foreach($setting_groups as $group => $settings)
        <div class="modern-main-card mb-4">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-duotone fa-sliders me-2"></i>{{ __('common.' . $group) }}</h4>
            </div>
            <div class="card-body p-0">
                <div class="modern-table-container">
                    <table class="modern-table w-100">
                        <thead>
                            <tr>
                                <th><i class="fa-duotone fa-sliders-simple me-2"></i>{{ __('common.variable') }}</th>
                                <th><i class="fa-duotone fa-screwdriver-wrench me-2"></i>{{ __('common.value') }}</th>
                                <th class="text-end" style="width: 100px;">{{ __('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settings as $setting)
                            <tr>
                                <td>
                                    <div class="fw-semibold text-kongre-primary">{{ __('common.'.$setting->title) }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-kongre-secondary text-white">{{ $setting->value }}</span>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-warning btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#edit-modal-{{ $setting->variable }}" 
                                            title="{{ __('common.edit') }}">
                                        <i class="fa-duotone fa-pen-to-square"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modals for each setting -->
        @foreach($settings as $setting)
        <div class="modal fade" id="edit-modal-{{ $setting->variable }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="edit-modal-label-{{ $setting->variable }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="post" action="{{ route('portal.setting.update', $setting->id) }}">
                        @csrf
                        <input name="_method" type="hidden" value="PATCH" />
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label-{{ $setting->variable }}">
                                <i class="fa-duotone fa-pen-to-square me-2"></i>{{ __('common.edit') . " " . __('common.'.$setting->title) }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="value-{{ $setting->variable }}" class="form-label">{{ __('common.'.$setting->title) }}</label>
                                
                                @if($setting->type == 'text' || $setting->type == 'number')
                                    <input type="{{ $setting->type }}" 
                                           name="value" 
                                           class="form-control @error('value') is-invalid @enderror" 
                                           id="value-{{ $setting->variable }}" 
                                           placeholder="{{ $setting->value }}" 
                                           value="{{ $setting->value }}" />
                                           
                                @elseif($setting->type == 'select')
                                    <select name="value" class="form-select @error('value') is-invalid @enderror">
                                        @foreach(json_decode($setting->type_variables, true) as $option)
                                            <option value="{{ $option['value'] }}"{{ $setting->value == $option['value'] ? ' selected' : '' }}>
                                                {{ $option['title'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                @elseif($setting->type == 'radio')
                                    <div class="btn-group w-100 @error('value') is-invalid @enderror" role="group">
                                        @foreach(json_decode($setting->type_variables, true) as $option)
                                            <input type="radio" 
                                                   name="value" 
                                                   class="btn-check" 
                                                   id="value-{{ $setting->variable }}-{{ $option['value'] }}" 
                                                   value="{{ $option['value'] }}"{{ $setting->value == $option['value'] ? ' checked' : '' }} />
                                            <label class="btn btn-outline-primary" for="value-{{ $setting->variable }}-{{ $option['value'] }}">
                                                {{ $option['title'] }}
                                            </label>
                                        @endforeach
                                    </div>
                                    
                                @elseif($setting->type == 'checkbox')
                                    <div class="form-check">
                                        @foreach(json_decode($setting->type_variables, true) as $option)
                                            <input type="checkbox" 
                                                   name="value[]" 
                                                   class="form-check-input" 
                                                   id="value-{{ $setting->variable }}-{{ $option['value'] }}" 
                                                   value="{{ $option['value'] }}"{{ $setting->value == $option['value'] ? ' checked' : '' }} />
                                            <label class="form-check-label" for="value-{{ $setting->variable }}-{{ $option['value'] }}">
                                                {{ $option['title'] }}
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                                
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fa-duotone fa-xmark me-2"></i>{{ __('common.close') }}
                            </button>
                            <button type="submit" class="btn btn-kongre-accent">
                                <i class="fa-duotone fa-floppy-disk me-2"></i>{{ __('common.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>
</div>

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
