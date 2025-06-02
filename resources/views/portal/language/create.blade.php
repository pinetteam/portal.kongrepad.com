@extends('layout.portal.common')
@section('title', __('common.add-new-language'))

@section('body')
<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route("portal.language.index") }}">{{ __('common.languages') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('common.add-new-language') }}</li>
        </ol>
    </nav>
</div>

<div class="modern-hero-card">
    <div class="hero-content">
        <div class="hero-icon">
            <i class="fa-duotone fa-plus"></i>
        </div>
        <div class="hero-text">
            <h1 style="color: white; margin-bottom: 0.5rem; font-size: 2rem; font-weight: 700;">{{ __('common.add-new-language') }}</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1.1rem;">{{ __('common.create-new-language-for-your-application') }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="modern-main-card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-duotone fa-language me-2"></i>{{ __('common.language-details') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('portal.language.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="form-label">{{ __('common.name') }}</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">{{ __('common.enter-language-name-in-its-native-form') }}</div>
                    </div>

                    <div class="mb-4">
                        <label for="code" class="form-label">{{ __('common.code') }}</label>
                        <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">{{ __('common.enter-the-language-code-for-example-en-for-english') }}</div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{ old('is_active') ? 'checked' : 'checked' }}>
                            <label for="is_active" class="form-check-label">{{ __('common.active') }}</label>
                        </div>
                        <div class="form-text">{{ __('common.active-languages-can-be-selected-by-users') }}</div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('portal.language.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fa-duotone fa-arrow-left me-2"></i>{{ __('common.back') }}
                        </a>
                        <button type="submit" class="btn btn-kongre-accent">
                            <i class="fa-duotone fa-floppy-disk me-2"></i>{{ __('common.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 