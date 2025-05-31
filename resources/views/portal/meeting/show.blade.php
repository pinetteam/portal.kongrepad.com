@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.meeting'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $meeting->title }}</li>
@endsection
@section('meeting_content')
    <div class="card meeting-info-banner">
        <div class="card-header">
            <h1 class="text-center"><span class="fa-duotone fa-bee fa-fade"></span> {{ $meeting->title }}</h1>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                @if(isset($meeting->banner_name) && isset($meeting->banner_extension))
                    <div class="col-12 mb-4">
                        <img class="img-fluid rounded shadow-sm" src="{{ asset('storage/meeting-banners/' . $meeting->banner_name . '.' . $meeting->banner_extension) }}" alt="{{ $meeting->title }}">
                    </div>
                @endif
                
                <div class="col-md-6">
                    <div class="card bg-kongre-secondary border-kongre mb-3">
                        <div class="card-header bg-transparent border-kongre">
                            <h5 class="m-0"><i class="fa-duotone fa-circle-info me-2 text-kongre-light"></i>{{ __('common.meeting_info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-label">{{ __('common.meeting-title') }}:</label>
                                <div class="text-value">
                                    @if($meeting->status)
                                        <i style="color:var(--kongre-success)" class="fa-regular fa-toggle-on me-2"></i>
                                    @else
                                        <i style="color:var(--kongre-danger)" class="fa-regular fa-toggle-off me-2"></i>
                                    @endif
                                    {{ $meeting->title }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-label">{{ __('common.type') }}:</label>
                                <div class="text-value">{{ __('common.' . $meeting->type) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card bg-kongre-secondary border-kongre mb-3">
                        <div class="card-header bg-transparent border-kongre">
                            <h5 class="m-0"><i class="fa-duotone fa-calendar-days me-2 text-kongre-light"></i>{{ __('common.schedule') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-label">{{ __('common.start-at') }}:</label>
                                <div class="text-value">{{ $meeting->start_at }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="text-label">{{ __('common.finish-at') }}:</label>
                                <div class="text-value">{{ $meeting->finish_at }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card bg-kongre-secondary border-kongre">
                        <div class="card-header bg-transparent border-kongre">
                            <h5 class="m-0"><i class="fa-duotone fa-user-gear me-2 text-kongre-light"></i>{{ __('common.creation_details') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-label">{{ __('common.created-by') }}:</label>
                                <div class="text-value">{{ $meeting->created_by }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="text-label">{{ __('common.created-at') }}:</label>
                                <div class="text-value">{{ $meeting->created_at }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card bg-kongre-secondary border-kongre">
                        <div class="card-header bg-transparent border-kongre">
                            <h5 class="m-0"><i class="fa-duotone fa-chart-simple me-2 text-kongre-light"></i>{{ __('common.statistics') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border-end border-kongre">
                                        <div class="stats-value">{{$meeting->participants->count()}}</div>
                                        <div class="stats-label">{{ __('common.participants') }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-end border-kongre">
                                        <div class="stats-value">{{$meeting->halls->count()}}</div>
                                        <div class="stats-label">{{ __('common.halls') }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div>
                                        <div class="stats-value">{{$meeting->documents->count()}}</div>
                                        <div class="stats-label">{{ __('common.documents') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
