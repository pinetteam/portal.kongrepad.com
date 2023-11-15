<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-itunes-app" content="app-id=6463897045, app-argument=https://apps.apple.com/tr/app/kongrepad/id6463897045">
    <title>Home | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>
<header class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow justify-content-center" id="kp-header">
    <img src="{{ asset('images/kongrepad-icon.png') }}" class="img-fluid my-2" width="60" alt="KongrePad 01" />
</header>
<body class="d-flex flex-column h-100 bg-dark pt-5">
    <div id="kp-loading" class="d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </div>
    <div class="container" id="kp-home">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-2 gy-3 py-3">
            <div class="col pt-5">
                <div class="card text-bg-dark border-0">
                    <div class="card-body text-center">
                        <h1 class="border-bottom border-dark-subtle pt-4 pb-2">KongrePad'i indirin</h1>
                        <div class="row">
                            <div class="col">
                                <a href="https://apps.apple.com/tr/app/kongrepad/id6463897045" target="_blank" title="KongrePad AppStore">
                                    <img src="{{ asset('images/app-store-download.svg') }}" class="img-fluid" alt="KongrePad AppStore" />
                                </a>
                            </div>
                            <div class="col">
                                <a href="https://play.google.com/store/apps/details?id=com.pinet.kongrepad&gl=TR" target="_blank" title="KongrePad PlayStore">
                                    <img src="{{ asset('images/play-store-download.svg') }}" class="img-fluid" alt="KongrePad PlayStore" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-dark border-0">
                    <div class="card-body">
                        <img src="{{ asset('images/home-screenshot.png') }}" class="img-fluid rounded-2" alt="KongrePad 01" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer class="bg-dark text-light col-12 px-md-4 ms-sm-auto px-md-4 shadow" id="kp-footer">
    Copyright © 2017-{{ date('Y') }} {{ config('app.name') }}
</footer>
</html>
