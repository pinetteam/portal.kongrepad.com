@extends('layout.portal.common')
@section('title', $hall->title . ' | ' . __('common.session-reports'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-calendar-week fa-fade"></span> <small>"{{ $hall->title }}"</small> {{ __('common.session-reports') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="card text-bg-dark mt-2">
                <div class="table-responsive overflow-x-auto">
                    <table class="table table-dark table-striped table-hover">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"><span class="fa-regular fa-circle-sort mx-1"></span> {{ __('common.sort') }}</th>
                            <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-image mx-1"></span> {{ __('common.logo') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}</th>
                        </tr>
                        </thead>
                        @foreach($programs as $program)
                            <tbody>
                            <tr>
                                <td rowspan="2"></td>
                                <td rowspan="1">
                                    @if($program->sort_order)
                                        {{ $program->sort_order }}
                                    @else
                                        <i class="text-info">{{ __('common.unspecified') }}</i>
                                    @endif
                                </td>
                                <td rowspan="1">{{ $program->title }}</td>
                                <td rowspan="1">
                                    @if(isset($program->logo_name))
                                        <img src="{{ asset('storage/program-logos/' . $program->logo_name . '.' . $program->logo_extension) }}" alt="{{ $program->title }}"
                                             class="img-thumbnail" style="height:36px;"/>
                                    @else
                                        <i class="text-info">{{ __('common.unspecified') }}</i>
                                    @endif
                                </td>
                                <td rowspan="1">{{ $program->start_at }}</td>
                                <td rowspan="1">{{ $program->finish_at }}</td>
                                <td rowspan="1">{{ __('common.'.$program->type) }}</td>
                            </tr>
                            @if($program->sessions()->count() > 0 || $program->debates()->count() > 0)
                                <tr>
                                    <td rowspan="1" colspan="10">
                                        @if($program->sessions()->count() > 0)
                                            <div class="table-responsive w-100 overflow-x-auto">
                                                <table class="table table-dark table-striped table-hover">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">{{ __('common.speaker') }}</th>
                                                        <th scope="col">{{ __('common.sort') }}</th>
                                                        <th scope="col">{{ __('common.title') }}</th>
                                                        <th scope="col">{{ __('common.started-at') }}</th>
                                                        <th scope="col">{{ __('common.finished-at') }}</th>
                                                        <th scope="col">{{ __('common.duration') }}</th>
                                                        <th scope="col" class="text-end"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($program->sessions()->get() as $program_session)
                                                        <tr>
                                                            <td>
                                                                @if($program_session->speaker)
                                                                    {{ $program_session->speaker->full_name }}
                                                                @else
                                                                    <i class="text-info">{{ __('common.unspecified') }}</i>
                                                                @endif
                                                            </td>
                                                            <td>{{ $program_session->sort_order }}</td>
                                                            <td>{{ $program_session->title }}</td>
                                                            <td>{{ $program_session->started_at }}</td>
                                                            <td>{{ $program_session->finished_at }}</td>
                                                            <td>{{ $program_session->duration }}</td>
                                                            <td class="text-end">
                                                                <div class="btn-group" role="group"
                                                                     aria-label="{{ __('common.processes') }}">
                                                                    <a class="btn btn-warning btn-sm" href="{{ route('portal.meeting.hall.report.session.question.index', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'session' => $program_session->id]) }}" title="{{ __('common.questions') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.questions') }}">
                                                                        <span class="fa-regular fa-question"></span>
                                                                    </a>
                                                                    <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.report.session.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'session' => $program_session->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                                        <span class="fa-regular fa-page"></span>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                        @if($program->debates()->count() > 0)
                                            <div class="table-responsive w-100">
                                                <table class="table table-dark table-striped table-hover">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">{{ __('common.sort') }}</th>
                                                        <th scope="col">{{ __('common.title') }}</th>
                                                        <th scope="col">{{ __('common.voting-started-at') }}</th>
                                                        <th scope="col">{{ __('common.voting-finished-at') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($program->debates()->get() as $debate)
                                                        <tr>
                                                            <td>{{ $debate->sort_order }}</td>
                                                            <td>{{ $debate->title }}</td>
                                                            <td>{{ $debate->voting_started_at }}</td>
                                                            <td>{{ $debate->voting_finished_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
