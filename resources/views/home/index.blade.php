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
<header class="navbar navbar-dark fixed-top bg-dark p-0 shadow" id="kp-header">
    <a class="navbar-brand ms-3 overflow-hidden ps-3" href="{{ route("auth.login.index") }}">
        {{ config('app.name') }}
    </a>
    <div class="text-end btn-group mx-3 gap-2">
        <a href="{{ route('auth.login.index')}}" class="btn btn-primary btn-block text-end rounded-2 btn-sm" tabindex="-1" role="button" aria-disabled="true">{{ __('common.sign-in')}}</a>
        <a href="{{ route('register.index')}}" class="btn btn-success btn-block rounded-2 btn-sm" tabindex="-1" role="button" aria-disabled="true">
            <span style="white-space: nowrap">{{ __('common.try-it-for-free')}}</span>
        </a>
    </div>
</header>
<body class="d-flex flex-column h-100 bg-dark">
    <div id="kp-loading" class="d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </div>
    <div class="container mt-4" id="kp-home">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-2 gy-3 py-3 align-items-center">
            <div class="col mt-0">
                <div id="carouselExampleDark" class="carousel carousel-dark slide">
                    <div class="carousel-indicators mb-0">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner align-items-center">
                        <div class="carousel-item active align-items-center" data-bs-interval="10000">
                            <div class="container align-items-center mb-4">
                                <h1 class="border-bottom border-dark-subtle text-white text-center">{{ __('common.welcome-to-kongrepad')}}</h1>
                                    <div class="row pt-2 align-items-center text-center">
                                        <div class="btn-group w-100 mb-4">
                                        <div class="col">
                                            <a href="{{ route('auth.login.index')}}" class="btn btn-primary w-75 btn-block rounded-2" tabindex="-1" role="button" aria-disabled="true">{{ __('common.sign-in')}}</a>
                                        </div>
                                        <div class="col">
                                            <a href="{{ route('register.index')}}" class="btn btn-success w-75 btn-block rounded-2" tabindex="-1" role="button" aria-disabled="true">
                                                <span style="white-space: nowrap">{{ __('common.try-it-for-free')}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Second slide label</h5>
                                <p>Some representative placeholder content for the second slide.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Third slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col justify-content-center align-items-center text-center">
                <div class="card text-bg-dark border-0">
                    <div class="card-body">
                        <img src="{{ asset('images/home-screenshot.png') }}" class="img-fluid rounded-2 w-75" alt="KongrePad 01" />
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
