@extends('layout.portal.common')
@section('title', __('common.hall') . ' | ' . $hall->title)
@section('breadcrumb')
    <li class="breadcrumb-item text-white"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.show', $hall->meeting->id) }}" class="text-decoration-none">{{ $hall->meeting->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item active text-white" aria-current="page">{{ $hall->title }}</li>
@endsection
@section('body')
<div class="card text-bg-dark">
    <div class="card-header">
        <h1 class="text-center"><span class="fa-duotone fa-hotel fa-fade"></span> <small>"{{ $hall->title }}"</small></h1>
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
                    <th scope="row" class="text-end w-25">{{ __('common.hall-program-count') }}:</th>
                    <td class="text-start w-25">{{ $hall->programs->count() }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                    <td class="text-start w-25">{{ $hall->created_by_name }}</td>
                    <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                    <td class="text-start w-25">{{ $hall->created_at }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-2 gy-3 py-3">
                <div class="col">
                    <div class="card text-bg-dark">
                        <div class="card-header">
                            <h1 class="m-0 text-center"><span class="badge text-bg-dark">1.</span> {{ __('common.programs') }}</h1>
                        </div>
                        <div class="card-body">
                            <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.hall.program.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" title="{{ __('common.show') }}">
                                <span class="fa-duotone fa-calendar-week"></span> {{ __('common.programs') }}
                            </a>
                            <hr />
                            <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.hall.report.session.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" title="{{ __('common.show') }}">
                                <span class="fa-duotone fa-page"></span> {{ __('common.session-reports') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card text-bg-dark">
                        <div class="card-header">
                            <h1 class="m-0 text-center"><span class="badge text-bg-dark">2.</span> {{ __('common.screens') }}</h1>
                        </div>
                        <div class="card-body">
                            <a class="btn btn-outline-light btn-lg w-100" href="{{ route('portal.meeting.hall.screen.index', ['meeting' => $meeting->id, 'hall' => $hall->id]) }}" title="{{ __('common.show') }}">
                                <span class="fa-duotone fa-presentation-screen"></span> {{ __('common.screens') }}
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
