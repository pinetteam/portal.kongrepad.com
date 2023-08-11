@extends('layout.portal.common')
@section('title', $session->title . ' | ' . __('common.session'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{'"' .$session->title. '"'}}</h1>
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
            <h2 class="text-center">
                <span class="fa-regular fa-tablet fa-fade p-2"> </span>{{ __('common.keypads') }}
            </h2>
        </div>
        <div class="card-body p-0">
            <div class="card text-bg-dark mt-2">

                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"><span class="fa-regular fa-messages-question mx-1 "></span> {{ __('common.keypad-title') }}</th>
                                <th scope="col"><span class="fa-regular fa-circle-sort mx-1 "></span> {{ __('common.sort-order') }}</th>
                                <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1  "></span> {{ __('common.option-count') }}</th>
                                <th scope="col" class="text-end"></th>
                            </tr>
                            </thead>
                            @foreach($keypads as $keypad)
                            <tbody>
                            <tr>
                                <td rowspan="2" style="width: 2%"></td>
                                <td rowspan="1">{{$keypad->keypad}}</td>
                                <td rowspan="1">{{$keypad->sort_order}}</td>
                                <td rowspan="1">{{$keypad->options->count()}}</td>
                                <td class="text-end" rowspan="1">
                                    <div class="btn-group" role="group"
                                         aria-label="{{ __('common.processes') }}">
                                        <div data-bs-toggle="tooltip" data-bs-placement="top"
                                             data-bs-custom-class="kp-tooltip"
                                             data-bs-title="{{ __('common.add-option')}}">
                                            <button type="button"
                                                    class="btn btn-outline-success btn-sm w-100  "
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#option-create-modal"
                                                    data-route="{{ route('portal.meeting.hall.program.session.keypad.option.store',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}">
                                                <i class="fa-solid fa-plus"></i> {{ __('common.add-option') }}
                                            </button>
                                        </div>
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('portal.meeting.hall.program.session.keypad.show',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}"
                                           title="{{ __('common.show') }}"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="kp-tooltip"
                                           data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top"
                                             data-bs-custom-class="kp-tooltip"
                                             data-bs-title="{{ __('common.edit')}}">
                                            <button class="btn btn-warning btn-sm"
                                                    title="{{ __('common.edit') }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#keypad-edit-modal"
                                                    data-route="{{ route('portal.meeting.hall.program.session.keypad.update',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}"
                                                    data-resource="{{ route('portal.meeting.hall.program.session.keypad.edit',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}"
                                                    data-id="{{ $keypad->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top"
                                             data-bs-custom-class="kp-tooltip"
                                             data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm"
                                                    title="{{ __('common.delete') }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#keypad-delete-modal"
                                                    data-route="{{ route('portal.meeting.hall.program.session.keypad.destroy',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}"
                                                    data-record="{{ $keypad->keypad }}">
                                                <span class="fa-regular fa-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="1" colspan="4">
                                    <div class="table-responsive w-100">
                                        <table class="table table-dark table-striped table-hover">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span> {{ __('common.option-title') }}</th>
                                                <th scope="col"><span class="fa-regular fa-circle-sort mx-1"></span> {{ __('common.sort-order') }}</th>
                                                <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                                                <th scope="col" class=""></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($keypad->options as $option)
                                                <tr>
                                                    <td>{{$option->option}}</td>
                                                    <td>{{$option->sort_order}}</td>
                                                    <td>
                                                        @if($option->status)
                                                            <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                                        @else
                                                            <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="btn-group" role="group"
                                                             aria-label="{{ __('common.processes') }}">
                                                            <div data-bs-toggle="tooltip"
                                                                 data-bs-placement="top"
                                                                 data-bs-custom-class="kp-tooltip"
                                                                 data-bs-title="{{ __('common.edit')}}">
                                                                <button
                                                                    class="btn btn-warning btn-sm"
                                                                    title="{{ __('common.edit') }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#option-edit-modal"
                                                                    data-route="{{ route('portal.meeting.hall.program.session.keypad.option.update',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id, 'option'=>$option->id]) }}"
                                                                    data-resource="{{ route('portal.meeting.hall.program.session.keypad.option.edit',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id, 'option'=>$option->id]) }}"
                                                                    data-id="{{ $option->id }}">
                                                                    <span class="fa-regular fa-pen-to-square"></span>
                                                                </button>
                                                            </div>
                                                            <div data-bs-toggle="tooltip"
                                                                 data-bs-placement="top"
                                                                 data-bs-custom-class="kp-tooltip"
                                                                 data-bs-title="{{ __('common.delete') }}">
                                                                <button class="btn btn-danger btn-sm"
                                                                        title="{{ __('common.delete') }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#option-delete-modal"
                                                                        data-route="{{ route('portal.meeting.hall.program.session.keypad.option.destroy',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id, 'option'=>$option->id]) }}">
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
                                </td>
                            </tr>
                            </tbody>
                            @endforeach
                        </table>
                        <tr>
                            <div class="card-footer d-flex justify-content-center">
                                <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal"
                                        data-bs-target="#keypad-create-modal"
                                        data-route="{{ route('portal.meeting.hall.program.session.keypad.store', ['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id]) }}">
                                    <i class="fa-solid fa-plus"></i> {{ __('common.create-new-keypad') }}
                                </button>
                            </div>
                        </tr>
                        </thead>
                        </table>
                    </div>
            </div>
        </div>
    </div>
    </div>
    <x-crud.form.common.create name="option" method="c-o">
        @section('option-create-form')
            <x-input.hidden method="c-o" name="keypad_id"
                            :value="$keypad->id"/>
            <x-input.text method="c-o" name="option" title="option"
                          icon="list-dropdown"/>
            <x-input.number method="c-o" name="sort_order" title="sort"
                            icon="circle-sort"/>
        @endsection
    </x-crud.form.common.create>

    <x-crud.form.common.delete name="option"/>

    <x-crud.form.common.edit name="option" method="e-o">
        @section('option-edit-form')
            <x-input.hidden method="e-o" name="keypad_id"
                            :value="$keypad->id"/>
            <x-input.text method="e-o" name="option" title="option"
                          icon="list-dropdown"/>
            <x-input.number method="e-o" name="sort_order" title="sort"
                            icon="circle-sort"/>
        @endsection
    </x-crud.form.common.edit>
    <x-crud.form.common.create name="keypad">
        @section('keypad-create-form')
            <x-input.hidden method="c" name="session_id" :value="$session->id"/>
            <x-input.text method="c" name="keypad" title="keypad" icon="input-text"/>
            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort"/>
        @endsection
    </x-crud.form.common.create>

    <x-crud.form.common.delete name="keypad"/>

    <x-crud.form.common.edit name="keypad">
        @section('keypad-edit-form')
            <x-input.hidden method="e" name="session_id" :value="$session->id"/>
            <x-input.text method="e" name="keypad" title="keypad" icon="input-text"/>
            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort"/>
        @endsection
    </x-crud.form.common.edit>
@endsection
