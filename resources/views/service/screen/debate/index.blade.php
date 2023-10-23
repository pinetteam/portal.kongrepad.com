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
        <div class="card bg-dark shadow-lg m-5 px-5">
            <div class="card-body">
                <div class="fw-bold text-center text-white fs-3">{{ isset($debate->title) ? $debate->title . ' ' : null }}</div>
                <hr />
                <ol class="list-group align-content-center">
                @foreach($teams as $team)
                    <li class="list-group-item overflow-scroll bg-dark border-dark text-white">
                        {{ $team->title }}<span class="p-1 mx-2 badge bg-success rounded-4 text-start text-black">({{ $team->votes->count() }} Votes)</span>
                    </li>
                @endforeach
                </ol>
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

