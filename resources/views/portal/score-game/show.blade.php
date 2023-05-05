@extends('layout.portal.common')
@section('title', __('common.score-game').' | '.$score_game->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.score-game').' | '.$score_game->title }}</h1>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-sm-2 flex-shrink-0 g-2">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.score-game') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-hotel mx-1"></span> {{ __('common.meeting') }}:</b> {{ $score_game->meeting->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-hotel mx-1"></span> {{ __('common.title') }}:</b> {{ $score_game->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}:</b> {{ $score_game->start_at }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}:</b> {{ $score_game->finish_at }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.types') }}:</b> @foreach($score_game->types as $type){{__('common.'.$type)}} @endforeach</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b>
                                @if($score_game->status)
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
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col"><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.name') }}</th>
                                    <th scope="col"><span class="fa-regular fa-hundred-points mx-1"></span> {{ __('common.score') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($scores as $score)
                                    <tr>
                                        <td>{{ $score->user->full_name }}</td>
                                        <td>{{ $score->score }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card text-bg-dark mt-2">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.qr-codes') }}</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}</th>
                        <th scope="col"><span class="fa-regular fa-hundred-points mx-1"></span> {{ __('common.score') }}</th>
                        <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($score_game_qr_codes as $qr_code)
                            <tr>
                                <td>
                                    <a href="{{ route('portal.qr-code-download', $qr_code->id) }}" class="btn btn-sm btn-info w-100" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.download') }}">
                                        <span class="fa-regular fa-file-arrow-down"></span>{{ $qr_code->title }}
                                    </a>
                                </td>
                                <td>{{ $qr_code->start_at }}</td>
                                <td>{{ $qr_code->finish_at }}</td>
                                <td>{{ $qr_code->score }}</td>
                                <td>
                                    @if($qr_code->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#showQr" data-bs-code="{{$qr_code->code}}" title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </button>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#qr-code-edit-modal" data-route="{{ route('portal.qr-code.update', $qr_code->id) }}" data-resource="{{ route('portal.qr-code.edit', $qr_code->id) }}" data-id="{{ $qr_code->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#qr-code-delete-modal" data-route="{{ route('portal.qr-code.destroy', $qr_code->id) }}" data-record="{{ $qr_code->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#qr-code-create-modal" data-route="{{ route('portal.qr-code.store') }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.add-new-qr-code') }}
            </button>
        </div>
        <x-crud.form.common.create name="qr-code">
            @section('qr-code-create-form')
                <x-input.text method="c" name="title" title="title" icon="input-text" />
                <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar-arrow-down" />
                <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
                <x-input.number method="e" name="score" title="score" icon="hundred-points" />
                <x-input.select method="c" name="score_game_id" title="score-game" :options="$score_games" option_value="id" option_name="title" icon="hundred-points" />
                <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.create>
        <x-crud.form.common.delete name="qr-code" />
        <x-crud.form.common.edit name="qr-code">
            @section('qr-code-edit-form')
                <x-input.text method="e" name="title" title="title" icon="input-text" />
                <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar-arrow-down" />
                <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
                <x-input.number method="e" name="score" title="score" icon="hundred-points" />
                <x-input.select method="e" name="score_game_id" title="score-game" :options="$score_games" option_value="id" option_name="title" icon="hundred-points" />
                <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.edit>
    </div>
    <div class="modal fade" id="showQr" tabindex="-1" aria-labelledby="showQr" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">{{__('common.show-qr-code')}}</h5>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="qr-code" class="mb-3">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
            var showQrModal = document.getElementById('showQr')
            showQrModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget
                var code = button.getAttribute('data-bs-code')
                var qrCode = document.getElementById('qr-code')

                qrCode.innerHTML = code
            })
    </script>
@endsection
