@extends('layout.portal.common')
@section('title', __('common.user-roles') . ' | ' . $user_role->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.user-role.index") }}" class="text-decoration-none text-white">{{ __('common.user-roles') }}</a></li>
    <li class="breadcrumb-item active text-white" aria-current="page">{{ $user_role->title }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ $user_role->title }}</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ __('common.title') }}</h5>
                    <p>{{ $user_role->title }}</p>
                </div>
                <div class="col-md-6">
                    <h5>{{ __('common.status') }}</h5>
                    @if($user_role->status)
                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i> {{ __('common.active') }}
                    @else
                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i> {{ __('common.passive') }}
                    @endif
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <h5>{{ __('common.access-scopes') }}</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('common.route') }}</th>
                                    <th>{{ __('common.code') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($routes as $route)
                                    @if(in_array($route['route'], $user_role->routes))
                                        <tr>
                                            <td>{{ $route['route'] }}</td>
                                            <td>{{ $route['code'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <h5>{{ __('common.created_at') }}</h5>
                    <p>{{ $user_role->created_at ? $user_role->created_at->format('d.m.Y H:i:s') : '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h5>{{ __('common.updated_at') }}</h5>
                    <p>{{ $user_role->updated_at ? $user_role->updated_at->format('d.m.Y H:i:s') : '-' }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="btn-group w-100" role="group">
                <a href="{{ route('portal.user-role.index') }}" class="btn btn-secondary">{{ __('common.back') }}</a>
                <button class="btn btn-warning" data-bs-toggle="offcanvas" data-bs-target="#user-role-edit-modal" data-route="{{ route('portal.user-role.update', $user_role->id) }}" data-resource="{{ route('portal.user-role.edit', $user_role->id) }}">{{ __('common.edit') }}</button>
                <button class="btn btn-danger" data-bs-toggle="offcanvas" data-bs-target="#user-role-delete-modal" data-route="{{ route('portal.user-role.destroy', $user_role->id) }}" data-record="{{ $user_role->title}}">{{ __('common.delete') }}</button>
            </div>
        </div>
    </div>
    
    <x-crud.form.common.delete name="user-role" />
    <x-crud.form.common.edit name="user-role">
        @section('user-role-edit-form')
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.checkbox method="e" name="routes" title="access-scopes" :options="$routes" option_value="route" option_name="code" icon="ballot-check" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection 