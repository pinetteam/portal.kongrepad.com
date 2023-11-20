@extends('layout.screen.common')
@section('title', $meeting_hall_screen->title)
@section('script')
    <script type="module">
        let stopwatch = document.getElementById('stopwatch');

        let totalTime = 600;
        let tInterval;
        let running = false;

        function updateTime() {
            totalTime--;
            updateDisplay();

            if (totalTime === 0) {
                clearInterval(tInterval);
                running = false;
                tInterval = setInterval(updateTime, 1000);
            }
        }

        function updateDisplay() {
            let absTime = Math.abs(totalTime);
            let minutes = Math.floor(absTime / 60);
            let seconds = absTime % 60;

            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            let timeString = minutes + ':' + seconds;
            if (totalTime < 0) {
                stopwatch.style.color = 'red';
            } else {
                stopwatch.style.color = '{{ $meeting_hall_screen->font_color }}';
            }


            stopwatch.innerText = timeString;
        }

        updateDisplay();
        Echo.channel('service.screen.timer.{{ $meeting_hall_screen->code }}')
            .listen('.timer-event', data => {
                if(data.action === 'restart') {
                    clearInterval(tInterval);
                    totalTime = data.time * 60;
                    updateDisplay();
                } else if (data.action === 'stop'){
                    if (running) {
                        clearInterval(tInterval);
                        running = false;
                    }
                }else if (data.action === 'start'){
                    if (!running) { // Ensure the timer isn't already running
                        tInterval = setInterval(updateTime, 1000);
                        running = true;
                    }
                }
            });
    </script>
@endsection
@section('body')
    @isset($meeting_hall_screen->background_name)
        <div class="bg-img bg-cover" style="background-color: #fff;background-image: url({{ asset('storage/screen-backgrounds/' . $meeting_hall_screen->background_name . '.' . $meeting_hall_screen->background_extension)}} ); height:100%; width:100%; background-size: cover; background-repeat: no-repeat;">
    @endisset
    <div class="d-flex align-items-center justify-content-center h-100">
        <div id="stopwatch" style="font-size: {{$meeting_hall_screen->font_size ?? 96}}px">00:00:00</div>
    </div>
@endsection

