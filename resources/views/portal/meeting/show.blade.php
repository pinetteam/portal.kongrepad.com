@extends('layout.portal.common')
@section('title', $meeting->title .' | ' . __('common.meeting'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-bee fa-fade"></span> <small>"{{ $meeting->title }}"</small> {{ __('common.meeting') }}</h1>
        </div>
        <div class="card-body p-0">
            İçerik burada
        </div>
        <div class="card-footer">
            <a class="btn btn-success btn-lg w-100" href="{{ route('portal.meeting.document.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                <span class="fa-duotone fa-presentation-screen"></span> {{ __('common.documents') }}
            </a>
            <hr />
            <a class="btn btn-success btn-lg w-100" href="{{ route('portal.meeting.participant.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                <span class="fa-duotone fa-screen-users"></span> {{ __('common.participants') }}
            </a>
            <hr />
            <a class="btn btn-success btn-lg w-100" href="{{ route('portal.meeting.hall.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                <span class="fa-duotone fa-hotel"></span> {{ __('common.halls') }}
            </a>
            <hr />
            <a class="btn btn-success btn-lg w-100" href="{{ route('portal.meeting.survey.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                <span class="fa-duotone fa-hotel"></span> {{ __('common.surveys') }}
            </a>
        </div>
    </div>
@endsection
