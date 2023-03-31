@extends('layout.portal.common')
@section('title', __('common.users'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.users') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover ">
                    <caption class="text-end me-3">
                        {{ $users->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.user-role') }}</th>
                            <th scope="col"><span class="fa-regular fa-id-card-clip mx-1"></span> {{ __('common.username') }}</th>
                            <th scope="col"><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.name') }}</th>
                            <th scope="col"><span class="fa-regular fa-envelope mx-1"></span> {{ __('common.email') }}</th>
                            <th scope="col"><span class="fa-regular fa-mobile-screen mx-1"></span> {{ __('common.phone') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col"><span class="fa-regular fa-right-to-bracket mx-1"></span> {{ __('common.last-login') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->userRole->title }}</td>
                                <td>
                                    @if($user->activity_status)
                                        <div class="spinner-grow spinner-grow-sm text-success" role="status"></div>
                                    @else
                                        <div class="spinner-border spinner-border-sm text-danger" role="status"></div>
                                    @endif
                                    | {{ $user->username }}
                                </td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->phone_country_id && $user->phone)
                                        +{{ $user->phoneCountry->phone_code }} {{ $user->phone }}
                                    @else
                                        {{ __('common.unspecified') }}
                                    @endif
                                </td>
                                <td>
                                    @if($user->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td>{{ $user->last_login }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.user.show', $user->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#edit-modal" data-route="{{ route('portal.user.update', $user->id) }}" data-resource="{{ route('portal.user.edit', $user->id) }}" data-id="{{ $user->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#delete-modal" data-route="{{ route('portal.user.destroy', $user->id) }}" data-record="{{ $user->full_name }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#create-modal" data-route="{{ route('portal.user.store') }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-user') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create>
        @section('create-form')
            <x-input.select method="c" name="user_role_id" title="user-role" :options="$user_roles" option_value="id" option_name="title" icon="person-military-pointing" />
            <x-input.text method="c" type="text" name="username" title="username" icon="id-card-clip" />
            <x-input.text method="c" type="text" name="first_name" title="first-name" icon="id-card" />
            <x-input.text method="c" type="text" name="last_name" title="last-name" icon="id-card" />
            <x-input.text method="c" type="email" name="email" title="email" icon="envelope" />
            <x-input.select method="c" name="phone_country_id" title="phone-country" :options="$phone_countries" option_value="id" option_name="NameAndCode" icon="flag" />
            <x-input.text method="c" type="number" name="phone" title="phone" icon="mobile-screen" />
            <x-input.text method="c" type="password" name="password" title="password" icon="lock" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete/>
    <x-crud.form.common.edit method="e">
        @section('edit-form')
            <x-input.select method="e" name="user_role_id" title="user-role" :options="$user_roles" option_value="id" option_name="title" icon="person-military-pointing" />
            <x-input.text method="e" type="text" name="username" title="username" icon="id-card-clip" />
            <x-input.text method="e" type="text" name="first_name" title="first-name" icon="id-card" />
            <x-input.text method="e" type="text" name="last_name" title="last-name" icon="id-card" />
            <x-input.text method="e" type="email" name="email" title="email" icon="envelope" />
            <x-input.select method="e" name="phone_country_id" title="phone-country" :options="$phone_countries" option_value="id" option_name="NameAndCode" icon="flag" />
            <x-input.text method="e" type="number" name="phone" title="phone" icon="mobile-screen" />
            <x-input.text method="e" type="password" name="password" title="password" icon="lock" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
