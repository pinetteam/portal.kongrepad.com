<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') }}</title>
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
        @if(Auth()->check() && isset(Auth()->user()->customer->title))
            {{ Auth()->user()->customer->title }}
        @else
            {{ config('app.name') }}
        @endif
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kp-menu" aria-controls="kp-menu" aria-expanded="false">
        <i class="fa-regular fa-bars" id="kp-navbar-icon"></i>
    </button>
</header>
<div class="container-fluid h-100">
    <div class="row h-100">
        <main class="ms-sm-auto px-md-4 flex-shrink-0" id="kp-main">
            <div class="card bg-dark">
                <div class="card-header bg-dark text-white">
                    <h1 class="m-0 text-center">{{ __('common.demo-request') }}</h1>
                </div>
                <div class="card-body mt-2">
                    <div class="container text-center">
                        <form method="POST" action="{{ route('demo.store') }}" name="demo-create-form" id="demo-create-form" enctype="multipart/form-data" autocomplete="nope">
                            @csrf
                            <div class="container-fluid">
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 justify-content-center">
                                    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-xs-1 row-gap-5">
                                        <x-input.text method="c" name="title" title="title" icon="input-text" />
                                        <x-input.text method="c" name="email" title="email" icon="envelope" />
                                        <x-input.text method="c" name="username" title="username" icon="user" />
                                        <x-input.password method="c" name="password" title="password" icon="lock" />
                                        <x-input.password method="c" name="repeat_password" title="repeat-password" icon="lock" />
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success w-75" id="demo-create-form-submit">{{ __('common.create') }}</button>
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

