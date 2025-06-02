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
<body class="d-flex flex-column h-100 align-items-center">
    <div id="kp-loading" class="d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </div>
    <header class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" id="kp-header">
        <a class="navbar-brand me-0 px-3 overflow-hidden text-center" href="{{ route("home.index") }}">
            {{ config('app.name') }}
        </a>
        <div class="navbar-nav d-flex">
            <form action="{{ route('change.locale') }}" method="POST">
                @csrf
                <select class="bg-dark text-light mx-4 mx-lg-3 mt-lg-0 mt-2 mb-2 mb-lg-0" name="locale" onchange="this.form.submit()">
                    @foreach($activeLanguages as $language)
                        <option value="{{ $language->code }}" {{ session('locale') == $language->code ? 'selected' : '' }}>
                            {{ strtoupper($language->code) }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </header>
    <div class="container-fluid h-100">
        <div class="row h-100 vertical-offset-100 justify-content-center">
            <main class="h-100" id="kp-main">
                @yield('body')
            </main>
        </div>
    </div>
    <footer class="bg-dark text-light col-12 px-2 ms-sm-auto shadow" id="kp-footer">
        Copyright © 2017-{{ date('Y') }} {{ config('app.name') }}
    </footer>
    <x-common.popup.default />
    @yield('footer')
</body>
</html>
