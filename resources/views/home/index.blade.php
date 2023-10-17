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
        <header class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" id="kp-header">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 overflow-hidden text-center" href="{{ route("auth.login.index") }}">
                {{ config('app.name') }}
            </a>
        </header>
        <body class="d-flex bg-dark h-100 align-items-center overflow-scroll">
            <div id="kp-loading" class="d-flex align-items-center justify-content-center">
                <div class="spinner-grow text-success" role="status">
                    <span class="visually-hidden">{{ __('common.loading') }}</span>
                </div>
            </div>
            <div class="container overflow-scroll mt-5 py-5">
                <div class="row h-100 vertical-offset-100 d-flex justify-content-center">
                    <div class="card bg-dark w-100 border-dark ">
                        <div class="card-body">
                            <div class="container text-center">
                                <div class="row row-cols-1 row-cols-xs-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 column-gap-0 row-gap-5">
                                    <div class="col">
                                        <img class="img-fluid" src="{{ asset('images/homepage.png') }}">
                                    </div>
                                    <div class="col">
                                        <img class="img-fluid" src="{{ asset('images/dashboard.png') }}">
                                    </div>
                                    <div class="col">
                                        <div class="card bg-dark border-dark shadow-lg rounded-4 mt-5 p-4 overflow-hidden">
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
                </div>
            </div>
        </body>
        <footer class="bg-dark text-light col-12 shadow" id="kp-footer">
            Copyright © 2017-{{ date('Y') }} {{ config('app.name') }}
        </footer>
    </html>
