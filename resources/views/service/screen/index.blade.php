<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Screen Test | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
    <script type="module">
        console.log('test');
        Echo.channel('screen-channel')
            .listen('.my-event', data => {
                document.getElementById("speaker").innerHTML = data.participant.first_name + ' ' + data.participant.last_name;
            });
    </script>
</head>
<body class="d-flex bg-dark h-100 align-items-center">
<div id="kp-loading" class="d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-success" role="status">
        <span class="visually-hidden">{{ __('common.loading') }}</span>
    </div>
</div>
<h1 class="text-white text-center w-100" id="speaker" style="font-size: 72px"></h1>
</body>
</html>

