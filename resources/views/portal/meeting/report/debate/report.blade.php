@extends('layout.portal.common')
@section('title', $debate->title . ' | ' . __('common.report'))
@section('breadcrumb')
    <li class="breadcrumb-item text-white"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.show', $debate->program->hall->meeting->id) }}" class="text-decoration-none">{{ $debate->program->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.report.debate.index', ['meeting' => $debate->program->hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.debate-reports') }}</a></li>
    <li class="breadcrumb-item active text-white" aria-current="page">{{ $debate->title }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark" xmlns="http://www.w3.org/1999/html">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-regular fa-square-poll-vertical fa-fade"></span> <small>"{{ $debate->title }}"</small> {{ __('common.report') }}
            </h1>
        </div>
    </div>
    <div class="card text-bg-dark">
        <div class="card-body">
            <div class="ms-2 w-100 overflow-hidden">
                <div class="fw-bold text-center">{{ $debate->title }}</div>
                <hr />
                @foreach($teams as $team)
                    @if($debate->votes->count() != 0)
                        <div class="progress mt-2 h-25" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-black text-center p-2 overflow-visible" style="width: {{ $team->votes->count() / $debate->votes->count()*100 }}%">
                                {{ $team->title }} ({{round($team->votes->count() / $debate->votes->count()*100,2)}}%)
                            </div>
                        </div>
                    @elseif($debate->votes->count() == 0)
                        <div class="progress mt-2 h-25" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-black text-center p-2 overflow-visible" style="width: {{ $team->votes->count()}}%">
                                {{ $team->title }} ({{ $team->votes->count() }}%)
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
