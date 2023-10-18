@extends('layout.portal.common')
@section('title', $survey->title .' | ' . __('common.reports'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-regular fa-square-poll-vertical fa-fade"></span> <small>"{{ $survey->title }}"</small>{{ __('common.survey') }}
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
                    <thead>
                    <tr>
                        <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span> {{ __('common.question-title') }}</th>
                        <th scope="col"><span class="fa-regular fa-vote-yea mx-1"></span>{{ __('common.vote-count') }}</th>
                        <th scope="col"><span class="fa-regular fa-circle-sort mx-1"></span>{{ __('common.sort-order') }}</th>
                        <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span>{{ __('common.status') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    @foreach($survey->questions as $question)
                        <tbody>
                            <tr>
                                <td>{{ $question->question }}</td>
                                <td>{{ $question->votes->count() }}</td>
                                <td>{{ $question->sort_order }}</td>
                                <td>
                                    @if($question->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-success btn-sm" href="{{ route("portal.survey-report.question.participants",['question_id'=>$question->id, 'survey_id'=>$survey->id]) }}" title="{{ __('common.participants') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.participants') }}">
                                            <span class="fa-regular fa-user"></span>
                                        </a>
                                        <a class="btn btn-info btn-sm" href="{{ route("portal.survey-report.question.chart",['question_id'=>$question->id, 'survey_id'=>$survey->id]) }}" title="{{ __('common.results') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.results') }} ">
                                            <span class="fa-regular fa-presentation-screen"></span>
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
@endsection

