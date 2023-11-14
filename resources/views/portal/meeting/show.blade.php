@extends('layout.portal.common')
@section('title', $meeting->title . ' | ' . __('common.meeting'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center"><span class="fa-duotone fa-bee fa-fade"></span> <small>"{{ $meeting->title }}"</small> {{ __('common.meeting') }}</h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        @if(isset($meeting->banner_name) && isset($meeting->banner_extension))
                            <img src="{{ asset('storage/meeting-banners/' . $meeting->banner_name . '.' . $meeting->banner_extension) }}" alt="{{ $meeting->title }}" width="720" height="180">
                        @else
                            <i class="text-info">{{ __('common.unspecified') }}</i>
                        @endif
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.code') }}:</th>
                        <td class="text-start w-25">{{ $meeting->code }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.meeting-title') }}:</th>
                        <td class="text-start w-25">
                            @if($meeting->status)
                                <i style="color:green" class="fa-regular fa-toggle-on"></i>
                            @else
                                <i style="color:red" class="fa-regular fa-toggle-off"></i>
                            @endif
                            {{ $meeting->title }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.start-at') }}:</th>
                        <td class="text-start w-25">{{ $meeting->start_at }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.finish-at') }}:</th>
                        <td class="text-start w-25">{{ $meeting->finish_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                        <td class="text-start w-25">{{ $meeting->created_by }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                        <td class="text-start w-25">{{ $meeting->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 gy-3 py-3">
                    <div class="col">
                        <div class="card text-bg-dark">
                            <div class="card-header">
                                <h1 class="m-0 text-center"><span class="badge text-bg-dark">1.</span> {{ __('common.preparation') }}</h1>
                            </div>
                            <div class="card-body">
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.document.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                                    <span class="fa-duotone fa-presentation-screen"></span> {{ __('common.documents') }}
                                </a>
                                <hr />
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.participant.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                                    <span class="fa-duotone fa-screen-users"></span> {{ __('common.participants') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-bg-dark">
                            <div class="card-header">
                                <h1 class="m-0 text-center"><span class="badge text-bg-dark">2.</span> {{ __('common.event-and-activity') }}</h1>
                            </div>
                            <div class="card-body">
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.announcement.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                                    <span class="fa-duotone fa-megaphone"></span> {{ __('common.announcements') }}
                                </a>
                                <hr />
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.score-game.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                                    <span class="fa-duotone fa-hundred-points"></span>
                                    {{ __('common.score-games') }}
                                </a>
                                <hr />
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.survey.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                                    <span class="fa-duotone fa-square-poll-horizontal"></span> {{ __('common.surveys') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-bg-dark">
                            <div class="card-header">
                                <h1 class="m-0 text-center"><span class="badge text-bg-dark">3.</span> {{ __('common.environment') }}</h1>
                            </div>
                            <div class="card-body">
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.hall.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                                    <span class="fa-duotone fa-hotel"></span> {{ __('common.halls') }}
                                </a>
                                <hr />
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.virtual-stand.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                                    <span class="fa-duotone fa-browser"></span> {{ __('common.virtual-stands') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-bg-dark">
                            <div class="card-header">
                                <h1 class="m-0 text-center"><span class="badge text-bg-dark">4.</span> {{ __('common.reports') }}</h1>
                            </div>
                            <div class="card-body">
                                <a class="btn btn-outline-light btn-lg w-100" href="#">
                                    <span class="nav-icon fa-duotone fa-chart-user fa-fade"></span>
                                    {{ __('common.registration-reports') }}
                                </a>
                                <hr />
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route("portal.meeting.report.survey.index", ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-option fa-fade"></span>
                                    {{ __('common.survey-reports') }}
                                </a>
                                <hr />
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route("portal.meeting.report.keypad.index", ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-chart-pie fa-fade"></span>
                                    {{ __('common.keypad-reports') }}
                                </a>
                                <hr />
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route("portal.meeting.report.debate.index", ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-podium-star fa-fade"></span>
                                    {{ __('common.debate-reports') }}
                                </a>
                                <hr />
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route("portal.meeting.report.score-game.index", ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-hundred-points fa-fade"></span>
                                    {{ __('common.score-game-reports') }}
                                </a>
                                <hr />
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route("portal.meeting.report.question.index", ['meeting' => $meeting->id]) }}">
                                    <span class="nav-icon fa-duotone fa-question fa-fade"></span>
                                    {{ __('common.question-reports') }}
                                </a>
                                <hr />
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.hall.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                                    <span class="fa-duotone fa-hotel"></span> {{ __('common.halls') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
