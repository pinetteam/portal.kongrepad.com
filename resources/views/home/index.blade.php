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
<nav class="navbar navbar-dark navbar-expand-lg sticky-top bg-dark p-0 shadow" id="kp-header">
    <div class="container-fluid">
        <a class="navbar-brand ms-3 overflow-hidden ps-3" href="{{ route("home.index") }}">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pb-2" id="navbarTogglerDemo01">
                <ul class="navbar-nav mx-4">
                    <li class="nav-item">
                        <a href="" class="nav-link text-white" tabindex="-1" role="button" aria-disabled="true">{{ trans('common.tutorials') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('home.pricing')}}" class="nav-link text-white" tabindex="-1" role="button" aria-disabled="true">
                            <span style="white-space: nowrap">{{ trans('common.pricing') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('auth.login.index')}}" class="nav-link text-light" tabindex="-1" role="button" aria-disabled="true">{{ __('common.sign-in')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register.index')}}" class="btn btn-orange btn-block rounded-2 btn-sm text-light mx-2" tabindex="-1" role="button" aria-disabled="true">
                            <span style="white-space: nowrap">{{ __('common.try-it-for-free')}}</span>
                        </a>
                    </li>
                </ul>
        </div>
        <form action="{{ route('change.locale') }}" method="POST">
            @csrf
            <select class="bg-color2 text-light mx-5 mx-lg-3 my-lg-0 my-2 px-2" name="locale" onchange="this.form.submit()">
                <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>EN</option>
                <option value="tr" {{ session('locale') == 'tr' ? 'selected' : '' }}>TR</option>
            </select>
        </form>
    </div>
