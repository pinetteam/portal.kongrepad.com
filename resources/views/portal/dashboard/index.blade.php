@extends('layout.portal.common')
@section('title', __('common.dashboard'))
@section('body')
    <div class="card bg-dark">
        <div class="card-header bg-dark text-white">
            <h1 class="m-0 text-center">{{ __('common.dashboard') }}</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-hover table-striped">
                    <tbody>
                    @foreach($meetings as $meeting)
                        <tr>
                            <td>
                                <div class="table-responsive">
                                    <table class="table table-dark table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <h4 class="m-0 p-3 text-center">{{ __('common.meeting') }} | {{ $meeting->title }}</h4>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.document.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-dark table-borderless">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td class="text-center">{{ __('common.documents') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <h4 class="text-white">{{$meeting->documents->count()}}
                                                                            </h4>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.hall.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-dark table-borderless">
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-center">{{ __('common.meeting-halls') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h4>{{$meeting->halls->count()}}</h4>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                    </span>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.participant.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-dark table-borderless">
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-center">{{ __('common.participants') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h4>{{$meeting->participants->count()}}</h4>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a class="text-white link-underline-dark" href="{{ route('portal.dashboard.meeting.program.index', $meeting->id) }} " title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-dark table-borderless">
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-center">{{ __('common.programs') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h4>{{$meeting->programs->count()}}</h4>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                    </span>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.virtual-stand.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-dark table-borderless">
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-center">{{ __('common.virtual-stands') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h4>{{$meeting->virtualStands->count()}}</h4>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                    </span>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.announcement.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-dark table-borderless">
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-center">{{ __('common.announcements') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h4> {{$meeting->announcements->count() }}</h4>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                    </span>
                                                </a>
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
                                                                    <h4>{{$meeting->programChairs()->count()}}</h4>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.survey.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-dark table-borderless">
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-center">{{ __('common.surveys') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h4>{{$meeting->surveys->count()}}</h4>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                    </span>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.score-game.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-dark table-borderless">
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-center">{{ __('common.score-games') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <h4>{{$meeting->scoreGames->count()}}</h4>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                            <td>
                                <div class="table-responsive">
                                    <table class="table table-dark table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <h4 class="m-0 p-3 text-center">{{ __('common.last-5-users')}} | {{ $meeting->title }}</h4>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($meeting->participants->take(5) as $participant)
                                            <tr>
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
                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped table-hover">
                                            <thead>
                                                <h4 class="m-0 text-center">{{ __('common.on-vote') }}</h4>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <a class="text-white link-underline-dark" href="{{ route('portal.survey-report.index') }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                        <span>
                                                            <div class="card-body p-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-dark table-borderless">
                                                                <tbody>
                                                                <tr>
                                                                    <td class="text-center">{{ __('common.survey') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <h3>{{ $meeting->surveys()->where('meeting_surveys.on_vote','1')->count() }}</h3>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                        </span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="text-white link-underline-dark" href="{{ route('portal.debate-report.index') }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                        <span>
                                                            <div class="card-body p-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-dark table-borderless">
                                                                <tbody>
                                                                <tr>
                                                                    <td class="text-center">{{ __('common.debate') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <h3>{{$meeting->debates()->where('meeting_hall_program_debates.on_vote','1')->count()}}</h3>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                        </span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="text-white link-underline-dark" href="{{ route('portal.keypad-report.index') }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                        <span>
                                                            <div class="card-body p-0">
                                                        <div class="table-responsive">
                                                            <table class="table table-dark table-borderless">
                                                                <tbody>
                                                                <tr>
                                                                    <td class="text-center">{{ __('common.keypad') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <h3>{{$meeting->keypads()->where('meeting_hall_program_session_keypads.on_vote','1')->count()}}</h3>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
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
