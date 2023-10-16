@extends('layout.portal.common')
@section('title', __('common.question').' | '.$question->question)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-regular fa-square-question fa-fade p-2 "></span>
                <small>"{{$question->question }}"</small>
            </h1>
        </div>
    </div>

    <div class="card text-bg-dark">
        <div class="card-header">
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <div class="chart-container">
                            <div class="polarArea-chart-container">
                                <canvas id="polarArea-chart"></canvas>
                            </div>
                        </div>
                        <script>
                            $(function(){
                                var cData = JSON.parse(`<?php echo $chart_data; ?>`);
                                var ctx = $("#polarArea-chart");
                                var data = {
                                    labels: cData.label,
                                    datasets: [
                                        {
                                            label: "Votes",
                                            data: cData.data,
                                            backgroundColor: [
                                                'rgb(255, 99, 132)',
                                                'rgb(75, 192, 192)',
                                                'rgb(255, 205, 86)',
                                                'rgb(201, 203, 207)',
                                                'rgb(54, 162, 235)'
                                            ]
                                        }
                                    ]
                                };
                                var chart1 = new Chart(ctx, {
                                    type: "polarArea",
                                    data: data,
                                    options: {
                                        indexAxis: 'y',
                                    }
                                });
                            });
                        </script>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
