@extends('layout.screen.common')
@section('title', $meeting_hall_screen->title)
@section('script')
    <script type="module">
        let stopwatch = document.getElementById('stopwatch');

        let totalTime = 600; // 10 minutes in seconds
        let tInterval;
        let running = false;

        function updateTime() {
            totalTime--;
            updateDisplay();

            if (totalTime <= 0) {
                clearInterval(tInterval);
                running = false;
            }
        }

        function updateDisplay() {
            let minutes = Math.floor(totalTime / 60);
            let seconds = totalTime % 60;

            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            stopwatch.innerText = minutes + ':' + seconds;
        }

        updateDisplay();
        Echo.channel('service.screen.timer.{{ $meeting_hall_screen->code }}')
            .listen('.timer-event', data => {
                if(data.action === 'restart') {
                    clearInterval(tInterval);
                    totalTime = data.time * 60;
                    updateDisplay();
                    tInterval = setInterval(updateTime, 1000);
                    running = true;
                } else if (data.action === 'stop'){
                    if (running) {
                        clearInterval(tInterval);
                        running = false;
                    }
                }else if (data.action === 'start'){
                    tInterval = setInterval(updateTime, 1000);
                    running = true;
                }
            });
    </script>
@endsection
@section('body')
    @isset($meeting_hall_screen->background_name)
        <div class="bg-img bg-cover" style="backgroud-color: #fff;background-image: url({{ asset('storage/screen-backgrounds/' . $meeting_hall_screen->background_name . '.' . $meeting_hall_screen->background_extension)}} ); height:100%; width:100%;">
    @endisset
    <div class="d-flex align-items-center justify-content-center h-100">
        <div id="stopwatch" class="text-{{$meeting_hall_screen->font_color}}" style="font-size: {{$meeting_hall_screen->font_size ?? 96}}px">00:00:00</div>
    </div>
@endsection

