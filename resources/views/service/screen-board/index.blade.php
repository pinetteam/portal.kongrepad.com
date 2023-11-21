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
                            @isset($screen->current_object_name)
                                <div class="card-body">
                                    <p>{{ $screen->current_object_name }}</p>
                                </div>
                            @endisset
                            <div class="card-footer">
                                @if($screen->type == 'speaker')
                                    <div class="row justify-content-start align-items-center">
                                        <div class="col-md-9 form-group mb-3">
                                            <form method="POST" action="{{ route('service.screen-board.speaker-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                <div class="container-fluid">
                                                    @csrf
                                                    <select name="speaker_id" class="form-select @error('speaker_id')is-invalid @enderror" id="c-speaker_id" aria-label="{{ __('common.speaker') }}" autocomplete="false" onchange="this.form.submit()">
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
                                            </form>
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <a class="btn btn-outline-success btn-sm" href="{{ route('service.screen.speaker.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="{{ __('common.screen') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.screen') }}" target="_blank">
                                                <span class="fa-regular fa-tv"></span>
                                            </a>
                                        </div>
                                    </div>
                                @elseif($screen->type == 'chair')
                                    <div class="row justify-content-start align-items-center">
                                        <div class="col-md-9 form-group mb-3">
                                            <form method="POST" action="{{ route('service.screen-board.chair-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                <div class="container-fluid">
                                                @csrf
                                                    <select name="chair_id" class="form-select @error('chair_id')is-invalid @enderror" id="c-chair_id" aria-label="{{ __('common.chair') }}" autocomplete="false" onchange="this.form.submit()">
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
                                            </form>
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <a class="btn btn-outline-success btn-sm" href="{{ route('service.screen.chair.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="{{ __('common.screen') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.screen') }}" target="_blank">
                                                <span class="fa-regular fa-tv"></span>
                                            </a>
                                        </div>
                                    </div>
                                @elseif($screen->type == 'keypad')
                                    <div class="row justify-content-start align-items-center">
                                        <div class="col-md-9 form-group mb-3">
                                            <form method="POST" action="{{ route('service.screen-board.keypad-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                <div class="container-fluid">
                                                    @csrf
                                                    <select name="keypad_id" class="form-select @error('keypad_id')is-invalid @enderror" id="c-keypad_id" aria-label="{{ __('common.keypad') }}" autocomplete="false" onchange="this.form.submit()">
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
                                            </form>
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <a class="btn btn-outline-success btn-sm" href="{{ route('service.screen.keypad.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="{{ __('common.keypad') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.keypad') }}" target="_blank">
                                                <span class="fa-regular fa-tv"></span>
                                            </a>
                                        </div>
                                    </div>
                                @elseif($screen->type == 'debate')
                                    <div class="row justify-content-start align-items-center">
                                        <div class="col-md-9 form-group mb-3">
                                            <form method="POST" action="{{ route('service.screen-board.debate-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                <div class="container-fluid">
                                                    @csrf
                                                    <select name="debate_id" class="form-select @error('debate_id')is-invalid @enderror" id="c-debate_id" aria-label="{{ __('common.debate') }}" autocomplete="false" onchange="this.form.submit()">
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
                                            </form>
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <a class="btn btn-outline-success btn-sm" href="{{ route('service.screen.debate.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="{{ __('common.debate') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.debate') }}" target="_blank">
                                                <span class="fa-regular fa-tv"></span>
                                            </a>
                                        </div>
                                    </div>
                                @elseif($screen->type == 'document')
                                    <div class="row justify-content-start align-items-center">
                                        <div class="col-md-9 form-group mb-3">
                                            <form method="POST" action="{{ route('service.screen-board.document-screen', ['code' => $screen->code]) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                <div class="container-fluid">
                                                    @csrf
                                                    <select name="document_id" class="form-select @error('document_id')is-invalid @enderror" id="c-document_id" aria-label="{{ __('common.document') }}" autocomplete="false" onchange="this.form.submit()">
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
                                            </form>
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <a class="btn btn-outline-success btn-sm" href="{{ route('service.screen.document.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="{{ __('common.document') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.document') }}" target="_blank">
                                                <span class="fa-regular fa-tv"></span>
                                            </a>
                                        </div>
                                    </div>
                                @elseif($screen->type == 'timer')
                                    <div class="row justify-content-start align-items-center">
                                        <div class="col-lg-6 form-group mb-3">
                                            <form method="POST" action="{{ route('service.screen-board.timer-screen', ['code' => $screen->code, 'action' => 'restart']) }}" name="create-form-{{ $screen->id }}" id="create-form-{{ $screen->id }}" enctype="multipart/form-data" autocomplete="nope">
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
                                            <a class="btn btn-outline-success btn-sm" href="{{ route('service.screen.timer.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="{{ __('common.timer') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.timer') }}" target="_blank">
                                                <span class="fa-regular fa-tv"></span>
                                            </a>
                                        </div>
                                        </div>
                                    </div>
                                @elseif($screen->type == 'questions')
                                    <a class="btn btn-outline-success btn-sm" href="{{ route('service.screen.questions.index', ['meeting_hall_screen_code' => $screen->code]) }}" title="{{ __('common.questions') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.questions') }}" target="_blank">
                                        <span class="fa-regular fa-tv"></span>
                                    </a>
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
