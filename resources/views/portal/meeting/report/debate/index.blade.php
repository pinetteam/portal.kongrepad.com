@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' .  __('common.debate-reports'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.debate-reports') }}</li>
@endsection
@section('meeting_content')
    <div class="card bg-kongre-secondary">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-podium-star fa-fade"></span> {{ __('common.debate-reports') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span>{{ __('common.debate-program') }}</th>
                        <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span>{{ __('common.debate') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span>{{ __('common.voting-started-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span>{{ __('common.voting-finished-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-vote-yea mx-1"></span>{{ __('common.vote-count') }}</th>
                        <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span>{{ __('common.on_vote') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    @foreach($debates as $debate)
                        <tbody>
                        <tr>
                            <td>{{ $debate->program->title }}</td>
                            <td>{{ $debate->title }}</td>
                            <td>
                                @if($debate->voting_started_at)
                                    {{ $debate->voting_started_at }}
                                @else
                                    <i class="text-info">{{__('common.unspecified')}}</i>
                                @endif
                            </td>
                            <td>
                                @if($debate->voting_finished_at)
                                    {{ $debate->voting_finished_at }}
                                @else
                                    <i class="text-info">{{__('common.unspecified')}}</i>
                                @endif
                            </td>
                            <td>{{ $debate->votes->count() }}</td>
                            <td>
                                @if($debate->on_vote)
                                    <i style="color:var(--kongre-success)" class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:var(--kongre-danger)" class="fa-regular fa-toggle-off fa-xg"></i>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                    <a class="btn btn-kongre-accent btn-sm" href="{{ route("portal.meeting.report.debate.participants",['debate'=>$debate->id, 'meeting'=> $meeting->id]) }}" title="{{ __('common.participants') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.participants') }}">
                                        <span class="fa-regular fa-user"></span>
                                    </a>
                                    <a class="btn btn-success btn-sm" href="{{ route("portal.meeting.report.debate",['debate'=>$debate->id, 'meeting'=> $meeting->id]) }}" title="{{ __('common.report') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.report') }} ">
                                        <span class="fa-regular fa-page"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection



