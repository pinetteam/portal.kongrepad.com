@extends('layout.portal.common')
@section('title', __('common.program').' | '.$program->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.program').' | '.$program->title }}</h1>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-sm-2 flex-shrink-0 g-2">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.program') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @if($program->logo)
                                <li class="list-group-item bg-dark text-center"><img src="{{ $program->logo }}" alt="{{ $program->title }}" class="img-thumbnail img-fluid" /></li>
                            @endif
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-hotel mx-1"></span> {{ __('common.meeting-hall') }}:</b> {{ $program->meetingHall->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-code-simple mx-1"></span> {{ __('common.code') }}:</b> {{ $program->code }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-hotel mx-1"></span> {{ __('common.meeting-hall') }}:</b> {{ $program->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}:</b> {{ $program->start_at }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}:</b> {{ $program->finish_at }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}:</b> {{ __('common.'.$program->type) }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b>
                                @if($program->status)
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
                        <h2 class="m-0 text-center h3">{{ __('common.moderators') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col"><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.name') }}</th>
                                    <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}</th>
                                    <th scope="col" class="text-end"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($program_moderators as $program_moderator)
                                        <tr>
                                            <td>{{ $program_moderator->moderator->full_name }}</td>
                                            <td>{{ __('common.'.$program_moderator->moderator->type) }}</td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                        <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#moderator-delete-modal" data-route="{{ route('portal.program-moderator.destroy', $program_moderator->id) }}" data-record="{{ $program_moderator->moderator->full_name }}">
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
                        <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#moderator-create-modal" data-route="{{ route('portal.program-moderator.store') }}">
                            <i class="fa-solid fa-plus"></i> {{ __('common.add-new-moderator') }}
                        </button>
                    </div>
                    <x-crud.form.common.create name="moderator">
                        @section('moderator-create-form')
                            <x-input.hidden method="c" name="program_id" :value="$program->id" />
                            <x-input.select method="c" name="moderator_id" title="moderator" :options="$moderators" option_value="id" option_name="full_name" icon="id-card" />
                        @endsection
                    </x-crud.form.common.create>
                    <x-crud.form.common.delete name="moderator" />
                    <x-crud.form.common.edit name="moderator">
                        @section('moderator-edit-form')
                            <x-input.hidden method="e" name="program_id" :value="$program->id" />
                            <x-input.select method="e" name="moderator_id" title="moderator" :options="$moderators" option_value="id" option_name="full_name" icon="id-card" />
                        @endsection
                    </x-crud.form.common.edit>
                </div>
            </div>
        </div>
    </div>
    <div class="card text-bg-dark mt-2">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.sessions') }}</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        Total Session
                    </caption>
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-person-chalkboard mx-1"></span> {{ __('common.presenter') }}</th>
                        <th scope="col"><span class="fa-regular fa-presentation-screen mx-1"></span> {{ __('common.document') }}</th>
                        <th scope="col"><span class="fa-regular fa-circle-sort mx-1"></span> {{ __('common.sort') }}</th>
                        <th scope="col"><span class="fa-regular fa-code-simple mx-1"></span> {{ __('common.code') }}</th>
                        <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-block-question mx-1"></span> {{ __('common.questions') }}</th>
                        <th scope="col"><span class="fa-regular fa-circle-1 mx-1"></span> {{ __('common.question-limit') }}</th>
                        <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($program_sessions as $program_session)
                            <tr>
                                <td>{{ $program_session->presenter->full_name }}</td>
                                <td>
                                    @if($program_session->document_id)
                                        <a href="{{ route('portal.document-download.index', $program_session->document->file_name) }}" class="btn btn-sm btn-info w-100" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.view') }}">
                                            <span class="fa-regular fa-file-arrow-down"></span> {{ $program_session->document->title }}
                                        </a>
                                    @else
                                        <i class="text-info">{{ __('common.unspecified') }}</i>
                                    @endif
                                </td>
                                <td>{{ $program_session->sort_id }}</td>
                                <td>{{ $program_session->code }}</td>
                                <td>{{ $program_session->title }}</td>
                                <td>{{ $program_session->start_at }}</td>
                                <td>{{ $program_session->finish_at }}</td>
                                <td>
                                    @if($program_session->questions)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td>{{ $program_session->question_limit }}</td>
                                <td>
                                    @if($program_session->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.program-session.show', $program_session->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#session-edit-modal" data-route="{{ route('portal.program-session.update', $program_session->id) }}" data-resource="{{ route('portal.program-session.edit', $program_session->id) }}" data-id="{{ $program_session->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#session-delete-modal" data-route="{{ route('portal.program-session.destroy', $program_session->id) }}" data-record="{{ $program_session->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#session-create-modal" data-route="{{ route('portal.program-session.store') }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.add-new-session') }}
            </button>
        </div>
        <x-crud.form.common.create name="session">
            @section('session-create-form')
                <x-input.hidden method="c" name="program_id" :value="$program->id" />
                <x-input.select method="c" name="presenter_id" title="presenter" :options="$presenters" option_value="id" option_name="full_name" icon="person-chalkboard" />
                <x-input.select method="c" name="document_id" title="document" :options="$documents" option_value="id" option_name="title" icon="presentation-screen" />
                <x-input.number method="c" name="sort_id" title="sort" icon="circle-sort" />
                <x-input.text method="c" name="code" title="code" icon="code-simple" />
                <x-input.text method="c" name="title" title="title" icon="input-text" />
                <x-input.text method="c" name="description" title="description" icon="comment-dots" />
                <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar-arrow-down" />
                <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
                <x-input.radio method="c" name="questions" title="questions" :options="$questions" option_value="value" option_name="title" icon="block-question" />
                <x-input.number method="c" name="question_limit" title="question-limit" icon="circle-1" />
                <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.create>
        <x-crud.form.common.delete name="session" />
        <x-crud.form.common.edit name="session">
            @section('session-edit-form')
                <x-input.hidden method="e" name="program_id" :value="$program->id" />
                <x-input.select method="e" name="presenter_id" title="presenter" :options="$presenters" option_value="id" option_name="full_name" icon="person-chalkboard" />
                <x-input.select method="e" name="document_id" title="document" :options="$documents" option_value="id" option_name="title" icon="presentation-screen" />
                <x-input.number method="e" name="sort_id" title="sort" icon="circle-sort" />
                <x-input.text method="e" name="code" title="code" icon="code-simple" />
                <x-input.text method="e" name="title" title="title" icon="input-text" />
                <x-input.text method="e" name="description" title="description" icon="comment-dots" />
                <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar-arrow-down" />
                <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
                <x-input.radio method="e" name="questions" title="questions" :options="$questions" option_value="value" option_name="title" icon="block-question" />
                <x-input.number method="e" name="question_limit" title="question-limit" icon="circle-1" />
                <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.edit>
    </div>
@endsection
