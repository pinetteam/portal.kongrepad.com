@extends('layout.portal.common')
@section('title', __('common.hall').' | '.$meeting_hall->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.hall').' | '.$meeting_hall->title }}</h1>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-sm-2 flex-shrink-0 g-2">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.hall') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-hotel mx-1"></span> {{ __('common.meeting') }}:</b> {{ $meeting_hall->meeting->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}:</b> {{ $meeting_hall->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b>
                                @if($meeting_hall->status)
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
                        <h2 class="m-0 text-center h3">{{ __('common.chairs') }}</h2>
                    </div>
                    <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-dark table-striped table-hover">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col"><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.name') }}</th>
                                            <th scope="col" class="text-end"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ __('common.chair') }} 1</td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                        <a class="btn btn-success btn-sm" href="{{ route('portal.current-chair.show',[ $meeting_hall->id, 1]) }}" title="{{ __('common.chair') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.chair') }}">
                                                            <span class="fa-regular fa-presentation-screen"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('common.chair') }} 2</td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                        <a class="btn btn-success btn-sm" href="{{ route('portal.current-chair.show',[ $meeting_hall->id, 2]) }}" title="{{ __('common.chair') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.chair') }}">
                                                            <span class="fa-regular fa-presentation-screen"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('common.chair') }} 3</td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                        <a class="btn btn-success btn-sm" href="{{ route('portal.current-chair.show',[ $meeting_hall->id, 3]) }}" title="{{ __('common.chair') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.chair') }}">
                                                            <span class="fa-regular fa-presentation-screen"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('common.speaker') }}</td>
                                                <td class="text-end">
                                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                        <a class="btn btn-success btn-sm" href="{{ route('portal.current-speaker.show',[ $meeting_hall->id]) }}" title="{{ __('common.speaker') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.speaker') }}">
                                                            <span class="fa-regular fa-presentation-screen"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
