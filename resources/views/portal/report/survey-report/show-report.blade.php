@extends('layout.portal.common')
@section('title', $survey->title .' | ' . __('common.report'))
@section('body')
    <div class="card text-bg-dark" xmlns="http://www.w3.org/1999/html">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-regular fa-square-poll-vertical fa-fade"></span> <small>"{{ $survey->title }}"</small> {{ __('common.report') }}
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
                </table>
            </div>
        </div>
    </div>
    <div class="card text-bg-dark">
        <div class="card-body">
            <ol class="list-group list-group-numbered">
                @foreach($survey->questions as $question)
                    <li class="list-group-item d-flex justify-content-between align-items-start bg-dark border-dark-subtle text-white">
                        <div class="ms-2 w-100 overflow-hidden">
                            <div class="fw-bold">{{ $question->question }}</div>
                            <hr />
                            @foreach($question->options as $option)
                                @if($question->votes->count() != 0)
                                    <div class="progress mt-2 h-25" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-black text-center p-2 overflow-visible" style="width: {{ $option->votes->count() / $question->votes->count()*100 }}%">
                                            {{ $option->option }} ({{$option->votes->count() / $question->votes->count()*100}}%)
                                        </div>
                                    </div>
                                @elseif($question->votes->count() == 0)
                                    <div class="progress mt-2 h-25" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-black text-center p-2 overflow-visible" style="width: {{ $option->votes->count()}}%">
                                            {{ $option->option }} ({{ $option->votes->count() }}%)
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
@endsection
