<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>{{ucwords(__('common.log-in'))}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>

<body class="d-flex align-items-center bg-dark h-100">
<header class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow-lg" id="mp-header">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">KongrePad</a>
</header>
<div class="container mt-4">
    <div class="row vertical-offset-100 d-flex justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card text-bg-dark bg-gradient shadow-lg ">
                <div class="card-header">
                    <h1 class="text-center font-bold">{{ strtoupper(__('common.log-in')) }}</h1>
                </div>
                <div class="card-body">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form accept-charset="UTF-8" method="POST" role="form"
                                  action="{{ route("auth.login.store") }}">
                                @csrf
                                <fieldset>
                                    <p>
                                        <x-input.text name="username" title="username" icon="user"/>
                                    </p>
                                    <p>
                                        <x-input.text name="password" type="password" title="password" icon="lock"/>
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <div class="checkbox ">
                                            <label>
                                                <input id="remember "name="remember" type="checkbox"
                                                       value="Remember Me"> {{ __('common.remember-me') }}
                                            </label>
                                        </div>
                                        <div>
                                            <a class="text-info" href="#">{{ __('common.forgot-password') }}</a>
                                        </div>
                                    </div>
                                    <input class="btn btn-lg btn-block mt-2 bg-info" type="submit" value="{{ __('common.log-in') }}">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

