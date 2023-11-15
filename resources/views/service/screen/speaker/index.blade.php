@extends('layout.screen.common')
@section('title', $meeting_hall_screen->title)
@section('script')
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
@endsection
@section('body')
<div id="kp-loading" class="d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-success" role="status">
        <span class="visually-hidden">{{ __('common.loading') }}</span>
    </div>
</div>
@if($speaker)
    <div class="d-flex align-items-center justify-content-center h-100">
        <h1 class="text-white text-center w-100 fw-bold" id="speaker" style="font-size: 96px">{{ isset($speaker->title) ? $speaker->title . ' ' : null }}{{ $speaker->first_name }} {{ $speaker->last_name }}</h1>
    </div>
    @else
    <h1 class="text-white text-center w-100 fw-bold" id="speaker" style="font-size: 96px">
        <div class="spinner-grow text-success text-center" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </h1>
@endif
@endsection

