@extends('layout.screen.common')
@section('title', __('common.keypad-screen'))
@section('script')
    <script type="module">
        var chart = null;
        Echo.channel('service.screen.keypad.{{ $meeting_hall_screen->code }}')
            .listen('.keypad-event', data => {
                if(data.keypad !== null) {
                    if (chart){
                        chart.destroy();
                    }
                    var options = data.keypad.options
                    Chart.defaults.font.size = 18;
                    Chart.defaults.color = "#fff";
                    chart = new Chart(
                        document.getElementById('options'),
                        {
                            type: 'bar',
                            options: {
                                animation: false,

                                plugins: {
                                    ChartDataLabels,
                                    datalabels: {
                                        color: '#36A2EB'
                                    },
                                    legend: {
                                        display: false,
                                    },
                                    tooltip: {
                                        enabled: false
                                    }
                                },
                            },
                            data: {
                                labels: options.map((row, index) => {
                                    const options_names = ['A', 'B', 'C', 'D', 'E'];
                                    return options_names[index % options_names.length] + " - %" + +(options[index].votes_count*100/data.keypad.votes_count).toFixed(2);
                                }),
                                datasets: [
                                    {
                                        data: options.map((row, index) => {
                                            return +(options[index].votes_count*100/data.keypad.votes_count).toFixed(2);
                                        }),
                                        backgroundColor: options.map((row, index) => {
                                            const colors = ['red', 'blue', 'green', 'yellow', 'purple'];
                                            return colors[index % colors.length];
                                        })
                                    }
                                ]
                            }
                        }
                    );
                    document.getElementById("keypad-title").innerText = data.keypad.keypad;
                } else {
                    document.getElementById("options").innerHTML = '...';
                }
            });
    </script>
@endsection
@section('body')
    <div class="card text-bg-dark w-100">
        @if($keypad)
            <div class="card-header">
                <h1 class="text-center p-2">
                    <span class="fa-regular fa-square-question fa-fade p-2 "></span>
                    <small id="keypad-title">"{{ $keypad->keypad }}"</small>
                </h1>
            </div>
            @if($options)
                <div class="card-body">
                    <canvas id="options" class="w-100 p-3"></canvas>
                    <script type="module">
                        (async function() {
                            Chart.defaults.font.size = 18;
                            Chart.defaults.color = "#fff";
                            var data = @json($options);
                            new Chart(
                                document.getElementById('options'),
                                {
                                    type: 'bar',
                                    options: {
                                        animation: false,
                                        plugins: {
                                            legend: {
                                                display: false,
                                            },
                                            tooltip: {
                                                enabled: false
                                            }
                                        }
                                    },
                                    data: {
                                        labels: data.map((row, index) => {
                                            const options = ['A', 'B', 'C', 'D', 'E'];
                                            return options[index % options.length] + " - %" + +(data[index].votes_count*100/{{ $keypad ? $keypad->votes_count : 1 }}).toFixed(2);
                                        }),
                                        datasets: [
                                            {
                                                data: data.map((row, index) => {
                                                    return +(data[index].votes_count*100/{{ $keypad ? $keypad->votes_count : 1 }}).toFixed(2);
                                                }),
                                                backgroundColor: data.map((row, index) => {
                                                    const colors = ['red', 'blue', 'green', 'yellow', 'purple'];
                                                    return colors[index % colors.length];
                                                })
                                            }
                                        ]
                                    }
                                }
                            );
                        })();
                    </script>
            </div>
            @endif
        @endif
    </div>
@endsection
