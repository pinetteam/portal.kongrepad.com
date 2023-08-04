@extends('layout.portal.common')
@section('title', $meeting->title .' | ' . __('common.documents'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-presentation-screen fa-fade"></span> <small>"{{ $meeting->title }}"</small> {{ __('common.documents') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $documents->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-bee mx-1"></span> {{ __('common.meeting') }}</th>
                            <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-envelope mx-1"></span> {{ __('common.sharing-via-email') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $document)
                            <tr>
                                <td>{{ $document->meeting->title }}</td>
                                <td>
                                    <a href="{{ route('portal.document-download.index', $document->file_name) }}" class="btn btn-sm btn-info w-100" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.view') }}">
                                        <span class="fa-regular fa-file-arrow-down"></span> {{ $document->title }}
                                    </a>
                                </td>
                                <td>
                                    @if($document->sharing_via_email)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td>
                                    @if($document->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.document.show', ['meeting' => $meeting->id, 'document' => $document->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#default-edit-modal" data-route="{{ route('portal.meeting.document.update', ['meeting' => $meeting->id, 'document' => $document->id]) }}" data-resource="{{ route('portal.meeting.document.edit', ['meeting' => $meeting->id, 'document' => $document->id]) }}" data-id="{{ $document->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#default-delete-modal" data-route="{{ route('portal.meeting.document.destroy', ['meeting' => $meeting->id, 'document' => $document->id]) }}" data-record="{{ $document->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#default-create-modal" data-route="{{ route('portal.meeting.document.store', ['meeting' => $meeting->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-document') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create>
        @section('default-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.file method="c" name="file" title="file" icon="file-import" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.radio method="c" name="sharing_via_email" title="sharing-via-email" :options="$sharing_via_emails" option_value="value" option_name="title" icon="envelope" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete />
    <x-crud.form.common.edit>
        @section('default-edit-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.file method="e" name="file" title="file" icon="file-import" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.radio method="e" name="sharing_via_email" title="sharing-via-email" :options="$sharing_via_emails" option_value="value" option_name="title" icon="envelope" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
