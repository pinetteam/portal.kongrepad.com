@extends('layout.portal.common')
@section('title', $program->title)
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
                                        @if($program->logo)
                                            <img src="{{ $program->logo }}" alt="{{ $program->title }}" class="img-thumbnail img-fluid" />
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
                                        <td>{{ __('common.'.$program_chair->chair->type) }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                    <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#chair-delete-modal" data-route="{{ route('portal.meeting.hall.program.chair.destroy', ['meeting' => $program_chair->program->hall->meeting_id, 'hall' => $program_chair->program->hall_id, 'program' => $program_chair->program->id, 'chair' => $program_chair->id ]) }}" data-record="{{ $program_chair->chair->full_name }}">
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
                        <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#chair-create-modal" data-route="{{ route('portal.meeting.hall.program.chair.store' , ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall_id, 'program' => $program->id]) }}">
                            <i class="fa-solid fa-plus"></i> {{ __('common.add-new-chair') }}
                        </button>
                    </div>
                    <x-crud.form.common.create name="chair">
                        @section('chair-create-form')
                            <x-input.hidden method="c" name="program_id" :value="$program->id" />
                            <x-input.select method="c" name="chair_id" title="chair" :options="$chairs" option_value="id" option_name="full_name" icon="id-card" />
                        @endsection
                    </x-crud.form.common.create>
                    <x-crud.form.common.delete name="chair" />
                    <x-crud.form.common.edit name="chair">
                        @section('chair-edit-form')
                            <x-input.hidden method="e" name="program_id" :value="$program->id" />
                            <x-input.select method="e" name="chair_id" title="chair" :options="$chairs" option_value="id" option_name="full_name" icon="id-card" />
                        @endsection
                    </x-crud.form.common.edit>
                </div>
            </div>
        </div>
    </div>
    <div class="card text-bg-dark mt-2">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-face-party fa-fade"></span> {{ __('common.debates') }}</h1>
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
                        <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($debates as $debate)
                            <tr>
                                <td>{{ $debate->sort_order }}</td>
                                <td>{{ $debate->code }}</td>
                                <td>{{ $debate->title }}</td>
                                <td>{{ $debate->id }}</td>
                                <td>{{ $debate->voting_started_at }}</td>
                                <td>{{ $debate->voting_finished_at }}</td>
                                <td>
                                    @if($debate->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.program.debate.show', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall_id, 'program' => $program->id, 'debate' => $debate->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#debate-edit-modal" data-route="{{ route('portal.meeting.hall.program.debate.update', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall_id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-resource="{{ route('portal.meeting.hall.program.debate.edit', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall_id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-id="{{ $debate->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#debate-delete-modal" data-route="{{ route('portal.meeting.hall.program.debate.destroy', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall_id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-record="{{ $debate->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#debate-create-modal" data-route="{{ route('portal.meeting.hall.program.debate.store', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall_id, 'program' => $program->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.add-new-debate') }}
            </button>
        </div>
        <x-crud.form.common.create name="debate">
            @section('debate-create-form')
                <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort" />
                <x-input.hidden method="c" name="program_id" :value="$program->id" />
                <x-input.text method="c" name="code" title="code" icon="code-simple" />
                <x-input.text method="c" name="title" title="title" icon="input-text" />
                <x-input.text method="c" name="description" title="description" icon="comment-dots" />
                <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.create>
        <x-crud.form.common.delete name="debate" />
        <x-crud.form.common.edit name="debate">
            @section('debate-edit-form')
                <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort" />
                <x-input.hidden method="e" name="program_id" :value="$program->id" />
                <x-input.text method="e" name="code" title="code" icon="code-simple" />
                <x-input.text method="e" name="title" title="title" icon="input-text" />
                <x-input.text method="e" name="description" title="description" icon="comment-dots" />
                <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.edit>
    </div>
@endsection
