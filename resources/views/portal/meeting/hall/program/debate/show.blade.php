@extends('layout.portal.common')
@section('title', $debate->title . ' | ' . __('common.debate'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none text-white">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $debate->program->hall->meeting->id) }}" class="text-decoration-none text-white">{{ $debate->program->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $debate->program->hall->meeting->id]) }}" class="text-decoration-none text-white">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $debate->program->hall->meeting->id, 'hall' => $debate->program->hall->id]) }}" class="text-decoration-none text-white">{{ $debate->program->hall->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.program.index', ['meeting' => $debate->program->hall->meeting->id, 'hall' => $debate->program->hall->id]) }}" class="text-decoration-none text-white">{{ __('common.programs') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.program.show', ['meeting' => $debate->program->hall->meeting->id, 'hall' => $debate->program->hall->id, 'program' => $debate->program->id]) }}" class="text-decoration-none text-white">{{ $debate->program->title }}</a></li>
    <li class="breadcrumb-item active text-white text-decoration-underline" aria-current="page">{{ $debate->title }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-face-party fa-fade"></span> {{'"' .$debate->title. '"'}}</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col card text-bg-dark p-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped-columns table-bordered">
                                <tr>
                                    <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                                    <td class="text-start w-25">{{ $debate->title}}</td>
                                    <th scope="row" class="text-end w-25">{{ __('common.code') }}:</th>
                                    <td class="text-start w-25">{{ $debate->code }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-25">{{ __('common.program') }}:</th>
                                    <td class="text-start w-25">{{ $debate->program->title}}</td>
                                    <th scope="row" class="text-end w-25">{{ __('common.status') }}:</th>
                                    <td class="text-start w-25">
                                        @if($debate->status)
                                            {{ __('common.active') }}
                                        @else
                                            {{ __('common.passive') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-25">{{ __('common.voting-started-at') }}:</th>
                                    <td class="text-start w-25">{{ $debate->voting_started_at}}</td>
                                    <th scope="row" class="text-end w-25">{{ __('common.voting-finished-at') }}:</th>
                                    <td class="text-start w-25">{{ $debate->voting_finished_at }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                                    <td class="text-start w-25">{{ $debate->created_by_name }}</td>
                                    <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                                    <td class="text-start w-25">{{ $debate->created_at }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col card text-bg-dark p-0 mt-2">
        <div class="card-header">
            <h2 class="m-0 text-center h3">{{ __('common.teams') }}</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-image mx-1"></span> {{ __('common.logo') }}</th>
                        <th scope="col"><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.code') }}</th>
                        <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.title') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($debate->teams as $team)
                        <tr>
                            <td>
                                @if(isset($team->logo_name))
                                    <img src="{{ asset('storage/team-logos/' . $team->logo_name . '.' . $team->logo_extension) }}" alt="{{ $team->title }}"
                                         class="img-thumbnail" style="height:36px;"/>
                                @else
                                    <i class="text-info">{{ __('common.unspecified') }}</i>
                                @endif
                            </td>
                            <td>{{ $team->code }}</td>
                            <td>{{ $team->title }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                    <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.program.debate.team.show', ['meeting' => $debate->program->hall->meeting_id, 'hall' => $debate->program->hall->id, 'program' => $debate->program_id, 'debate' => $debate->id, 'team' => $team->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                        <span class="fa-regular fa-eye"></span>
                                    </a>
                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                        <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#team-edit-modal" data-route="{{ route('portal.meeting.hall.program.debate.team.update', ['meeting' => $debate->program->hall->meeting_id, 'hall' => $debate->program->hall->id, 'program' => $debate->program_id, 'debate' => $debate->id, 'team' => $team->id]) }}" data-resource="{{ route('portal.meeting.hall.program.debate.team.edit', ['meeting' => $debate->program->hall->meeting_id, 'hall' => $debate->program->hall->id, 'program' => $debate->program_id, 'debate' => $debate->id, 'team' => $team->id]) }}" data-id="{{ $team->id }}">
                                            <span class="fa-regular fa-pen-to-square"></span>
                                        </button>
                                    </div>
                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                        <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#team-delete-modal" data-route="{{ route('portal.meeting.hall.program.debate.team.destroy', ['meeting' => $debate->program->hall->meeting_id, 'hall' => $debate->program->hall->id, 'program' => $debate->program_id, 'debate' => $debate->id, 'team' => $team->id]) }}" data-record="{{ $team->title }}">
                                            <span class="fa-regular fa-trash"></span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#team-create-modal" data-route="{{ route('portal.meeting.hall.program.debate.team.store', ['meeting' => $debate->program->hall->meeting_id, 'hall' => $debate->program->hall_id, 'program' => $debate->program_id, 'debate' => $debate->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.add-new-team') }}
            </button>
        </div>
        <x-crud.form.common.create name="team">
            @section('team-create-form')
                <x-input.hidden method="c" name="debate_id" :value="$debate->id" />
                <x-input.text method="c" name="code" title="code" icon="code-simple" />
                <x-input.file method="c" name="logo" title="logo" icon="image" />
                <x-input.text method="c" name="title" title="title" icon="input-text" />
                <x-input.text method="c" name="description" title="description" icon="comment-dots" />
            @endsection
        </x-crud.form.common.create>
        <x-crud.form.common.delete name="team" />
        <x-crud.form.common.edit name="team">
            @section('team-edit-form')
                <x-input.hidden method="e" name="debate_id" :value="$debate->id" />
                <x-input.text method="e" name="code" title="code" icon="code-simple" />
                <x-input.file method="e" name="logo" title="logo" icon="image" />
                <x-input.text method="e" name="title" title="title" icon="input-text" />
                <x-input.text method="e" name="description" title="description" icon="comment-dots" />
            @endsection
        </x-crud.form.common.edit>
    </div>
@endsection
