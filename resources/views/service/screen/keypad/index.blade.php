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
                        optionsHTML += '<div class="progress mt-2 h-25 bg-dark" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> <div class="progress-bar progress-bar-striped progress-bar-animated bg-info text-{{$meeting_hall_screen->font_color}} text-center p-2 overflow-visible" style="width:'
                        optionsHTML += option.votes_count == 0 ? 0 : option.votes_count / keypad.votes_count*100
                        optionsHTML += '%; font-size: {{$meeting_hall_screen->font_size ?? 72}}px">'
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
    <div class="card text-bg-dark border-dark">
        <div class="card-header">
            <h1 class="text-center p-2">
                <span class="fa-regular fa-square-question fa-fade p-2 "></span>
                <small>"{{ $keypad->keypad }}"</small>
            </h1>
        </div>
        @if($keypad->options)
            <div class="card-body">
                <div class="chart-container border-dark">
                    <div class="bar-chart-container">
                        <canvas id="bar-chart"></canvas>
                    </div>
                </div>
            <script>
                $(function(){
                    var cData = JSON.parse(`<?php echo $chart_data; ?>`);
                    var ctx = $("#bar-chart");
                    var data = {
                        labels: cData.label,
                        datasets: [{
                            label: 'Votes',
                            data: cData.data,
                            borderRadius: 10,
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                        }]
                    }
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            animation: {
                                duration: 0,
                                onComplete: function () {
                                    var chartInstance = this.chart,
                                        ctx = chartInstance.ctx;
                                    ctx.textAlign = 'center';
                                    ctx.fillStyle = "white";
                                    ctx.textBaseline = 'bottom';
                                    ctx.font = "30px 'Helvetica Neue', Helvetica, Arial, sans-serif";

                                    this.data.datasets.forEach(function (dataset, i) {
                                        var meta = chartInstance.controller.getDatasetMeta(i);
                                        meta.data.forEach(function (bar, index) {
                                            var data = dataset.data[index];
                                            ctx.fillText(data, bar._model.x, bar._model.y + 40);

                                        });
                                    });
                                }
                            },
                            legend: {
                                display: false
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        fontColor: "white",
                                        fontSize: 30,
                                    },
                                    gridLines: {
                                        lineWidth: 1
                                    }
                                }],
                                xAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        fontColor: "white",
                                        fontSize: 30,
                                    },
                                    gridLines: {
                                        lineWidth: 0
                                    }
                                }]
                            }
                        }
                    });
                });
                $(function(){
                    var cData = JSON.parse(`<?php echo $chart_data; ?>`);
                    var ctx = $("#pie-chart");
                    var data = {
                        labels: cData.label,
                        datasets: [{
                            label: 'Votes',
                            data: cData.data,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(153, 102, 255, 0.5)',
                                'rgba(255, 159, 64, 0.5)',
                                'rgba(255, 99, 132, 0.5)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    }
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                });
            </script>
        </div>
        @endif
    </div>
@endsection
