@extends('layout.auth.common')
@section('title', __('common.login'))
@section('body')
    <div class="card text-bg-dark shadow">
        <form method="POST" action="{{ route("auth.login.store") }}" name="auth-login-form" id="auth-login-form" autocomplete="off">
            @csrf
            <div class="card-header">
                <h1 class="font-bold pt-3"><span class="fa-duotone fa-shield-keyhole fa-fade"></span> {{ __('common.login') }}</h1>
            </div>
            <div class="card-body">
                <x-input.text name="username" title="username" icon="user" />
                <x-input.password name="password" title="password" icon="lock" />
                <x-input.checkbox name="remember_me" title="remember-me" :options="$remember" option_value="value" option_name="title" icon="cloud-check" fade="on" />
                <button type="submit" class="btn btn-success float-end mb-3 shadow">{{__('common.login')}}</button>
            </div>
        </form>
    </div>
@endsection
