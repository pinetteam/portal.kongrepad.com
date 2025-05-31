@extends('layout.portal.common')
@section('title', $program->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none text-white">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $program->hall->meeting->id) }}" class="text-decoration-none text-white">{{ $program->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $program->hall->meeting->id]) }}" class="text-decoration-none text-white">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $program->hall->meeting->id, 'hall' => $program->hall->id]) }}" class="text-decoration-none text-white">{{ $program->hall->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.hall.program.index', ['meeting' => $program->hall->meeting->id, 'hall' => $program->hall->id]) }}" class="text-decoration-none text-white">{{ __('common.programs') }}</a></li>
    <li class="breadcrumb-item active text-white text-decoration-underline" aria-current="page">{{ $program->title }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-newspaper fa-fade"></span> <small>"{{ $program->title }}"</small> </h1>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-sm-2 flex-shrink-0 g-2">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.program') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped-columns table-bordered">
                                <tr>
                                    <th scope="row" class="text-end w-50">{{ __('common.logo') }}:</th>
                                    <td class="text-start w-50">
                                        @if(isset($program->logo_name))
                                            <img src="{{ asset('storage/program-logos/' . $program->logo_name . '.' . $program->logo_extension) }}" alt="{{ $program->title }}"
                                                 class="img-thumbnail" style="height:36px;"/>
                                        @else
                                            <i class="text-info">{{ __('common.unspecified') }}</i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-50">{{ __('common.title') }}:</th>
                                    <td class="text-start w-50">{{ $program->title}}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-50">{{ __('common.code') }}:</th>
                                    <td class="text-start w-50">{{ $program->code }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-50">{{ __('common.hall') }}:</th>
                                    <td class="text-start w-50">{{ $program->hall->title}}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-50">{{ __('common.start-at') }}:</th>
                                    <td class="text-start w-50">{{ $program->start_at}}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-50">{{ __('common.finish-at') }}:</th>
                                    <td class="text-start w-50">{{ $program->finish_at }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-50">{{ __('common.type') }}:</th>
                                    <td class="text-start w-50">{{ __('common.'.$program->type) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-50">{{ __('common.status') }}:</th>
                                    <td class="text-start w-50">
                                        @if($program->status)
                                            {{ __('common.active') }}
                                        @else
                                            {{ __('common.passive') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-50">{{ __('common.created-by') }}:</th>
                                    <td class="text-start w-50">{{ $program->created_by_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end w-50">{{ __('common.created-at') }}:</th>
                                    <td class="text-start w-50">{{ $program->created_at }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.chairs') }}</h2>
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
                                @foreach($program_chairs as $program_chair)
                                    <tr>
                                        <td>{{ $program_chair->chair->full_name }}</td>
                                        <td>{{ __('common.'.$program_chair->type) }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                    <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#chair-delete-modal" data-route="{{ route('portal.meeting.hall.program.chair.destroy', ['meeting' => $program_chair->program->hall->meeting_id, 'hall' => $program_chair->program->hall->id, 'program' => $program_chair->program->id, 'chair' => $program_chair->id ]) }}" data-record="{{ $program_chair->chair->full_name }}">
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
                        <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="offcanvas" data-bs-target="#chair-create-modal" data-route="{{ route('portal.meeting.hall.program.chair.store' , ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id]) }}">
                            <i class="fa-solid fa-plus"></i> {{ __('common.add-new-chair') }}
                        </button>
                    </div>
                    <x-crud.form.common.create name="chair">
                        @section('chair-create-form')
                            <x-input.hidden method="c" name="program_id" :value="$program->id" />
                            <x-input.select method="c" name="chair_id" title="chair" :options="$chairs" option_value="id" option_name="full_name" icon="id-card" :searchable="true"/>
                            <x-input.select method="c" name="type" title="type" :options="$chair_types" option_value="value" option_name="title" icon="person-military-pointing" />
                        @endsection
                    </x-crud.form.common.create>
                    <x-crud.form.common.delete name="chair" />
                    <x-crud.form.common.edit name="chair">
                        @section('chair-edit-form')
                            <x-input.hidden method="e" name="program_id" :value="$program->id" />
                            <x-input.select method="e" name="chair_id" title="chair" :options="$chairs" option_value="id" option_name="full_name" icon="id-card" :searchable="true" />
                            <x-input.select method="e" name="type" title="type" :options="$chair_types" option_value="value" option_name="title" icon="person-military-pointing" />
                        @endsection
                    </x-crud.form.common.edit>
                </div>
            </div>
        </div>
    </div>
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.sessions') }}</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-person-chalkboard mx-1"></span> {{ __('common.speaker') }}</th>
                        <th scope="col"><span class="fa-regular fa-folder-open mx-1"></span> {{ __('common.document') }}</th>
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
                                <td>
                                    @if($program_session->speaker)
                                        {{ $program_session->speaker->full_name }}
                                    @else
                                        <i class="text-info">{{ __('common.unspecified') }}</i>
                                    @endif
                                </td>
                                <td>
                                    @if($program_session->document_id)
                                        <a href="{{ route('portal.meeting.document.download', ['meeting' => $program->hall->meeting_id, 'document' => $program_session->document->file_name]) }}" class="btn btn-sm btn-info w-100" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.view') }}">
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
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.program.session.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $program_session->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#session-edit-modal" data-route="{{ route('portal.meeting.hall.program.session.update', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $program_session->id]) }}" data-resource="{{ route('portal.meeting.hall.program.session.edit', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $program_session->id]) }}" data-id="{{ $program_session->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#session-delete-modal" data-route="{{ route('portal.meeting.hall.program.session.destroy', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $program_session->id]) }}" data-record="{{ $program_session->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="offcanvas" data-bs-target="#session-create-modal" data-route="{{ route('portal.meeting.hall.program.session.store', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.add-new-session') }}
            </button>
        </div>
        <x-crud.form.common.create name="session">
            @section('session-create-form')
                <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort" />
                <x-input.hidden method="c" name="program_id" :value="$program->id" />
                <x-input.select method="c" name="speaker_id" title="speaker" :options="$speakers" option_value="id" option_name="full_name" icon="person-chalkboard" :searchable="true"/>
                <x-input.select method="c" name="document_id" title="document" :options="$documents" option_value="id" option_name="title" icon="presentation-screen" :searchable="true"/>
                <x-input.text method="c" name="code" title="code" icon="code-simple" />
                <x-input.text method="c" name="title" title="title" icon="input-text" />
                <x-input.text method="c" name="description" title="description" icon="comment-dots" />
                <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar-arrow-down" />
                <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
                <x-input.radio method="c" name="questions_allowed" title="questions" :options="$questions" option_value="value" option_name="title" icon="block-question" />
                <x-input.number method="c" name="questions_limit" title="question-limit" icon="circle-1" />
                <x-input.radio method="c" name="questions_auto_start" title="questions-auto-start" :options="$questions_auto_start" option_value="value" option_name="title" icon="block-question" />
                <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.create>
        <x-crud.form.common.delete name="session" />
        <x-crud.form.common.edit name="session">
            @section('session-edit-form')
                <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort" />
                <x-input.hidden method="e" name="program_id" :value="$program->id" />
                <x-input.select method="e" name="speaker_id" title="speaker" :options="$speakers" option_value="id" option_name="full_name" icon="person-chalkboard" :searchable="true" />
                <x-input.select method="e" name="document_id" title="document" :options="$documents" option_value="id" option_name="title" icon="presentation-screen" :searchable="true" />
                <x-input.text method="e" name="code" title="code" icon="code-simple" />
                <x-input.text method="e" name="title" title="title" icon="input-text" />
                <x-input.text method="e" name="description" title="description" icon="comment-dots" />
                <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar-arrow-down" />
                <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
                <x-input.radio method="e" name="questions_allowed" title="questions" :options="$questions" option_value="value" option_name="title" icon="block-question" />
                <x-input.number method="e" name="questions_limit" title="question-limit" icon="circle-1" />
                <x-input.radio method="e" name="questions_auto_start" title="questions-auto-start" :options="$questions_auto_start" option_value="value" option_name="title" icon="block-question" />
                <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.edit>
    </div>
@endsection
