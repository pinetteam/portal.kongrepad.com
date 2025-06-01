@extends('layout.portal.meeting-detail')
@section('title', __('common.score-game') . ' | ' . $score_game->title)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $score_game->meeting->id) }}" class="text-decoration-none">{{ $score_game->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.report.score-game.index', ['meeting' => $score_game->meeting->id]) }}" class="text-decoration-none">{{ __('common.score-game-reports') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $score_game->title }}</li>
@endsection
@section('meeting_content')
    <div class="card bg-kongre-secondary">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-screen-users fa-fade"></span> <small>"{{ $score_game->title }}"</small> {{ __('common.participants') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $score_game_points->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.name') }}</th>
                            <th scope="col"><span class="fa-regular fa-hundred-points mx-1"></span> {{ __('common.point') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($score_game_points as $score_game_point)
                            @php
                                $participant = \App\Models\Meeting\Participant\Participant::findOrFail($score_game_point->participant_id);
                            @endphp
                            <tr>
                                <td><a href="{{ route('portal.meeting.participant.show', ['meeting' => $score_game->meeting->id, 'participant' => $participant->id]) }}" class="fw-bold text-white text-decoration-none">{{ $participant->full_name }}</a></td>
                                <td>{{ $score_game_point->total_points }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
