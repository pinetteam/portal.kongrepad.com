<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('common.keypad-screen') }} | {{ config('app.name') }}</title>
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
@if($keypad)
    <div class="ms-2 w-100 overflow-hidden">
        <div class="card bg-dark shadow-lg m-5 px-5">
            <div class="card-body">

                <div class="ms-2 w-100 overflow-hidden">
                    <h1 class="fw-bold text-center text-white">{{ $keypad->keypad }}</h1>
                    <hr />
                    @foreach($keypad->options as $option)
                        @if($keypad->votes->count() != 0)
                            <div class="progress mt-2 h-25 bg-dark" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info text-white text-center p-2 overflow-visible" style="width: {{ $option->votes->count() / $keypad->votes->count()*100 }}%; font-size: 72px">
                                    {{ $option->option }} ({{$option->votes->count() / $keypad->votes->count()*100}}%)
                                </div>
                            </div>
                        @elseif($keypad->votes->count() == 0)
                            <div class="progress mt-2 h-25 bg-dark" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info text-white text-center p-2 overflow-visible" style="width: {{ $option->votes->count()}}%; font-size: 72px">
                                    {{ $option->option }} ({{ $option->votes->count() }}%)
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@else
    <h1 class="text-white text-center w-100" id="chair" style="font-size: 72px">
        <div class="spinner-grow text-success text-center" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </h1>
@endif
</body>
</html>

