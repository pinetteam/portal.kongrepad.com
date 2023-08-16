@extends('layout.portal.common')
@section('title', __('common.dashboard'))
@section('body')
    <div class="card bg-dark">
        <div class="card-header bg-dark text-white">
            <h1 class="m-0 text-center">{{ __('common.dashboard') }}</h1>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-sm-2 flex-shrink-0 g-2">
                <div class="col">
                    <div class="card text-bg-dark">
                        <div class="card-header">
                            <h4 class="m-0 text-center">{{ __('common.meetings') }}</h4>
                        </div>
                        @foreach($meetings as $meeting)
                            @if($meeting->halls()->where('status','1')->count()>0)
                                <div class="card text-bg-dark mx-4 my-2">
                                    <div class="card-header">
                                        <h4 class="m-0 text-center">{{ $meeting->title }} | {{ __('common.meeting-halls') }}</h4>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-dark table-striped table-hover">
                                        <tbody>
                                        <tr>
                                            @foreach($meeting->halls()->where('status','1')->get() as $meeting_hall)
                                                <td>
                                                    <div class="card-body p-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-dark table-borderless">
                                                                <tbody>
                                                                <tr>
                                                                    <th>{{ $meeting_hall->title }}</th>
                                                                    <th class="text-end">
                                                                        <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                                            <a class="btn btn-success btn-sm" href="#" title="{{ __('common.operator-board') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.operator-board') }}">
                                                                                <span class="fa-regular fa-presentation-screen"></span>
                                                                            </a>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="card text-bg-dark mt-2">
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
                <div class="col">
                    <div class="card text-bg-dark">
                        <div class="card-header">
                            <h4 class="m-0 text-center">{{ __('common.statistics') }}</h4>
                        </div>
                        <div class="card text-bg-dark mx-4 my-2">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover">
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.documents') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$document_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.meeting-halls') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$meeting_hall_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.participants') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$participant_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.programs') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$program_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.sessions') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$session_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.debates') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$debate_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.chairs') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$chair_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.surveys') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$survey_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.score-games') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$score_game_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                    <div class="card text-bg-dark mt-2">
                        <div class="card-header">
                            <h4 class="m-0 text-center">{{ __('common.on-vote') }}</h4>
                        </div>
                        <div class="card text-bg-dark mt-2 mx-3">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover">
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.survey') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$on_vote_survey_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.debate') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$on_vote_debate_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-borderless">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">{{ __('common.keypad') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h3>{{$on_vote_keypad_count}}</h3>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
