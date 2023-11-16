@extends('layout.screen.common')
@section('title', __('common.keypad-screen'))
@section('script')
    <script type="module">
        Echo.channel('service.screen.keypad.{{ $meeting_hall_screen->code }}')
            .listen('.keypad-event', data => {
                if(data.keypad !== null) {
                    var keypad = data.keypad;
                    console.log(keypad)
                    var options = data.keypad.options;
                    var optionsHTML = '';
                    options.forEach(function(option) {
                        optionsHTML += '<div class="progress mt-2 h-25 bg-dark" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> <div class="progress-bar progress-bar-striped progress-bar-animated bg-info text-white text-center p-2 overflow-visible" style="width:'
                        optionsHTML += option.votes_count == 0 ? 0 : option.votes_count / keypad.votes_count*100
                        optionsHTML += '%; font-size: 72px">'
                        optionsHTML += option.option
                        optionsHTML += ' ('
                        optionsHTML += keypad.votes_count == 0 ? 0 : option.votes_count / keypad.votes_count*100
                        optionsHTML +='%) </div> </div>';
                    });
                    document.getElementById("keypad-title").innerText = keypad.keypad;
                    document.getElementById("options").innerHTML = optionsHTML;
                } else {
                    document.getElementById("options").innerHTML = '...';
                }
            });
    </script>
@endsection
@section('body')
    <div class="card text-bg-dark" xmlns="http://www.w3.org/1999/html">
        <div class="card-header">
            <h1 class="text-center" id="keypad-title"> {{ isset($keypad) ? $keypad->keypad : ""}} </h1>
        </div>
    </div>
    <div class="card text-bg-dark">
        <div class="card-body">
            <div class="ms-2 w-100 overflow-hidden" id="options">
                @isset($keypad)
                @foreach($keypad->options as $option)
                    <div class="progress mt-2 h-25 bg-dark" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info text-white text-center p-2 overflow-visible" style="width: {{ $keypad->votes->count() == 0 ? 0 :$option->votes->count() / $keypad->votes->count()*100 }}%">
                            {{ $option->option }} ({{ $keypad->votes->count() == 0 ? 0 : round($option->votes->count() / $keypad->votes->count()*100, 2)}}%)
                        </div>
                    </div>
                @endforeach
                @endisset
            </div>
        </div>
    </div>
@endsection
