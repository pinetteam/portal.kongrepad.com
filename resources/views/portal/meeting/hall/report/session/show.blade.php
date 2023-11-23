@extends('layout.portal.common')
@section('title', $session->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><small>"{{ $session->title }}"</small></h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col card text-bg-dark p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped-columns table-bordered">
                            <tr>
                                <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                                <td class="text-start w-25">{{ $session->title}}</td>
                                <th scope="row" class="text-end w-25">{{ __('common.code') }}:</th>
                                <td class="text-start w-25">{{ $session->code }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-end w-25">{{ __('common.program') }}:</th>
                                <td class="text-start w-25">{{ $session->program->title}}</td>
                                <th scope="row" class="text-end w-25">{{ __('common.status') }}:</th>
                                <td class="text-start w-25">
                                    @if($session->status)
                                        {{ __('common.active') }}
                                    @else
                                        {{ __('common.passive') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-end w-25">{{ __('common.started-at') }}:</th>
                                <td class="text-start w-25">{{ $session->started_at}}</td>
                                <th scope="row" class="text-end w-25">{{ __('common.finished-at') }}:</th>
                                <td class="text-start w-25">{{ $session->finished_at }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-end w-25">{{ __('common.duration') }}:</th>
                                <td class="text-start w-25">{{ $session->duration }}</td>
                                <th scope="row" class="text-end w-25">{{ __('common.questions') }}:</th>
                                <td class="text-start w-25">{{ $session->questions()->count() }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                                <td class="text-start w-25">{{ $session->created_by_name }}</td>
                                <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                                <td class="text-start w-25">{{ $session->created_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-chart-pie fa-fade"></span> {{ __('common.keypad-reports') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span>{{ __('common.keypad') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span>{{ __('common.voting-started-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span>{{ __('common.voting-finished-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-vote-yea mx-1"></span>{{ __('common.vote-count') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    @foreach($session->keypads as $keypad)
                        <tbody>
                        <tr>
                            <td>{{ $keypad->keypad }}</td>
                            <td>
                                @if($keypad->voting_started_at)
                                    {{ $keypad->voting_started_at }}
                                @else
                                    <i class="text-info">{{__('common.unspecified')}}</i>
                                @endif
                            </td>
                            <td>
                                @if($keypad->voting_finished_at)
                                    {{ $keypad->voting_finished_at }}
                                @else
                                    <i class="text-info">{{__('common.unspecified')}}</i>
                                @endif
                            </td>
                            <td>{{ $keypad->votes->count() }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                    <a class="btn btn-info btn-sm" href="{{ route("portal.meeting.report.keypad.participants",['keypad'=>$keypad->id, 'meeting'=>$meeting->id]) }}" title="{{ __('common.participants') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.participants') }}">
                                        <span class="fa-regular fa-user"></span>
                                    </a>
                                    <a class="btn btn-success btn-sm" href="{{ route("portal.meeting.report.keypad.question",['keypad'=>$keypad->id, 'meeting'=>$meeting->id]) }}" title="{{ __('common.report') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.report') }} ">
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
