<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-itunes-app" content="app-id=6463897045, app-argument=https://apps.apple.com/tr/app/kongrepad/id6463897045">
    <title>Home | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>
<header class="navbar navbar-dark fixed-top bg-dark p-0 shadow" id="kp-header">
    <a class="navbar-brand ms-3 overflow-hidden ps-3" href="{{ route("auth.login.index") }}">
        {{ config('app.name') }}
    </a>
    <div class="text-end btn-group mx-3 gap-2">
        <a href="{{ route('auth.login.index')}}" class="btn btn-primary btn-block text-end rounded-2 btn-sm" tabindex="-1" role="button" aria-disabled="true">{{ __('common.sign-in')}}</a>
        <a href="{{ route('register.index')}}" class="btn btn-success btn-block rounded-2 btn-sm" tabindex="-1" role="button" aria-disabled="true">
            <span style="white-space: nowrap">{{ __('common.try-it-for-free')}}</span>
        </a>
    </div>
</header>
<body class="d-flex flex-column h-100 bg-dark">
    <div id="kp-loading" class="d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </div>
    <div class="container mt-4" id="kp-home">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-2 gy-3 py-3 align-items-center">
            <div class="col mt-0">
                <div id="carouselExampleDark" class="carousel carousel-dark slide">
                    <div class="carousel-indicators mb-0">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    </div>
                    <div class="carousel-inner align-items-center">
                        <div class="carousel-item active align-items-center" data-bs-interval="10000">
                            <div class="container align-items-center mb-4">
                                <h1 class="border-bottom border-dark-subtle text-white text-center">What is KongrePad?</h1>
                                    <div class="row pt-2 align-items-center text-center">
                                        <div class="btn-group w-100 mb-4">
                                        <div class="col">
                                            <h5 class="text-white">KongrePad allows you to control your congress via a single phone application without the need for an extra device. Thanks to its database structure, it can be used in more than one congress at the same time.</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <div class="container align-items-center mb-4">
                                <h1 class="border-bottom border-dark-subtle text-white text-center">Advantages</h1>
                                <div class="row pt-2 align-items-center text-center">
                                    <div class="btn-group w-100 mb-4">
                                        <div class="col">
                                            <h5 class="text-white">The timer, session chair or speaker name, document, keypad and debate voting results can be dynamically displayed on the screens. The font, font size and background of each screen can be changed.</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <div class="container align-items-center mb-4">
                                <h1 class="border-bottom border-dark-subtle text-white text-center">{{ __('common.welcome-to-kongrepad')}}</h1>
                                <div class="row pt-2 align-items-center text-center">
                                    <div class="btn-group w-100 mb-4">
                                        <div class="col">
                                            <a href="{{ route('auth.login.index')}}" class="btn btn-primary w-75 btn-block rounded-2" tabindex="-1" role="button" aria-disabled="true">{{ __('common.sign-in')}}</a>
                                        </div>
                                        <div class="col">
                                            <a href="{{ route('register.index')}}" class="btn btn-success w-75 btn-block rounded-2" tabindex="-1" role="button" aria-disabled="true">
                                                <span style="white-space: nowrap">{{ __('common.try-it-for-free')}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <div class="container align-items-center">
                                <h1 class="border-bottom border-dark-subtle text-white text-center mb-0">Download KongrePad</h1>
                                <div class="row">
                                    <div class="col">
                                        <a href="https://apps.apple.com/tr/app/kongrepad/id6463897045" target="_blank" title="KongrePad AppStore">
                                            <img src="{{ asset('images/app-store-download.svg') }}" class="img-fluid" alt="KongrePad AppStore" />
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="https://play.google.com/store/apps/details?id=com.pinet.kongrepad&gl=TR" target="_blank" title="KongrePad PlayStore">
                                            <img src="{{ asset('images/play-store-download.svg') }}" class="img-fluid" alt="KongrePad PlayStore" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col justify-content-center align-items-center text-center">
                <div class="card text-bg-dark border-0">
                    <div class="card-body">
                        <img src="{{ asset('images/home-screenshot.png') }}" class="img-fluid rounded-2 w-50" alt="KongrePad 01" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow-lg">
                    <div class="h1 m-3"><span class="fa-duotone fa-square-poll-horizontal fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">Surveys</h5>
                        <p class="card-text">Surveys can be conducted and detailed survey reports can be obtained. All users can answer the surveys via their phone.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color1 text-white shadow-sm">
                    <div class="h1 m-3"><span class="fa-duotone fa-fade fa-calendar-week text-white"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">Keypads</h5>
                        <p class="card-text">Keypads can be made and detailed keypad reports can be obtained. All users can answer the question via their phone.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow-lg">
                    <div class="h1 m-3"><span class="fa-duotone fa-question fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">Asking Question</h5>
                        <p class="card-text">Participants can ask questions to the speaker anonymously or under their own names during the session.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color1 text-white shadow-sm">
                    <div class="h1 m-3"><span class="fa-duotone fa-podium-star fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">Debate</h5>
                        <p class="card-text">Debates can be created. You can create any teams you want. Participants can vote via the application.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow-lg">
                    <div class="h1 m-3"><span class="fa-duotone fa-chart-user fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">Reports</h5>
                        <p class="card-text">Thanks to the QR code scanning system, attendance at the session can be made and attendance can be seen. Thanks to the log system, user movements, keypad and debate participation and sessions can be reported. Surveys can be conducted and detailed survey reports can be obtained.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer class="bg-dark text-light col-12 px-md-4 ms-sm-auto px-md-4 shadow" id="kp-footer">
    Copyright © 2017-{{ date('Y') }} {{ config('app.name') }}
</footer>
</html>
