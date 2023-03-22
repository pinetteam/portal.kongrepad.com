@extends('layout.portal.common')
@section('title', __('common.meeting-rooms'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.meeting-rooms') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover ">
                    <caption class="text-end me-3">
                        {{ $meeting_rooms->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-id-card mx-1"></span>{{ __('common.meeting') }}</th>
                            <th scope="col"><span class="fa-regular fa-id-card mx-1"></span>{{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-dashboard mx-1"></span>{{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meeting_rooms as $meeting_room)
                            <tr>
                                <td>{{ $meeting_room->title }} </td>
                                <td>{{ $meeting_room->title }}</td>
                                <td >
                                    @if($meeting_room->status)
                                        <i style="color:green" class="fa-solid fa-check-square fa-lg"></i>
                                    @else
                                        <i style="color:red" class="fa-solid fa-square-xmark fa-lg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.meeting-room.show', $meeting_room->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#edit-modal" data-route="{{ route('portal.meeting-room.update', $meeting_room->id) }}" data-resource="{{ route('portal.meeting-room.edit', $meeting_room->id) }}" data-id="{{ $meeting_room->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#delete-modal" data-route="{{ route('portal.meeting-room.destroy', $meeting_room->id) }}" data-record="{{ $meeting_room->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#create-modal" data-route="{{ route('portal.meeting-room.store') }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-meeting-room') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create>
        @section('create-form')
            <x-input.select method="c" name="meeting_id" title="meeting" :options="$meetings" option_value="id" option_name="title" icon="user-helmet-safety" />
            <x-input.text method="c" type="text" name="title" title="title" icon="user" />
            <x-input.radio method="c" name="status" title="status" :options="$status_options" option_value="value" option_name="title" icon="gauge" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete/>
    <x-crud.form.common.edit method="e">
        @section('edit-form')
            <x-input.select method="e" name="meeting_id" title="meeting" :options="$meetings" option_value="id" option_name="title" icon="user-helmet-safety" />
            <x-input.text method="e" type="text" name="title" title="title" icon="user" />
            <x-input.radio method="e" name="status" title="status" :options="$status_options" option_value="value" option_name="title" icon="gauge" />
        @endsection
    </x-crud.form.common.edit>
@endsection
