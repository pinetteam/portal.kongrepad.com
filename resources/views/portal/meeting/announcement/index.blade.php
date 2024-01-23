@extends('layout.portal.common')
@section('title', $meeting->title .' | ' . __('common.announcements'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class=" text-white text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none text-white">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active text-decoration-underline text-white" aria-current="page">{{ __('common.announcements') }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-megaphone fa-fade"></span> <small>"{{ $meeting->title }}"</small> {{ __('common.announcements') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $announcements->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-bee mx-1"></span> {{ __('common.meeting') }}</th>
                            <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.publish-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.is-published') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $announcement)
                            <tr>
                                <td>{{ $meeting->title }}</td>
                                <td>{{ $announcement->title }}</td>
                                <td>{{ $announcement->publish_at }}</td>
                                <td>
                                    @if($announcement->is_published)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td>
                                    @if($announcement->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.announcement.show', ['meeting' => $announcement->meeting->id, 'announcement' => $announcement->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#announcement-edit-modal" data-route="{{ route('portal.meeting.announcement.update', ['meeting' => $announcement->meeting->id, 'announcement' => $announcement->id]) }}" data-resource="{{ route('portal.meeting.announcement.edit', ['meeting' => $announcement->meeting->id, 'announcement' => $announcement->id]) }}" data-id="{{ $announcement->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#announcement-delete-modal" data-route="{{ route('portal.meeting.announcement.destroy', ['meeting' => $announcement->meeting->id, 'announcement' => $announcement->id]) }}" data-record="{{ $announcement->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#announcement-create-modal" data-route="{{ route('portal.meeting.announcement.store', ['meeting' => $meeting->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-announcement') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create name="announcement" >
        @section('announcement-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.datetime method="c" name="publish_at" title="publish-at" icon="calendar-arrow-down" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete name="announcement" />
    <x-crud.form.common.edit name="announcement" >
        @section('announcement-edit-form')
            <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.datetime method="e" name="publish_at" title="publish-at" icon="calendar-arrow-down" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
