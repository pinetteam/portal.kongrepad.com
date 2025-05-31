@extends('layout.portal.meeting-detail')
@section('title', $meeting->title . ' | ' . __('common.score-games'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('common.score-games') }}</li>
@endsection
@section('meeting_content')
    <div class="card bg-kongre-secondary">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-hundred-points fa-fade"></span> {{ __('common.score-games') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $score_games->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-image mx-1"></span> {{ __('common.logo') }}</th>
                            <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-image-landscape mx-1"></span> {{ __('common.theme') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($score_games as $score_game)
                            <tr>
                                <td>
                                    @if($score_game->logo)
                                        <img src="{{ $score_game->logo }}" alt="{{ $score_game->title }}" class="img-thumbnail" style="height:36px;" />
                                    @else
                                        <i class="text-info">{{ __('common.unspecified') }}</i>
                                    @endif
                                </td>
                                <td>{{ $score_game->title }}</td>
                                <td>
                                    @if($score_game->start_at)
                                        {{ $score_game->start_at }}
                                    @else
                                        <i class="text-info">{{ __('common.unspecified') }}</i>
                                    @endif
                                </td>
                                <td>
                                    @if($score_game->finish_at)
                                        {{ $score_game->finish_at }}
                                    @else
                                        <i class="text-info">{{ __('common.unspecified') }}</i>
                                    @endif
                                </td>
                                <td>{{ $score_game->theme }}</td>
                                <td>
                                    @if($score_game->status)
                                        <i style="color:var(--kongre-success)" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:var(--kongre-danger)" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-kongre-accent btn-sm" href="{{ route('portal.meeting.score-game.show', ['meeting' => $meeting->id, 'score_game' => $score_game->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="offcanvas" data-bs-target="#score-game-edit-modal" data-route="{{ route('portal.meeting.score-game.update', ['meeting' => $meeting->id, 'score_game' => $score_game->id]) }}" data-resource="{{ route('portal.meeting.score-game.edit', ['meeting' => $meeting->id, 'score_game' => $score_game->id]) }}" data-id="{{ $score_game->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="offcanvas" data-bs-target="#score-game-delete-modal" data-route="{{ route('portal.meeting.score-game.destroy', ['meeting' => $meeting->id, 'score_game' => $score_game->id]) }}" data-record="{{ $score_game->title }}">
                                                <span class="fa-regular fa-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="offcanvas" data-bs-target="#score-game-create-modal" data-route="{{ route('portal.meeting.score-game.store', ['meeting' => $meeting->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-score-game') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create name="score-game" >
        @section('score-game-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.file method="c" name="logo" title="logo" icon="image" />
            <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.select method="c" name="theme" title="theme" :options="$themes" option_value="value" option_name="title" icon="image-landscape" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete name="score-game" />
    <x-crud.form.common.edit name="score-game" >
        @section('score-game-edit-form')
            <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.file method="e" name="logo" title="logo" icon="image" />
            <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.select method="e" name="theme" title="theme" :options="$themes" option_value="value" option_name="title" icon="image-landscape" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
