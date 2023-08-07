@extends('layout.portal.common')
@section('title', $meeting->title .' | ' . __('common.meeting'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center"><span class="fa-duotone fa-bee fa-fade"></span> <small>"{{ $meeting->title }}"</small> {{ __('common.meeting') }}</h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
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
                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 gy-3 py-3">
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
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.survey.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                                    <span class="fa-duotone fa-square-poll-horizontal"></span> {{ __('common.surveys') }}
                                </a>
                                <hr />
                                <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.score-game.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                                    <span class="fa-duotone fa-hundred-points"></span>
                                    {{ __('common.score-game') }}
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
