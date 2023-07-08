<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>
<body class="d-flex bg-dark h-100 align-items-center">
    <header class="navbar navbar-dark fixed-top bg-dark p-0 shadow" id="kp-header">
        <a class="navbar-brand ms-3 overflow-hidden ps-3" href="{{ route("auth.login.index") }}">
            {{ config('app.name') }}
        </a>
    </header>
    <div class="container">
        <div class="row h-100 vertical-offset-100 d-flex justify-content-center">
            <main class="col-md-6 col-lg-4 flex-shrink-0 h-100" id="kp-main">
                @yield('body')
            </main>
            <footer class="bg-dark text-light col-12 shadow" id="kp-footer">
                Copyright © 2017-{{ date('Y') }} {{ config('app.name') }}
            </footer>
        </div>
    </div>
    <x-common.popup.default />
</body>
</html>

