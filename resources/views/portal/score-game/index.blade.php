@extends('layout.portal.common')
@section('title', __('common.score-games'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.score-games') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $score_games->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-bee mx-1"></span> {{ __('common.meeting') }}</th>
                            <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.types') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($score_games as $score_game)
                            <tr>
                                <td>{{ $score_game->meeting->title }}</td>
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
                                <td>
                                    @foreach($score_game->types as $type)
                                        {{__('common.'.$type)}}
                                    @endforeach
                                </td>
                                <td>
                                    @if($score_game->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.score-game.show', $score_game->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#default-edit-modal" data-route="{{ route('portal.score-game.update', $score_game->id) }}" data-resource="{{ route('portal.score-game.edit', $score_game->id) }}" data-id="{{ $score_game->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#default-delete-modal" data-route="{{ route('portal.score-game.destroy', $score_game->id) }}" data-record="{{ $score_game->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#default-create-modal" data-route="{{ route('portal.score-game.store') }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-score-game') }}
            </button>
        </div>
    </div>
    <x-crud.form.common.create>
        @section('default-create-form')
            <x-input.select method="c" name="meeting_id" title="meeting" :options="$meetings" option_value="id" option_name="title" icon="bee" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.checkbox method="c" name="types" title="types" :options="$types" option_value="value" option_name="value" icon="person-military-pointing" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete />
    <x-crud.form.common.edit>
        @section('default-edit-form')
            <x-input.select method="e" name="meeting_id" title="meeting" :options="$meetings" option_value="id" option_name="title" icon="bee" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar-arrow-down" />
            <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
            <x-input.checkbox method="e" name="types" title="types" :options="$types" option_value="value" option_name="value" icon="person-military-pointing" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
