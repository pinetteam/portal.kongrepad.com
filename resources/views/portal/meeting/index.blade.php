@extends('layout.portal.common')
@section('title', __('common.meetings'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.meetings') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover ">
                    <caption class="text-end me-3">
                        {{ $meetings->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-code-simple mx-1"></span>{{ __('common.code') }}</th>
                            <th scope="col"><span class="fa-regular fa-input-text mx-1"></span>{{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span>{{ __('common.start-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span>{{ __('common.finish-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meetings as $meeting)
                            <tr>
                                <td>{{ $meeting->code }}</td>
                                <td>{{ $meeting->title }}</td>
                                <td>
                                    @if($meeting->start_at)
                                        {{ Carbon::create($meeting->start_at)->format(Auth::user()->customer->settings['date-format']) }}
                                    @else
                                        {{ __('common.unspecified') }}
                                    @endif
                                </td>
                                <td>
                                    @if($meeting->finish_at)
                                        {{ Carbon::create($meeting->finish_at)->format(Auth::user()->customer->settings['date-format']) }}
                                    @else
                                        {{ __('common.unspecified') }}
                                    @endif
                                </td>
                                <td>
                                    @if($meeting->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.show', $meeting->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#edit-modal" data-route="{{ route('portal.meeting.update', $meeting->id) }}" data-resource="{{ route('portal.meeting.edit', $meeting->id) }}" data-id="{{ $meeting->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#delete-modal" data-route="{{ route('portal.meeting.destroy', $meeting->id) }}" data-record="{{ $meeting->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#create-modal" data-route="{{ route('portal.meeting.store') }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-meeting') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create>
        @section('create-form')
            <x-input.text method="c" name="code" title="code" icon="code-simple" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.date method="c" name="start_at" title="start-at" icon="calendar-arrow-up" />
            <x-input.date method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete />
    <x-crud.form.common.edit>
        @section('edit-form')
            <x-input.text method="e" name="code" title="code" icon="code-simple" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.date method="e" name="start_at" title="start-at" icon="calendar-arrow-up" />
            <x-input.date method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
