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
                                    legend: {
                                        display: false,
                                    },
                                    tooltip: {
                                        enabled: false
                                    }
                                },
                            },
                            data: {
                                labels: options.map(row => row.option),
                                datasets: [
                                    {
                                        data: options.map(row => row.votes_count),
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
    <div class="card text-bg-dark border-dark">
        <div class="card-header">
            <h1 class="text-center p-2">
                <span class="fa-regular fa-square-question fa-fade p-2 "></span>
                <small id="keypad-title">"{{ $keypad->keypad }}"</small>
            </h1>
        </div>
        @if($options)
            <div class="card-body">
                <div class="w-100 p-3"><canvas id="options"></canvas></div>
                <script>
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
                                    labels: data.map(row => row.option),
                                    datasets: [
                                        {
                                            data: data.map(row => row.votes_count),
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
    </div>
@endsection
