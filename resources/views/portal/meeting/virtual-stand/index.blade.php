@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.virtual-stands'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.virtual-stands') }}</li>
@endsection
@section('meeting_content')
    <div class="card bg-kongre-secondary">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-browser fa-fade"></span> {{ __('common.virtual-stands') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $virtual_stands->links() }}
                    </caption>
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-image mx-1"></span> {{ __('common.logo') }}</th>
                        <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                        <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($virtual_stands as $virtual_stand)
                        <tr>
                            <td>
                                @if(isset($virtual_stand->file_name))
                                    <img src="{{ asset('storage/virtual-stands/' . $virtual_stand->file_name . '.' . $virtual_stand->file_extension) }}" alt="{{ $virtual_stand->title }}"
                                         class="img-thumbnail" style="height:36px;"/>
                                @else
                                    <i class="text-info">{{ __('common.unspecified') }}</i>
                                @endif
                            </td>
                            <td>{{ $virtual_stand->title }}</td>
                            <td>
                                @if($virtual_stand->status)
                                    <i style="color:var(--kongre-success)" class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:var(--kongre-danger)" class="fa-regular fa-toggle-off fa-xg"></i>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                    <a class="btn btn-kongre-accent btn-sm" href="{{ route('portal.meeting.virtual-stand.show', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                        <span class="fa-regular fa-eye"></span>
                                    </a>
                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                        <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#virtual-stand-edit-modal" data-route="{{ route('portal.meeting.virtual-stand.update', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" data-resource="{{ route('portal.meeting.virtual-stand.edit', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" data-id="{{ $virtual_stand->id }}">
                                            <span class="fa-regular fa-pen-to-square"></span>
                                        </button>
                                    </div>
                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                        <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#virtual-stand-delete-modal" data-route="{{ route('portal.meeting.virtual-stand.destroy', ['meeting' => $meeting->id, 'virtual_stand' => $virtual_stand->id]) }}" data-record="{{ $virtual_stand->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="offcanvas" data-bs-target="#virtual-stand-create-modal" data-route="{{ route('portal.meeting.virtual-stand.store', ['meeting' => $meeting->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-virtual-stand') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create name="virtual-stand">
        @section('virtual-stand-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.file method="c" name="file" title="file" icon="file-import" />
            <x-input.file method="c" name="pdf" title="pdf" icon="file-import" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete name="virtual-stand"/>
    <x-crud.form.common.edit name="virtual-stand">
        @section('virtual-stand-edit-form')
            <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
            <x-input.file method="e" name="file" title="file" icon="file-import" />
            <x-input.file method="e" name="pdf" title="pdf" icon="file-import" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
