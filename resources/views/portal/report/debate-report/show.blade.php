@extends('layout.portal.common')
@section('title', __('common.debate').' | '.$title->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-thin fa-messages fa-fade p-2"></span>
                <small>"{{ $title->title }}"</small>
            </h1>
        </div>
    </div>

    <div class="card text-bg-dark">
        <div class="card-header">
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <div class="chart-container">
                            <div class="pie-chart-container">
                                <canvas id="pie-chart"></canvas>
                            </div>
                        </div>
                        <script>
                            $(function(){
                                var cData = JSON.parse(`<?php echo $chart_data; ?>`);
                                var ctx = $("#pie-chart");
                                var data = {
                                    labels: cData.label,
                                    datasets: [
                                        {
                                            label: "Votes",
                                            data: cData.data,
                                            backgroundColor: [
                                                "#3179ab",
                                                "#4a1d96",
                                                "#2f14dc",
                                                "#124d7a",
                                                "#2E8B57",
                                                "#1D7A46",
                                                "#48b08d",
                                            ],
                                            borderColor: [
                                                "#ffffff",
                                                "#ffffff",
                                                "#ffffff",
                                                "#ffffff",
                                                "#ffffff",
                                                "#ffffff",
                                                "#ffffff",
                                            ],
                                            borderWidth: [1, 1, 1, 1, 1, 1, 1]
                                        }
                                    ]
                                };
                                var options = {
                                    responsive: true,
                                    title: {
                                        display: true,
                                        position: "top",
                                        text: "",
                                        fontSize: 18,
                                        fontColor: "#ffffff"
                                    },
                                    legend: {
                                        display: true,
                                        position: "bottom",
                                        labels: {
                                            fontColor: "#ffffff",
                                            fontSize: 16
                                        }
                                    },
                                    animation: {
                                        onComplete: () => {
                                            delayed = true;
                                        },
                                        delay: (context) => {
                                            let delay = 0;
                                            if (context.type === 'data' && context.mode === 'default' && !delayed) {
                                                delay = context.dataIndex * 300 + context.datasetIndex * 100;
                                            }
                                            return delay;
                                        },
                                    },
                                };
                                var chart1 = new Chart(ctx, {
                                    type: "pie",
                                    data: data,
                                    options: options
                                });
                            });
                        </script>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
