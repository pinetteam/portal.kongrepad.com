@extends('layout.portal.common')
@section('title', __('common.sessions'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.sessions') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover ">
                    <caption class="text-end me-3">
                        {{ $sessions->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-input-text mx-1"></span>{{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span>{{ __('common.start-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span>{{ __('common.finish-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $session)
                            <tr>
                                <td>{{ $session->title }}</td>
                                <td>
                                    @if($session->start_at)
                                        {{ $session->start_at }}
                                    @else
                                        {{ __('common.unspecified') }}
                                    @endif
                                </td>
                                <td>
                                    @if($session->finish_at)
                                        {{ $session->finish_at }}
                                    @else
                                        {{ __('common.unspecified') }}
                                    @endif
                                </td>
                                <td>
                                    @if($session->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.session.show', $session->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#edit-modal" data-route="{{ route('portal.session.update', $session->id) }}" data-resource="{{ route('portal.session.edit', $session->id) }}" data-id="{{ $session->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#delete-modal" data-route="{{ route('portal.session.destroy', $session->id) }}" data-record="{{ $session->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#create-modal" data-route="{{ route('portal.session.store') }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-session') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create>
        @section('create-form')
            <x-input.select method="c" name="session_id" title="main-session" :options="$main_sessions" option_value="id" option_name="title" icon="bee" />
            <x-input.select method="c" name="meeting_hall_id" title="meeting-halls" :options="$meeting_halls" option_value="id" option_name="title" icon="bee" />
            <x-input.text method="c" type="text" name="sort_id" title="sort" icon="input-text" />
            <x-input.text method="c" type="text" name="code" title="code" icon="input-text" />
            <x-input.text method="c" type="text" name="title" title="title" icon="input-text" />
            <x-input.text method="c" type="text" name="description" title="description" icon="input-text" />
            <x-input.text method="c" type="date" name="date" title="date" icon="calendar-arrow-up" />
            <x-input.text method="c" type="date" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.text method="c" type="date" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.select method="c" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing" />
            <x-input.radio method="c" name="status" title="status" :options="$status_options" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete />
    <x-crud.form.common.edit>
        @section('edit-form')
            <x-input.select method="e" name="session_id" title="main-session" :options="$main_sessions" option_value="id" option_name="title" icon="bee" />
            <x-input.select method="e" name="meeting_hall_id" title="meeting-halls" :options="$meeting_halls" option_value="id" option_name="title" icon="bee" />
            <x-input.text method="e" type="text" name="sort_id" title="sort" icon="input-text" />
            <x-input.text method="e" type="text" name="code" title="code" icon="input-text" />
            <x-input.text method="e" type="text" name="title" title="title" icon="input-text" />
            <x-input.text method="e" type="text" name="description" title="description" icon="input-text" />
            <x-input.text method="e" type="date" name="date" title="date" icon="calendar-arrow-up" />
            <x-input.text method="e" type="date" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.text method="e" type="date" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.select method="e" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing" />
            <x-input.radio method="e" name="status" title="status" :options="$status_options" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
