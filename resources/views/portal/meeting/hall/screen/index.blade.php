@extends('layout.portal.common')
@section('title', $hall->title .' | ' . __('common.screens'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-display fa-fade"></span> <small>"{{ $hall->title }}"</small> {{ __('common.screens') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $screens->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-bee mx-1"></span> {{ __('common.hall') }}</th>
                            <th scope="col"><span class="fa-regular fa-code-simple mx-1"></span> {{ __('common.code') }}</th>
                            <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($screens as $screen)
                            <tr>
                                <td>{{ $screen->hall->title }}</td>
                                <td>{{ $screen->code }}</td>
                                <td>{{ $screen->title }}</td>
                                <td>{{ __('common.'.$screen->type) }}</td>
                                <td >
                                    @if($screen->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.screen.show', ['meeting' => $hall->meeting->id, 'hall' => $hall->id, 'screen' => $screen->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#screen-edit-modal" data-route="{{ route('portal.meeting.hall.screen.update', ['meeting' => $hall->meeting->id, 'hall' => $hall->id, 'screen' => $screen->id]) }}" data-resource="{{ route('portal.meeting.hall.screen.edit', ['meeting' => $hall->meeting->id, 'hall' => $hall->id, 'screen' => $screen->id]) }}" data-id="{{ $hall->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#screen-delete-modal" data-route="{{ route('portal.meeting.hall.screen.destroy', ['meeting' => $hall->meeting->id, 'hall' => $hall->id, 'screen' => $screen->id]) }}" data-record="{{ $hall->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#screen-create-modal" data-route="{{ route('portal.meeting.hall.screen.store', ['meeting' => $hall->meeting->id, 'hall' => $hall->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-screen') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create name="screen" >
        @section('screen-create-form')
            <x-input.hidden method="c" name="hall_id" :value="$hall->id"/>
            <x-input.text method="c" name="code" title="code" icon="code-simple"/>
            <x-input.text method="c" name="title" title="title" icon="input-text"/>
            <x-input.text method="c" name="description" title="description" icon="comment-dots"/>
            <x-input.select method="c" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing"/>
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete name="screen" />
    <x-crud.form.common.edit name="screen" >
        @section('screen-edit-form')
            <x-input.hidden method="e" name="hall_id" :value="$hall->id"/>
            <x-input.text method="e" name="code" title="code" icon="code-simple"/>
            <x-input.text method="e" name="title" title="title" icon="input-text"/>
            <x-input.text method="e" name="description" title="description" icon="comment-dots"/>
            <x-input.select method="e" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing"/>
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
        @endsection
    </x-crud.form.common.edit>
@endsection
