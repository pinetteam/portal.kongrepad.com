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
<body class="d-flex flex-column h-100">
<div id="kp-loading" class="d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-success" role="status">
        <span class="visually-hidden">{{ __('common.loading') }}</span>
    </div>
</div>
<header class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" id="kp-header">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 overflow-hidden text-center" href="{{ route("portal.dashboard.index") }}">
        {{ config('app.name') }}
    </a>
</header>
<div class="container-fluid h-100">
    <div class="row h-100">
        <main class="ms-sm-auto px-md-4 flex-shrink-0" id="kp-main">
            <div class="card bg-dark">
                <div class="card-header bg-dark text-white">
                    <h1 class="m-0 text-center">{{ __('common.demo-request') }}</h1>
                </div>
                <div class="card-body m-2">
                    <div class="container text-center">
                        <form method="POST" action="{{ route('demo.store') }}" name="demo-create-form" id="demo-create-form" enctype="multipart/form-data" autocomplete="nope">
                            @csrf
                            <div class="container-fluid">
                                <div class="row row-cols-1 row-cols-sm-1 row-cols-xl-1 justify-content-center">
                                    <div class="w-50 h-1 row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-xs-1 row-gap-3 shadow-lg">
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.text method="c" name="title" title="title" icon="input-text" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.text method="c" name="email" title="email" icon="envelope" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.text method="c" name="username" title="username" icon="user" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.password method="c" name="password" title="password" icon="lock" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.password method="c" name="repeat_password" title="repeat-password" icon="lock" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.file method="c" name="logo" title="logo" icon="image"/>
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.text method="c" name="web_address" title="web-address" icon="globe" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.text method="c" name="address" title="address" icon="location-dot" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.select method="c" name="phone_country" title="phone-country" :options="$phone_countries" option_value="phone_code" option_name="name" icon="flag" :searchable="true" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.text method="c" name="phone" title="phone" icon="mobile-screen" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.select method="c" name="timezone" title="timezone" :options="$timezones" option_value="value" option_name="title" icon="flag" :searchable="true" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.select method="c" name="time_format" title="time-format" :options="$time_formats" option_value="value" option_name="title" icon="clock" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.select method="c" name="date_format" title="date-format" :options="$date_formats" option_value="value" option_name="title" icon="calendar" />
                                        </div>
                                        <div class="card bg-dark border-dark text-white mt-2 shadow-sm p-2">
                                            <x-input.select method="c" name="datetime_format" title="date-time-format" :options="$datetime_formats" option_value="value" option_name="title" icon="calendar" />
                                        </div>
                                        <button type="submit" class="btn btn-success w-100 mb-2" id="demo-create-form-submit">{{ __('common.create') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <footer class="bg-dark text-light col-12 px-md-4 ms-sm-auto px-md-4 shadow" id="kp-footer">
            Copyright © 2017-{{ date('Y') }} {{ config('app.name') }}
        </footer>
    </div>
</div>
<x-common.popup.default />
</body>
</html>

