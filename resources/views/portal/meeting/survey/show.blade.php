@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . $survey->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.survey.index', $meeting->id) }}" class="text-decoration-none">{{ __('common.surveys') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $survey->title }}</li>
@endsection

@push('styles')
    @vite(['resources/css/meeting-pages-theme.css'])
@endpush

@section('meeting_content')
    <!-- Modern Hero Section for Survey Detail -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-poll fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ $survey->title }}</h1>
                        <p class="hero-subtitle">{{ $survey->description ?: __('common.survey-details') }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-question-circle me-1"></i>
                                {{ $survey->questions->count() }} {{ __('common.questions') }}
                            </span>
                            <span class="badge-status {{ $survey->status ? 'status-active' : 'status-inactive' }}">
                                <i class="fa-regular fa-{{ $survey->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                {{ $survey->status ? __('common.active') : __('common.inactive') }}
                            </span>
                            @if($survey->start_at)
                                <span class="stat-item">
                                    <i class="fa-regular fa-calendar-arrow-up me-1"></i>
                                    {{ \Carbon\Carbon::parse($survey->start_at)->format('d.m.Y H:i') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#question-create-modal" data-route="{{ route('portal.meeting.survey.question.store', ['meeting' => $meeting->id, 'survey' => $survey->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.add-new-question') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Survey Details Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-info-circle me-2"></i>
                        {{ __('common.survey-information') }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">
                                    <i class="fa-regular fa-signature me-2"></i>{{ __('common.title') }}
                                </label>
                                <div class="detail-value">{{ $survey->title }}</div>
                            </div>
                        </div>
                        @if($survey->description)
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">
                                        <i class="fa-regular fa-comment-dots me-2"></i>{{ __('common.description') }}
                                    </label>
                                    <div class="detail-value">{{ $survey->description }}</div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">
                                    <i class="fa-regular fa-calendar-arrow-up me-2"></i>{{ __('common.start-at') }}
                                </label>
                                <div class="detail-value">
                                    @if($survey->start_at)
                                        <span class="date-badge">
                                            <i class="fa-regular fa-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($survey->start_at)->format('d.m.Y H:i') }}
                                        </span>
                                    @else
                                        <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">
                                    <i class="fa-regular fa-calendar-arrow-down me-2"></i>{{ __('common.finish-at') }}
                                </label>
                                <div class="detail-value">
                                    @if($survey->finish_at)
                                        <span class="date-badge">
                                            <i class="fa-regular fa-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($survey->finish_at)->format('d.m.Y H:i') }}
                                        </span>
                                    @else
                                        <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">
                                    <i class="fa-regular fa-sort me-2"></i>{{ __('common.sort-order') }}
                                </label>
                                <div class="detail-value">
                                    <span class="id-badge">
                                        <i class="fa-regular fa-sort me-1"></i>
                                        {{ $survey->sort_order }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label class="detail-label">
                                    <i class="fa-regular fa-toggle-large-on me-2"></i>{{ __('common.status') }}
                                </label>
                                <div class="detail-value">
                                    <span class="status-badge {{ $survey->status ? 'status-active' : 'status-inactive' }}">
                                        <i class="fa-regular fa-{{ $survey->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                        {{ $survey->status ? __('common.active') : __('common.inactive') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-question-circle me-2"></i>
                        {{ __('common.questions') }}
                        <span class="count-badge ms-2">{{ $survey->questions->count() }}</span>
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($survey->questions->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-sort me-2"></i>
                                            {{ __('common.sort') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-signature me-2"></i>
                                            {{ __('common.title') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-list me-2"></i>
                                            {{ __('common.type') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-list-ul me-2"></i>
                                            {{ __('common.options') }}
                                        </th>
                                        <th class="text-center">
                                            <i class="fa-regular fa-toggle-large-on me-2"></i>
                                            {{ __('common.status') }}
                                        </th>
                                        <th class="text-center">
                                            <i class="fa-regular fa-gear me-2"></i>
                                            {{ __('common.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($survey->questions as $question)
                                        <tr>
                                            <td>
                                                <span class="id-badge">
                                                    <i class="fa-regular fa-sort me-1"></i>
                                                    {{ $question->sort_order }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="item-info">
                                                    <div class="item-title">{{ $question->question }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="theme-badge">
                                                    <i class="fa-regular fa-list-check me-1"></i>
                                                    {{ __('common.question') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($question->options->count() > 0)
                                                    <div class="options-container">
                                                        @foreach($question->options as $option)
                                                            <div class="option-item-row">
                                                                <span class="option-order">{{ $option->sort_order }}.</span>
                                                                <span class="option-title-text">{{ $option->option }}</span>
                                                                <span class="option-status-badge">
                                                                    <span class="badge bg-{{ $option->status ? 'success' : 'danger' }} badge-sm">
                                                                        {{ $option->status ? __('common.active') : __('common.passive') }}
                                                                    </span>
                                                                </span>
                                                                <div class="option-actions">
                                                                    <button class="btn btn-outline-warning btn-xs" data-bs-toggle="offcanvas" data-bs-target="#option-edit-modal" data-route="{{ route('portal.meeting.survey.question.option.update', ['meeting' => $meeting->id, 'survey' => $survey->id, 'question' => $question->id, 'option' => $option->id]) }}" data-resource="{{ route('portal.meeting.survey.question.option.edit', ['meeting' => $meeting->id, 'survey' => $survey->id, 'question' => $question->id, 'option' => $option->id]) }}" data-id="{{ $option->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                                    </button>
                                                                    <button class="btn btn-outline-danger btn-xs" data-bs-toggle="offcanvas" data-bs-target="#option-delete-modal" data-route="{{ route('portal.meeting.survey.question.option.destroy', ['meeting' => $meeting->id, 'survey' => $survey->id, 'question' => $question->id, 'option' => $option->id]) }}" data-record="{{ $option->option }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                                        <i class="fa-regular fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <button type="button" class="btn btn-outline-success btn-xs mt-2" data-bs-toggle="offcanvas" data-bs-target="#option-create-modal" data-route="{{ route('portal.meeting.survey.question.option.store', ['meeting' => $meeting->id, 'survey' => $survey->id, 'question' => $question->id]) }}">
                                                            <i class="fa-solid fa-plus me-1"></i>{{ __('common.add-option') }}
                                                        </button>
                                                        <div class="option-summary mt-2">
                                                            <small class="text-muted">
                                                                <span class="badge bg-success badge-sm me-1">{{ $question->options->where('status', 1)->count() }} {{ __('common.active') }}</span>
                                                                <span class="badge bg-danger badge-sm">{{ $question->options->where('status', 0)->count() }} {{ __('common.passive') }}</span>
                                                            </small>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="no-options-state">
                                                        <span class="unspecified-text">{{ __('common.no-options-message') }}</span>
                                                        <button type="button" class="btn btn-outline-success btn-xs ms-2" data-bs-toggle="offcanvas" data-bs-target="#option-create-modal" data-route="{{ route('portal.meeting.survey.question.option.store', ['meeting' => $meeting->id, 'survey' => $survey->id, 'question' => $question->id]) }}">
                                                            <i class="fa-solid fa-plus me-1"></i>{{ __('common.add-first-option') }}
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="status-badge {{ $question->status ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $question->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $question->status ? __('common.active') : __('common.passive') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.actions') }}">
                                                    <button class="btn btn-outline-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#question-edit-modal" data-route="{{ route('portal.meeting.survey.question.update', ['meeting' => $meeting->id, 'survey' => $survey->id, 'question' => $question->id]) }}" data-resource="{{ route('portal.meeting.survey.question.edit', ['meeting' => $meeting->id, 'survey' => $survey->id, 'question' => $question->id]) }}" data-id="{{ $question->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#question-delete-modal" data-route="{{ route('portal.meeting.survey.question.destroy', ['meeting' => $meeting->id, 'survey' => $survey->id, 'question' => $question->id]) }}" data-record="{{ $question->question }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                        <i class="fa-regular fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-question-circle"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-questions-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-questions-message') }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#question-create-modal" data-route="{{ route('portal.meeting.survey.question.store', ['meeting' => $meeting->id, 'survey' => $survey->id]) }}">
                                <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-first-question') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- CRUD Forms -->
    <!-- Survey Edit/Delete Forms -->
    <x-crud.form.common.edit name="survey">
        @section('survey-edit-form')
            <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort" />
            <x-input.text method="e" name="title" title="title" icon="pen-field" />
            <x-input.text method="e" name="description" title="description" icon="comment-dots" />
            <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
    
    <x-crud.form.common.delete name="survey" />

    <!-- Question CRUD Forms -->
    <x-crud.form.common.create name="question">
        @section('question-create-form')
            <x-input.hidden method="c" name="survey_id" :value="$survey->id" />
            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort" />
            <x-input.text method="c" name="question" title="question" icon="pen-field" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    
    <x-crud.form.common.edit name="question">
        @section('question-edit-form')
            <x-input.hidden method="e" name="survey_id" :value="$survey->id" />
            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort" />
            <x-input.text method="e" name="question" title="question" icon="pen-field" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
    
    <x-crud.form.common.delete name="question" />

    <!-- Option CRUD Forms -->
    <x-crud.form.common.create name="option">
        @section('option-create-form')
            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort" />
            <x-input.text method="c" name="option" title="option" icon="pen-field" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    
    <x-crud.form.common.edit name="option">
        @section('option-edit-form')
            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort" />
            <x-input.text method="e" name="option" title="option" icon="pen-field" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
    
    <x-crud.form.common.delete name="option" />
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-select active status for option create form
    const optionCreateModal = document.getElementById('option-create-modal');
    if (optionCreateModal) {
        optionCreateModal.addEventListener('shown.bs.offcanvas', function() {
            const activeStatusRadio = document.getElementById('c-status-1');
            if (activeStatusRadio && !document.querySelector('input[name="status"]:checked')) {
                activeStatusRadio.checked = true;
            }
        });
    }
    
    // Auto-select active status for question create form
    const questionCreateModal = document.getElementById('question-create-modal');
    if (questionCreateModal) {
        questionCreateModal.addEventListener('shown.bs.offcanvas', function() {
            const activeStatusRadio = document.getElementById('c-status-1');
            if (activeStatusRadio && !document.querySelector('input[name="status"]:checked')) {
                activeStatusRadio.checked = true;
            }
        });
    }
    
    // Enhanced radio button clearing in edit modals  
    const editModals = document.querySelectorAll('[id$="-edit-modal"]');
    editModals.forEach(modal => {
        modal.addEventListener('hide.bs.offcanvas', function() {
            // Clear all radio buttons in this modal when closing
            const radioButtons = modal.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radio => {
                radio.checked = false;
                radio.removeAttribute('checked');
            });
        });
    });
    
    // Fix option edit modal radio button selection
    const optionEditModal = document.getElementById('option-edit-modal');
    if (optionEditModal) {
        optionEditModal.addEventListener('shown.bs.offcanvas', function() {
            // Add a small delay to ensure data has loaded
            setTimeout(() => {
                // If no radio button is selected, ensure at least one is checked
                const statusRadios = optionEditModal.querySelectorAll('input[name="status"]');
                const checkedRadio = optionEditModal.querySelector('input[name="status"]:checked');
                
                if (!checkedRadio && statusRadios.length > 0) {
                    // Default to active (value 1)
                    const activeRadio = optionEditModal.querySelector('#e-status-1');
                    if (activeRadio) {
                        activeRadio.checked = true;
                    }
                }
            }, 100);
        });
    }
    
    // Fix question edit modal radio button selection
    const questionEditModal = document.getElementById('question-edit-modal');
    if (questionEditModal) {
        // Listen for when the modal is about to show
        questionEditModal.addEventListener('show.bs.offcanvas', function() {
            console.log('Question Edit Modal - Show event triggered');
            // Clear any previous radio button states
            const statusRadios = questionEditModal.querySelectorAll('input[name="status"]');
            console.log('Question Edit Modal - Clearing radios:', statusRadios.length);
            statusRadios.forEach(radio => {
                radio.checked = false;
                radio.removeAttribute('checked');
            });
        });
        
        questionEditModal.addEventListener('shown.bs.offcanvas', function() {
            // Add a delay to ensure AJAX data has loaded
            setTimeout(() => {
                // Check if any radio button is selected after data load
                const checkedRadio = questionEditModal.querySelector('input[name="status"]:checked');
                const allStatusRadios = questionEditModal.querySelectorAll('input[name="status"]');
                
                console.log('Question Edit Modal - Status radios found:', allStatusRadios.length);
                console.log('Question Edit Modal - Checked radio:', checkedRadio);
                
                // If no radio button is selected, default to active
                if (!checkedRadio) {
                    const activeRadio = questionEditModal.querySelector('#e-status-1');
                    console.log('Question Edit Modal - Active radio element:', activeRadio);
                    if (activeRadio) {
                        activeRadio.checked = true;
                        activeRadio.setAttribute('checked', 'checked');
                        console.log('Question Edit Modal - Set active radio to checked');
                    }
                }
            }, 300);
        });
    }
});
</script>
@endpush
