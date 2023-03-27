@extends('layout.portal.common')
@section('title', __('common.documents'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.documents') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover ">
                    <caption class="text-end me-3">
                        {{ $documents->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-bee mx-1"></span> {{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.participant') }}</th>
                            <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}</th>
                            <th scope="col"><span class="fa-regular fa-right-to-bracket mx-1"></span> {{ __('common.file') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $document)
                            <tr>
                                <td>{{ $document->title }}</td>
                                <td>{{ $document->participant->full_name }}</td>
                                <td>{{ __('common.'.$document->type) }}</td>
                                <td><a href="{{ route('portal.document-download.index', $document->file_name) }}" class="btn btn-sm btn-info w-100"><span class="fa-regular fa-file-arrow-down"></span> {{ __('common.view') }}</a></td>
                                <td>
                                    @if($document->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.document.show', $document->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#edit-modal" data-route="{{ route('portal.document.update', $document->id) }}" data-resource="{{ route('portal.document.edit', $document->id) }}" data-id="{{ $document->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#delete-modal" data-route="{{ route('portal.document.destroy', $document->id) }}" data-record="{{ $document->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#create-modal" data-route="{{ route('portal.document.store') }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-document') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create>
        @section('create-form')
            <x-input.select method="c" name="participant_id" title="participant" :options="$participants" option_value="id" option_name="full_name" icon="screen-users" />
            <x-input.text method="c" type="text" name="title" title="title" icon="input-text" />
            <x-input.select method="c" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing" />
            <x-input.file method="c" type="file" name="file" title="file" icon="file-import" />
            <x-input.radio method="c" name="status" title="status" :options="$status_options" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete/>
    <x-crud.form.common.edit method="e">
        @section('edit-form')
            <x-input.select method="e" name="participant_id" title="participant" :options="$participants" option_value="id" option_name="full_name" icon="screen-users" />
            <x-input.text method="e" type="text" name="title" title="title" icon="input-text" />
            <x-input.select method="e" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing" />
            <x-input.file method="e" type="file" name="file" title="file" icon="file-import" />
            <x-input.radio method="e" name="status" title="status" :options="$status_options" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
