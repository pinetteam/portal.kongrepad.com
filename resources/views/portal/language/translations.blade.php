@extends('layout.portal.common')
@section('title', __('common.language-translations'))

@section('body')
<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route("portal.language.index") }}">{{ __('common.languages') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $language->name }} {{ __('common.translations') }}</li>
        </ol>
    </nav>
</div>

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

@foreach($translations as $group => $items)
<div class="row mb-4 translation-group" data-group="{{ $group }}">
    <div class="col-md-12">
        <div class="modern-main-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fa-duotone fa-layer-group me-2"></i>{{ $group }}</h4>
                <div>
                    <span class="badge bg-info">{{ count($items) }} {{ __('common.keys') }}</span>
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
                            <tr class="translation-row {{ $item['exists'] ? 'translated-item' : 'untranslated-item' }}">
                                <td>
                                    <div class="fw-semibold text-kongre-primary">{{ $key }}</div>
                                </td>
                                <td>
                                    <div class="text-muted">{{ $item['original'] }}</div>
                                </td>
                                <td>
                                    <form id="translation-form-{{ $group }}-{{ $key }}" action="{{ route('portal.language.translations.update', $language->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $key }}">
                                        <input type="hidden" name="group" value="{{ $group }}">
                                        <textarea name="value" class="form-control">{{ $item['translated'] }}</textarea>
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
                } else if (selectedStatus === 'untranslated' && row.classList.contains('untranslated-item')) {
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