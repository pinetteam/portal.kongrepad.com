<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('common.survey-screen') }} | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>
<body class="d-flex bg-dark h-100 align-items-center">
<div class="container-fluid h-100">
    <div class="row h-100 align-items-center">
        <div id="carouselExample" class="carousel slide d-flex">
            <div class="carousel-inner h-100">
                <div class="carousel-item active">
                    <h1 class="text-center text-white">{{ $survey->title }}</h1>
                    <h2 class="text-center text-white">{{ $survey->description }}</h2>
                </div>
                @foreach($survey->questions as $question)
                    <div class="carousel-item p-5">
                        <div class="card bg-dark shadow-lg m-5">
                            <div class="card-body overflow-scroll text-center">
                                <ol class=" list-group-item fw-bold text-white fs-4 bg-dark border-dark">{{ $question->question }}</ol>
                                <hr />
                                <ol class="list-group list-group-flush align-items-start justify-content-center">
                                    @foreach($question->options as $option)
                                        <li class="list-group-item overflow-scroll bg-dark border-dark text-white">
                                            {{ $option->option }}<span class="p-1 mx-2 badge bg-success rounded-4 text-start text-black">({{ $option->votes->count() }} Votes)</span>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
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
