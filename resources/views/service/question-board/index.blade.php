@extends('layout.screen.common')
@section('title', __('common.question-board'))
@section('script')
    <script type="module">
        Echo.channel('service.screen.question-board.{{ $hall->code }}')
            .listen('.question-board-event', data => {
                if(data.questions !== null) {
                    var questions = data.questions;
                    var questionsHTML = '';
                    questions.forEach(function(question) {
                        questionsHTML += '<tr>';
                        questionsHTML += '<td class="w-75">' + question.question + '</td>';
                        if (question.is_hidden_name == 0)
                            questionsHTML += '<td>' + question.questioner.first_name + ' ' + question.questioner.last_name + '</td>';
                        else
                            questionsHTML += '<td>Anonim</td>';
                        questionsHTML += '<td><a href="https://app.kongrepad.com/portal/session-question-on-screen/' + question.id + '"><i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i></a></td>';
                        questionsHTML += '</tr>';
                    });

                    // Tabloyu yeniden render et
                    document.getElementById('questions-table-body').innerHTML = questionsHTML;
                }

                if(data.selected_questions !== null) {
                    var selectedQuestionsHTML = '';
                    data.selected_questions.forEach(function(question) {
                        selectedQuestionsHTML += '<tr>';
                        selectedQuestionsHTML += '<td class="w-75">' + question.question + '</td>';
                        if (question.is_hidden_name == 0)
                            selectedQuestionsHTML += '<td>' + question.questioner.first_name + ' ' + question.questioner.last_name + '</td>';
                        else
                            selectedQuestionsHTML += '<td>Anonim</td>';
                        selectedQuestionsHTML += '<td><a href="https://app.kongrepad.com/portal/session-question-on-screen/' + question.id + '"><i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i></a></td>';
                        selectedQuestionsHTML += '</tr>';
                    });

                    // Seçilen sorular tablosunu yeniden render et
                    document.getElementById('selected-questions-table-body').innerHTML = selectedQuestionsHTML;
                }
            });
    </script>
@endsection
@section('body')
    <div class="container">
        <h2>Soru Panosu</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Soru</th>
                <th>İsim</th>
                <th>Durum</th>
            </tr>
            </thead>
            <tbody id="questions-table-body">
            <!-- Sorular burada dinamik olarak yüklenecek -->
            </tbody>
        </table>

        <h3>Seçilen Sorular</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Soru</th>
                <th>İsim</th>
                <th>Durum</th>
            </tr>
            </thead>
            <tbody id="selected-questions-table-body">
            <!-- Seçilen sorular burada dinamik olarak yüklenecek -->
            </tbody>
        </table>
    </div>
@endsection
