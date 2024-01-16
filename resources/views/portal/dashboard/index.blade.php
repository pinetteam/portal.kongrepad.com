@extends('layout.portal.common')
@section('title', __('common.dashboard'))
@section('body')
    <div class="card bg-dark">
        <div class="card-header bg-dark text-white border-dark">
            <h1 class="m-0 text-center">{{ __('common.dashboard') }}</h1>
        </div>
        <div class="card-body mt-2">
            <div class="container text-center">
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-xs-1 row-gap-5">
                    @foreach($meetings as $meeting)
                        <div class="row w-100">
                            <h4 class="pb-3 text-white text-center">{{ __('common.meeting') }} | {{ $meeting->title }}</h4>
                        </div>
                        <div class="col border-2">
                            <div class="card bg-dark border-dark">
                                <div class="card-block">
                                    <div class="container text-center">
                                        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-xs-1 g-2">
                                            <div class="col border-2">
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.document.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0 shadow">
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
                                            </div>
                                            <div class="col border-2">
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.participant.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0 shadow">
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
                                            </div>
                                            <div class="col border-2">
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.announcement.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0 shadow">
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
                                            </div>
                                            <div class="col border-2">
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.survey.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0 shadow">
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
                                            </div>
                                            <div class="col border-2">
                                                <a class="text-white link-underline-dark" href="{{ route('portal.meeting.score-game.index', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                    <span>
                                                        <div class="card-body p-0 shadow">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col border-2">
                             <div class="card bg-dark border-dark">
                                 <div class="card-body mb-3">
                                     <div class="container text-center">
                                         <div class="row row-cols-1 g-2">
                                             @foreach($meeting->halls as $hall)
                                                 <div class="col">
                                                  <span>
                                                       <div class="card-block p-0 shadow">
                                                             <div class="table-responsive">
                                                                 <table class="table table-dark table-borderless">
                                                                     <tbody>
                                                                        <tr>
                                                                            <td> {{$hall->title}} </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <a class="btn btn-info btn-sm" href="{{ route('service.operator-board.start', ['code' => $hall->code, 'program_order' => 0]) }}" title="{{ __('common.operator-board') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.operator-board') }}">
                                                                                    <span class="fa-regular fa-rectangles-mixed"></span>
                                                                                </a>
                                                                                <a class="btn btn-warning btn-sm" href="{{ route('service.screen-board.start', ['code' => $hall->code]) }}" title="{{ __('common.screen-board') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.screen-board') }}">
                                                                                    <span class="fa-regular fa-screen-users"></span>
                                                                                </a>
                                                                                <a class="btn btn-success btn-sm" href="{{ route('service.question-board.start', ['code' => $hall->code]) }}" title="{{ __('common.question-board') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.question-board') }}">
                                                                                    <span class="fa-regular fa-question"></span>
                                                                                </a>
                                                                                <a class="btn btn-secondary btn-sm" href="{{ route('portal.meeting.hall.screen.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" title="{{ __('common.screens') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.screens') }}">
                                                                                    <span class="fa-duotone fa-presentation-screen"></span>
                                                                                </a>
                                                                                <a class="btn btn-primary btn-sm" href="{{ route('portal.meeting.hall.program.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" title="{{ __('common.progams') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.programs') }}">
                                                                                    <span class="fa-regular fa-calendar-week"></span>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                     </tbody>
                                                                 </table>
                                                             </div>
                                                         </div>
                                                  </span>
                                                 </div>
                                             @endforeach
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                        <hr class="text-bg-primary w-100">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
