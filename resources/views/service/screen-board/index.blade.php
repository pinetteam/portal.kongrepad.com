@extends('layout.screen.common')
@section('title', __('common.screen-board'))
@section('body')
<body class="d-flex bg-dark flex-column h-100">
<div class="container-fluid h-100">
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-screen-users fa-fade"></span> <small>"{{ $hall->title }}"</small> {{ __('common.screen-board') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="container">
                <div class="row">
                    @foreach($screens as $screen)
                    <div class="col-md-4 my-3">
                        <div class="card bg-dark text-white text-center shadow">
                            <div class="card-header">
                                <p>{{ $screen->title }}</p>
                            </div>
                            <div class="card-body">
                                <div class="ratio ratio-16x9 border border-white">
                                    <iframe src="{{ route('service.screen.' . $screen->type . '.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="screen" class="ratio ratio-16x9" allowfullscreen></iframe>
                                    <a href="{{ route('service.screen.' . $screen->type . '.index', ['meeting_hall_screen_code' => $screen->code]) }}" class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0,0,0,0); border: none;" title="{{ __('common.screen') }}" target="_blank">
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer">
                                @if($screen->type == 'speaker')
                                    <form method="POST" action="{{ route('service.screen-board.speaker-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                        <div class="row justify-content-start align-items-center">
                                            <div class="col-lg-8 form-group mb-3">
                                                @csrf
                                                <select name="speaker_id" class="form-select @error('speaker_id')is-invalid @enderror" id="c-speaker_id" aria-label="{{ __('common.speaker') }}" autocomplete="false">
                                                    <option selected value="">{{ __('common.choose') }}</option>
                                                    @foreach($participants as $option)
                                                        @if(is_array($option))
                                                            <option value="{{ $option['id'] }}"{{ $option['id'] == $screen->current_object_id ? ' selected' : '' }}>{{ $option['full_name'] }}</option>
                                                        @else
                                                            <option value="{{ $option->id }}"{{ $option->id == $screen->current_object_id ? ' selected' : '' }}>{{ $option->full_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('speaker_id')
                                                <div class="invalid-feedback d-block">
                                                    <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 form-group mb-3">
                                                <button type="submit" class="btn btn-success w-75" id="create-form-submit-{{ $screen->id }}">{{ __('common.update') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                @elseif($screen->type == 'chair')
                                    <form method="POST" action="{{ route('service.screen-board.chair-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                    <div class="row justify-content-start align-items-center">
                                        <div class="col-lg-8 form-group mb-3">
                                        @csrf
                                            <select name="chair_id" class="form-select @error('chair_id')is-invalid @enderror" id="c-chair_id" aria-label="{{ __('common.chair') }}" autocomplete="false">
                                                <option selected value="">{{ __('common.choose') }}</option>
                                                @foreach($participants as $option)
                                                    @if(is_array($option))
                                                        <option value="{{ $option['id'] }}"{{ $option['id'] == $screen->current_object_id ? ' selected' : '' }}>{{ $option['full_name'] }}</option>
                                                    @else
                                                        <option value="{{ $option->id }}"{{ $option->id == $screen->current_object_id ? ' selected' : '' }}>{{ $option->full_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('chair_id')
                                            <div class="invalid-feedback d-block">
                                                <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-4 form-group mb-3">
                                            <button type="submit" class="btn btn-success w-75" id="create-form-submit-{{ $screen->id }}">{{ __('common.update') }}</button>
                                        </div>
                                    </div>
                                    </form>
                                @elseif($screen->type == 'keypad')
                                    <form method="POST" action="{{ route('service.screen-board.keypad-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                    <div class="row justify-content-start align-items-center">
                                        <div class="col-lg-8 form-group mb-3">
                                            @csrf
                                            <select name="keypad_id" class="form-select @error('keypad_id')is-invalid @enderror" id="c-keypad_id" aria-label="{{ __('common.keypad') }}" autocomplete="false">
                                                <option selected value="">{{ __('common.choose') }}</option>
                                                @foreach($keypads as $option)
                                                    @if(is_array($option))
                                                        <option value="{{ $option['id'] }}"{{ $option['id'] == $screen->current_object_id ? ' selected' : '' }}>{{ $option['keypad'] }}</option>
                                                    @else
                                                        <option value="{{ $option->id }}"{{ $option->id == $screen->current_object_id ? ' selected' : '' }}>{{ $option->keypad }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('keypad_id')
                                            <div class="invalid-feedback d-block">
                                                <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-4 form-group mb-3">
                                            <button type="submit" class="btn btn-success w-75" id="create-form-submit-{{ $screen->id }}">{{ __('common.update') }}</button>
                                        </div>
                                    </div>
                                </form>
                                @elseif($screen->type == 'debate')
                                    <form method="POST" action="{{ route('service.screen-board.debate-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                        <div class="row justify-content-start align-items-center">
                                            <div class="col-lg-8 form-group mb-3">
                                                @csrf
                                                <select name="debate_id" class="form-select @error('debate_id')is-invalid @enderror" id="c-debate_id" aria-label="{{ __('common.debate') }}" autocomplete="false">
                                                    <option selected value="">{{ __('common.choose') }}</option>
                                                    @foreach($debates as $option)
                                                        @if(is_array($option))
                                                            <option value="{{ $option['id'] }}"{{ $option['id'] == $screen->current_object_id ? ' selected' : '' }}>{{ $option['title'] }}</option>
                                                        @else
                                                            <option value="{{ $option->id }}"{{ $option->id == $screen->current_object_id ? ' selected' : '' }}>{{ $option->title }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('debate_id')
                                                <div class="invalid-feedback d-block">
                                                    <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 form-group mb-3">
                                                <button type="submit" class="btn btn-success w-75" id="create-form-submit-{{ $screen->id }}">{{ __('common.update') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                @elseif($screen->type == 'document')
                                    <form method="POST" action="{{ route('service.screen-board.document-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                        <div class="row justify-content-start align-items-center">
                                            <div class="col-lg-8 form-group mb-3">
                                                @csrf
                                                <select name="document_id" class="form-select @error('document_id')is-invalid @enderror" id="c-document_id" aria-label="{{ __('common.document') }}" autocomplete="false">
                                                    <option selected value="">{{ __('common.choose') }}</option>
                                                    @foreach($documents as $option)
                                                        @if(is_array($option))
                                                            <option value="{{ $option['id'] }}"{{ $option['id'] == $screen->current_object_id ? ' selected' : '' }}>{{ $option['title'] }}</option>
                                                        @else
                                                            <option value="{{ $option->id }}"{{ $option->id == $screen->current_object_id ? ' selected' : '' }}>{{ $option->title }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('document_id')
                                                <div class="invalid-feedback d-block">
                                                    <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 form-group mb-3">
                                                <button type="submit" class="btn btn-success w-75" id="create-form-submit-{{ $screen->id }}">{{ __('common.update') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                @elseif($screen->type == 'timer')
                                    <div class="row justify-content-start align-items-center">
                                        <div class="col-lg-6 form-group mb-3">
                                            <form method="POST" action="{{ route('service.screen-board.timer-screen', ['code' => $screen->code, 'action' => 'edit']) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                <div class="container-fluid">
                                                    @csrf
                                                    <x-input.hidden name="time" :value="0" />
                                                    <input type="number" name="time" class="form-control @error('time')is-invalid @enderror" id="c-time" placeholder="{{ __('common.time') }}" min="0" autocomplete="false" />
                                                    @error('time')
                                                    <div class="invalid-feedback d-block">
                                                        <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
                                                    </div>
                                                    @enderror
                                                    <button type="submit" class="btn btn-success w-75" id="create-form-submit-{{ $screen->id }}">{{ __('common.reset') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                <form method="POST" action="{{ route('service.screen-board.timer-screen', ['code' => $screen->code, 'action' => 'start']) }}" name="start-form-{{ $screen->id }}" id="start-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                        @csrf
                                                        <x-input.hidden name="time" :value="null" />
                                                        <button type="submit" class="btn btn-success w-100" id="create-form-submit-{{ $screen->id }}"><span class="fa-regular fa-play"></span></button>
                                                </form>
                                                <form method="POST" action="{{ route('service.screen-board.timer-screen', ['code' => $screen->code, 'action' => 'stop']) }}" name="stop-form-{{ $screen->id }}" id="stop-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                        @csrf
                                                        <x-input.hidden name="time" :value="null" />
                                                        <button type="submit" class="btn btn-danger w-100" id="create-form-submit-{{ $screen->id }}"><span class="fa-regular fa-stop"></span></button>
                                                </form>
                                                <form method="POST" action="{{ route('service.screen-board.timer-screen', ['code' => $screen->code, 'action' => 'reset']) }}" name="stop-form-{{ $screen->id }}" id="stop-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                        @csrf
                                                        <x-input.hidden name="time" :value="null" />
                                                        <button type="submit" class="btn btn-warning w-100" id="create-form-submit-{{ $screen->id }}"><span class="fa-regular fa-power-off"></span></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection
