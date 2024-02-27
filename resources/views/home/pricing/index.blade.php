<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') . ' | ' . __('common.pricing')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>
<header class="navbar navbar-dark fixed-top bg-dark p-0 shadow" id="kp-header">
    <a class="navbar-brand ms-3 overflow-hidden ps-3" href="{{ route("home.index") }}">
        {{ config('app.name') }}
    </a>
    <div class="text-end btn-group mx-3 gap-2">
        <a href="" class="btn btn-block text-end rounded-2 btn-sm text-white text-decoration-underline" tabindex="-1" role="button" aria-disabled="true">{{ trans('common.tutorials') }}</a>
        <a href="{{ route('home.pricing')}}" class="btn btn-block rounded-2 btn-sm text-white text-decoration-underline" tabindex="-1" role="button" aria-disabled="true">
            <span style="white-space: nowrap">{{ trans('common.pricing') }}</span>
        </a>
        <a href="{{ route('auth.login.index')}}" class="btn btn-primary btn-block text-end rounded-2 btn-sm" tabindex="-1" role="button" aria-disabled="true">{{ __('common.sign-in')}}</a>
        <a href="{{ route('register.index')}}" class="btn btn-success btn-block rounded-2 btn-sm" tabindex="-1" role="button" aria-disabled="true">
            <span style="white-space: nowrap">{{ __('common.try-it-for-free')}}</span>
        </a>
        <form action="{{ route('change.locale') }}" method="POST">
            @csrf
            <select name="locale" onchange="this.form.submit()">
                <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>TR</option>
                <option value="tr" {{ session('locale') == 'tr' ? 'selected' : '' }}>EN</option>
            </select>
        </form>
    </div>
</header>
<body class="d-flex flex-column bg-dark">
    <div id="kp-loading" class="d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </div>
    <div class="container mt-4" id="kp-home">
        <div class="row align-items-center text-center">
            <h1 class="text-center text-white"> {{ trans('common.prices') }} </h1>
            <hr>
        </div>
        <div class="row">
            <h6 class="text-center text-white"> {{ trans('common.each_participants_daily_login_is_deducted_from_you2') }}</h6>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4 mx-4 mb-4 mt-2">
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow-lg">
                    <div class="h1 m-3 text-center"><span class="fa-duotone fa-coins fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title text-center">50000 credit</h5>
                        <div class="h5 text-success card-body text-center">500$</div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow-lg">
                    <div class="h1 m-3 text-center"><span class="fa-duotone fa-coins fa-fade"></span></div>
                    <div class="card-body text-center">
                        <h5 class="card-title text-center">10000 credit</h5>
                        <div class="h5 text-success card-body text-center">500$</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow-lg">
                    <div class="h1 m-3 text-center"><span class="fa-duotone fa-coin fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title text-center">5000 credit</h5>
                        <div class="h5 text-success card-body text-center">500$</div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow-lg">
                    <div class="h1 m-3 text-center"><span class="fa-duotone fa-coin fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title text-center">1000 credit</h5>
                        <div class="h5 text-success card-body text-center">500$</div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow-lg">
                    <div class="h1 m-3 text-center"><span class="fa-duotone fa-coin fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title text-center">500 credit</h5>
                        <div class="h5 text-success card-body text-center">500$</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="text-center align-items-center">
                <a href="{{ route('register.index')}}" class="btn btn-success btn-block rounded-2 mb-3 mx-3 btn-md w-25 align-items-center" tabindex="-1" role="button" aria-disabled="true">
                    <span style="white-space: nowrap">{{ __('common.try-it-for-free')}}</span>
                    <span class="fa-solid fa-regular fa-arrow-right mx-2"></span>
                </a>
            </div>
        </div>
    </div>
</body>
<footer class="bg-dark text-light col-12 px-md-0 ms-sm-auto shadow" id="kp-footer">
    <div class="fixed-bottom bg-dark shadow px-md-4">Copyright © 2017-{{ date('Y') }} {{ config('app.name') }} </div>
</footer>
</html>
