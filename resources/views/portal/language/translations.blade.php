@extends('layout.portal.common')
@section('title', $language->name . ' ' . __('common.translations'))

@section('body')
<div class="container-fluid">
    <!-- Breadcrumb Navigation -->
    <div class="breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('portal.dashboard.index') }}">
                        <i class="fa-duotone fa-home me-1"></i>{{ __('common.dashboard') }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('portal.language.index') }}">
                        <i class="fa-duotone fa-language me-1"></i>{{ __('common.languages') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fa-duotone fa-pen-to-square me-1"></i>{{ $language->name }} {{ __('common.translations') }}
                </li>
            </ol>
        </nav>
    </div>

    <!-- Hero Section -->
    <div class="modern-hero-card mb-4">
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fa-duotone fa-globe"></i>
            </div>
            <div class="hero-text">
                <h1 class="hero-title">{{ $language->name }} {{ __('common.translations') }}</h1>
                <p class="hero-subtitle">{{ __('common.manage-translations-for-this-language') }}</p>
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
                                    <th style="width: 20%"><i class="fa-duotone fa-key me-2"></i>{{ __('common.key') }}</th>
                                    <th style="width: 35%"><i class="fa-duotone fa-language me-2"></i>{{ __('common.original-text') }}</th>
                                    <th style="width: 35%"><i class="fa-duotone fa-pen-to-square me-2"></i>{{ __('common.translation') }}</th>
                                    <th style="width: 10%" class="text-end">{{ __('common.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $key => $item)
                                <tr class="translation-row {{ $item['exists'] ? 'translated-item' : 'untranslated-item' }} {{ isset($item['is_missing']) && $item['is_missing'] ? 'missing-item' : '' }}" data-group="{{ $group }}" data-key="{{ $key }}">
                                    <td>
                                        <div class="fw-semibold text-kongre-primary d-flex align-items-center">
                                            <code>{{ $key }}</code>
                                            @if(isset($item['is_missing']) && $item['is_missing'])
                                                <span class="badge bg-warning ms-2" title="{{ __('common.missing-key-found-in-code') }}">
                                                    <i class="fa-duotone fa-triangle-exclamation"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if(isset($item['is_missing']) && $item['is_missing'])
                                            <div class="input-group">
                                                <input type="text" class="form-control original-text" 
                                                       placeholder="{{ __('common.enter-original-text') }}" 
                                                       value="" data-original="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary save-original" type="button" title="{{ __('common.save') }} {{ __('common.original-text') }}">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @else
                                            <div class="input-group">
                                                <input type="text" class="form-control original-text" 
                                                       value="{{ $item['original'] }}" data-original="{{ $item['original'] }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary save-original" type="button" title="{{ __('common.save') }} {{ __('common.original-text') }}">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <textarea class="form-control translation-text" rows="2" 
                                                      placeholder="{{ isset($item['is_missing']) && $item['is_missing'] ? __('common.enter-translation-for-missing-key') : __('common.enter-translation') }}">{{ $item['translated'] }}</textarea>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-success save-translation-ajax" type="button" title="{{ __('common.save') }} {{ __('common.translation') }}">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-info auto-translate-single" 
                                                    title="{{ __('common.auto-translate') }}">
                                                <i class="fas fa-language"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-key" 
                                                    title="{{ __('common.delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
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
            const languageId = {{ $language->id }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Show loading modal
            function showLoading() {
                // You can add a loading modal here if needed
            }

            // Hide loading modal
            function hideLoading() {
                // You can hide loading modal here if needed
            }

            // Show message
            function showMessage(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
                
                // Remove existing alerts
                document.querySelectorAll('.alert-dismissible').forEach(alert => alert.remove());
                
                const messageHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        <i class="fas fa-${icon} me-2"></i>
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                
                // Insert at the top of the page
                const container = document.querySelector('.modern-hero-card');
                container.insertAdjacentHTML('afterend', messageHtml);
                
                // Auto hide after 3 seconds
                setTimeout(() => {
                    const alert = document.querySelector('.alert-dismissible');
                    if (alert) alert.remove();
                }, 3000);
            }

            // Save original text
            document.addEventListener('click', function(e) {
                if (e.target.closest('.save-original')) {
                    const button = e.target.closest('.save-original');
                    const row = button.closest('tr');
                    const group = row.dataset.group;
                    const key = row.dataset.key;
                    const value = row.querySelector('.original-text').value;

                    showLoading();

                    fetch(`/portal/language/${languageId}/save-original-text`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            group: group,
                            key: key,
                            value: value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        if (data.success) {
                            showMessage('success', data.message);
                            row.querySelector('.original-text').setAttribute('data-original', value);
                        } else {
                            showMessage('error', data.message);
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        showMessage('error', '{{ __("common.error-occurred") }}');
                    });
                }
            });

            // Save translation
            document.addEventListener('click', function(e) {
                if (e.target.closest('.save-translation-ajax')) {
                    const button = e.target.closest('.save-translation-ajax');
                    const row = button.closest('tr');
                    const group = row.dataset.group;
                    const key = row.dataset.key;
                    const value = row.querySelector('.translation-text').value;

                    if (!value.trim()) {
                        showMessage('error', '{{ __("common.translation-cannot-be-empty") }}');
                        return;
                    }

                    showLoading();

                    fetch(`/portal/language/${languageId}/translations-ajax`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            group: group,
                            key: key,
                            value: value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        if (data.success) {
                            showMessage('success', data.message);
                            // Update row styling to show it's translated
                            row.classList.remove('untranslated-item');
                            row.classList.add('translated-item');
                        } else {
                            showMessage('error', data.message);
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        showMessage('error', '{{ __("common.error-occurred") }}');
                    });
                }
            });

            // Auto translate single key
            document.addEventListener('click', function(e) {
                if (e.target.closest('.auto-translate-single')) {
                    const button = e.target.closest('.auto-translate-single');
                    const row = button.closest('tr');
                    const group = row.dataset.group;
                    const key = row.dataset.key;
                    const originalText = row.querySelector('.original-text').value;
                    const translationTextarea = row.querySelector('.translation-text');
                    const saveButton = row.querySelector('.save-translation-ajax');

                    if (!originalText.trim()) {
                        showMessage('error', '{{ __("common.original-text-required") }}');
                        return;
                    }

                    // Show loading state
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                    fetch(`/portal/language/${languageId}/auto-translate-key`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            group: group,
                            key: key,
                            original_text: originalText
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Fill the translation textarea
                            translationTextarea.value = data.translation;
                            
                            // Highlight the textarea to show it's been auto-filled
                            translationTextarea.style.backgroundColor = '#e8f5e8';
                            translationTextarea.style.border = '2px solid #28a745';
                            
                            // Highlight the save button to indicate user should save
                            saveButton.style.backgroundColor = '#28a745';
                            saveButton.style.borderColor = '#28a745';
                            saveButton.style.color = 'white';
                            saveButton.innerHTML = '<i class="fas fa-save"></i> {{ __("common.save-translation") }}';
                            
                            // Show success message
                            showMessage('success', '{{ __("common.auto-translation-completed-please-save") }}');
                            
                            // Focus on the textarea so user can review
                            translationTextarea.focus();
                            
                            // Reset highlighting after 5 seconds
                            setTimeout(() => {
                                translationTextarea.style.backgroundColor = '';
                                translationTextarea.style.border = '';
                                saveButton.style.backgroundColor = '';
                                saveButton.style.borderColor = '';
                                saveButton.style.color = '';
                                saveButton.innerHTML = '<i class="fas fa-save"></i>';
                            }, 5000);
                            
                        } else {
                            showMessage('error', data.message);
                        }
                    })
                    .catch(error => {
                        showMessage('error', '{{ __("common.translation-failed") }}');
                    })
                    .finally(() => {
                        button.disabled = false;
                        button.innerHTML = '<i class="fas fa-language"></i>';
                    });
                }
            });

            // Delete key
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-key')) {
                    if (!confirm('{{ __("common.are-you-sure") }}')) return;

                    const button = e.target.closest('.delete-key');
                    const row = button.closest('tr');
                    const group = row.dataset.group;
                    const key = row.dataset.key;

                    showLoading();

                    fetch(`/portal/language/${languageId}/delete-key`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            group: group,
                            key: key
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        if (data.success) {
                            showMessage('success', data.message);
                            row.style.transition = 'opacity 0.5s';
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 500);
                        } else {
                            showMessage('error', data.message);
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        showMessage('error', '{{ __("common.error-occurred") }}');
                    });
                }
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
                    const key = row.querySelector('code').textContent.toLowerCase();
                    const original = row.querySelector('.original-text').value.toLowerCase();
                    const translation = row.querySelector('.translation-text').value.toLowerCase();
                    
                    if (key.includes(searchTerm) || original.includes(searchTerm) || translation.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</div>
@endsection 