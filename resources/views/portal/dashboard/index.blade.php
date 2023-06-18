@extends('layout.portal.common')
@section('title', __('common.dashboard'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.dashboard') }}</h1>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-sm-2 flex-shrink-0 g-2">
                <div class="col">
                @foreach($meetings as $meeting)
                    @if($meeting->halls()->where('status','1')->count()>0)
                    <div class="card text-bg-dark">
                        <div class="card-header">
                            <h3 class="m-0 text-center">{{ $meeting->title }} | {{ __('common.meeting-halls') }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-dark table-striped table-hover">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                                        <th scope="col" class="text-end"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($meeting->halls()->where('status','1')->get() as $meeting_hall)
                                        <tr>
                                            <td>{{ $meeting_hall->title }}</td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                    <a class="btn btn-success btn-sm" href="{{ route('portal.operator-board.index',[ $meeting_hall->id, 0]) }}" title="{{ __('common.operator-board') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.operator-board') }}">
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
                    @endif
                @endforeach
                    <div class="card text-bg-dark">
                        <div class="card-header">
                            <h3 class="m-0 text-center">{{ __('common.last-users') }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-dark table-striped table-hover">

                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col"><span class="fa-regular fa-bee mx-1"></span> {{ __('common.meeting') }}</th>
                                        <th scope="col"><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.name') }}</th>
                                        <th scope="col"><span class="fa-regular fa-right-to-bracket mx-1"></span> {{ __('common.last-login') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($participants as $participant)
                                        <tr>
                                            <td>{{ $participant->meeting->title }}</td>
                                            <td>
                                                @if($participant->activity_status)
                                                    <div class="spinner-grow spinner-grow-sm text-success" role="status"></div>
                                                @else
                                                    <div class="spinner-border spinner-border-sm text-danger" role="status"></div>
                                                @endif
                                                {{ $participant->full_name }}
                                            </td>
                                            <td>{{ $participant->last_login }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.statistics') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ __('common.documents') }}</td>
                                    <td>{{$document_count}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.meeting-halls') }}</td>
                                    <td>{{$meeting_hall_count}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.participants') }}</td>
                                    <td>{{$participant_count}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.programs') }}</td>
                                    <td>{{$program_count}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.sessions') }}</td>
                                    <td>{{$session_count}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.debates') }}</td>
                                    <td>{{$debate_count}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.chairs') }}</td>
                                    <td>{{$chair_count}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.surveys') }}</td>
                                    <td>{{$survey_count}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.score-games') }}</td>
                                    <td>{{$score_game_count}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
