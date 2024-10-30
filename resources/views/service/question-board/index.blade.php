@extends('layout.screen.common')
@section('title', __('common.question-board'))
@section('script')
    <script type="module">
        document.addEventListener("contextmenu", function (e){
            e.preventDefault();
        }, false);
        Echo.channel('service.screen.question-board.{{ $hall->code }}')
            .listen('.question-board-event', data => {
                location.reload();
                if(data.questions !== null) {
                    var questions = data.questions;
                    var questionsHTML = '';
                    questions.forEach(function(question) {
                        questionsHTML += '<tr>';
                        questionsHTML += '<td class="w-75">' + question.question + '</td>';
                        if(question.is_hidden_name == 0)
                            questionsHTML += '<td>' + question.questioner.first_name + ' ' + question.questioner.last_name + '</td>';
                        else
                            questionsHTML += '<td>Anonim</td>';
                        questionsHTML += '<td><a href="https://app.kongrepad.com/portal/session-question-on-screen/'+question.id+'"><i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i></a></td>';
                        questionsHTML += '</tr>';
                    });
                    var selected_questions = data.selected_questions;
                    var selectedQuestionsHTML = '';
                    selected_questions.forEach(function(question) {
                        selectedQuestionsHTML += '<tr>';
                        selectedQuestionsHTML += '<td class="w-75">' + question.question + '</td>';
                        if(question.is_hidden_name == 0)
                            selectedQuestionsHTML += '<td>' + question.questioner.first_name + ' ' + question.questioner.last_name + '</td>';
                        else
                            selectedQuestionsHTML += '<td>Anonim</td>';
                        selectedQuestionsHTML += '<td><a href="https://app.kongrepad.com/portal/session-question-on-screen/'+question.id+'"><i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i></a></td>';
                        selectedQuestionsHTML += '</tr>';
                    });
                    document.getElementById("questions").innerHTML = questionsHTML;
                    document.getElementById("selected-questions").innerHTML = selectedQuestionsHTML;
                } else {
                    document.getElementById("questions").innerHTML = '...';
                }
            });
    </script>
@endsection
@section('body')
    <style type="text/css">
        .table-scroll tbody {
            overflow-y: scroll;
        }
        .table-scroll tr {
            width: 100%;
            table-layout: fixed;
            display: inline-table;
        }

        .table-scroll thead > tr > th {
            border: none;
        }
    </style>
    <body class="d-flex bg-dark flex-column h-100">
    <div class="container-fluid h-100">
        @isset($session)
            <div class="row row-cols-1">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header text-center">
                        <h1 class="text-center">{{__('common.question-board')}}</h1>
                        <h3 class="text-center">{{ $session->title }}</h3>
                        @isset($session->speaker)
                            <h2 class="text-center h3">{{ $session->title }} <span class="badge bg-primary">{{ $session->speaker->full_name }}</span></h2>
                        @endisset
                        <div>
                        <span class="alert alert-info d-inline-flex align-items-center rounded border-danger py-1" role="alert">
                            <i class="fa-duotone fa-circle-exclamation fa-fade px-1"></i>  Maksimum izin verilen soru adedi: {{$session->questions_limit}}
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 h-75">
                <div class="col card text-bg-dark p-0 h-100">
                    <div class="card-header">
                        <h2 class="text-center h3"><span class="fa-duotone fa-inbox-in fa-fade mx-1"></span> {{__('common.incoming-questions')}}</h2>
                    </div>
                    <div class="card-body d-block p-0 overflow-y-auto">
                        <table class="table table-dark table-striped table-hover w-100 table-scroll">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="w-75"><span class="fa-regular fa-messages-question mx-1"></span> {{__('common.question')}}</th>
                                <th scope="col"><span class="fa-regular fa-user mx-1"></span> {{__('common.name')}}</th>
                                <th scope="col"><span class="fa-light fa-check mx-1"></span> {{__('common.add')}}</th>
                            </tr>
                            </thead>
                            <tbody id="questions" class="h-100">
                            @foreach($questions as $question)
                                <tr>
                                    <td class="w-75">{{ $question->question }}</td>
                                    @if($question->is_hidden_name == 0)
                                        <td>{{ $question->questioner->full_name }}</td>
                                    @else
                                        <td>{{__('common.anonymous')}}</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('portal.session-question.on-screen', [$question->id]) }}" title="{{ __('common.on-screen') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.on-screen') }}">
                                            @if($question->selected_for_show)
                                                <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                            @else
                                                <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col card text-bg-dark p-0 h-100">
                    <div class="card-header">
                        <h2 class="text-center h3"><span class="fa-duotone fa-inbox-out fa-fade mx-1"></span> {{__('common.selected-questions')}}</h2>
                    </div>
                    <div class="card-body d-block p-0 overflow-y-auto">
                        <table class="table table-dark table-striped table-hover w-100 table-scroll">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="w-75"><span class="fa-regular fa-messages-question mx-1"></span> {{__('common.question')}}</th>
                                <th scope="col"><span class="fa-regular fa-user mx-1"></span>  {{__('common.name')}}</th>
                                <th scope="col"><span class="fa-light fa-xmark"></span>  {{__('common.remove')}}</th>
                            </tr>
                            </thead>
                            <tbody id="selected-questions" class="h-100">
                            @foreach($selected_questions as $question)
                                <tr>
                                    <td class="w-75">{{ $question->question }}</td>
                                    @if(!$question->is_hidden_name)
                                        <td>{{ $question->questioner->full_name }}</td>
                                    @else
                                        <td>{{ __('common.anonymous') }}</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('portal.session-question.on-screen', [$question->id]) }}" title="{{ __('common.on-screen') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.on-screen') }}">
                                            @if($question->selected_for_show)
                                                <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                            @else
                                                <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endisset
    </div>
    <x-common.popup.default />
    </body>
@endsection
