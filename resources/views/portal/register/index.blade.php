<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') . ' | ' . __('common.register')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>
<header class="navbar navbar-dark fixed-top bg-dark p-0 shadow" id="kp-header">
    <a class="navbar-brand ms-3 overflow-hidden ps-3" href="https://kongrepad.com">
        {{ config('app.name') }}
    </a>
    <form action="{{ route('change.locale') }}" method="POST">
        @csrf
        <select class="bg-color2 text-light mx-4 mx-lg-3 mt-lg-0 mt-2 mb-2 mb-lg-0" name="locale" onchange="this.form.submit()">
            <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>EN</option>
            <option value="tr" {{ session('locale') == 'tr' ? 'selected' : '' }}>TR</option>
        </select>
    </form>
</header>
<body class="d-flex flex-column h-100">
<div id="kp-loading" class="d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-success" role="status">
        <span class="visually-hidden">{{ __('common.loading') }}</span>
    </div>
</div>
<div class="bg-gradient bg-dark p-0 overflow-x-hidden text-white">
    <div class="row h-100">
        <main class="ms-sm-auto px-md-4 flex-shrink-0" id="kp-main">
            <div class="card bg-transparent justify-content-center w-100 m-0 border-0 mt-2">
                <div class="container text-center align-items-center container-fluid content-row d-block">
                    <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                        Register now and get <strong>100 free credits!</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('register.store') }}" name="register-create-form" id="register-create-form" enctype="multipart/form-data" autocomplete="nope">
                        @csrf
                        <div class="col justify-content-center align-items-center">
                            <div class="row">
                                <h1 class="m-0 text-center text-white">{{ __('common.register') }}</h1>
                            </div>
                            <hr class="text-white"/>
                            <div class="row align-items-center text-center justify-content-center">
                                <div class="col col-sm-12 col-lg-6 p-0 flex-column">
                                    <div class="card bg-transparent text-center p-5 text-black">
                                        <h5 class="text-white">{{ trans('common.create_your_kongrepad_account') }}</h5>
                                        <hr class="text-light">
                                        <div class="row">
                                            <div class="card bg-transparent border-0 text-white px-2">
                                                <x-input.text method="c" name="title" title="company-title" icon="input-text"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="card bg-transparent border-0 text-white px-2">
                                                <x-input.text method="c" name="email" title="email" icon="envelope" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="card bg-transparent border-0 text-white px-2">
                                                <x-input.text method="c" name="username" title="username" icon="user" :value="$random_username"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-sm-12 col-lg-6 p-0">
                                                <div class="card bg-transparent border-0 text-white px-2">
                                                    <x-input.select method="c" name="phone_country" title="phone-country" :options="$phone_countries" option_value="id" option_name="NameAndCode" icon="flag" :searchable="true" />
                                                </div>
                                            </div>
                                            <div class="col col-sm-12 col-lg-6 p-0">
                                                <div class="card bg-transparent border-0 text-white px-2">
                                                    <x-input.text method="c" name="phone" title="phone" icon="mobile-screen" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-sm-12 col-lg-6 p-0">
                                                <div class="card bg-transparent border-0 text-white px-2">
                                                    <x-input.password method="c" name="password" title="password" icon="lock" />
                                                </div>
                                            </div>
                                            <div class="col col-sm-12 col-lg-6 p-0">
                                                <div class="card bg-transparent border-0 text-white px-2">
                                                    <x-input.password method="c" name="repeat_password" title="repeat-password" icon="lock" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--- <div class="col p-0 w-100 d-block">
                                    <div class="card text-center bg-transparent border-0 p-5 text-white">
                                        <h5 class="text-white">{{ trans('common.add_more_informationoptional') }}</h5>
                                        <hr>
                                        <div class="row">
                                            <div class="col">
                                                <div class="card bg-transparent border-0 text-white p-0 px-2">
                                                    <x-input.select method="c" name="date_format" title="date-format" :options="$date_formats" option_value="value" option_name="title" icon="calendar" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="card bg-transparent border-0 text-white p-0 px-2">
                                                    <x-input.select method="c" name="timezone" title="timezone" :options="$timezones" option_value="value" option_name="title" icon="flag" :searchable="true" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="card bg-transparent border-0 text-white -0 px-2">
                                                    <x-input.select method="c" name="time_format" title="time-format" :options="$time_formats" option_value="value" option_name="title" icon="clock" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card bg-transparent border-0 text-white px-2">
                                            <x-input.text method="c" name="web_address" title="web-address" icon="globe" />
                                        </div>
                                        <div class="card bg-transparent border-0 text-white px-2">
                                            <x-input.text method="c" name="address" title="address" icon="location-dot" />
                                        </div>
                                    </div>
                                </div> --->
                            </div>
                            <div class="row justify-content-center mt-2">
                                <button type="submit" class="btn btn-success w-50 btn-block" id="register-create-form-submit">
                                    <span style="white-space: nowrap">{{ __('common.try-it-for-free')}}</span>
                                </button>
                            </div>
                            <div class="row">
                                <p class="mt-2 text-white">{{ __('common.do-you-have-an-account')}} <a href="{{ route('auth.login.index')}}" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover text-info">{{ __('common.sign-in')}}</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
<footer class="bg-dark text-light col-12 shadow px-2" id="kp-footer">
    Copyright © 2017-{{ date('Y') }} {{ config('app.name') }}
</footer>
<x-common.popup.default />
</body>
</html>

