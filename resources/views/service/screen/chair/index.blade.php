<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('common.chair-screen') }} | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])
    <script type="module">
        Echo.channel('service.screen.chair.{{ $meeting_hall_screen->code }}')
            .listen('.chair-event', data => {
                if(data.chair !== null) {
                    if(data.chair.title !== null)
                    {
                        document.getElementById("chair").innerHTML = data.chair.title + ' ' + data.chair.first_name + ' ' + data.chair.last_name;
                    } else {
                        document.getElementById("chair").innerHTML = data.chair.first_name + ' ' + data.chair.last_name;
                    }
                } else {
                    document.getElementById("chair").innerHTML = '...';
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
@if($chair)
    <h1 class="text-white text-center w-100" id="chair" style="font-size: 72px">{{ isset($chair->title) ? $chair->title . ' ' : null }}{{ $chair->first_name }} {{ $chair->last_name }}</h1>
@else
    <h1 class="text-white text-center w-100" id="chair" style="font-size: 72px">
        <div class="spinner-grow text-success text-center" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </h1>
@endif
</body>
</html>

