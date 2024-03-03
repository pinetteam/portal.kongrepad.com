@extends('layout.auth.common')
@section('title', __('common.verify'))
@section('body')
    <div class="card text-bg-dark shadow">
        <form method="POST" action="{{ route("portal.sms-verification.store") }}" name="auth-login-form" id="auth-login-form" autocomplete="off">
            @csrf
            <div class="card-header">
                <h1 class="font-bold pt-3"><span class="fa-duotone fa-shield-keyhole fa-fade"></span> {{ __('common.verify-your-phone-number') }}</h1>
            </div>
            <div class="card-body">
                <p>{{ __('common.enter-the-code') }}</p>
                <x-input.number name="code" title="code" icon="number" />
                <button type="submit" class="btn btn-success float-end mb-3 shadow">{{__('common.send')}}</button>
            </div>
        </form>
    </div>
    <a class="btn btn-info btn-sm" href="{{ route('portal.send-sms.index') }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
        <span class="fa-regular fa-eye"></span> {{__('common.resend-sms')}}
    </a>
    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
        <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#user-edit-modal" data-route="{{ route('portal.phone.update') }}" data-resource="{{ route('portal.user.get-phone', \Illuminate\Support\Facades\Auth::user()->id) }}" data-id="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
            <span class="fa-regular fa-pen-to-square"></span> {{__('common.edit-phone-number')}}
        </button>
    </div>
    <x-crud.form.common.edit name="user">
        @section('user-edit-form')
            <x-input.select method="e" name="phone_country_id" title="phone-country" :options="$phone_countries" option_value="id" option_name="NameAndCode" icon="flag" :searchable="true" />
            <x-input.number method="e" name="phone" title="phone" icon="mobile-screen" />
        @endsection
    </x-crud.form.common.edit>
@endsection
