<!DOCTYPE html>
    <html class="h-100">
        <head>
            <meta charset="utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <title>Home | {{ config('app.name') }}</title>
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
            <a class="navbar-brand ms-3 overflow-hidden ps-3" href="{{ route("auth.login.index") }}">
                {{ config('app.name') }}
            </a>
        </header>
        <div class="container">
            <div class="row h-100 vertical-offset-100 d-flex justify-content-center">
                    <div class="card bg-dark w-100 border-dark mt-sm-5">
                        <div class="card-body mt-2 mt-sm-5">
                            <div class="container text-center">
                                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-xs-1 row-cols-lg-2 column-gap-0 mt-md-5 mt-sm-5">
                                    <div class="col">
                                        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-xs-1 row-cols-lg-2 row-gap-5 mt-md-5 mt-sm-5">
                                            <div class="col">
                                                <div class="card bg-dark border-dark">
                                                    <div class="card-body">
                                                        <img class="img-responsive" style= "height: 490px; width: 260px" src="{{ asset('storage/images/homepage.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="card bg-dark border-dark">
                                                    <div class="card-body">
                                                        <img class="img-responsive" style= "height: 500px; width: 280px" src="{{ asset('storage/images/dashboard.png') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mt-5">
                                        <div class="card bg-dark border-dark shadow-lg rounded-4 mt-5">
                                            <div class="card-body">
                                                <h1 class="mt-5 text-center text-white">Welcome to KongrePad</h1>
                                                <a type="button" class="btn btn-secondary btn-lg rounded shadow-lg m-5" href="{{ route("auth.login.index") }}">Continue with Web</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <footer class="bg-dark text-light col-12 shadow" id="kp-footer">
                    Copyright © 2017-{{ date('Y') }} {{ config('app.name') }}
                </footer>
            </div>
        </div>
        </body>
    </html>

