@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.meeting'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $meeting->title }}</li>
@endsection
@section('meeting_content')
    <!-- Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden bg-dark">
                <div class="card-body text-white position-relative py-4">
                    @if(isset($meeting->banner_name) && isset($meeting->banner_extension))
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ asset('storage/meeting-banners/' . $meeting->banner_name . '.' . $meeting->banner_extension) }}'); background-size: cover; background-position: center; opacity: 0.2;"></div>
                    @endif
                    <div class="position-relative">
                        <div class="d-flex align-items-center mb-3">
                            @if($meeting->status)
                                <span class="badge bg-success me-3 px-3 py-2"><i class="fa-solid fa-broadcast-tower me-1"></i>LIVE</span>
                            @else
                                <span class="badge bg-secondary me-3 px-3 py-2"><i class="fa-solid fa-clock me-1"></i>OFFLINE</span>
                            @endif
                            <small class="text-white-50">{{ __('common.' . $meeting->type) }}</small>
                        </div>
                        <h2 class="mb-2 fw-bold text-white">{{ $meeting->title }}</h2>
                        <p class="mb-0 text-white-75">
                            <i class="fa-solid fa-calendar-alt me-2"></i>{{ $meeting->start_at }} - {{ $meeting->finish_at }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="rounded-circle bg-primary p-3">
                            <i class="fa-solid fa-users text-white fa-lg"></i>
                        </div>
                    </div>
                    <h4 class="mb-1 fw-bold text-primary">{{ $meeting->participants->count() }}</h4>
                    <small class="text-muted">{{ __('common.participants') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="rounded-circle bg-success p-3">
                            <i class="fa-solid fa-building text-white fa-lg"></i>
                        </div>
                    </div>
                    <h4 class="mb-1 fw-bold text-success">{{ $meeting->halls->count() }}</h4>
                    <small class="text-muted">{{ __('common.halls') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="rounded-circle bg-info p-3">
                            <i class="fa-solid fa-file-lines text-white fa-lg"></i>
                        </div>
                    </div>
                    <h4 class="mb-1 fw-bold text-info">{{ $meeting->documents->count() }}</h4>
                    <small class="text-muted">{{ __('common.documents') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="rounded-circle bg-warning p-3">
                            <i class="fa-solid fa-poll text-white fa-lg"></i>
                        </div>
                    </div>
                    <h4 class="mb-1 fw-bold text-warning">{{ $meeting->surveys->count() ?? 0 }}</h4>
                    <small class="text-muted">{{ __('common.surveys') }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Section -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-0 pb-3">
                    <h5 class="card-title mb-0 d-flex align-items-center text-dark">
                        <i class="fa-solid fa-circle-info text-primary me-2"></i>
                        {{ __('common.meeting_info') }}
                    </h5>
                </div>
                <div class="card-body bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted text-uppercase fw-semibold">{{ __('common.meeting-title') }}</small>
                                <p class="mb-0 fw-medium text-dark">{{ $meeting->title }}</p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted text-uppercase fw-semibold">{{ __('common.type') }}</small>
                                <p class="mb-0 fw-medium text-dark">{{ __('common.' . $meeting->type) }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted text-uppercase fw-semibold">{{ __('common.start-at') }}</small>
                                <p class="mb-0 fw-medium text-dark">{{ $meeting->start_at }}</p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted text-uppercase fw-semibold">{{ __('common.finish-at') }}</small>
                                <p class="mb-0 fw-medium text-dark">{{ $meeting->finish_at }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0 pb-3">
                    <h5 class="card-title mb-0 d-flex align-items-center text-dark">
                        <i class="fa-solid fa-user-gear text-secondary me-2"></i>
                        {{ __('common.creation_details') }}
                    </h5>
                </div>
                <div class="card-body bg-white">
                    <div class="mb-3">
                        <small class="text-muted text-uppercase fw-semibold">{{ __('common.created-by') }}</small>
                        <p class="mb-0 fw-medium text-dark">{{ $meeting->created_by }}</p>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted text-uppercase fw-semibold">{{ __('common.created-at') }}</small>
                        <p class="mb-0 fw-medium text-dark">{{ $meeting->created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
