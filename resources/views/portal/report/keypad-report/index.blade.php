@extends('layout.portal.common')
@section('title', __('common.keypad-reports'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-chart-pie fa-fade"></span> {{ __('common.keypad-reports') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="w-50"><span class="fa-regular fa-square-question fa-fade mx1"></span> {{ __('common.keypad') }}</th>
                        <th scope="col"><span class="fa-regular fa-chart-pie fa-fade mx1"></span> {{ __('common.report') }}</th>
                    </tr>
                    </thead>
                    @foreach($keypads as $keypad)
                        <tbody>
                        <tr>
                        <th scope="col"></th>
                        <td>
                            <div class="table-responsive mt-5">
                                <table class="table table-dark table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <th scope="col"><span class="fa-regular fa-bee mx-1"></span> {{ __('common.session') }}</th>
                                        <td>{{ $keypad->session->title }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col"><span class="fa-regular fa-pen-field mx-1"></span> {{ __('common.keypad') }}</th>
                                        <td>{{ $keypad->keypad }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.voting-started-at') }}</th>
                                        <td>
                                            @if($keypad->voting_started_at)
                                                {{ $keypad->voting_started_at }}
                                            @else
                                                <i class="text-info">{{__('common.unspecified')}}</i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.voting-finished-at') }}</th>
                                        <td>
                                            @if($keypad->voting_finished_at)
                                                {{ $keypad->voting_finished_at }}
                                            @else
                                                <i class="text-info">{{__('common.unspecified')}}</i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.on_vote') }}</th>
                                        <td>
                                            @if($keypad->on_vote)
                                                <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                            @else
                                                <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                        <td>
                            <div class="chart-container">
                                <div class="pie-chart-container">
                                    <canvas id="pie-chart-{{ $keypad->id }}"></canvas>
                                </div>
                            </div>
                        </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                    <a class="btn btn-info btn-sm" href="{{ route("portal.keypad-report.question.chart",['keypad_id'=>$keypad->id]) }}" title="{{ __('common.show-report') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                        <span class="fa-regular fa-eye">
                                            <h7>Show Chart</h7>
                                        </span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            @foreach($keypads as $keypad)
                var cData = JSON.parse(`<?php echo $chart_data[$keypad->id]; ?>`);
                var ctx = $("#pie-chart-<?php echo $keypad->id; ?>");
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
            @endforeach
        });
    </script>
@endsection



