<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('common.speaker-screen') }} | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
    <script type="module">
        Echo.channel('service.screen.speaker.{{ $meeting_hall_screen->code }}')
            .listen('.speaker-event', data => {
                if(data.speaker !== null) {
                    if(data.speaker.title !== null)
                    {
                        document.getElementById("speaker").innerHTML = data.speaker.title + ' ' + data.speaker.first_name + ' ' + data.speaker.last_name;
                    } else {
                        document.getElementById("speaker").innerHTML = data.speaker.first_name + ' ' + data.speaker.last_name;
                    }
                } else {
                    document.getElementById("speaker").innerHTML = '...';
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
@if($speaker)
    <div class="col">
        <h1 class="text-white text-center w-100 fw-bold" id="speaker" style="font-size: 96px">{{ isset($speaker->title) ? $speaker->title . ' ' : null }}{{ $speaker->first_name }} {{ $speaker->last_name }}</h1>
    </div>
    @else
    <h1 class="text-white text-center w-100 fw-bold" id="speaker" style="font-size: 96px">
        <div class="spinner-grow text-success text-center" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </h1>
@endif

</body>
</html>

