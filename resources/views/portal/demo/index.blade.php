<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') . ' | ' . __('common.demo-request')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>
<header class="navbar navbar-dark fixed-top bg-dark p-0 shadow" id="kp-header">
    <a class="navbar-brand ms-3 overflow-hidden ps-3" href="{{ route("auth.login.index") }}">
        {{ config('app.name') }}
    </a>
</header>
<body class="d-flex flex-column h-100">
    <div id="kp-loading" class="d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </div>
        <div class="bg-image p-0 overflow-x-hidden" style="background-image: url('{{ URL::asset('images/registration.png')}}');background-size: cover;   background-repeat: no-repeat;background-position: center}">
            <div class="row h-100">
                <main class="ms-sm-auto px-md-4 flex-shrink-0" id="kp-main">
                    <div class="card bg-transparent border-0">
                        <div class="card-body m-2 justify-content-center w-100">
                            <div class="container text-center justify-content-center align-items-center">
                                <form method="POST" action="{{ route('demo.store') }}" name="demo-create-form" id="demo-create-form" enctype="multipart/form-data" autocomplete="nope">
                                    @csrf
                                    <div class=" w-100 container justify-content-center align-items-center">
                                        <div class="col-md-6 offset-md-3">
                                            <div class="w-100 h-1 row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-xs-1 row-gap-1">
                                                <div class="row">
                                                    <h1 class="m-0 text-center text-dark-emphasis">{{ __('common.demo-request') }}</h1>
                                                </div>
                                                <hr/>
                                                <div class="row">
                                                    <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                        <x-input.text method="c" name="title" title="title" icon="input-text" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                        <x-input.text method="c" name="email" title="email" icon="envelope" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                        <x-input.text method="c" name="username" title="username" icon="user" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                        <x-input.password method="c" name="password" title="password" icon="lock" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                        <x-input.password method="c" name="repeat_password" title="repeat-password" icon="lock" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="card bg-transparent border-0 text-dark-emphasisp-0 px-2">
                                                        <x-input.select method="c" name="timezone" title="timezone" :options="$timezones" option_value="value" option_name="title" icon="flag" :searchable="true" />                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                        <x-input.select method="c" name="time_format" title="time-format" :options="$time_formats" option_value="value" option_name="title" icon="clock" />
                                                    </div>
                                                </div>
                                                <div class="row row-cols-1 row-cols-md-2 row-cols-sm-1 row-cols-xl-2 justify-content-center mt-2">
                                                    <div class="col mb-2">
                                                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            <span class="fa-plus" style="white-space: nowrap;white-space: small"> {{ __('common.add-more-information') }}</span>
                                                        </button>
                                                    </div>
                                                    <div class="col">
                                                        <button type="submit" class="btn btn-success w-100" id="demo-create-form-submit">
                                                            <span style="white-space: nowrap">{{ __('common.try-it-for-free')}}</span></button>
                                                    </div>
                                                    <p class="mt-2">{{ __('common.do-you-have-an-account')}} <a href="{{ route('auth.login.index')}}" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{ __('common.sign-in')}}</a></p>
                                                </div>
                                                <div class="modal fade justify-content-center" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog justify-content-center">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <span class="modal-title fs-4 text-dark" id="exampleModalLabel">{{ __('common.add-more-information') }}</span>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <hr class="text-black m-0">
                                                            <div class="modal-body">
                                                                <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                                    <x-input.text method="c" name="web_address" title="web-address" icon="globe" />
                                                                </div>
                                                                <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                                    <x-input.text method="c" name="address" title="address" icon="location-dot" />
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                                            <x-input.select method="c" name="phone_country" title="phone-country" :options="$phone_countries" option_value="phone_code" option_name="name" icon="flag" :searchable="true" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                                            <x-input.text method="c" name="phone" title="phone" icon="mobile-screen" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                                                <x-input.select method="c" name="date_format" title="date-format" :options="$date_formats" option_value="value" option_name="title" icon="calendar" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="card bg-transparent border-0 text-dark-emphasis px-2">
                                                                                <x-input.select method="c" name="datetime_format" title="date-time-format" :options="$datetime_formats" option_value="value" option_name="title" icon="calendar" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-success w-100 my-2" id="demo-create-form-submit">{{ __('common.try-it-for-free') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    <footer class="bg-dark text-light col-12 px-md-4 ms-sm-auto px-md-4 shadow" id="kp-footer">
        Copyright © 2017-{{ date('Y') }} {{ config('app.name') }}
    </footer>
<x-common.popup.default />
</body>
</html>

