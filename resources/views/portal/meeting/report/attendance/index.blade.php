@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' .  __('common.attendance-reports'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.attendance-reports') }}</li>
@endsection
@section('meeting_content')
    <div class="card bg-kongre-secondary">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-hundred-points fa-fade"></span> {{ __('common.attendance-reports') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $participant_logs->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-image mx-1"></span> {{ __('common.participant') }}</th>
                            <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.point-hours-minutes') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participant_logs as $participant_log)
                            @php
                                $time = \Carbon\Carbon::createFromTime(0, 0)->addMinutes(round($participant_log->total_actions*20/60));
                            @endphp
                            <tr>
                                <td>{{ $participant_log->participant->full_name }}</td>
                                <td>{{ $time->format('H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
