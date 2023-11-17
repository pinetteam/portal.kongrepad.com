@extends('layout.screen.common')
@section('title', $meeting_hall_screen->title)
@section('script')
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
@endsection
@section('body')
    @isset($meeting_hall_screen->background_name)
        <div class="bg-img bg-cover" style="backgroud-color: #fff;background-image: url({{ asset('storage/screen-backgrounds/' . $meeting_hall_screen->background_name . '.' . $meeting_hall_screen->background_extension)}} ); height:100%; width:100%;">
    @endisset
    @if($chair)
        <div class="d-flex align-items-center justify-content-center h-100">
            <h1 class="text-{{$meeting_hall_screen->font_color}} text-center w-100 fw-bold" id="chair" style="font-size: {{$meeting_hall_screen->font_size ?? 172}}px">{{ isset($chair->title) ? $chair->title . ' ' : null }}{{ $chair->first_name }} {{ $chair->last_name }}</h1>
        </div>
    @else
        <div class="d-flex align-items-center justify-content-center h-100">
            <h1 class="text-{{$meeting_hall_screen->font_color}} text-center w-100 fw-bold" id="chair" style="font-size: {{$meeting_hall_screen->font_size ?? 172}}px">
            </h1>
        </div>
    @endif
@endsection

