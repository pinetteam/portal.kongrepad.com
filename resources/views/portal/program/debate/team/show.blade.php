@extends('layout.portal.common')
@section('title', __('common.team').' | '.$team->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.team') }}</h1>
        </div>
        <div class="card-body">
            <div class="row flex-shrink-0 g-2">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.team') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-code-simple mx-1"></span> {{ __('common.code') }}:</b> {{ $team->code }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}:</b> {{ $team->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-face-party mx-1"></span> {{ __('common.debate') }}:</b> {{ $team->debate->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b>
                                @if($team->status)
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
