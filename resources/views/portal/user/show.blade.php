@extends('layout.portal.common')
@section('title', $user->full_name)
@section('breadcrumb')
    <li class="breadcrumb-item text-white"><a href="{{ route("portal.user.index") }}" class="text-decoration-none">{{ __('common.users') }}</a></li>
    <li class="breadcrumb-item active text-white" aria-current="page">{{ $user->full_name }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center"><span class="fa-duotone fa-screen-users fa-fade"></span> <small>"{{ $user->full_name }}"</small></h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                        <td class="text-start w-25">{{ $user->title }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.name') }}:</th>
                        <td class="text-start w-25">
                            @if($user->activity_status)
                                <i style="color:green" class="fa-regular fa-toggle-on"></i>
                            @else
                                <i style="color:red" class="fa-regular fa-toggle-off"></i>
                            @endif
                            {{ $user->full_name }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.email') }}:</th>
                        <td class="text-start w-25">{{ $user->email }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.identification-number') }}:</th>
                        <td class="text-start w-25">{{ $user->identification_number }}</td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.phone') }}:</th>
                        <td class="text-start w-25">{{ $user->full_phone }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.status') }}:</th>
                        <td class="text-start w-25">
                            @if($user->status)
                                {{ __('common.active') }}
                            @else
                                {{ __('common.passive') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                        <td class="text-start w-25">{{ $user->created_by_name }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                        <td class="text-start w-25">{{ $user->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
