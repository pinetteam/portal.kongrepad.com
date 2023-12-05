@extends('layout.screen.common')
@section('title', __('common.debate-screen'))
@section('script')
    <script type="module">
        var chart = null;
        Echo.channel('service.screen.debate.{{ $meeting_hall_screen->code }}')
            .listen('.debate-event', data => {
                if(data.debate !== null) {
                    if (chart){
                        chart.destroy();
                    }
                    var teams = data.debate.teams
                    Chart.defaults.font.size = 18;
                    Chart.defaults.color = "#fff";
                    chart = new Chart(
                        document.getElementById('teams'),
                        {
                            type: 'bar',
                            teams: {
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
                                labels: teams.map(row => row.title),
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
                    document.getElementById("debate-title").innerText = data.debate.debate;
                } else {
                    document.getElementById("teams").innerHTML = '...';
                }
            });
    </script>
@endsection
@section('body')
    <div class="card text-bg-dark border-dark w-100">
        <div class="card-header">
            <h1 class="text-center p-2">
                <span class="fa-regular fa-square-question fa-fade p-2 "></span>
                <small id="debate-title">"{{ $debate ? $debate->title : ""}}"</small>
            </h1>
        </div>
        @if($teams)
            <div class="card-body">
                <canvas id="teams" class="w-100 p-3"></canvas>
                <script type="module">
                    (async function() {
                        Chart.defaults.font.size = 18;
                        Chart.defaults.color = "#fff";
                        var data = @json($teams);
                        new Chart(
                            document.getElementById('teams'),
                            {
                                type: 'bar',
                                options: {
                                    animation: false,
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            enabled: false
                                        },
                                    },
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
