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
<div id="kp-loading" class="d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-success" role="status">
        <span class="visually-hidden">{{ __('common.loading') }}</span>
    </div>
</div>
@if($chair)
    <div class="d-flex align-items-center justify-content-center h-100">
        <h1 class="text-white text-center w-100 fw-bold" id="chair" style="font-size: 172px">{{ isset($chair->title) ? $chair->title . ' ' : null }}{{ $chair->first_name }} {{ $chair->last_name }}</h1>
    </div>
@else
    <h1 class="text-white text-center w-100 fw-bold" id="chair" style="font-size: 172px">
        <div class="spinner-grow text-success text-center" role="status">
            <span class="visually-hidden">{{ __('common.loading') }}</span>
        </div>
    </h1>
@endif
@endsection

