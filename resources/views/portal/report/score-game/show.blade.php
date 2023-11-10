@extends('layout.portal.common')
@section('title', __('common.score-game') . ' | ' . $score_game->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center"><span class="fa-duotone fa-hundred-points fa-fade"></span> <small>"{{ $score_game->title }}"</small> {{ __('common.score-game') }}</h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                        <td class="text-start w-25">{{ $score_game->title }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.meeting-title') }}:</th>
                        <td class="text-start w-25">{{ $score_game->meeting->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.start-at') }}:</th>
                        <td class="text-start w-25">{{ $score_game->start_at}}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.finish-at') }}:</th>
                        <td class="text-start w-25">{{ $score_game->finish_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.status') }}:</th>
                        <td class="text-start w-25">
                            @if($score_game->status)
                                {{ __('common.active') }}
                            @else
                                {{ __('common.passive') }}
                            @endif</td>
                        <th scope="row" class="text-end w-25">{{ __('common.logo') }}:</th>
                        <td>
                            @if($score_game->logo)
                                <img src="{{ $score_game->logo }}" alt="{{ $score_game->title }}" class="img-thumbnail" style="height:36px;" />
                            @else
                                <i class="text-info">{{ __('common.unspecified') }}</i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                        <td class="text-start w-25">{{ $score_game->created_by_name }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                        <td class="text-start w-25">{{ $score_game->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card text-bg-dark mt-2">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.participants') }}</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
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
