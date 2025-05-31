@extends('layout.screen.common')
@section('title', __('common.operator-board'))
@section('body')
    <style>
        :root {
            --bs-primary: #3498db;
            --bs-secondary: #2c3e50;
            --bs-dark: #1a2530;
            --bs-success: #2ecc71;
            --bs-warning: #f39c12;
            --bs-danger: #e74c3c;
            --bs-info: #3498db;
            --bs-light: #ecf0f1;
            --bs-gradient: linear-gradient(to right, var(--bs-secondary), var(--bs-dark));
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        .card {
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            border: none;
        }
        
        .card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
        
        .card-header {
            background: var(--bs-gradient);
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 1.5rem;
        }
        
        .list-group-item {
            background-color: rgba(26, 37, 48, 0.95);
            color: white;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 0.75rem 1.25rem;
        }
        
        .list-group-item b {
            color: rgba(255, 255, 255, 0.75);
        }
        
        .list-group-item .fa-regular,
        .list-group-item .fa-solid {
            color: var(--bs-primary);
            width: 1.5rem;
            text-align: center;
        }
        
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table-dark {
            background-color: rgba(26, 37, 48, 0.95);
            color: white;
        }
        
        .table th {
            background-color: rgba(0, 0, 0, 0.2);
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            padding: 1rem;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
        
        .table td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn-group {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .btn-group .btn {
            border-radius: 0;
            box-shadow: none;
        }
        
        .btn-success {
            background-color: var(--bs-success);
            border-color: var(--bs-success);
        }
        
        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }
        
        .btn-danger {
            background-color: var(--bs-danger);
            border-color: var(--bs-danger);
        }
        
        .btn-warning {
            background-color: var(--bs-warning);
            border-color: var(--bs-warning);
            color: white;
        }
        
        .btn-dark {
            background-color: var(--bs-dark);
            border-color: var(--bs-dark);
        }
        
        .modal-content {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header, .modal-footer {
            border-color: rgba(255, 255, 255, 0.05);
        }
        
        .nav-icon {
            color: var(--bs-primary);
            width: 1.5rem;
            text-align: center;
        }
        
        .fa-toggle-on {
            color: var(--bs-success) !important;
            font-size: 1.5rem;
            filter: drop-shadow(0 2px 4px rgba(46, 204, 113, 0.4));
        }
        
        .fa-toggle-off {
            color: var(--bs-danger) !important;
            font-size: 1.5rem;
            filter: drop-shadow(0 2px 4px rgba(231, 76, 60, 0.4));
        }
        
        #time {
            font-size: 1.5rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .side-nav-button {
            height: 100%;
            position: sticky;
            top: 0;
        }
        
        .side-nav-button button {
            height: calc(100vh - 30px);
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            overflow: visible;
        }
        
        .side-nav-button button:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        
        #operator-board-main {
            min-height: 80vh;
        }
        
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
            color: white;
        }
        
        input[type="number"] {
            font-size: 1.2rem;
            font-weight: 700;
        }
        
        @media (max-width: 992px) {
            .col-lg-6.form-group.mx-3 {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            
            #operator-board-main {
                margin-top: 1rem !important;
            }
            
            .btn {
                padding: 0.5rem;
            }
            
            .side-nav-button button {
                height: 100px;
            }
        }
    </style>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-12 col-lg-1 p-0 mb-4 side-nav-button" id="operator-board-left">
                <a href="{{ route('service.operator-board.start',['code' => $meeting_hall->code, 'program_order' => (int)\Route::current()->parameter('program_order') - 1]) }}" class="w-100 h-100 d-block">
                    <button type="button" class="btn btn-dark w-100 text-center text-white">
                        <i class="fa-solid fa-chevron-left display-1"></i>
                    </button>
                </a>
            </div>
            <div class="col-12 col-lg-10 mb-4 mt-2 card text-bg-dark" id="operator-board-main">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-center">
                        <h2 class="mb-0 text-center">
                            <i class="fa-solid fa-gauge-high me-2"></i>
                            {{__('common.operator-board')}}
                            <small class="text-light ms-2">{{ $meeting_hall->title }}</small>
                        </h2>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row row-cols-1 row-cols-md-2 g-3 mb-4">
                        <div class="col">
                            <div class="card text-bg-dark h-100">
                                <div class="card-header d-flex align-items-center">
                                    <i class="fa-solid fa-info-circle me-2"></i>
                                    <h3 class="m-0 h4">{{ $program->title }}</h3>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        @isset($program)
                                        <li class="list-group-item"><b><span class="fa-regular fa-hotel mx-1"></span> {{ __('common.hall') }}:</b> {{ $meeting_hall->title }}</li>
                                        <li class="list-group-item"><b><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}:</b> {{ $program->start_at }}</li>
                                        <li class="list-group-item"><b><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}:</b> {{ $program->finish_at }}</li>
                                        <li class="list-group-item"><b><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}:</b> {{ __('common.'.$program->type) }}</li>
                                        <li class="list-group-item"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b>
                                            @if($program->status)
                                                <span class="badge bg-success">{{ __('common.active') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('common.passive') }}</span>
                                            @endif
                                        </li>
                                        @endisset
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-bg-dark h-100">
                                <div class="card-header d-flex align-items-center">
                                    <i class="fa-solid fa-clock me-2"></i>
                                    <h3 class="m-0 h4" id="time"></h3>
                                </div>
                                @isset($timer_screen)
                                <div class="card-body">
                                    <div class="container-fluid p-2">
                                        <div class="row">
                                            <div class="col-lg-6 form-group mb-3">
                                                <form method="POST" action="{{ route('service.screen-board.timer-screen', ['code' => $timer_screen->code, 'action' => 'edit']) }}" name="create-form-{{ $timer_screen->id }}" id="create-form-{{ $timer_screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                    <div class="container-fluid">
                                                        @csrf
                                                        <x-input.hidden name="time" :value="0" />
                                                        <div class="form-floating mb-3">
                                                            <input type="number" name="time" class="form-control @error('time')is-invalid @enderror" id="c-time" placeholder="{{ __('common.time') }}" min="0" autocomplete="false" />
                                                            <label for="c-time">{{ __('common.time') }}</label>
                                                        </div>
                                                        @error('time')
                                                        <div class="invalid-feedback d-block">
                                                            <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
                                                        </div>
                                                        @enderror
                                                        <button type="submit" class="btn btn-success w-100" id="create-form-submit-{{ $timer_screen->id }}">
                                                            <i class="fa-solid fa-rotate me-1"></i> {{ __('common.reset') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-lg-6 form-group">
                                                <div class="btn-group w-100 mb-2" role="group" aria-label="{{ __('common.processes') }}">
                                                    <form method="POST" action="{{ route('service.screen.timer.index', ['meeting_hall_screen_code' => $timer_screen->code]) }}" name="index-{{ $timer_screen->id }}" id="index-{{ $timer_screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                        @csrf
                                                        <x-input.hidden name="time" :value="null" />
                                                        <button type="submit" class="btn btn-primary" id="create-form-submit-{{ $timer_screen->id }}">
                                                            <span class="fa-regular fa-presentation-screen"></span>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="btn-group w-100" role="group">
                                                    <form method="POST" action="{{ route('service.screen-board.timer-screen', ['code' => $timer_screen->code, 'action' => 'start']) }}" name="start-form-{{ $timer_screen->id }}" id="start-form-{{ $timer_screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                        @csrf
                                                        <x-input.hidden name="time" :value="null" />
                                                        <button type="submit" class="btn btn-success" id="create-form-submit-{{ $timer_screen->id }}">
                                                            <span class="fa-regular fa-play"></span>
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('service.screen-board.timer-screen', ['code' => $timer_screen->code, 'action' => 'stop']) }}" name="stop-form-{{ $timer_screen->id }}" id="stop-form-{{ $timer_screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                        @csrf
                                                        <x-input.hidden name="time" :value="null" />
                                                        <button type="submit" class="btn btn-danger" id="create-form-submit-{{ $timer_screen->id }}">
                                                            <span class="fa-regular fa-stop"></span>
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('service.screen-board.timer-screen', ['code' => $timer_screen->code, 'action' => 'reset']) }}" name="stop-form-{{ $timer_screen->id }}" id="stop-form-{{ $timer_screen->id }}" enctype="multipart/form-data" autocomplete="nope">
                                                        @csrf
                                                        <x-input.hidden name="time" :value="null" />
                                                        <button type="submit" class="btn btn-warning" id="create-form-submit-{{ $timer_screen->id }}">
                                                            <span class="fa-regular fa-power-off"></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                    @isset($sessions)
                        <div class="row row-cols-1">
                            <div class="col">
                                <div class="card text-bg-dark">
                                    <div class="card-header d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-users-rectangle me-2"></i>
                                        <h3 class="m-0 h4">{{ __('common.sessions') }}</h3>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="table-responsive">
                                            <table class="table table-dark table-striped table-hover align-middle">
                                                <thead>
                                                <tr>
                                                    <th scope="col"><span class="fa-regular fa-circle-play"></span> {{ __('common.is-started') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-person-chalkboard"></span> {{ __('common.speaker') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-folder-open"></span> {{ __('common.document') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-input-text"></span> {{ __('common.title') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-calendar-arrow-up"></span> {{ __('common.start-at') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-calendar-arrow-down"></span> {{ __('common.finish-at') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-block-question"></span> {{ __('common.questions') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-circle-play"></span> {{ __('common.is-questions-started') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-circle-1"></span> {{ __('common.question-limit') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-tablet"></span> {{ __('common.keypads') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($sessions as $session)
                                                    <tr>
                                                        <td class="text-center">
                                                            <a href="javascript:void(0);" title="{{ __('common.start-stop') }}" data-bs-toggle="modal" data-bs-target="#start-session-confirmation-modal" data-route="{{ route('portal.meeting.hall.program.session.start-stop', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id]) }}" data-record="{{ $session->title }}" data-start-stop="{{ $session->on_air }} " data-bs-title="{{ __('common.start-stop') }}">
                                                                @if($session->on_air)
                                                                    <i class="fa-regular fa-toggle-on"></i>
                                                                @else
                                                                    <i class="fa-regular fa-toggle-off"></i>
                                                                @endif
                                                            </a>
                                                        </td>
                                                        <td>
                                                            @if($session->speaker_id)
                                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">{{ $session->speaker->full_name }}</span>
                                                            @else
                                                                <span class="badge bg-secondary">{{ __('common.unspecified') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($session->document_id)
                                                                <a href="{{ route('portal.meeting.document.download', ['meeting' => $program->hall->meeting_id, 'document' => $session->document->file_name]) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.view') }}">
                                                                    <span class="fa-regular fa-file-arrow-down me-1"></span> <span class="d-inline-block text-truncate" style="max-width: 100px; vertical-align: middle">{{ $session->document->title }}</span>
                                                                </a>
                                                            @else
                                                                <span class="badge bg-secondary">{{ __('common.unspecified') }}</span>
                                                            @endif
                                                        </td>
                                                        <td><span class="d-inline-block text-truncate" style="max-width: 150px;">{{ $session->title }}</span></td>
                                                        <td>{{ $session->start_at }}</td>
                                                        <td>{{ $session->finish_at }}</td>
                                                        <td class="text-center">
                                                            @if($session->questions_allowed)
                                                                <i class="fa-regular fa-toggle-on"></i>
                                                            @else
                                                                <i class="fa-regular fa-toggle-off"></i>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($session->questions_allowed)
                                                                <a href="{{ route('portal.meeting.hall.program.session.start-stop-questions', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id]) }}" title="{{ __('common.start-stop-questions') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.start-stop-questions') }}">
                                                                @if($session->is_questions_started)
                                                                    <i class="fa-regular fa-toggle-on"></i>
                                                                @else
                                                                    <i class="fa-regular fa-toggle-off"></i>
                                                                @endif
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($session->questions_allowed)
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="{{ route('portal.meeting.hall.program.session.edit-question-limit', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id, 'increment' => -1]) }}" class="btn btn-outline-danger" title="{{ __('common.decrement') }}">
                                                                        <i class="fa-regular fa-minus"></i>
                                                                    </a>
                                                                    <button type="button" class="btn btn-outline-light">{{ $session->questions_limit }}</button>
                                                                    <a href="{{ route('portal.meeting.hall.program.session.edit-question-limit', ['meeting' => $program->hall->meeting_id, 'hall' => $program->hall->id, 'program' => $program->id, 'session' => $session->id, 'increment' => 1]) }}" class="btn btn-outline-success" title="{{ __('common.increment') }}">
                                                                        <i class="fa-regular fa-plus"></i>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-warning btn-sm" title="{{ __('common.keypads') }}" data-bs-toggle="modal" data-bs-target="#session-keypads-modal-{{$session->id}}">
                                                                <span class="fa-regular fa-tablet me-1"></span> {{ __('common.keypads') }}
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($sessions as $session)
                            <div class="modal fade" id="session-keypads-modal-{{$session->id}}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="#{{$session->id}}-session-keypads-modal-label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content bg-dark">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="{{$session->id}}-session-keypads-modal-label">
                                                <i class="fa-solid fa-tablet me-2"></i>{{ __('common.keypads') }}
                                            </h1>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col"><span class="fa-regular fa-circle-sort"></span> {{ __('common.sort') }}</th>
                                                        <th scope="col"><span class="fa-regular fa-input-text"></span> {{ __('common.title') }}</th>
                                                        <th scope="col"><span class="fa-regular fa-toggle-large-on"></span> {{ __('common.on-vote') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($session->keypads as $keypad)
                                                        <tr>
                                                            <td>{{ $keypad->sort_order }}</td>
                                                            <td>{{ $keypad->keypad }}</td>
                                                            <td>
                                                                <div class="d-flex gap-2 align-items-center">
                                                                    @if($session->on_air)
                                                                    <a href="javascript:void(0);" class="me-2" title="{{ __('common.start-stop-voting') }}" data-bs-toggle="modal" data-bs-target="#start-keypad-confirmation-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.start-stop-voting',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}" data-record="{{ $keypad->keypad }}" data-start-stop="{{ $keypad->on_vote }}">
                                                                        @if($keypad->on_vote)
                                                                            <i class="fa-regular fa-toggle-on"></i>
                                                                        @else
                                                                            <i class="fa-regular fa-toggle-off"></i>
                                                                        @endif
                                                                    </a>
                                                                    @else
                                                                        <span class="badge bg-secondary">{{ __('common.first-you-should-start-session') }}</span>
                                                                    @endif
                                                                    @if($session->on_air && $keypad->on_vote)
                                                                    <a href="javascript:void(0);" title="{{ __('common.resend-voting') }}" data-bs-toggle="modal" data-bs-target="#start-keypad-confirmation-modal" data-route="{{ route('portal.meeting.hall.program.session.keypad.resend-voting',['meeting'=>$session->program->hall->meeting_id, 'keypad'=> $keypad->id,'session'=> $session->id,'program'=>$session->program_id, 'hall'=>$session->program->hall_id]) }}" data-record="{{ $keypad->keypad }}" data-start-stop="{{ $keypad->on_vote }}" data-action-type="resend">
                                                                        <span class="badge bg-primary"><i class="fa-regular fa-recycle me-1"></i> {{ __('common.resend') }}</span>
                                                                    </a>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="start-keypad-confirmation-modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="#start-keypad-confirmation-modal-label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-dark">
                                        <form method="GET" action="" name="start-keypad-confirmation-form" id="start-keypad-confirmation-form" autocomplete="nope">
                                            @csrf
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="start-keypad-confirmation-modal-label">
                                                    <i class="fa-solid fa-circle-question me-2"></i>{{ __('common.confirmation') }}
                                                </h1>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-warning">
                                                    <p id="start-keypad-start-stop-record" class="mb-2"></p>
                                                    <p class="mb-0"><strong id="start-keypad-confirmation-record" class="text-danger"></strong>?</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fa-solid fa-xmark me-1"></i> {{ __('common.no') }}
                                                </button>
                                                <button type="submit" class="btn btn-success" id="start-keypad-confirmation-form-submit">
                                                    <i class="fa-solid fa-check me-1"></i> {{ __('common.confirmation') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <script type="module">
                                const confirmationFormSubmit = document.getElementById('start-keypad-confirmation-form-submit');
                                const confirmationModal = document.getElementById('start-keypad-confirmation-modal');
                                var waitForSeconds, countdown;
                                confirmationModal.addEventListener('show.bs.modal', event => {
                                    const button = event.relatedTarget;
                                    if(button) {
                                        confirmationFormSubmit.disabled = true;
                                        waitForSeconds = 1;
                                        clearInterval(countdown);
                                        document.getElementById('start-keypad-confirmation-form').action = button.getAttribute('data-route');
                                        confirmationModal.querySelector('#start-keypad-confirmation-record').textContent = button.getAttribute('data-record');
                                        
                                        // Check if this is a resend action
                                        if(button.getAttribute('data-action-type') === 'resend') {
                                            confirmationModal.querySelector('#start-keypad-start-stop-record').textContent = '{{ __('common.are-you-sure-you-want-to-resend-voting') }}';
                                        } else {
                                            // Normal start/stop action
                                            if(button.getAttribute('data-start-stop') == 0)
                                                confirmationModal.querySelector('#start-keypad-start-stop-record').textContent = '{{ __('common.are-you-sure-you-want-to-stop-voting-other-keypads-and-start-voting') }}';
                                            else
                                                confirmationModal.querySelector('#start-keypad-start-stop-record').textContent = '{{ __('common.are-you-sure-you-want-to-stop-voting') }}';
                                        }
                                        
                                        countdown = setInterval(function() {
                                            confirmationFormSubmit.innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __('common.yes') }} (' + (--waitForSeconds) + ')';
                                            if (waitForSeconds <= 0) {
                                                confirmationFormSubmit.innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __('common.yes') }}';
                                                confirmationFormSubmit.disabled = false;
                                            }
                                        }, 1000);
                                    }
                                    confirmationFormSubmit.innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __('common.yes') }} (' + (waitForSeconds) + ')';
                                });
                                confirmationFormSubmit.addEventListener('click', function() {
                                    confirmationFormSubmit.disabled = true;
                                    confirmationFormSubmit.innerHTML = '<div class="spinner-border spinner-border-sm me-1" role="status"></div> {{ __('common.loading') }}';
                                    document.getElementById('start-keypad-confirmation-form').submit();
                                });
                            </script>
                        @endforeach
                        <div class="modal fade" id="start-session-confirmation-modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="#start-session-confirmation-modal-label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-dark">
                                    <form method="GET" action="" name="start-session-confirmation-form" id="start-session-confirmation-form" autocomplete="nope">
                                        @csrf
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="start-session-confirmation-modal-label">
                                                <i class="fa-solid fa-circle-question me-2"></i>{{ __('common.confirmation') }}
                                            </h1>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-warning">
                                                <p id="start-session-start-stop-record" class="mb-2"></p>
                                                <p class="mb-0"><strong id="start-session-confirmation-record" class="text-danger"></strong>?</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fa-solid fa-xmark me-1"></i> {{ __('common.no') }}
                                            </button>
                                            <button type="submit" class="btn btn-success" id="start-session-confirmation-form-submit">
                                                <i class="fa-solid fa-check me-1"></i> {{ __('common.confirmation') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script type="module">
                            const confirmationFormSubmit = document.getElementById('start-session-confirmation-form-submit');
                            const confirmationModal = document.getElementById('start-session-confirmation-modal');
                            var waitForSeconds, countdown;
                            confirmationModal.addEventListener('show.bs.modal', event => {
                                const button = event.relatedTarget;
                                if(button) {
                                    confirmationFormSubmit.disabled = true;
                                    waitForSeconds = 1;
                                    clearInterval(countdown);
                                    document.getElementById('start-session-confirmation-form').action = button.getAttribute('data-route');
                                    confirmationModal.querySelector('#start-session-confirmation-record').textContent = button.getAttribute('data-record');
                                    if(button.getAttribute('data-start-stop') == 0)
                                        confirmationModal.querySelector('#start-session-start-stop-record').textContent = '{{ __('common.are-you-sure-you-want-to-stop-other-sessions-and-start') }}';
                                    else
                                        confirmationModal.querySelector('#start-session-start-stop-record').textContent = '{{ __('common.are-you-sure-you-want-to-stop') }}';
                                    countdown = setInterval(function() {
                                        confirmationFormSubmit.innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __('common.yes') }} (' + (--waitForSeconds) + ')';
                                        if (waitForSeconds <= 0) {
                                            confirmationFormSubmit.innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __('common.yes') }}';
                                            confirmationFormSubmit.disabled = false;
                                        }
                                    }, 1000);
                                }
                                confirmationFormSubmit.innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __('common.yes') }} (' + (waitForSeconds) + ')';
                            });
                            confirmationFormSubmit.addEventListener('click', function() {
                                confirmationFormSubmit.disabled = true;
                                confirmationFormSubmit.innerHTML = '<div class="spinner-border spinner-border-sm me-1" role="status"></div> {{ __('common.loading') }}';
                                document.getElementById('start-session-confirmation-form').submit();
                            });
                        </script>
                    @endisset
                    @isset($debates)
                        <div class="row row-cols-1 mt-4">
                            <div class="col">
                                <div class="card text-bg-dark">
                                    <div class="card-header d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-gavel me-2"></i>
                                        <h3 class="m-0 h4">{{ __('common.debates') }}</h3>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="table-responsive">
                                            <table class="table table-dark table-striped table-hover align-middle">
                                                <thead>
                                                <tr>
                                                    <th scope="col"><span class="fa-regular fa-input-text"></span> {{ __('common.title') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-comment-dots"></span> {{ __('common.description') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-box-ballot"></span> {{ __('common.on-vote') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-calendar-arrow-up"></span> {{ __('common.voting-started-at') }}</th>
                                                    <th scope="col"><span class="fa-regular fa-calendar-arrow-down"></span> {{ __('common.voting-finished-at') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($debates as $debate)
                                                    <tr>
                                                        <td><span class="d-inline-block text-truncate" style="max-width: 200px;">{{ $debate->title }}</span></td>
                                                        <td><span class="d-inline-block text-truncate" style="max-width: 300px;">{{ $debate->description }}</span></td>
                                                        <td class="text-center">
                                                            <a href="javascript:void(0);" title="{{ __('common.start-stop') }}" data-bs-toggle="modal" data-bs-target="#start-debate-confirmation-modal" data-route="{{ route('portal.meeting.hall.program.debate.start-stop-voting', ['meeting' => $meeting_hall->meeting_id, 'hall' => $meeting_hall->id, 'program' => $program->id, 'debate' => $debate->id]) }}" data-record="{{ $debate->title }}" data-start-stop="{{ $debate->on_vote }}">
                                                                @if($debate->on_vote)
                                                                <i class="fa-regular fa-toggle-on"></i>
                                                                @else
                                                                <i class="fa-regular fa-toggle-off"></i>
                                                                @endif
                                                            </a>
                                                        </td>
                                                        <td>{{ $debate->voting_started_at }}</td>
                                                        <td>{{ $debate->voting_finished_at }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="start-debate-confirmation-modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="#start-debate-confirmation-modal-label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-dark">
                                    <form method="GET" action="" name="start-debate-confirmation-form" id="start-debate-confirmation-form" autocomplete="nope">
                                        @csrf
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="start-debate-confirmation-modal-label">
                                                <i class="fa-solid fa-circle-question me-2"></i>{{ __('common.confirmation') }}
                                            </h1>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-warning">
                                                <p id="start-debate-start-stop-record" class="mb-2"></p>
                                                <p class="mb-0"><strong id="start-debate-confirmation-record" class="text-danger"></strong>?</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fa-solid fa-xmark me-1"></i> {{ __('common.no') }}
                                            </button>
                                            <button type="submit" class="btn btn-success" id="start-debate-confirmation-form-submit">
                                                <i class="fa-solid fa-check me-1"></i> {{ __('common.confirmation') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script type="module">
                            const confirmationFormSubmit = document.getElementById('start-debate-confirmation-form-submit');
                            const confirmationModal = document.getElementById('start-debate-confirmation-modal');
                            var waitForSeconds, countdown;
                            confirmationModal.addEventListener('show.bs.modal', event => {
                                const button = event.relatedTarget;
                                if(button) {
                                    confirmationFormSubmit.disabled = true;
                                    waitForSeconds = 1;
                                    clearInterval(countdown);
                                    document.getElementById('start-debate-confirmation-form').action = button.getAttribute('data-route');
                                    confirmationModal.querySelector('#start-debate-confirmation-record').textContent = button.getAttribute('data-record');
                                    if(button.getAttribute('data-start-stop') == 0)
                                        confirmationModal.querySelector('#start-debate-start-stop-record').textContent = '{{ __('common.are-you-sure-you-want-to-stop-voting-other-debates-and-start-voting') }}';
                                    else
                                        confirmationModal.querySelector('#start-debate-start-stop-record').textContent = '{{ __('common.are-you-sure-you-want-to-stop-voting') }}';
                                    countdown = setInterval(function() {
                                        confirmationFormSubmit.innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __('common.yes') }} (' + (--waitForSeconds) + ')';
                                        if (waitForSeconds <= 0) {
                                            confirmationFormSubmit.innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __('common.yes') }}';
                                            confirmationFormSubmit.disabled = false;
                                        }
                                    }, 1000);
                                }
                                confirmationFormSubmit.innerHTML = '<i class="fa-solid fa-check me-1"></i> {{ __('common.yes') }} (' + (waitForSeconds) + ')';
                            });
                            confirmationFormSubmit.addEventListener('click', function() {
                                confirmationFormSubmit.disabled = true;
                                confirmationFormSubmit.innerHTML = '<div class="spinner-border spinner-border-sm me-1" role="status"></div> {{ __('common.loading') }}';
                                document.getElementById('start-debate-confirmation-form').submit();
                            });
                        </script>
                    @endisset
                </div>
            </div>

            <div class="col-12 col-lg-1 p-0 mb-4 side-nav-button" id="operator-board-right">
                <a href="{{ route('service.operator-board.start',['code' => $meeting_hall->code, 'program_order' => (int)\Route::current()->parameter('program_order') + 1]) }}" class="w-100 h-100 d-block">
                    <button type="button" class="btn btn-dark w-100 text-center text-white">
                        <i class="fa-solid fa-chevron-right display-1"></i>
                    </button>
                </a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function showTime() {
            var date = new Date();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var seconds = date.getSeconds();
            
            // Add leading zeros
            hours = (hours < 10) ? "0" + hours : hours;
            minutes = (minutes < 10) ? "0" + minutes : minutes;
            seconds = (seconds < 10) ? "0" + seconds : seconds;
            
            document.getElementById('time').innerHTML = hours + ":" + minutes + ":" + seconds;
        }
        
        // Initialize time
        showTime();
        
        // Update time every second
        setInterval(showTime, 1000);
        
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
