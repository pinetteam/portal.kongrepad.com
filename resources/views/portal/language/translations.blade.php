@extends('layout.portal.common')
@section('title', $language->name . ' ' . __('common.translations'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.language.index") }}" class="text-decoration-none">{{ __('common.languages') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $language->name . ' ' . __('common.translations') }}</li>
@endsection

@section('body')
<div class="modern-hero-card">
    <div class="hero-content">
        <div class="hero-icon">
            <i class="fa-duotone fa-globe"></i>
        </div>
        <div class="hero-text">
            <h1 style="color: white; margin-bottom: 0.5rem; font-size: 2rem; font-weight: 700;">{{ $language->name }} {{ __('common.translations') }}</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1.1rem;">{{ __('common.manage-translations-for-this-language') }}</p>
        </div>
    </div>
</div>

@if(!empty($missingKeys))
<div class="row mb-4">
    <div class="col-md-12">
        <div class="alert alert-warning d-flex align-items-center justify-content-between">
            <div>
                <i class="fa-duotone fa-triangle-exclamation me-2"></i>
                <strong>{{ __('common.missing-translation-keys-found') }}</strong>
                <span class="ms-2">
                    {{ __('common.found-missing-keys-count', ['count' => collect($missingKeys)->flatten()->count()]) }}
                </span>
            </div>
            <form action="{{ route('portal.language.add-missing-keys', $language->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm">
                    <i class="fa-duotone fa-plus me-2"></i>{{ __('common.add-missing-keys-automatically') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endif

<div class="row mb-4">
    <div class="col-md-12">
        <div class="modern-main-card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa-duotone fa-filter me-2"></i>{{ __('common.filter-translations') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="group-filter" class="form-label">{{ __('common.group') }}</label>
                        <select id="group-filter" class="form-select">
                            <option value="">{{ __('common.all-groups') }}</option>
                            @foreach($groups as $group)
                                <option value="{{ $group }}">{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-status" class="form-label">{{ __('common.status') }}</label>
                        <select id="filter-status" class="form-select">
                            <option value="">{{ __('common.all') }}</option>
                            <option value="translated">{{ __('common.translated') }}</option>
                            <option value="untranslated">{{ __('common.untranslated') }}</option>
                            <option value="missing">{{ __('common.missing-keys') }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="search-key" class="form-label">{{ __('common.search') }}</label>
                        <input type="text" id="search-key" class="form-control" placeholder="{{ __('common.search-by-key-or-value') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                @php
                    $totalEmptyTranslations = collect($translations)->flatten(1)->where('translated', '')->count();
                @endphp
                @if($totalEmptyTranslations > 0)
                <div class="alert alert-info d-flex align-items-center">
                    <i class="fa-duotone fa-info-circle me-2"></i>
                    <span>{{ $totalEmptyTranslations }} {{ __('common.empty-translations') }} {{ __('common.found') }}</span>
                </div>
                @endif
            </div>
            <div>
                @if($totalEmptyTranslations > 0)
                <form action="{{ route('portal.language.auto-translate', $language->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-duotone fa-wand-magic-sparkles me-2"></i>{{ __('common.translate-from-english') }}
                    </button>
                </form>
                @endif
                
                <form action="{{ route('portal.language.list-empty-translations', $language->id) }}" method="GET" class="d-inline ms-2">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="fa-duotone fa-list me-2"></i>{{ __('common.empty-translations') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($translations as $group => $items)
<div class="row mb-4 translation-group" data-group="{{ $group }}">
    <div class="col-md-12">
        <div class="modern-main-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fa-duotone fa-layer-group me-2"></i>{{ $group }}</h4>
                <div>
                    @php
                        $missingCount = collect($items)->where('is_missing', true)->count();
                        $translatedCount = collect($items)->where('exists', true)->count();
                        $totalCount = count($items);
                        $emptyCount = collect($items)->where('translated', '')->count();
                    @endphp
                    <span class="badge bg-info">{{ $totalCount }} {{ __('common.keys') }}</span>
                    @if($missingCount > 0)
                        <span class="badge bg-warning">{{ $missingCount }} {{ __('common.missing') }}</span>
                    @endif
                    @if($emptyCount > 0)
                        <span class="badge bg-secondary">{{ $emptyCount }} {{ __('common.empty-translations') }}</span>
                    @endif
                    <span class="badge bg-success">{{ $translatedCount }} {{ __('common.translated') }}</span>
                    
                    <!-- Auto Translate Button -->
                    @if($emptyCount > 0)
                    <form action="{{ route('portal.language.auto-translate', $language->id) }}" method="POST" class="d-inline ms-2">
                        @csrf
                        <input type="hidden" name="group" value="{{ $group }}">
                        <button type="submit" class="btn btn-primary btn-sm" title="{{ __('common.auto-translate') }}">
                            <i class="fa-duotone fa-wand-magic-sparkles me-1"></i>{{ __('common.auto-translate') }}
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                <div class="modern-table-container">
                    <table class="modern-table w-100">
                        <thead>
                            <tr>
                                <th style="width: 25%"><i class="fa-duotone fa-key me-2"></i>{{ __('common.key') }}</th>
                                <th style="width: 35%"><i class="fa-duotone fa-language me-2"></i>{{ __('common.original-text') }}</th>
                                <th style="width: 35%"><i class="fa-duotone fa-pen-to-square me-2"></i>{{ __('common.translation') }}</th>
                                <th style="width: 5%" class="text-end">{{ __('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $key => $item)
                            <tr class="translation-row {{ $item['exists'] ? 'translated-item' : 'untranslated-item' }} {{ isset($item['is_missing']) && $item['is_missing'] ? 'missing-item' : '' }}">
                                <td>
                                    <div class="fw-semibold text-kongre-primary d-flex align-items-center">
                                        {{ $key }}
                                        @if(isset($item['is_missing']) && $item['is_missing'])
                                            <span class="badge bg-warning ms-2" title="{{ __('common.missing-key-found-in-code') }}">
                                                <i class="fa-duotone fa-triangle-exclamation"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if(isset($item['is_missing']) && $item['is_missing'])
                                        <div class="text-muted fst-italic">{{ __('common.key-found-in-code-but-not-defined') }}</div>
                                    @else
                                        <div class="text-muted">{{ $item['original'] }}</div>
                                    @endif
                                </td>
                                <td>
                                    <form id="translation-form-{{ $group }}-{{ $key }}" action="{{ route('portal.language.translations.update', $language->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $key }}">
                                        <input type="hidden" name="group" value="{{ $group }}">
                                        <textarea name="value" class="form-control" placeholder="{{ isset($item['is_missing']) && $item['is_missing'] ? __('common.enter-translation-for-missing-key') : '' }}">{{ $item['translated'] }}</textarea>
                                    </form>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-kongre-accent btn-sm save-translation" data-form="translation-form-{{ $group }}-{{ $key }}">
                                        <i class="fa-duotone fa-floppy-disk"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('portal.language.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fa-duotone fa-arrow-left me-2"></i>{{ __('common.back-to-languages') }}
    </a>
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

<style>
.missing-item {
    background-color: rgba(255, 193, 7, 0.1) !important;
    border-left: 4px solid #ffc107;
}

.missing-item:hover {
    background-color: rgba(255, 193, 7, 0.2) !important;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Save translation AJAX
        document.querySelectorAll('.save-translation').forEach(button => {
            button.addEventListener('click', function() {
                const formId = this.getAttribute('data-form');
                const form = document.getElementById(formId);
                form.submit();
            });
        });

        // Group filter
        document.getElementById('group-filter').addEventListener('change', function() {
            const selectedGroup = this.value;
            document.querySelectorAll('.translation-group').forEach(group => {
                if (selectedGroup === '' || group.getAttribute('data-group') === selectedGroup) {
                    group.style.display = '';
                } else {
                    group.style.display = 'none';
                }
            });
        });

        // Status filter
        document.getElementById('filter-status').addEventListener('change', function() {
            const selectedStatus = this.value;
            document.querySelectorAll('.translation-row').forEach(row => {
                if (selectedStatus === '') {
                    row.style.display = '';
                } else if (selectedStatus === 'translated' && row.classList.contains('translated-item')) {
                    row.style.display = '';
                } else if (selectedStatus === 'untranslated' && row.classList.contains('untranslated-item') && !row.classList.contains('missing-item')) {
                    row.style.display = '';
                } else if (selectedStatus === 'missing' && row.classList.contains('missing-item')) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Search filter
        document.getElementById('search-key').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('.translation-row').forEach(row => {
                const key = row.querySelector('.text-kongre-primary').textContent.toLowerCase();
                const original = row.querySelector('.text-muted').textContent.toLowerCase();
                const translation = row.querySelector('textarea').value.toLowerCase();
                
                if (key.includes(searchTerm) || original.includes(searchTerm) || translation.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection 