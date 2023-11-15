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
<div id="kp-loading" class="d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-success" role="status">
        <span class="visually-hidden">{{ __('common.loading') }}</span>
    </div>
</div>
@if($questions)
    <h1 class="text-white text-start w-100 p-5" id="questions" style="font-size: 36px">
        <hr/>
        @foreach($questions as $question)
            {{ $question->question }}
            @if(!$question->is_hidden_name)
                | <small>{{ $question->questioner->full_name }}</small>
            @else
                | <small>Anonim</small>
            @endif
            <hr />
        @endforeach
    </h1>
@else
    <h1 class="text-white text-start w-100 p-5" id="questions" style="font-size: 72px">
        <div class="spinner-grow text-success text-center" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </h1>
@endif
</body>
@endsection

