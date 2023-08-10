@extends('layout.portal.common')
@section('title', __('common.session').' | '.$session->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{'"'.$session->title.'" '. __('common.session') }}</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col card text-bg-dark p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped-columns table-bordered">
                            <tr>
                                <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                                <td class="text-start w-25">{{ $session->title}}</td>
                                <th scope="row" class="text-end w-25">{{ __('common.code') }}:</th>
                                <td class="text-start w-25">{{ $session->code }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-end w-25">{{ __('common.program') }}:</th>
                                <td class="text-start w-25">{{ $session->program->title}}</td>
                                <th scope="row" class="text-end w-25">{{ __('common.status') }}:</th>
                                <td class="text-start w-25">
                                    @if($session->status)
                                        {{ __('common.active') }}
                                    @else
                                        {{ __('common.passive') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-end w-25">{{ __('common.start-at') }}:</th>
                                <td class="text-start w-25">{{ $session->start_at}}</td>
                                <th scope="row" class="text-end w-25">{{ __('common.finish-at') }}:</th>
                                <td class="text-start w-25">{{ $session->finish_at }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                                <td class="text-start w-25">{{ $session->created_by }}</td>
                                <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                                <td class="text-start w-25">{{ $session->created_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card text-bg-dark mt-2">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.keypads') }}</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-circle-sort mx-1"></span> {{ __('common.sort') }}</th>
                        <th scope="col"><span class="fa-regular fa-code-simple mx-1"></span> {{ __('common.code') }}</th>
                        <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                        <th scope="col"><span class="fa-regular fa-comment-dots mx-1"></span> {{ __('common.description') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.voting-started-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.voting-finished-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.on-vote') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($keypads as $keypad)
                        <tr>
                            <td>{{ $keypad->sort_order }}</td>
                            <td>{{ $keypad->code }}</td>
                            <td>{{ $keypad->title }}</td>
                            <td>{{ $keypad->description }}</td>
                            <td>{{ $keypad->voting_started_at }}</td>
                            <td>{{ $keypad->voting_finished_at }}</td>
                            <td>
                                @if($keypad->on_vote)
                                    <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                            @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                    <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.program.session.keypad.show', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id, 'program' => $session->program->id, 'session' => $session->id, 'keypad' => $keypad->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                        <span class="fa-regular fa-eye"></span>
                                    </a>
                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                        <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#keypad-edit-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.update', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id, 'program' => $session->program->id, 'session' => $session->id, 'keypad' => $keypad->id]) }}" data-resource="{{ route('portal.meeting.hall.program.session.keypad.edit', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id, 'program' => $session->program->id, 'session' => $session->id, 'keypad' => $keypad->id]) }}" data-id="{{ $keypad->id }}">
                                            <span class="fa-regular fa-pen-to-square"></span>
                                        </button>
                                    </div>
                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                        <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#keypad-delete-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.destroy', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id, 'program' => $session->program->id, 'session' => $session->id, 'keypad' => $keypad->id]) }}" data-record="{{ $keypad->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#keypad-create-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.store', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id, 'program' => $session->program->id, 'session' => $session->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.add-new-keypad') }}
            </button>
        </div>
        <x-crud.form.common.create name="keypad">
            @section('keypad-create-form')
                <x-input.hidden method="c" name="session_id" :value="$session->id" />
                <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort" />
                <x-input.text method="c" name="code" title="code" icon="code-simple" />
                <x-input.text method="c" name="title" title="title" icon="input-text" />
                <x-input.text method="c" name="description" title="description" icon="comment-dots" />
                @endsection
        </x-crud.form.common.create>
        <x-crud.form.common.delete name="keypad" />
        <x-crud.form.common.edit name="keypad">
            @section('keypad-edit-form')
                <x-input.hidden method="e" name="session_id" :value="$session->id" />
                <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort" />
                <x-input.text method="e" name="code" title="code" icon="code-simple" />
                <x-input.text method="e" name="title" title="title" icon="input-text" />
                <x-input.text method="e" name="description" title="description" icon="comment-dots" />
                @endsection
        </x-crud.form.common.edit>
    </div>
@endsection
