@extends('layout.portal.common')
@section('title', __('common.user-roles'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.user-roles') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover ">
                    <caption class="text-end me-3">
                        {{ $user_roles->links() }}
                    </caption>
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-pen-nib mx-1"></span>{{ __('common.title') }}</th>
                        <th scope="col"><span class="fa-regular fa-dashboard mx-1"></span>{{ __('common.status') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($user_roles as $user_role)
                            <tr>
                                <td>{{ $user_role->title }}</td>
                                <td>
                                    @if($user_role->status)
                                        <i style="color:green" class="fa-solid fa-check-square fa-lg"></i>
                                    @else
                                        <i style="color:red" class="fa-solid fa-square-xmark fa-lg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.user-role.show', $user_role->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#edit-modal" data-route="{{ route('portal.user-role.update', $user_role->id) }}" data-resource="{{ route('portal.user-role.edit', $user_role->id) }}" data-id="{{ $user_role->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#delete-modal" data-route="{{ route('portal.user-role.destroy', $user_role->id) }}" data-record="{{ $user_role->title}}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#create-modal" data-route="{{ route('portal.user-role.store') }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-user-role') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create>
        @section('create-form')
            <x-input.text method="c" type="text" name="title" title="title" icon="pen-nib" />
            <x-input.radio method="c" name="status" title="status" :options="$status_options" option_value="value" option_name="title" icon="gauge" />
            <x-input.checkbox method="c" name="access_scopes" title="scopes" :options="$scopes" option_value="route" option_name="code" icon="gauge" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete/>
    <x-crud.form.common.edit method="e">
        @section('edit-form')
            <x-input.text method="e" type="text" name="title" title="title" icon="pen-nib" />
            <x-input.radio method="e" name="status" title="status" :options="$status_options" option_value="value" option_name="title" icon="gauge" />
            <x-input.checkbox method="e" name="access_scopes" title="scopes" :options="$scopes" option_value="route" option_name="code" icon="gauge" />
        @endsection
    </x-crud.form.common.edit>
@endsection
