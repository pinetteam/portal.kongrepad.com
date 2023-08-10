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
            <h2 class="text-center">
                <span class="fa-regular fa-circle-keypad fa-fade p-2"> </span>{{ __('common.keypads') }}
            </h2>
        </div>
        <div class="card-body p-0">
            <div class="card text-bg-dark mt-2">
                <table class=" caption-top table table-dark table-striped-columns table-bordered ">
                    <tbody>
                    <tr>
                        <td>
                            <table
                                class=" caption-top table table-dark table-striped-columns table-bordered m-2">
                                <tbody>
                                <tr>
                                    @foreach($keypads as $keypad)
                                        <table
                                            class=" caption-top table table-dark table-striped-columns table-bordered ">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col"><span
                                                        class="fa-regular fa-messages-keypad mx-1 "></span> {{ __('common.keypad-title') }}
                                                </th>
                                                <th scope="col"><span
                                                        class="fa-regular fa-circle-sort mx-1 "></span> {{ __('common.sort-order') }}
                                                </th>
                                                <th scope="col"><span
                                                        class="fa-regular fa-toggle-large-on mx-1  "></span> {{ __('common.option-count') }}
                                                </th>
                                                <th scope="col" class="text-end "></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{$keypad->keypad}}</td>
                                                <td>{{$keypad->sort_order}}</td>
                                                <td>{{$keypad->options->count()}}</td>
                                                <td class="text-end">

                                                    <div class="btn-group" role="group"
                                                         aria-label="{{ __('common.processes') }}">
                                                        <div data-bs-toggle="tooltip" data-bs-placement="top"
                                                             data-bs-custom-class="kp-tooltip"
                                                             data-bs-title="{{ __('common.add-option')}}">
                                                            <button type="button"
                                                                    class="btn btn-outline-success btn-sm w-100  "
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#option-{{$keypad->id}}-create-modal"
                                                                    data-route="{{ route('portal.meeting.hall.program.session.keypad.option.store',['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id, 'keypad' => $keypad->id]) }}">
                                                                <i class="fa-solid fa-plus"></i> {{ __('common.add-option') }}
                                                            </button>
                                                        </div>
                                                        {{--show button--}}
                                                        <a class="btn btn-info btn-sm"
                                                           href="{{ route('portal.meeting.hall.program.session.keypad.show', ['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id, 'keypad' => $keypad->id]) }}"
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
                                                            {{--edit button--}}
                                                            <button class="btn btn-warning btn-sm"
                                                                    title="{{ __('common.edit') }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#keypad-edit-modal"
                                                                    data-route="{{ route('portal.meeting.hall.program.session.keypad.update', ['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id, 'keypad' => $keypad->id]) }}"
                                                                    data-resource="{{ route('portal.meeting.hall.program.session.keypad.edit', ['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id, 'keypad' => $keypad->id]) }}"
                                                                    data-id="{{ $keypad->id }}">
                                                                        <span
                                                                            class="fa-regular fa-pen-to-square"></span>
                                                            </button>
                                                        </div>
                                                        <div data-bs-toggle="tooltip" data-bs-placement="top"
                                                             data-bs-custom-class="kp-tooltip"
                                                             data-bs-title="{{ __('common.delete') }}">
                                                            <button class="btn btn-danger btn-sm"
                                                                    title="{{ __('common.delete') }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#keypad-delete-modal"
                                                                    data-route="{{ route('portal.meeting.hall.program.session.keypad.destroy', ['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id, 'keypad' => $keypad->id]) }}"
                                                                    data-record="{{ $keypad->keypad }}">
                                                                <span class="fa-regular fa-trash"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">
                                                    <div class="table-responsive">
                                                        <table
                                                            class=" caption-top table table-dark table-striped table-hover  table-bordered">
                                                            <thead class="thead-dark">
                                                            <tr>
                                                                <th scope="col"><span
                                                                        class="fa-regular fa-messages-keypad mx-1"></span> {{ __('common.option-title') }}
                                                                </th>
                                                                <th scope="col"><span
                                                                        class="fa-regular fa-circle-sort mx-1"></span> {{ __('common.sort-order') }}
                                                                </th>
                                                                <th scope="col" class=""></th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            @foreach($keypad->options as $option)
                                                                <tr>
                                                                    <td>{{$option->option}}</td>
                                                                    <td>{{$option->sort_order}}</td>
                                                                    <td class="text-end">
                                                                        <div class="btn-group" role="group"
                                                                             aria-label="{{ __('common.processes') }}">
                                                                            <div data-bs-toggle="tooltip"
                                                                                 data-bs-placement="top"
                                                                                 data-bs-custom-class="kp-tooltip"
                                                                                 data-bs-title="{{ __('common.edit')}}">
                                                                                {{--edit button--}}
                                                                                <button
                                                                                    class="btn btn-warning btn-sm"
                                                                                    title="{{ __('common.edit') }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#option-edit-modal"
                                                                                    data-route="{{ route('portal.meeting.hall.program.session.keypad.option.update', ['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id, 'keypad' => $keypad->id, 'option' => $option->id]) }}"
                                                                                    data-resource="{{ route('portal.meeting.hall.program.session.keypad.option.edit', ['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id, 'keypad' => $keypad->id, 'option' => $option->id]) }}"
                                                                                    data-id="{{ $option->id }}">
                                                                            <span
                                                                                class="fa-regular fa-pen-to-square"></span>
                                                                                </button>
                                                                            </div>
                                                                            <div data-bs-toggle="tooltip"
                                                                                 data-bs-placement="top"
                                                                                 data-bs-custom-class="kp-tooltip"
                                                                                 data-bs-title="{{ __('common.delete') }}">
                                                                                <button
                                                                                    class="btn btn-danger btn-sm"
                                                                                    title="{{ __('common.delete') }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#option-delete-modal"
                                                                                    data-route="{{ route('portal.meeting.hall.program.session.keypad.option.destroy', ['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id, 'keypad' => $keypad->id, 'option' => $option->id]) }}"
                                                                                    data-record="{{ $option->option }}">
                                                                                <span
                                                                                    class="fa-regular fa-trash"></span>
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
                                        </table>
                                        <x-crud.form.common.create name="option-{{$keypad->id}}" method="c-o">
                                            @section('option-'.$keypad->id.'-create-form')
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
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <div class="card-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal"
                                    data-bs-target="#keypad-create-modal"
                                    data-route="{{ route('portal.meeting.hall.program.session.keypad.store', ['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id]) }}">
                                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-keypad') }}
                            </button>
                        </div>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <x-crud.form.common.create name="keypad">
        @section('keypad-create-form')
            <x-input.hidden method="c" name="session_id" :value="$session->id"/>
            <x-input.text method="c" name="title" title="title" icon="input-text"/>
            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort"/>
        @endsection
    </x-crud.form.common.create>

    <x-crud.form.common.delete name="keypad"/>

    <x-crud.form.common.edit name="keypad">
        @section('keypad-edit-form')
            <x-input.hidden method="e" name="session_id" :value="$session->id"/>
            <x-input.text method="e" name="title" title="title" icon="input-text"/>
            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort"/>
        @endsection
    </x-crud.form.common.edit>
@endsection
