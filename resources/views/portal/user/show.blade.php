@extends('layout.portal.common')
@section('title', __('common.user').' | '.$user->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.user').' | '.$user->title }}</h1>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-sm-2 flex-shrink-0 g-2">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.user') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.name') }}:</b> @if($user->activity_status)
                                    <div class="spinner-grow spinner-grow-sm text-success" role="status"></div>
                                @else
                                    <div class="spinner-border spinner-border-sm text-danger" role="status"></div>
                                @endif
                                {{ $user->full_name }}
                            </li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-envelope mx-1"></span> {{ __('common.email') }}:</b> {{ $user->email }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-mobile-screen mx-1"></span> {{ __('common.phone') }}:</b> {{ $user->full_phone }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b>
                                @if($user->status)
                                    {{ __('common.active') }}
                                @else
                                    {{ __('common.passive') }}
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.scores') }}</h2>
                    </div>
                    <div class="card-body p-0">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
