@extends('layout.screen.common')
@section('title', $meeting_hall_screen->title)
@section('script')
    <script type="module">
        Echo.channel('service.screen.questions.{{ $meeting_hall_screen->code }}')
            .listen('.questions-event', data => {
                if(data.questions !== null) {
                    var questions = data.questions;
                    var questionsHTML = '<hr />';
                    questions.forEach(function(question) {
                        questionsHTML += question.question;
                        if(!question.is_hidden_name) {
                            questionsHTML += ' | <small>' + question.questioner.first_name + ' ' + question.questioner.last_name + '</small>';
                        } else {
                            questionsHTML += ' | <small>Anonim</small>'
                        }
                        questionsHTML += '<hr />';
                    });
                    document.getElementById("questions").innerHTML = questionsHTML;
                } else {
                    document.getElementById("questions").innerHTML = '...';
                }
            });
    </script>
@endsection
@section('body')
<body class="d-flex bg-dark h-100 align-items-center">
@if($questions)
    <h1 class="text-white text-start w-100 p-5" id="questions" style="font-size: {{ $meeting_hall_screen->font_size }}px; color: {{ $meeting_hall_screen->font_color }}; font-family: '{{ $meeting_hall_screen->font }}'">
        <hr/>
        @foreach($questions as $question)
            {{ $question->question }}
            @if(!$question->is_hidden_name)
                | <small>{{ $question->questioner->full_name }}</small>
            @else
                | <small>{{ __('common.anonymous') }}</small>
            @endif
            <hr />
        @endforeach
    </h1>
@endif
</body>
@endsection

