<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('common.debate-screen') }} | {{ config('app.name') }}</title>
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
@if($debate)
    <div class="ms-2 w-100 overflow-hidden">
        <div class="fw-bold text-center text-white fs-3">{{ isset($debate->title) ? $debate->title . ' ' : null }}</div>
        <hr />
        @foreach($teams as $team)
            @if($debate->votes->count() != 0)
                <div class="progress mt-2 h-25 mx-5" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-black text-center p-2 overflow-visible" style="width: {{ $team->votes->count() / $debate->votes->count()*100 }}%">
                        {{ $team->title }} ({{ $team->votes->count() }} Votes)
                    </div>
                </div>
            @elseif($debate->votes->count() == 0)
                <div class="progress mt-2 h-25 mx-5" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-black text-center p-2 overflow-visible" style="width: {{ $team->votes->count()}}%">
                        {{ $team->title }} ({{ $team->votes->count() }} Votes)
                    </div>
                </div>
            @endif
        @endforeach
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

