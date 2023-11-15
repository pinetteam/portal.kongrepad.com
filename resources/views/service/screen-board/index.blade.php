<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{__('common.screen-board')}} | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>
<body class="d-flex bg-dark flex-column h-100">
<div class="container-fluid h-100">
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-display fa-fade"></span> <small>"{{ $hall->title }}"</small> {{ __('common.screens') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                        <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}</th>
                        <th scope="col"><span class="fa-regular fa-tv mx-1"></span> {{ __('common.content') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($screens as $screen)
                        <tr>
                            <td>{{ $screen->title }}</td>
                            <td>{{ __('common.'.$screen->type) }}</td>
                            <td>
                                @if($screen->type == 'speaker')
                                    <form method="POST" action="{{ route('service.screen-board.speaker-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                        <div class="container-fluid">
                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 justify-content-start align-items-center">
                                                @csrf
                                                <div class="col form-group mb-3">
                                                <x-input.select method="c" name="speaker_id" title="speaker" :options="$participants" option_value="id" option_name="full_name" icon="person-chalkboard" />
                                                </div>
                                                <div class="col form-group mb-3">
                                                <button type="submit" class="btn btn-success w-75" id="create-form-submit-{{ $screen->id }}">{{ __('common.edit') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @elseif($screen->type == 'chair')
                                    <form method="POST" action="{{ route('service.screen-board.chair-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                        <div class="container-fluid">
                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 justify-content-start align-items-center">
                                                @csrf
                                                <div class="col form-group mb-3">
                                                <x-input.select method="c" name="chair_id" title="chair" :options="$participants" option_value="id" option_name="full_name" icon="person-chalkboard" />
                                                </div>
                                                <div class="col form-group mb-3">
                                                <button type="submit" class="btn btn-success w-75" id="create-form-submit-{{ $screen->id }}">{{ __('common.edit') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @elseif($screen->type == 'keypad')
                                    <form method="POST" action="{{ route('service.screen-board.keypad-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                        <div class="container-fluid">
                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 justify-content-start align-items-center">
                                                @csrf
                                                <div class="col form-group mb-3">
                                                <x-input.select method="c" name="keypad_id" title="keypad" :options="$keypads" option_value="id" option_name="title" icon="tablet" />
                                                </div>
                                                <div class="col form-group mb-3">
                                                <button type="submit" class="btn btn-success w-75" id="create-form-submit-{{ $screen->id }}">{{ __('common.edit') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                    @if($screen->type == 'speaker')
                                        <a class="btn btn-outline-success btn-sm" href="{{ route('service.screen.speaker.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="{{ __('common.screen') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.screen') }}" target="_blank">
                                            <span class="fa-regular fa-tv"></span>
                                        </a>
                                    @elseif($screen->type == 'chair')
                                        <a class="btn btn-outline-success btn-sm" href="{{ route('service.screen.chair.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="{{ __('common.screen') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.screen') }}" target="_blank">
                                            <span class="fa-regular fa-tv"></span>
                                        </a>
                                    @elseif($screen->type == 'questions')
                                        <a class="btn btn-outline-success btn-sm" href="{{ route('service.screen.keypad.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="{{ __('common.questions') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.questions') }}" target="_blank">
                                            <span class="fa-regular fa-tv"></span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
