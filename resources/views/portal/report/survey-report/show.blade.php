@extends('layout.portal.common')
@section('title', $survey->title .' | ' . __('common.survey'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-regular fa-square-poll-vertical fa-fade"></span> <small class="p-2">"{{$survey->title }}
                    "</small>{{ __('common.survey') }}
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

    <div class="card text-bg-dark mt-2">
        <div class="card-header">
            <h2 class="text-center">
                <span class="fa-regular fa-circle-question fa-fade p-2"> </span>{{ __('common.questions') }}
            </h2>
        </div>
        <div class="card-body p-0">
            <div class="card text-bg-dark mt-2">
                <table class=" caption-top table table-dark table-striped-columns table-bordered ">
                    <tbody>
                    <tr>
                        <td>
                            <table
                                class=" caption-top table table-dark table-striped-columns table-bordered m-2">
                                <tbody>
                                <tr>

                                        <table
                                            class=" caption-top table table-dark table-striped-columns table-bordered ">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col "><span
                                                        class="fa-regular fa-messages-question mx-1 "></span> {{ __('common.question-title') }}
                                                </th>
                                                <th scope="col"><span
                                                        class="fa-regular fa-circle-sort mx-1 "></span> {{ __('common.sort-order') }}
                                                </th>
                                                <th scope="col"><span
                                                        class="fa-regular fa-toggle-large-on mx-1  "></span> {{ __('common.option-count') }}
                                                </th>
                                                <th scope="col"><span
                                                        class="fa-regular fa-toggle-large-on mx-1 "> </span> {{ __('common.status') }}
                                                </th>
                                                <th scope="col" class="text-end "></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($questions as $question)
                                                <tr>
                                                    <td>{{$question->question}}</td>
                                                    <td>{{$question->sort_order}}</td>
                                                    <td>{{$question->options->count()}}</td>
                                                    <td>
                                                        @if($question->status)
                                                            <i style="color:green"
                                                               class="fa-regular fa-toggle-on fa-xg"></i>
                                                        @else
                                                            <i style="color:red"
                                                               class="fa-regular fa-toggle-off fa-xg"></i>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="btn-group" role="group"
                                                             aria-label="{{ __('common.processes') }}">
                                                                <a class="btn btn-info btn-sm" href="{{ route("portal.chart.index",['survey_id'=>$survey->id, 'question_id'=>$question->id ]) }}" title="{{ __('common.show-report') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                                    <span class="fa-regular fa-eye"></span>
                                                                </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection

