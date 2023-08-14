@extends('layout.portal.common')
@section('title', $survey->title .' | ' . __('common.reports'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-regular fa-square-poll-vertical fa-fade"></span> <small>"{{$survey->title }}"</small>{{ __('common.survey') }}
            </h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.survey') }}:</th>
                        <td class="text-start w-25">
                            @if($survey->status)
                                <i style="color:green" class="fa-regular fa-toggle-on"></i>
                            @else
                                <i style="color:red" class="fa-regular fa-toggle-off"></i>
                            @endif
                            {{ $survey->title }}
                        </td>
                        <th scope="row" class="text-end w-25">{{ __('common.description') }}:</th>
                        <td class="text-start w-25">{{ $survey->description }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.start-at') }}:</th>
                        <td class="text-start w-25">{{ $survey->start_at }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.finish-at') }}:</th>
                        <td class="text-start w-25">{{ $survey->finish_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.question-count') }}:</th>
                        <td class="text-start w-25">{{ $survey->questions->count() }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.on_vote') }}:</th>
                        <td class="text-start w-25">
                            @if($survey->on_vote)
                                <i style="color:green" class="fa-regular fa-toggle-on"></i>
                            @else
                                <i style="color:red" class="fa-regular fa-toggle-off"></i>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-option fa-fade"></span> {{ __('common.survey-reports') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="w-50"><span class="fa-regular fa-circle-question fa-fade mx1"></span> {{ __('common.question') }}</th>
                        <th scope="col"><span class="fa-regular fa-chart-pie fa-fade mx1"></span> {{ __('common.report') }}</th>
                    </tr>
                    </thead>
                    @foreach($questions as $question)
                        <tbody>
                        <tr>
                            <th scope="col"></th>
                            <td>
                                <div class="table-responsive mt-5">
                                    <table class="table table-dark table-striped table-hover">
                                        <tbody>
                                        <tr>
                                            <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span> {{ __('common.question-title') }}</th>
                                            <td>{{ $question->question }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col"><span class="fa-regular fa-circle-sort mx-1"></span> {{ __('common.sort-order') }}</th>
                                            <td>{{ $question->sort_order }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                                            <td>
                                                @if($question->status)
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
                                        <canvas id="pie-chart-{{ $question->id }}"></canvas>
                                    </div>
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
            @foreach($questions as $question)
            var cData = JSON.parse(`<?php echo $chart_data[$question->id]; ?>`);
            var ctx = $("#pie-chart-<?php echo $question->id; ?>");
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

