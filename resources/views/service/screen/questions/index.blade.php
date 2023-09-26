<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('common.questions-screen') }} | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
    <script type="module">
        Echo.channel('service.screen.questions.{{ $meeting_hall_screen->code }}')
            .listen('.questions-event', data => {
                if(data.questions !== null) {
                    var questions = data.questions;
                    var questionsHTML = '<hr />';
                    questions.forEach(function(question) {
                        questionsHTML += question.question;
                        if(question.is_hidden_name) {
                            questionsHTML += ' | <small>' + question.questioner.first_name + ' ' + question.questioner.last_name + '</small>';
                        }
                        questionsHTML += '<hr />';
                    });
                    document.getElementById("questions").innerHTML = questionsHTML;
                } else {
                    document.getElementById("questions").innerHTML = '...';
                }
            });
    </script>
</head>
<body class="d-flex bg-dark h-100 align-items-center">
<div id="kp-loading" class="d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-success" role="status">
        <span class="visually-hidden">{{ __('common.loading') }}</span>
    </div>
</div>
@if($questions)
    <h1 class="text-white text-center w-100" id="questions" style="font-size: 72px">
        <hr/>
        @foreach($questions as $question)
            {{ $question->question }}
            @if($question->is_hidden_name)
                | <small>{{ $question->questioner->full_name }}</small>
            @endif
            <hr />
        @endforeach
    </h1>
@else
    <h1 class="text-white text-center w-100" id="questions" style="font-size: 72px">
        <div class="spinner-grow text-success text-center" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </h1>
@endif
</body>
</html>

