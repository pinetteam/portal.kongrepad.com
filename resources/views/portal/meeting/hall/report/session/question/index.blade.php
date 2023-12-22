@extends('layout.portal.common')
@section('title', $session->title . ' | ' .  __('common.question-reports'))
@section('breadcrumb')
    <li class="breadcrumb-item text-white"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.show', $session->program->hall->meeting->id) }}" class="text-decoration-none">{{ $session->program->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $session->program->hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id]) }}" class="text-decoration-none">{{ $session->program->hall->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.report.session.index', ['meeting' => $session->program->hall->meeting->id, 'hall' => $session->program->hall->id]) }}" class="text-decoration-none">{{ __('common.session-reports') }}</a></li>
    <li class="breadcrumb-item active text-white" aria-current="page">{{ $session->title . ' ' . __('common.question-reports') }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-question"></span> <small>{{ $session->title }}</small> {{ __('common.question-reports') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $questions->links() }}
                    </caption>
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.questioner') }}</th>
                        <th scope="col"><span class="fa-regular fa-question mx-1"></span> {{ __('common.question') }}</th>
                        <th scope="col"><span class="fa-regular fa-user-secret mx-1"></span> {{ __('common.is-hidden-name') }}</th>
                        <th scope="col"><span class="fa-regular fa-check mx-1"></span> {{ __('common.is-selected') }}</th>
                        <th scope="col"><span class="fa-regular fa-multiply mx-1"></span> {{ __('common.is-deselected') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td>{{ $question->questioner->full_name }}</td>
                            <td>{{ $question->question }}</td>
                            <td>
                                @if($question->is_hidden_name)
                                    <i style="color:green"
                                       class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                @endif
                            </td>
                            <td>
                                @if($question->logs()->where('action', 'select')->count() > 0)
                                    <i style="color:green"
                                       class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                @endif
                            </td>
                            <td>
                                @if($question->logs()->where('action', 'deselect')->count() > 0)
                                    <i style="color:green"
                                       class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