</nav>
<body class="d-flex flex-column bg-dark">
    <div id="kp-loading" class="d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </div>
    <div class="container-fluid background-image" id="kp-home">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-2 gy-3 py-3 align-items-center">
            <div class="col mt-0">
                <div id="carouselExampleDark" class="carousel carousel-dark slide">
                    <div class="carousel-indicators mb-0">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    </div>
                    <div class="carousel-inner align-items-center">
                        <div class="carousel-item active align-items-center" data-bs-interval="10000">
                            <div class="container align-items-center mb-4 mx-lg-3">
                                <h1 class="border-bottom border-dark-subtle text-white text-center">{{ trans('common.what_is_kongrepad') }}</h1>
                                    <div class="row pt-2 align-items-center text-center">
                                        <div class="btn-group w-100 mb-4">
                                        <div class="col">
                                            <h5 class="text-white">{{ trans('common.kongrepad_is_an_application_platform_with_live_key') }}</h5>
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
                    </div>
                </div>
            </div>
            <div class="col justify-content-center align-items-center text-center">
                <div class="card text-bg-dark border-0">
                    <div class="card-body">
                        <img src="{{ asset('images/homepage.png') }}" class="img-fluid rounded-2 w-100" alt="KongrePad 01" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-lg-4 mx-2">
            <h3 class="text-light">{{ trans('common.empower_your_events_elevate_your_experience_stream') }}</h3>
            <hr class="text-light">
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4 text-center mx-lg-4 mx-2">
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-cloud-check fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.cloud_based') }}</h5>
                        <p class="card-text">{{ trans('common.manage_your_congress_from_anywhere_with_its_web_ap') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-mobile-signal-out fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.mobile_app') }}</h5>
                        <p class="card-text">{{ trans('common.with_kongrepad_participants_can_access_the_congres') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-user-tie fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.easy_to_use') }}</h5>
                        <p class="card-text">{{ trans('common.thanks_to_its_userfriendly_interface_it_is_now_ver') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-people-roof fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.multiple_users') }}</h5>
                        <p class="card-text">{{ trans('common.add_as_many_users_as_you_want_to_your_account_and') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-coin fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.affordable') }}</h5>
                        <p class="card-text">{{ trans('common.experience_highquality_functionality_without_break') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-video fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.video_tutorials') }}</h5>
                        <p class="card-text">{{ trans('common.take_advantage_of_free_tutorials_whenever_you_need') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-2 mx-lg-4 my-3">
            <hr class="text-light">
            <p class="text-light"><span class="fa-regular fa-solid fa-thumbtack px-2"></span> {{ trans('common.introducing_kongrepad_a_revolutionary_congress_mana') }}</p>
            <a href="{{ route('register.index')}}" class="btn btn-success btn-block rounded-2 mx-3 btn-sm w-25" tabindex="-1" role="button" aria-disabled="true">
                <span>{{ __('common.try-it-for-free')}}</span>
                <span class="fa-solid fa-regular fa-arrow-right mx-2"></span>
            </a>
        </div>
        <div class="row mx-2 mx-lg-4">
            <h3 class="text-light mt-2">{{ trans('common.check_out_the_services_kongrepad_offers') }}</h3>
            <hr class="text-light">
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4 mb-5 justify-content-center text-center mx-2 mx-lg-4">
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-square-poll-horizontal fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.follow_live_document') }}</h5>
                        <p class="card-text">{{ trans('common.the_user_can_watch_the_speakers_onscreen_presentat') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-fade fa-calendar-week text-white"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.keypad_questions') }}</h5>
                        <p class="card-text">{{ trans('common.publish_keypad_questions_that_users_can_answer_ins') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-question fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.asking_question') }}</h5>
                        <p class="card-text">{{ trans('common.the_user_can_ask_questions_to_the_speaker_via_hish') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-podium-star fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.debate_voting') }}</h5>
                        <p class="card-text">{{ trans('common.offer_debate_voting_so_users_can_vote_for_the_team') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-chart-user fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.reports') }}</h5>
                        <p class="card-text">{{ trans('common.thanks_to_the_qr_code_scanning_system_attendance_a') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-hand fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.document_request') }}</h5>
                        <p class="card-text">{{ trans('common.the_user_can_request_the_desired_documents_via_ema') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-hundred-points fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.score_games') }}</h5>
                        <p class="card-text">{{ trans('common.score_games_can_be_organized_for_the_user_to_colle') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-screen-users fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ trans('common.screen_management') }}</h5>
                        <p class="card-text">{{ trans('common.the_timer_session_chair_or_speaker_name_document_k') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-browser fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ __('common.virtual-stands') }}</h5>
                        <p class="card-text">{{ trans('common.elevate_your_congress_with_kongrepad_by_showcasing') }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 bg-color2 text-white shadow">
                    <div class="h1 m-3"><span class="fa-duotone fa-square-poll-vertical fa-fade"></span></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ __('common.surveys') }}</h5>
                        <p class="card-text">{{ trans('common.effortlessly_collect_attendee_feedback_and_insights_with_our_integrated_survey_tool') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="showcase">
            <div class="container-fluid mt-4">
                <div class="row mx-lg-1">
                    <div class="col-md-12" id="our-customers-said">
                        <h1 class="text-center mb-0 text-light">{{ trans('common.our_customers_said') }}</h1>
                        <hr class="text-light w-100" />
                        <div id="our-customers-said-carousel" class="carousel carousel-dark slide py-2" data-ride="carousel">
                            <div class="carousel-indicators mb-0">
                                <button type="button" data-bs-target="#our-customers-said-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#our-customers-said-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#our-customers-said-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="text-center my-4">
                                        <blockquote class="blockquote w-50 mx-auto text-center">
                                            <p class="mb-2 text-light">We have been developing business smoothly for years with Pinet, with which we work as a solution partner. Thank you to the relevant and relevant team.</p>
                                            <footer class="blockquote-footer mt-2">Olgun Emre Aktaş <cite title="Source Title" class="small">General Manager at Sophos</cite></footer>
                                        </blockquote>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="text-center my-4">
                                        <blockquote class="blockquote w-50 mx-auto text-center">
                                            <p class="mb-2 text-light">With EmlakCRM you provided, we reduced our operating costs to a minimum. We have had a strong bond with you over the years. Thank you for your effort.</p>
                                            <footer class="blockquote-footer mt-2">Ferhat Ertürk <cite title="Source Title">General Manager at TOBAŞ</cite></footer>
                                        </blockquote>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="text-center my-4">
                                        <blockquote class="blockquote w-50 mx-auto text-center">
                                            <p class="mb-2 text-light">We would like to thank Pinet for facilitating the planning of our network architecture and the management of many offices.</p>
                                            <footer class="blockquote-footer mt-2">Hüseyin Tecer <cite title="Source Title">IT Manager at PTT PAL</cite></footer>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-2 mx-lg-4">
            <h3 class="text-light mt-3 mt-5">{{ trans('common.frequently_asked_questions') }}</h3>
            <hr class="text-light">
        </div>
        <div class="row mx-2 mx-lg-4">
            <div class="accordion accordion-flush text-white" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-color2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            {{ trans('common.what_is_kongrepad') }}
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">{{ trans('common.kongrepad_is_an_application_platform_with_live_key') }}</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-color2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            {{ trans('common.what_kongrepad_offers') }}
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">{{ trans('common.t_enables_congress_participants_to_participate_in') }}</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-color2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            {{ trans('common.can_try_kongrepad') }}
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">{{ trans('common.of_course_you_can_try_kongrepad_with_100_free_cred') }}</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-color2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                            {{ trans('common.how_can_use_kongrepad') }}
                        </button>
                    </h2>
                    <div id="flush-collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">{{ trans('common.thanks_to_the_training_videos_we_have_prepared_eve') }}</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-color2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                            {{ trans('common.can_manage_multiple_congresses_in_a_single_kongrep') }}
                        </button>
                    </h2>
                    <div id="flush-collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">{{ trans('common.yes_you_can_manage_as_many_congresses_as_you_want') }}</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-color2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                            {{ trans('common.what_is_premium_and_standard_congress') }}
                        </button>
                    </h2>
                    <div id="flush-collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">{{ trans('common.premium_congresses_are_congresses_where_keypad_deb') }}</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-color2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEight" aria-expanded="false" aria-controls="flush-collapseEight">
                            {{ trans('common.what_is_keypad') }}
                        </button>
                    </h2>
                    <div id="flush-collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">{{ trans('common.keypads_are_questions_that_you_can_send_to_all_log') }}</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-color2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseNine" aria-expanded="false" aria-controls="flush-collapseNine">
                            {{ trans('common.what_is_credit') }}
                        </button>
                    </h2>
                    <div id="flush-collapseNine" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">{{ trans('common.each_participants_daily_login_is_deducted_from_you') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-color2 text-white text-center px-0 flex">
        <div class="row align-items-center">
            <div class="col-md-6" id="footer-info-left">
                <div class="footer-info-container text-center">
                    <img src="https://pinet.com.tr/images/logos/pinet-white-logo.svg" class="footer-info-logo text-center mt-2" alt="Pinet Bilişim" width="100">
                    <ul class="list-group float-left w-100">
                        <li class="list-group-item text-center bg-color2 border-color2"><a href="https://pinet.com.tr/about-us.html" class="footer-info-link text-light">About Us</a></li>
                        <li class="list-group-item text-center bg-color2 border-color2"><a href="https://pinet.com.tr/about-us.html" class="footer-info-link text-light">Partners</a></li>
                        <li class="list-group-item text-center bg-color2 border-color2"><a href="https://blog.pinet.com.tr/" class="footer-info-link text-light">Blog</a></li>
                        <li class="list-group-item text-center bg-color2 border-color2"><a href="https://pinet.com.tr/contact.html" class="footer-info-link text-light">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 text-center bg-dark" id="footer-info-right">
                <div class="footer-info-container mt-4 text-center">
                    <a href="https://www.facebook.com/pinetbilisim/" class="footer-info-social-link h1"><i class="fab fa-facebook-square mr-2"></i></a>
                    <a href="https://twitter.com/pinetbilisim" class="footer-info-social-link h1"><i class="fab fa-twitter-square mr-2"></i></a>
                    <a href="https://www.instagram.com/pinetbilisim/" class="footer-info-social-link h1"><i class="fab fa-instagram-square mr-2"></i></a>
                    <a href="https://www.linkedin.com/company/pinetbilisim/" class="footer-info-social-link h1"><i class="fab fa-linkedin mr-2"></i></a>
                    <ul class="list-group float-left w-100">
                        <li class="list-group-item text-md-left text-center h5 bg-dark text-light border-dark"><strong><i class="fas fa-location-arrow"></i> Ankara, Turkey</strong></li>
                        <li class="list-group-item text-md-left text-center bg-dark text-light border-dark"><i class="fad fa-map-marker-alt"></i> Bahçelievler Mah. 323/1 Cadde 10/50C No: 65, Gölbaşı/Ankara</li>
                        <li class="list-group-item text-md-left text-center bg-dark border-dark"><i class="fad fa-phone text-light"></i> <a href="tel:+90 (312) 9119113" class="footer-info-link text-light">+90 (312) 9119113</a></li>
                        <li class="list-group-item text-md-left text-center bg-dark text-light border-dark"><i class="fa-envelope fa-regular"></i> <a href="/cdn-cgi/l/email-protection#88e1e6eee7c8f8e1e6edfca6ebe7e5a6fcfa" class="footer-info-link text-light"><span class="__cf_email__" data-cfemail="6900070f06291900070c1d470a0604471d1b">info@pinet.com.tr</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
<footer class="bg-dark text-light col-12 px-md-0 ms-sm-auto my-4">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="bg-dark px-md-4">Copyright © 2017-{{ date('Y') }} {{ config('app.name') }} </div>
                <p class="pb-2"><a href="#" class="text-decoration-underline text-light"><strong>{{ __('common.privacy_policy') }}</strong></a></p>
            </div>
        </div>
    </div>
</footer>
</html>
