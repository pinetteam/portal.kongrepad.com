@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.surveys'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.surveys') }}</li>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/meeting-pages-theme.css') }}">
@endpush

@section('meeting_content')
    <!-- Modern Hero Section for Surveys -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-poll fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.surveys') }}</h1>
                        <p class="hero-subtitle">{{ $meeting->title }} - {{ __('common.manage-surveys-subtitle') }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-poll me-1"></i>
                                {{ $surveys->count() }} {{ __('common.surveys') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-question-circle me-1"></i>
                                {{ $surveys->sum(function($survey) { return $survey->questions->count(); }) }} {{ __('common.questions') }}
                            </span>
                        </div>
                    </div>
                    <div class="hero-action">
                        <button type="button" class="btn btn-hero-create" data-bs-toggle="offcanvas" data-bs-target="#survey-create-modal" data-route="{{ route('portal.meeting.survey.store', ['meeting' => $meeting->id]) }}">
                            <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-new-survey') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Surveys List Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-list me-2"></i>
                        {{ __('common.surveys-list') }}
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($surveys->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-signature me-2"></i>
                                            {{ __('common.title') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-arrow-up me-2"></i>
                                            {{ __('common.start-at') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-calendar-arrow-down me-2"></i>
                                            {{ __('common.finish-at') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-question-circle me-2"></i>
                                            {{ __('common.questions') }}
                                        </th>
                                        <th>
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
                                    @foreach($surveys as $survey)
                                        <tr>
                                            <td>
                                                <div class="item-info">
                                                    <div class="item-title">{{ $survey->title }}</div>
                                                    @if($survey->description)
                                                        <small class="text-muted">{{ Str::limit($survey->description, 50) }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($survey->start_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($survey->start_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($survey->finish_at)
                                                    <span class="date-badge">
                                                        <i class="fa-regular fa-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($survey->finish_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="unspecified-text">{{ __('common.unspecified') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="id-badge">
                                                    <i class="fa-regular fa-question-circle me-1"></i>
                                                    {{ $survey->questions->count() }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $survey->status ? 'status-active' : 'status-inactive' }}">
                                                    <i class="fa-regular fa-{{ $survey->status ? 'toggle-on' : 'toggle-off' }} me-1"></i>
                                                    {{ $survey->status ? __('common.active') : __('common.inactive') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.actions') }}">
                                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('portal.meeting.survey.show', ['meeting' =>  $meeting->id, 'survey' => $survey->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-outline-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#survey-edit-modal" data-route="{{ route('portal.meeting.survey.update', ['meeting' => $meeting->id, 'survey' => $survey->id]) }}" data-resource="{{ route('portal.meeting.survey.edit', ['meeting' => $meeting->id, 'survey' => $survey->id]) }}" data-id="{{ $survey->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#survey-delete-modal" data-route="{{ route('portal.meeting.survey.destroy', ['meeting' => $meeting->id, 'survey' => $survey->id]) }}" data-record="{{ $survey->title }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                        <i class="fa-regular fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($surveys->hasPages())
                            <div class="card-footer">
                                {{ $surveys->links() }}
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-poll"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-surveys-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-surveys-message') }}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#survey-create-modal" data-route="{{ route('portal.meeting.survey.store', ['meeting' => $meeting->id]) }}">
                                <i class="fa-solid fa-plus me-2"></i>{{ __('common.create-first-survey') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- CRUD Forms -->
    <x-crud.form.common.create name="survey">
        @section('survey-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort" />
            <x-input.text method="c" name="title" title="title" icon="pen-field" />
            <x-input.text method="c" name="description" title="description" icon="comment-dots" />
            <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    
    <x-crud.form.common.delete name="survey" />
    
    <x-crud.form.common.edit name="survey" >
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
@endsection



