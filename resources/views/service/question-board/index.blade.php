<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{__('common.question-board')}} | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
</head>
<body class="d-flex bg-dark h-100 align-items-center">
    <div class="card text-center text-bg-dark w-100">
        <div class="card-body">
            @isset($session)
            <div class="row row-cols-1 row-cols-sm-2 flex-shrink-0 g-2">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.questions') }}</h2>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover">

                                <thead class="thead-dark">
                                <tr>

                                    <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span> {{ __('common.question-title') }}</th>
                                    <th scope="col"><span class="fa-regular fa-presentation-screen mx-1"></span> {{ __('common.on-screen') }}</th>
                                    <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                                    <th scope="col" class="text-end"></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <td>{{$question->question}}</td>
                                        <td>
                                            <a href="{{ route('portal.session-question.on-screen', [$question->id]) }}" title="{{ __('common.on-screen') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.on-screen') }}">
                                                @if($question->selected_for_show)
                                                    <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                                @else
                                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                                @endif
                                            </a>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                    <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#question-delete-modal" data-route="{{ route('portal.meeting.hall.program.session.question.destroy',['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id, 'question'=> $question->id,]) }}" data-record="{{ $question->question }}">
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
                </div>
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.questions-on-screen') }}</h2>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover">

                                <thead class="thead-dark">
                                <tr>

                                    <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span> {{ __('common.question-title') }}</th>
                                    <th scope="col"><span class="fa-regular fa-presentation-screen mx-1"></span> {{ __('common.on-screen') }}</th>
                                    <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                                    <th scope="col" class="text-end"></th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($selected_questions as $question)
                                    <tr>
                                        <td>{{$question->question}}</td>
                                        <td>
                                            <a href="{{ route('portal.session-question.on-screen', [$question->id]) }}" title="{{ __('common.on-screen') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.on-screen') }}">
                                                @if($question->selected_for_show)
                                                    <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                                @else
                                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                                @endif
                                            </a>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                    <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#question-delete-modal" data-route="{{ route('portal.meeting.hall.program.session.question.destroy',['meeting'=>$session->program->hall->meeting_id, 'hall'=>$session->program->hall_id, 'program'=>$session->program_id, 'session'=> $session->id, 'question'=> $question->id,]) }}" data-record="{{ $question->question }}">
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
                </div>
            </div>
            @endisset
    </div>
    </div>
    <x-crud.form.common.delete name="question"/>
    <x-common.popup.default />
</body>
