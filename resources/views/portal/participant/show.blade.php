@extends('layout.portal.common')
@section('title', __('common.participant').' | '.$participant->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.participant') }}</h1>
        </div>
        <div class="card-body">
            <div class="row flex-shrink-0 g-2">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.participant') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}:</b> {{ $participant->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.name') }}:</b> @if($participant->activity_status)
                                    <div class="spinner-grow spinner-grow-sm text-success" role="status"></div>
                                @else
                                    <div class="spinner-border spinner-border-sm text-danger" role="status"></div>
                                @endif
                                {{ $participant->full_name }}
                            </li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-building-columns mx-1"></span> {{ __('common.organisation') }}:</b> {{ $participant->organisation }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-envelope mx-1"></span> {{ __('common.email') }}:</b> {{ $participant->email }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-mobile-screen mx-1"></span> {{ __('common.phone') }}:</b> {{ $participant->full_phone }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-fingerprint mx-1"></span> {{ __('common.identification-number') }}:</b> {{ $participant->identification_number }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b>
                                @if($participant->status)
                                    {{ __('common.active') }}
                                @else
                                    {{ __('common.passive') }}
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
