@extends('layout.portal.common')
@section('title', __('common.score-game') . ' | ' . $score_game->title)
@section('breadcrumb')
    <li class="breadcrumb-item text-white"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none text-white">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.show', $score_game->meeting->id) }}" class="text-decoration-none text-white">{{ $score_game->meeting->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.report.score-game.index', ['meeting' => $score_game->meeting->id]) }}" class="text-decoration-none text-white">{{ __('common.score-game-reports') }}</a></li>
    <li class="breadcrumb-item active text-white text-decoration-underline" aria-current="page">{{ $score_game->title }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-screen-users fa-fade"></span> <small>"{{ $score_game->title }}"</small> {{ __('common.participants') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $participants->links() }}
                    </caption>
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.name') }}</th>
                        <th scope="col"><span class="fa-regular fa-hundred-points mx-1"></span> {{ __('common.point') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $participant)
                            <tr>
                                <td>{{ $participant->full_name }}</td>
                                <td>{{ $participant->getTotalScoreGamePoint(1) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
