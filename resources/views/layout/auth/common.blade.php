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
    <div id="kp-loading" class="d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </div>
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

