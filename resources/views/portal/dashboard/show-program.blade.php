@extends('layout.portal.common')
@section('title', $meeting->title . ' | ' . __('common.programs'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-newspaper fa-fade"></span> <small>"{{ $meeting->title }}"</small> {{ __('common.programs') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="card text-bg-dark mt-2">
                <div class="relative overflow-x-auto">
                    <table class="w-full table table-dark table-striped table-hover">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"><span class="fa-regular fa-circle-sort mx-1"></span> {{ __('common.sort') }}</th>
                            <th scope="col"><span class="fa-regular fa-code-simple mx-1"></span> {{ __('common.code') }}</th>
                            <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-image mx-1"></span> {{ __('common.logo') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                        </thead>
                        @foreach($programs as $program)
                            <tbody>
                            <tr>
                                <td rowspan="2" style="width: 2%"></td>
                                <td rowspan="1">
                                    @if($program->sort_order)
                                        {{ $program->sort_order }}
                                    @else
                                        <i class="text-info">{{ __('common.unspecified') }}</i>
                                    @endif
                                </td>
                                <td rowspan="1">{{ $program->code }}</td>
                                <td rowspan="1">{{ $program->title }}</td>
                                <td rowspan="1">
                                    @if($program->logo)
                                        <img src="{{ $program->logo }}" alt="{{ $program->title }}"
                                             class="img-thumbnail" style="height:36px;"/>
                                    @else
                                        <i class="text-info">{{ __('common.unspecified') }}</i>
                                    @endif
                                </td>
                                <td rowspan="1">{{ $program->start_at }}</td>
                                <td rowspan="1">{{ $program->finish_at }}</td>
                                <td rowspan="1">{{ __('common.'.$program->type) }}</td>
                                <td rowspan="1">
                                    @if($program->status)
                                        <i style="color:green"
                                           class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td rowspan="1" class="text-end">
                                    <div class="btn-group" role="group"
                                         aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.program.show', ['meeting' => $meeting->id, 'hall' => $program->hall->id, 'program' => $program->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @if($program->sessions()->count() > 0 || $program->debates()->count() > 0)
                                <tr>
                                    <td rowspan="1" colspan="10">
                                        @if($program->sessions()->count() > 0)
                                            <div class="relative overflow-x-auto">
                                                <table class="table table-dark table-striped table-hover">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">{{ __('common.speaker') }}</th>
                                                        <th scope="col">{{ __('common.document') }}</th>
                                                        <th scope="col">{{ __('common.sort') }}</th>
                                                        <th scope="col">{{ __('common.code') }}</th>
                                                        <th scope="col">{{ __('common.title') }}</th>
                                                        <th scope="col">{{ __('common.start-at') }}</th>
                                                        <th scope="col">{{ __('common.finish-at') }}</th>
                                                        <th scope="col">{{ __('common.questions') }}</th>
                                                        <th scope="col">{{ __('common.question-limit') }}</th>
                                                        <th scope="col">{{ __('common.status') }}</th>
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
                                                            <td>
                                                                @if($program_session->document_id)
                                                                    <a href="{{ route('portal.meeting.document.download', ['meeting' => $program->hall->meeting_id, 'document' => $program_session->document_id] ) }}" class="btn btn-sm btn-info w-100" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.view') }}">
                                                                        <span class="fa-regular fa-file-arrow-down"></span> {{ $program_session->document->title }}
                                                                    </a>
                                                                @else
                                                                    <i class="text-info">{{ __('common.unspecified') }}</i>
                                                                @endif
                                                            </td>
                                                            <td>{{ $program_session->sort_order }}</td>
                                                            <td>{{ $program_session->code }}</td>
                                                            <td>{{ $program_session->title }}</td>
                                                            <td>{{ $program_session->start_at }}</td>
                                                            <td>{{ $program_session->finish_at }}</td>
                                                            <td>
                                                                @if($program_session->questions_allowed)
                                                                    <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                                                @else
                                                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                                                @endif
                                                            </td>
                                                            <td>{{ $program_session->questions_limit }}</td>
                                                            <td>
                                                                @if($program_session->status)
                                                                    <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                                                @else
                                                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                                                @endif
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="btn-group" role="group"
                                                                     aria-label="{{ __('common.processes') }}">
                                                                    <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.program.session.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $program_session->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                                        <span class="fa-regular fa-eye"></span>
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
                                                        <th scope="col">{{ __('common.code') }}</th>
                                                        <th scope="col">{{ __('common.title') }}</th>
                                                        <th scope="col">{{ __('common.description') }}</th>
                                                        <th scope="col">{{ __('common.voting-started-at') }}</th>
                                                        <th scope="col">{{ __('common.voting-finished-at') }}</th>
                                                        <th scope="col">{{ __('common.status') }}</th>
                                                        <th scope="col" class="text-end"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($program->debates()->get() as $debate)
                                                        <tr>
                                                            <td>{{ $debate->sort_order }}</td>
                                                            <td>{{ $debate->code }}</td>
                                                            <td>{{ $debate->title }}</td>
                                                            <td>{{ $debate->description }}</td>
                                                            <td>{{ $debate->voting_started_at }}</td>
                                                            <td>{{ $debate->voting_finished_at }}</td>
                                                            <td>
                                                                @if($debate->status)
                                                                    <i style="color:green"
                                                                       class="fa-regular fa-toggle-on fa-xg"></i>
                                                                @else
                                                                    <i style="color:red"
                                                                       class="fa-regular fa-toggle-off fa-xg"></i>
                                                                @endif
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                                    <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.program.debate.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                                        <span class="fa-regular fa-eye"></span>
                                                                    </a>
                                                                </div>
                                                            </td>
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

