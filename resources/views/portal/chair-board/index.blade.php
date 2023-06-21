<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{__('common.chair-board')}} | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>
<body class="d-flex flex-column h-100">
<header class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" id="kp-header">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 overflow-hidden text-center" href="{{ route("portal.dashboard.index") }}">
        @if(Auth()->check() && isset(Auth()->user()->customer->title))
            {{ Auth()->user()->customer->title }}
        @else
            {{ config('app.name') }}
        @endif
    </a>
</header>
<main class="col-md-12 col-lg-12 ms-sm-auto px-md-4 flex-grow-1 d-flex align-items-stretch" id="kp-main">
    <div class="card text-center text-bg-dark w-100">
        <div class="card-body">
            @isset($session)
                <div class="card text-bg-dark mt-2">
                    <div class="card-header">
                        <h1 class="m-0 text-center">{{ $session->title.' | '.__('common.questions') }}</h1>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover">

                                <thead class="thead-dark">
                                <tr>

                                    <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span> {{ __('common.question-title') }}</th>
                                    <th scope="col"><span class="fa-regular fa-presentation-screen mx-1"></span> {{ __('common.on-screen') }}</th>
                                    <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                                    <th scope="col" class="text-end"></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <td>{{$question->title}}</td>
                                        <td>
                                            <a href="{{ route('portal.session-question.on-screen', [$question->id]) }}" title="{{ __('common.on-screen') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.on-screen') }}">
                                                @if($question->on_screen)
                                                    <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                                @else
                                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            @if($question->status)
                                                <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                            @else
                                                <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                    <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#default-delete-modal" data-route="{{ route('portal.session-question.destroy', $question->id) }}" data-record="{{ $question->title }}">
                                                        <span class="fa-regular fa-trash"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <x-crud.form.common.delete />
                    <x-common.popup.default />
                </div>
        </div>
            @endisset
        </div>
    </div>
</main>
