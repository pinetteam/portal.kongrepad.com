@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' .  __('common.survey-reports'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.survey-reports') }}</li>
@endsection
@section('meeting_content')
    <div class="card bg-kongre-secondary">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-square-poll-horizontal fa-fade px-3 "></span> {{ __('common.surveys') }}</h1>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $surveys->links() }}
                    </caption>
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-bee mx-1"></span> {{ __('common.meeting') }}</th>
                        <th scope="col"><span class="fa-regular fa-pen-field mx-1"></span> {{ __('common.title') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.question-count') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.total-participants') }}</th>
                        <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.on_vote') }}</th>
                        <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($surveys as $survey)
                        <tr>
                            <td>{{ $survey->meeting->title }}</td>
                            <td>{{ $survey->title }}</td>
                            <td>
                                @if($survey->start_at)
                                    {{ $survey->start_at }}
                                @else
                                    <i class="text-info">{{ __('common.unspecified') }}</i>
                                @endif
                            </td>
                            <td>
                                @if($survey->finish_at)
                                    {{ $survey->finish_at }}
                                @else
                                    <i class="text-info">{{ __('common.unspecified') }}</i>
                                @endif
                            </td>
                            <td>{{ $survey->questions->count() }}</td>
                            <td>{{ $survey->votes->groupBy('participant_id')->count() }}</td>
                            <td>
                                @if($survey->on_vote)
                                    <i style="color:var(--kongre-success)" class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:var(--kongre-danger)" class="fa-regular fa-toggle-off fa-xg"></i>
                                @endif
                            </td>
                            <td>
                                @if($survey->status)
                                    <i style="color:var(--kongre-success)" class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:var(--kongre-danger)" class="fa-regular fa-toggle-off fa-xg"></i>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                    <a class="btn btn-kongre-accent btn-sm" href="{{ route("portal.meeting.report.survey.participants",['survey'=>$survey->id, 'meeting'=>$survey->meeting->id]) }}" title="{{ __('common.participants') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.participants') }}">
                                        <span class="fa-regular fa-user"></span>
                                    </a>
                                    <a class="btn btn-success btn-sm" href="{{ route("portal.meeting.report.survey",['survey'=>$survey->id, 'meeting'=>$survey->meeting->id]) }}" title="{{ __('common.report') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.report') }} ">
                                        <span class="fa-regular fa-page"></span>
                                    </a>
                                    <a class="btn btn-kongre-accent btn-sm" href="{{ route("service.survey-report.start",['survey'=>$survey->id]) }}" title="{{ __('common.screen') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.screen') }} ">
                                        <span class="fa-regular fa-presentation-screen"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection



