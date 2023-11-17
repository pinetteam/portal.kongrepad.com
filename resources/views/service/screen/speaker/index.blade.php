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
    @isset($meeting_hall_screen->background_name)
        <div class="bg-img bg-cover" style="backgroud-color: #fff;background-image: url({{ asset('storage/screen-backgrounds/' . $meeting_hall_screen->background_name . '.' . $meeting_hall_screen->background_extension)}} ); height:100%; width:100%;">
    @endisset
    @if($speaker)
    <div class="d-flex align-items-center justify-content-center h-100">
        <h1 class="text-{{$meeting_hall_screen->font_color}} text-center w-100 fw-bold" id="speaker" style="font-size: {{$meeting_hall_screen->font_size ?? 96}}px">{{ isset($speaker->title) ? $speaker->title . ' ' : null }}{{ $speaker->first_name }} {{ $speaker->last_name }}</h1>
    </div>
    @else
    <div class="d-flex align-items-center justify-content-center h-100">
        <h1 class="text-{{$meeting_hall_screen->font_color}} text-center w-100 fw-bold" id="speaker" style="font-size: {{$meeting_hall_screen->font_size ?? 96}}px">
        </h1>
    </div>
@endif
@endsection

