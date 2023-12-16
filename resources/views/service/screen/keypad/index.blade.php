@extends('layout.screen.common')
@section('title', __('common.keypad-screen'))
@section('script')
@endsection
@section('body')
    <div class="card text-bg-dark w-100">
        @if($keypad)
            <div class="card-header">
                <h1 class="text-center p-2">
                    <small id="keypad-title">"{{ $keypad->keypad }}"</small>
                </h1>
            </div>
            @if($options)
                <div class="card-body">
                    <canvas id="options" class="w-100 p-3"></canvas>
                    <script type="module">
                        var chart = Chart.getChart("0");
                        Echo.channel('service.screen.keypad.{{ $meeting_hall_screen->code }}')
                            .listen('.keypad-event', data => {
                                if(data.keypad !== null) {
                                    if (chart){
                                        chart.destroy();
                                    }
                                    var options = data.keypad.options
                                    Chart.defaults.font.size = {{ $meeting_hall_screen->font_size }};
                                    Chart.defaults.color = "{{ $meeting_hall_screen->font_color }}";
                                    chart = new Chart(
                                        document.getElementById('options'),
                                        {
                                            type: 'bar',
                                            options: {
                                                layout: {
                                                    padding: {
                                                        top: 40
                                                    }
                                                },
                                                animation: false,
                                                plugins: {
                                                    datalabels: {
                                                        color: '{{ $meeting_hall_screen->font_color }}',
                                                        align: 'end',
                                                        anchor: 'end',
                                                        formatter: function(value, context) {
                                                            return '%' + value;
                                                        }
                                                    },
                                                    legend: {
                                                        display: false,
                                                    },
                                                    tooltip: {
                                                        enabled: false
                                                    },
                                                }
                                            },
                                            data: {
                                                labels: options.map((row, index) => {
                                                    const options_names = ['A', 'B', 'C', 'D', 'E', 'F'];
                                                    return options_names[index % options_names.length];
                                                }),
                                                datasets: [
                                                    {
                                                        data: options.map((row, index) => {
                                                            return +(options[index].votes_count*100/data.keypad.votes_count).toFixed(2);
                                                        }),
                                                        backgroundColor: options.map((row, index) => {
                                                            const colors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];
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
                        (async function() {
                            Chart.defaults.font.size = {{ $meeting_hall_screen->font_size }};
                            Chart.defaults.color = "{{ $meeting_hall_screen->font_color }}";
                            var data = @json($options);
                            chart = new Chart(
                                document.getElementById('options'),
                                {
                                    type: 'bar',
                                    options: {
                                        layout: {
                                            padding: {
                                                top: 40
                                            }
                                        },
                                        animation: false,
                                        plugins: {
                                            datalabels: {
                                                color: '#fff',
                                                align: 'end',
                                                anchor: 'end',
                                                formatter: function(value, context) {
                                                    return '%' + value;
                                                }
                                            },
                                            legend: {
                                                display: false,
                                            },
                                            tooltip: {
                                                enabled: false
                                            },
                                        }
                                    },
                                    data: {
                                        labels: data.map((row, index) => {
                                            const options = ['A', 'B', 'C', 'D', 'E', 'F'];
                                            return options[index % options.length];
                                        }),
                                        datasets: [
                                            {
                                                data: data.map((row, index) => {
                                                    return +(data[index].votes_count*100/{{ $keypad ? $keypad->votes_count : 1 }}).toFixed(2);
                                                }),
                                                backgroundColor: data.map((row, index) => {
                                                    const colors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];
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
