@extends('layout.portal.meeting-detail')
@section('title', $participant->fullname . ' | '. $survey->title . ' | ' . __('common.votes'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $survey->meeting->id) }}" class="text-decoration-none">{{ $survey->meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.participant.index', ['meeting' => $survey->meeting->id]) }}" class="text-decoration-none">{{ __('common.participants') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.participant.show', ['meeting' => $survey->meeting->id, 'participant' => $participant->id]) }}" class="text-decoration-none">{{ $participant->fullname }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $survey->title }}</li>
@endsection
@section('meeting_content')
    <div class="card bg-kongre-secondary">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-regular fa-square-poll-vertical fa-fade"></span> <small>"{{ $survey->title }}"</small> {{ __('common.survey') }}
            </h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.survey') }}:</th>
                        <td class="text-start w-25">
                            @if($survey->status)
                                <i style="color:var(--kongre-success)" class="fa-regular fa-toggle-on"></i>
                            @else
                                <i style="color:var(--kongre-danger)" class="fa-regular fa-toggle-off"></i>
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
    <div class="card bg-kongre-secondary">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-option fa-fade"></span> <small>"{{ $participant->fullname }}"</small> {{ __('common.votes') }}</h1>
        </div>
        <div class="card-body p-0">
            <ol class="list-group list-group-numbered">
                @foreach($survey_votes as $vote)
                    <li class="list-group-item bg-dark border-0 text-white fw-bold">
                        {{ $vote->question->title }}
                        <ol class="list-group list-group-numbered list-group">
                            @foreach($vote->question->options as $option)
                                @if($vote->option == $option)
                                    <li class="list-group-item list-group-item-success text-dark border-dark-subtle">{{$option->option}}</li>
                                @elseif($vote->option != $option)
                                    <li class="list-group-item bg-dark text-white border-dark-subtle">{{$option->option}}</li>
                                @endif
                            @endforeach
                        </ol>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
@endsection
