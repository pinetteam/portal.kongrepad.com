@extends('layout.portal.common')

@section('title', __('common.empty-translations') . ' - ' . $language->name)

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
                <li class="breadcrumb-item">
                    <a href="{{ route('portal.language.translations', $language->id) }}">
                        <i class="fa-duotone fa-pen-to-square me-1"></i>{{ $language->name }} {{ __('common.translations') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fa-duotone fa-list me-1"></i>{{ __('common.empty-translations') }}
                </li>
            </ol>
        </nav>
    </div>

    <!-- Hero Section -->
    <div class="modern-hero-card mb-4">
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fa-duotone fa-language"></i>
            </div>
            <div class="hero-text">
                <h1 class="hero-title">{{ __('common.empty-translations') }}</h1>
                <p class="hero-subtitle">{{ $language->name }} ({{ $language->code }})</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('portal.language.translations', $language) }}" class="btn btn-light">
                    <i class="fa-duotone fa-arrow-left me-2"></i>{{ __('common.back-to-translations') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Debug Information Card -->
    <div class="modern-main-card mb-4">
        <div class="card-header">
            <h4 class="mb-0">
                <i class="fa-duotone fa-bug me-2"></i>Debug Information
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item">
                        <span class="info-label">Language:</span>
                        <span class="info-value">{{ $language->name ?? 'N/A' }} ({{ $language->code ?? 'N/A' }})</span>
                    </div>
                    @if(isset($debugInfo) && !isset($debugInfo['error']))
                        <div class="info-item">
                            <span class="info-label">Base Language:</span>
                            <span class="info-value">{{ $debugInfo['baseLanguage']->name ?? 'N/A' }} ({{ $debugInfo['baseLanguage']->code ?? 'N/A' }})</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Empty Groups:</span>
                            <span class="info-value">{{ $debugInfo['emptyTranslationsCount'] ?? 0 }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Total Empty Keys:</span>
                            <span class="info-value">{{ $debugInfo['totalEmptyKeys'] ?? 0 }}</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    @if(isset($debugInfo) && !isset($debugInfo['error']))
                        <div class="info-item">
                            <span class="info-label">Groups Found:</span>
                            <span class="info-value">{{ implode(', ', $debugInfo['groups'] ?? []) }}</span>
                        </div>
                    @endif
                    <div class="info-item">
                        <span class="info-label">Timestamp:</span>
                        <span class="info-value">{{ now()->format('Y-m-d H:i:s') }}</span>
                    </div>
                </div>
            </div>
            
            @if(isset($debugInfo['error']))
                <div class="alert alert-danger mt-3">
                    <strong>❌ Error:</strong> {{ $debugInfo['error'] }}
                    <details class="mt-2">
                        <summary>Stack Trace</summary>
                        <pre class="small">{{ $debugInfo['trace'] ?? 'No trace available' }}</pre>
                    </details>
                </div>
            @endif
            
            @if(isset($debugInfo['message']))
                <div class="alert alert-warning mt-3">
                    <strong>⚠️ Note:</strong> {{ $debugInfo['message'] }}
                </div>
            @endif
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fa-duotone fa-triangle-exclamation me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-duotone fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div id="ajax-messages"></div>

    <!-- Progress Bar -->
    <div id="progress-container" class="modern-main-card mb-4" style="display: none;">
        <div class="card-header">
            <h4 class="mb-0">
                <i class="fa-duotone fa-wand-magic-sparkles me-2"></i>Auto Translation Progress
            </h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span id="progress-text">{{ __('common.auto-translate') }}...</span>
                <span id="progress-percentage" class="badge bg-primary">0%</span>
            </div>
            <div class="progress mb-2" style="height: 8px;">
                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" 
                     role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
            <small id="progress-details" class="text-muted"></small>
        </div>
    </div>

    <!-- Content Section -->
    @if(isset($emptyTranslations) && count($emptyTranslations) > 0)
        <!-- Action Buttons Card -->
        <div class="modern-main-card mb-4">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fa-duotone fa-wand-magic-sparkles me-2"></i>Translation Actions
                </h4>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <button id="auto-translate-all" class="btn btn-primary">
                        <i class="fa-duotone fa-language me-2"></i>
                        {{ __('common.auto-translate') }} {{ __('common.all') }}
                        <span class="badge bg-light text-dark ms-2">{{ array_sum(array_map('count', $emptyTranslations)) }}</span>
                    </button>
                    <button id="cancel-translate" class="btn btn-secondary" style="display: none;">
                        <i class="fa-duotone fa-stop me-2"></i>{{ __('common.cancel') }}
                    </button>
                    <form action="{{ route('portal.language.auto-translate', $language) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa-duotone fa-wand-magic-sparkles me-2"></i>
                            {{ __('common.translate-from-english') }}
                        </button>
                    </form>
                </div>
                
                <div class="alert alert-info mb-0">
                    <i class="fa-duotone fa-info-circle me-2"></i>
                    <strong>{{ __('common.found') }} {{ array_sum(array_map('count', $emptyTranslations)) }} {{ __('common.empty-translations') }}</strong>
                    in {{ count($emptyTranslations) }} groups
                </div>
            </div>
        </div>

        <!-- Empty Translations List -->
        @foreach($emptyTranslations as $group => $translations)
            <div class="group-section mb-4" data-group="{{ $group }}">
                <div class="modern-main-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fa-duotone fa-folder me-2"></i>
                                {{ $group }}.php
                            </h4>
                            <div class="d-flex gap-2">
                                <span class="badge bg-info group-count">{{ count($translations) }} keys</span>
                                <span class="status-dot status-warning" title="Has empty translations"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="modern-table-container">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">
                                            <i class="fa-duotone fa-key me-2"></i>{{ __('common.key') }}
                                        </th>
                                        <th style="width: 35%">
                                            <i class="fa-duotone fa-language me-2"></i>{{ __('common.original-text') }}
                                        </th>
                                        <th style="width: 35%">
                                            <i class="fa-duotone fa-pen-to-square me-2"></i>{{ __('common.translation') }}
                                        </th>
                                        <th style="width: 10%" class="text-end">
                                            <i class="fa-duotone fa-cogs me-2"></i>{{ __('common.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($translations as $key => $originalText)
                                        <tr data-group="{{ $group }}" data-key="{{ $key }}" class="translation-row">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="id-badge">{{ $key }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control original-text" 
                                                           value="{{ $originalText }}" data-original="{{ $originalText }}">
                                                    <button class="btn btn-outline-secondary save-original" type="button" 
                                                            title="{{ __('common.save') }}">
                                                        <i class="fa-duotone fa-floppy-disk"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control translation-text" 
                                                           placeholder="{{ __('common.enter-translation') }}">
                                                    <button class="btn btn-outline-success save-translation" type="button" 
                                                            title="{{ __('common.save') }}">
                                                        <i class="fa-duotone fa-floppy-disk"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button class="btn btn-info auto-translate-single" 
                                                            title="{{ __('common.auto-translate') }}">
                                                        <i class="fa-duotone fa-language"></i>
                                                    </button>
                                                    <button class="btn btn-danger delete-key" 
                                                            title="{{ __('common.delete') }}">
                                                        <i class="fa-duotone fa-trash"></i>
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
        @endforeach
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa-duotone fa-circle-check"></i>
            </div>
            <h3 class="empty-title">{{ __('common.no-empty-translations-found') }}</h3>
            <p class="empty-description">All translations are complete for this language!</p>
            <div class="empty-actions">
                <a href="{{ route('portal.language.translations', $language) }}" class="btn btn-primary">
                    <i class="fa-duotone fa-arrow-left me-2"></i>{{ __('common.back-to-translations') }}
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2">
                    <span id="loading-text">{{ __('common.loading') }}...</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const languageId = {{ $language->id }};
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    let isTranslating = false;
    let cancelTranslation = false;
    
    // Show loading modal
    function showLoading() {
        $('#loadingModal').modal('show');
    }
    
    // Hide loading modal
    function hideLoading() {
        $('#loadingModal').modal('hide');
    }
    
    // Show message
    function showMessage(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
        
        const messageHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas fa-${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('#ajax-messages').html(messageHtml);
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 3000);
    }
    
    // Show Success Message
    function showSuccess(message) {
        $('#success-message').text(message).show();
        setTimeout(() => $('#success-message').hide(), 3000);
    }

    // Show Error Message
    function showError(message) {
        $('#error-message').text(message).show();
        setTimeout(() => $('#error-message').hide(), 5000);
    }
    
    // Update Progress Bar
    function updateProgress(current, total, message = '') {
        const percentage = Math.round((current / total) * 100);
        $('#progress-bar').css('width', percentage + '%').attr('aria-valuenow', percentage);
        $('#progress-percentage').text(percentage + '%');
        if (message) {
            $('#progress-details').text(message);
        }
    }
    
    // Show Progress Container
    function showProgress() {
        $('#progress-container').show();
        $('#auto-translate-all').hide();
        $('#cancel-translate').show();
    }

    // Hide Progress Container
    function hideProgress() {
        $('#progress-container').hide();
        $('#auto-translate-all').show();
        $('#cancel-translate').hide();
        $('#progress-bar').css('width', '0%').attr('aria-valuenow', 0);
        $('#progress-percentage').text('0%');
        $('#progress-details').text('');
    }
    
    // Save original text
    $(document).on('click', '.save-original', function() {
        const row = $(this).closest('tr');
        const group = row.data('group');
        const key = row.data('key');
        const value = row.find('.original-text').val();
        
        showLoading();
        
        $.ajax({
            url: `/portal/language/${languageId}/save-original-text`,
            method: 'POST',
            data: {
                _token: csrfToken,
                group: group,
                key: key,
                value: value
            },
            success: function(response) {
                hideLoading();
                if (response.success) {
                    showSuccess(response.message);
                    row.find('.original-text').data('original', value);
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Error saving original text';
                showError(message);
            },
            complete: function() {
                hideLoading();
            }
        });
    });
    
    // Save translation
    $(document).on('click', '.save-translation', function() {
        const row = $(this).closest('tr');
        const group = row.data('group');
        const key = row.data('key');
        const value = row.find('.translation-text').val();
        
        if (!value.trim()) {
            showError('{{ __("common.translation-cannot-be-empty") }}');
            return;
        }
        
        showLoading();
        
        $.ajax({
            url: `/portal/language/${languageId}/translations-ajax`,
            method: 'POST',
            data: {
                _token: csrfToken,
                group: group,
                key: key,
                value: value
            },
            success: function(response) {
                hideLoading();
                if (response.success) {
                    showSuccess(response.message);
                    
                    // Remove row from empty translations
                    row.fadeOut(500, function() {
                        const groupSection = row.closest('.group-section');
                        const remainingRows = groupSection.find('.translation-row').length - 1;
                        
                        row.remove();
                        
                        if (remainingRows === 0) {
                            groupSection.remove();
                        } else {
                            groupSection.find('.group-count').text(remainingRows);
                        }
                        
                        // Update total count
                        const currentCount = parseInt($('#empty-count').text()) - 1;
                        $('#empty-count').text(currentCount);
                    });
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Error saving translation';
                showError(message);
            },
            complete: function() {
                hideLoading();
            }
        });
    });
    
    // Auto translate single key
    $(document).on('click', '.auto-translate-single', function() {
        const button = $(this);
        const row = button.closest('tr');
        const group = row.data('group');
        const key = row.data('key');
        const originalText = row.find('.original-text').val();
        
        if (!originalText.trim()) {
            showError('{{ __("common.original-text-required") }}');
            return;
        }
        
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: `/portal/language/${languageId}/auto-translate-key`,
            method: 'POST',
            data: {
                _token: csrfToken,
                group: group,
                key: key,
                original_text: originalText
            },
            success: function(response) {
                if (response.success) {
                    row.find('.translation-text').val(response.translation);
                    showSuccess('{{ __("common.translation-completed") }}');
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Error generating translation';
                showError(message);
            },
            complete: function() {
                hideLoading();
                button.prop('disabled', false).html('<i class="fas fa-language"></i>');
            }
        });
    });
    
    // Auto translate all keys
    $('#auto-translate-all').click(function() {
        if (isTranslating) return;
        
        const rows = $('.translation-row');
        if (rows.length === 0) {
            showError('{{ __("common.no-translations-to-process") }}');
            return;
        }

        isTranslating = true;
        cancelTranslation = false;
        showProgress();
        
        let current = 0;
        const total = rows.length;
        
        function translateNext() {
            if (cancelTranslation || current >= total) {
                isTranslating = false;
                hideProgress();
                if (cancelTranslation) {
                    showError('{{ __("common.translation-cancelled") }}');
                } else {
                    showSuccess('{{ __("common.all-translations-completed") }}');
                }
                return;
            }

            const row = $(rows[current]);
            const group = row.data('group');
            const key = row.data('key');
            const originalText = row.find('.original-text').val();
            
            updateProgress(current + 1, total, `${group}.${key}`);

            if (!originalText.trim()) {
                current++;
                setTimeout(translateNext, 100);
                return;
            }

            $.ajax({
                url: `/portal/language/${languageId}/auto-translate-key`,
                method: 'POST',
                data: {
                    _token: csrfToken,
                    group: group,
                    key: key,
                    original_text: originalText
                },
                success: function(response) {
                    if (response.success) {
                        row.find('.translation-text').val(response.translation);
                        row.addClass('table-success');
                    }
                },
                complete: function() {
                    current++;
                    setTimeout(translateNext, 500); // 500ms delay between requests
                }
            });
        }

        translateNext();
    });

    // Cancel translation
    $('#cancel-translate').click(function() {
        cancelTranslation = true;
    });
    
    // Delete key
    $(document).on('click', '.delete-key', function() {
        if (!confirm('{{ __("common.are-you-sure") }}')) return;

        const row = $(this).closest('tr');
        const group = row.data('group');
        const key = row.data('key');

        showLoading();
        
        $.ajax({
            url: `/portal/language/${languageId}/delete-key`,
            method: 'DELETE',
            data: {
                _token: csrfToken,
                group: group,
                key: key
            },
            success: function(response) {
                hideLoading();
                if (response.success) {
                    showSuccess(response.message);
                    
                    row.fadeOut(500, function() {
                        const groupSection = row.closest('.group-section');
                        const remainingRows = groupSection.find('.translation-row').length - 1;
                        
                        row.remove();
                        
                        if (remainingRows === 0) {
                            groupSection.remove();
                        } else {
                            groupSection.find('.group-count').text(remainingRows);
                        }
                        
                        // Update total count
                        const currentCount = parseInt($('#empty-count').text()) - 1;
                        $('#empty-count').text(currentCount);
                    });
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Error deleting key';
                showError(message);
            },
            complete: function() {
                hideLoading();
            }
        });
    });
    
    // Auto-resize textareas
    $('textarea').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>
@endpush 