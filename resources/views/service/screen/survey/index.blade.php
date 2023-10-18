<!DOCTYPE html>
    <html class="h-100">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ __('common.questions-screen') }} | {{ config('app.name') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
    </head>
    <body class="d-flex bg-dark h-100 align-items-center">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div id="carouselExample" class="carousel slide d-flex">
                    <div class="carousel-inner h-100">
                        <div class="carousel-item active">
                            <h1>{{ $survey->title }}</h1>
                        </div>
                        @foreach($survey->questions as $question)
                            <div class="carousel-item">
                                <div class="fw-bold text-white fs-6">{{ $question->question }}</div>
                                <hr />
                                <ol class="list-group">
                                    @foreach($question->options as $option)
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-dark border-dark text-white">
                                        {{ $option->option }}<span class="badge badge-warning">({{$option->votes->count()}} votes)</span>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </body>
    </html>
