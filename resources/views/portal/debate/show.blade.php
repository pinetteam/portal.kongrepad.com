@extends('layout.portal.common')
@section('title', __('common.debate').' | '.$debate->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.debate').' | '.$debate->title }}</h1>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-sm-2 flex-shrink-0 g-2">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.debate') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                           <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-code-simple mx-1"></span> {{ __('common.code') }}:</b> {{ $debate->code }}</li>
                           <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}:</b> {{ $debate->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-newspaper mx-1"></span> {{ __('common.program') }}:</b> {{ $debate->program->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.voting-started-at') }}:</b> {{ $debate->voting_started_at }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.voting-finished-at') }}:</b> {{ $debate->voting_finished_at }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b>
                                @if($debate->status)
                                    {{ __('common.active') }}
                                @else
                                    {{ __('common.passive') }}
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col card text-bg-dark p-0">
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
                                    @foreach($teams as $team)
                                        <tr>
                                            <td>
                                                @if($team->logo)
                                                    <img src="{{ $team->logo }}" alt="{{ $team->title }}" class="img-thumbnail" style="height:36px;" />
                                                @else
                                                    <i class="text-info">{{ __('common.unspecified') }}</i>
                                                @endif
                                            </td>
                                            <td>{{ $team->code }}</td>
                                            <td>{{ $team->title }}</td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                    <a class="btn btn-info btn-sm" href="{{ route('portal.team.show', $team->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                        <span class="fa-regular fa-eye"></span>
                                                    </a>
                                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                                        <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#team-edit-modal" data-route="{{ route('portal.team.update', $team->id) }}" data-resource="{{ route('portal.team.edit', $team->id) }}" data-id="{{ $team->id }}">
                                                            <span class="fa-regular fa-pen-to-square"></span>
                                                        </button>
                                                    </div>
                                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                        <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#team-delete-modal" data-route="{{ route('portal.team.destroy', $team->id) }}" data-record="{{ $team->title }}">
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
                        <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#team-create-modal" data-route="{{ route('portal.team.store') }}">
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
            </div>
        </div>
    </div>
    <div class="card text-bg-dark mt-2">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.votes') }}</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{__('common.total-vote')}}
                    </caption>
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-person-chalkboard mx-1"></span> {{ __('common.owner') }}</th>
                        <th scope="col"><span class="fa-regular fa-speakation-screen mx-1"></span> {{ __('common.team') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($votes as $vote)
                            <tr>
                                <td>{{ $vote->owner->full_name }}</td>
                                <td>{{ $vote->team->title }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.debate-vote.show', $vote->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#team-edit-modal" data-route="{{ route('portal.debate-vote.update', $vote->id) }}" data-resource="{{ route('portal.debate-vote.edit', $vote->id) }}" data-id="{{ $vote->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#team-delete-modal" data-route="{{ route('portal.debate-vote.destroy', $vote->id) }}" data-record="{{ $vote->title }}">
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
        <x-crud.form.common.delete name="vote" />
    </div>
@endsection
