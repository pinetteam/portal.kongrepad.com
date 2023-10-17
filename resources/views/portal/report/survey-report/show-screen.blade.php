@extends('layout.portal.common')
@section('title', $survey->title .' | ' . __('common.screen'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-regular fa-square-poll-vertical fa-fade"></span> <small>"{{ $survey->title }}"</small> {{ __('common.screen') }}
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
        <div class="card-body p-0">
            <div class="table-responsive mx-5">
                <table class="table table-dark table-striped table-bordered">
                    <tr>
                        <ol type="1">
                            @foreach($survey->questions as $question)
                                <span style="font-size: 30px;" class="m-2">
                                    <li>
                                        {{ $question->question }}
                                    </li>
                                </span>
                                <span style="font-size: 30px;" class="m-1">
                                        @foreach($question->options as $option)
                                            <div class="progress rounded-4 m-3 h-25" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-black overflow-scroll p-2" style="width: {{ $option->votes->count() }}%">
                                                   {{ $option->option }}
                                                </div>
                                            </div>
                                        @endforeach
                                </span>
                            @endforeach
                        </ol>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
