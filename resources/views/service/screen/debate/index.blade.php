@extends('layout.screen.common')
@section('title', __('common.debate-screen'))
@section('body')
    <div class="card text-bg-dark border-dark w-100">
        <div class="card-header">
            <h1 class="text-center p-2">
                <span class="fa-regular fa-square-question fa-fade p-0"></span>
                <small id="debate-title">"{{ $debate ? $debate->title : ""}}"</small>
            </h1>
        </div>
        @if($teams)
            <div class="card-body">
                <canvas id="teams" class="w-100 p-3"></canvas>
                <script type="module">
                    var chart = null;
                    Echo.channel('service.screen.debate.{{ $meeting_hall_screen->code }}')
                        .listen('.debate-event', data => {
                            if(data.debate !== null) {
                                if (chart){
                                    chart.destroy();
                                }
                                console.log(data.debate)
                                var teams = data.debate.teams
                                Chart.defaults.font.size = {{ $meeting_hall_screen->font_size }};
                                Chart.defaults.color = "{{ $meeting_hall_screen->font_color }}";
                                chart = new Chart(
                                    document.getElementById('teams'),
                                    {
                                        type: 'bar',
                                        options: {
                                            layout: {
                                                padding: {
                                                    top: 0
                                                }
                                            },
                                            animation: false,
                                            plugins: {
                                                datalabels: {
                                                    color: '{{ $meeting_hall_screen->font_color }}',
                                                    align: 'end',
                                                    anchor: 'end',
                                                    formatter: function(value, context) {
                                                        return  value;
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
                                            labels: teams.map((row, index) => {
                                                return teams[index].title;
                                            }),
                                            datasets: [
                                                {
                                                    data: teams.map((row, index) => {
                                                        return teams[index].votes_count;
                                                    }),
                                                    backgroundColor: teams.map((row, index) => {
                                                        const colors = ['red', 'blue', 'green', 'yellow', 'purple'];
                                                        return colors[index % colors.length];
                                                    })
                                                }
                                            ]
                                        }
                                    }
                                );
                                document.getElementById("debate-title").innerText = data.debate.title;
                            } else {
                                document.getElementById("teams").innerHTML = '...';
                            }
                        });
                    (async function() {
                        Chart.defaults.font.size = {{ $meeting_hall_screen->font_size }};
                        Chart.defaults.color = "{{ $meeting_hall_screen->font_color }}";
                        var data = @json($teams);
                        chart = new Chart(
                            document.getElementById('teams'),
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
                                                return  value;
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
                                    labels: data.map(row => row.title),
                                    datasets: [
                                        {
                                            data: data.map((row, index) => {
                                                return data[index].votes_count;
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
    </div>
@endsection
