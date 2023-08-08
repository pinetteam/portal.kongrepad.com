@extends('layout.portal.common')
@section('title', __('common.hall').' | '.$hall->title)
@section('body')

    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-duotone fa-hotel fa-fade"></span> <small>"{{ $hall->title }}"</small>
            </h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.meeting-title') }}:</th>
                        <td class="text-start w-25">
                            @if($hall->status)
                                <i style="color:green" class="fa-regular fa-toggle-on"></i>
                            @else
                                <i style="color:red" class="fa-regular fa-toggle-off"></i>
                            @endif
                            {{ $hall->title }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.start-at') }}:</th>
                        <td class="text-start w-25">{{ $hall->start_at }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.finish-at') }}:</th>
                        <td class="text-start w-25">{{ $hall->finish_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                        <td class="text-start w-25">{{ $hall->created_by }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                        <td class="text-start w-25">{{ $hall->created_at }}</td>
                    </tr>
                </table>
            </div>
            <div class="card-body p-0">
                <div class="container-fluid">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 gy-3 py-3">
                        <div class="col">
                            <div class="card text-bg-dark">
                                <div class="card-header">
                                    <h1 class="m-0 text-center"><span class="badge text-bg-dark"></span> {{ __('common.main-hall-programs') }}</h1>
                                </div>
                                <div class="card-body">
                                    <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.hall.program.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" title="{{ __('common.show') }}">
                                        <span class="fa-duotone fa-newspaper fa-fade "></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-bg-dark">
                                <div class="card-header">
                                    <h1 class="m-0 text-center"><span class="badge text-bg-dark"></span> {{ __('common.operator-board') }}</h1>
                                </div>
                                <div class="card-body">
                                    <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.hall.program.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" title="{{ __('common.show') }}">
                                        <span class="fa-duotone fa-presentation-screen fa-fade"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
