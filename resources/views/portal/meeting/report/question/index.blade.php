@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' .  __('common.question-reports'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}"><i class="fa-solid fa-house"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.question-reports') }}</li>
@endsection

@push('styles')
    @vite(['resources/css/meeting-pages-theme.css'])
@endpush

@section('meeting_content')
    <!-- Modern Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-hero-card">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fa-duotone fa-question fa-fade"></i>
                    </div>
                    <div class="hero-text">
                        <h1 class="hero-title">{{ __('common.question-reports') }}</h1>
                        <p class="hero-subtitle">{{ __('common.question-reports-description') ?? 'Katılımcıların sorularını ve interaktif oturumlara katılımlarını görüntüleyin.' }} - {{ $meeting->title }}</p>
                        <div class="hero-stats">
                            <span class="stat-item">
                                <i class="fa-regular fa-users me-1"></i>
                                {{ $participants->total() }} {{ __('common.total-participants') }}
                            </span>
                            <span class="stat-item">
                                <i class="fa-regular fa-question me-1"></i>
                                {{ $participants->sum(function($participant) { return $participant->sessionQuestions()->where([['is_hidden_name', 0], ['selected_for_show', 1]])->count(); }) }} {{ __('common.total-questions') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Question Reports Card -->
    <div class="row">
        <div class="col-12">
            <div class="modern-main-card">
                <div class="card-header">
                    <h3 class="card-header-title">
                        <i class="fa-duotone fa-messages-question me-2"></i>
                        {{ __('common.participant-questions') }}
                    </h3>
                    <div class="header-actions">
                        <span class="badge bg-info">
                            <i class="fa-regular fa-users me-1"></i>
                            {{ $participants->total() }} {{ __('common.participants') }}
                        </span>
                    </div>
                </div>
                
                @if($participants->count() > 0)
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="fa-regular fa-user me-2"></i>
                                            {{ __('common.name') }}
                                        </th>
                                        <th>
                                            <i class="fa-regular fa-question me-2"></i>
                                            {{ __('common.questions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participants as $participant)
                                        <tr>
                                            <td>
                                                <div class="item-name">{{ $participant->full_name }}</div>
                                            </td>
                                            <td>
                                                <span class="count-badge">{{ $participant->sessionQuestions()->where([['is_hidden_name', 0], ['selected_for_show', 1]])->count() }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    @if($participants->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $participants->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="card-body">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fa-duotone fa-question"></i>
                            </div>
                            <h4 class="empty-state-title">{{ __('common.no-questions-found') }}</h4>
                            <p class="empty-state-text">{{ __('common.no-questions-description') ?? 'Henüz hiç soru sorulmamış.' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
