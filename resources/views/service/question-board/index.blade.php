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
    <script type="module">
        Echo.channel('service.screen.question-board.{{ $hall->code }}')
            .listen('.question-board-event', data => {
                if(data.questions !== null) {
                    var questions = data.questions;
                    var questionsHTML = '';
                    questions.forEach(function(question) {
                        questionsHTML += '<tr>';
                        questionsHTML += '<td>' + question.question + '</td>';
                        questionsHTML += '<td><a href="https://app.kongrepad.com/portal/session-question-on-screen/'+question.id+'"><i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i></a></td>';
                        if(question.is_hidden_name === 0)
                            questionsHTML += '<td>' + question.questioner.first_name + ' ' + question.questioner.last_name + '</td>';
                        else
                            questionsHTML += '<td></td>';
                        questionsHTML += '</tr>';
                    });
                    var selected_questions = data.selected_questions;
                    var selectedQuestionsHTML = '';
                    selected_questions.forEach(function(question) {
                        selectedQuestionsHTML += '<tr>';
                        selectedQuestionsHTML += '<td>' + question.question + '</td>';
                        selectedQuestionsHTML += '<td><a href="https://app.kongrepad.com/portal/session-question-on-screen/'+question.id+'"><i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i></a></td>';
                        if(question.is_hidden_name === 0)
                            selectedQuestionsHTML += '<td>' + question.questioner.first_name + ' ' + question.questioner.last_name + '</td>';
                        else
                            selectedQuestionsHTML += '<td></td>';
                        selectedQuestionsHTML += '</tr>';
                    });
                    document.getElementById("questions").innerHTML = questionsHTML;
                    document.getElementById("selected-questions").innerHTML = selectedQuestionsHTML;
                } else {
                    document.getElementById("questions").innerHTML = '...';
                }
            });
    </script>
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
                                    <th scope="col"><span class="fa-regular fa-user mx-1"></span> {{ __('common.questioner') }}</th>
                                </tr>
                                </thead>

                                <tbody id="questions">
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
                                        @if(!$question->is_hidden_name)
                                            <td>{{$question->questioner->full_name}}</td>
                                        @else
                                            <td></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.selected_questions') }}</h2>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover">

                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span> {{ __('common.question-title') }}</th>
                                    <th scope="col"><span class="fa-regular fa-presentation-screen mx-1"></span> {{ __('common.on-screen') }}</th>
                                    <th scope="col"><span class="fa-regular fa-user mx-1"></span> {{ __('common.questioner') }}</th>
                                </tr>
                                </thead>

                                <tbody id="selected-questions">
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
                                        @if(!$question->is_hidden_name)
                                            <td>{{$question->questioner->full_name}}</td>
                                        @else
                                            <td></td>
                                        @endif
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
