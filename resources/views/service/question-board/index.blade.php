@extends('layout.screen.common')
@section('title', __('common.question-board'))
@section('script')
    <script type="module">
        // Kanal dinleme kısmı
        Echo.channel('service.screen.question-board.{{ $hall->code }}')
            .listen('.question-board-event', data => {
                if (data.questions !== null) {
                    var questionsHTML = '';
                    data.questions.forEach(function(question) {
                        questionsHTML += renderQuestionRow(question, 'incoming');
                    });
                    document.getElementById('questions-table-body').innerHTML = questionsHTML;
                }

                if (data.selected_questions !== null) {
                    var selectedQuestionsHTML = '';
                    data.selected_questions.forEach(function(question) {
                        selectedQuestionsHTML += renderQuestionRow(question, 'selected');
                    });
                    document.getElementById('selected-questions-table-body').innerHTML = selectedQuestionsHTML;
                }
            });

        // Soru satırını oluşturmak için fonksiyon
        function renderQuestionRow(question, type) {
            var questionHTML = '<tr id="question-' + question.id + '">';
            questionHTML += '<td class="w-75">' + question.question + '</td>';
            if (question.is_hidden_name == 0)
                questionHTML += '<td>' + question.questioner.first_name + ' ' + question.questioner.last_name + '</td>';
            else
                questionHTML += '<td>Anonymous</td>';
            if (type === 'incoming') {
                questionHTML += '<td><button class="toggle-btn" data-id="' + question.id + '" onclick="moveQuestion(' + question.id + ', \'incoming\')"><i class="fa-regular fa-toggle-off fa-xg text-danger"></i></button></td>';
            } else {
                questionHTML += '<td><button class="toggle-btn" data-id="' + question.id + '" onclick="moveQuestion(' + question.id + ', \'selected\')"><i class="fa-regular fa-toggle-on fa-xg text-success"></i></button></td>';
            }
            questionHTML += '</tr>';
            return questionHTML;
        }

        // Soruyu tablolar arasında taşımak için fonksiyon
        function moveQuestion(questionId, currentType) {
            var row = document.getElementById('question-' + questionId); // Satırı al
            var newType = (currentType === 'incoming') ? 'selected' : 'incoming'; // Hangi tabloya taşınacağını belirle
            var targetTableBody = (newType === 'incoming') ? 'questions-table-body' : 'selected-questions-table-body'; // Hedef tablo
            document.getElementById(targetTableBody).appendChild(row); // Satırı yeni tabloya ekle
            updateButton(row, newType); // Buton stilini ve fonksiyonunu güncelle
        }

        // Butonu güncelleme fonksiyonu
        function updateButton(row, newType) {
            var button = row.querySelector('.toggle-btn'); // Toggle butonunu bul
            button.setAttribute('onclick', 'moveQuestion(' + button.getAttribute('data-id') + ', \'' + newType + '\')'); // Onclick fonksiyonunu yeni tip ile güncelle
            if (newType === 'incoming') {
                button.innerHTML = '<i class="fa-regular fa-toggle-off fa-xg text-danger"></i>'; // Kırmızı buton
            } else {
                button.innerHTML = '<i class="fa-regular fa-toggle-on fa-xg text-success"></i>'; // Yeşil buton
            }
        }
    </script>
@endsection
@section('body')
    @isset($session)
        <div class="row row-cols-1">
            <div class="col card text-bg-dark p-0">
                <div class="card-header text-center">
                    <h1 class="text-center">{{__('common.question-board')}}</h1>
                    @isset($session->speaker)
                        <h2 class="text-center h3">{{ $session->title }} <span class="badge bg-primary">{{ $session->speaker->full_name }}</span></h2>
                    @endisset
                    <div>
                        <span class="alert alert-info d-inline-flex align-items-center rounded border-danger py-1" role="alert">
                            {!! trans('common.the_maximum_question_limit_allowed_for_this_session_is', ['questions_limit' => $session->questions_limit]) !!}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 h-100">
            <div class="col card text-bg-dark p-0 h-100">
                <div class="card-header text-center">
                    <h2 class="text-center h3"><span class="fa-duotone fa-inbox-in fa-fade mx-1"></span> {{__('common.incoming-questions')}}</h2>
                </div>
                <div class="card-body d-block p-0 overflow-y-auto h-100">
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
                                        <a href="{{ route('portal.session-question.on-screen', [$question->id]) }}" title="{{ __('common.on-screen') }}">
                                            <i class="fa-regular fa-toggle-off fa-xg text-danger"></i>
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
                <div class="card-body d-block p-0 overflow-y-auto h-100">
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
                                        <a href="{{ route('portal.session-question.on-screen', [$question->id]) }}" title="{{ __('common.on-screen') }}">
                                            <i class="fa-regular fa-toggle-on fa-xg text-success"></i>
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
    <style>
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
@endsection
