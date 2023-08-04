@extends('layout.portal.common')
@section('title', __('common.meeting').' | '.$meeting->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-bee fa-fade"></span> {{ __('common.meetings') }}</h1>
        </div>
        <div class="card-body p-0">
            İçerik burada
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a class="btn btn-success btn-lg w-100" href="{{ route('portal.meeting-hall.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                <span class="fa-duotone fa-hotel"></span> {{ __('common.meeting-halls') }}
            </a>
            <a class="btn btn-success btn-lg w-100" href="{{ route('portal.survey.index', ['meeting' => $meeting->id]) }}" title="{{ __('common.show') }}">
                <span class="fa-duotone fa-hotel"></span> {{ __('common.surveys') }}
            </a>
        </div>
    </div>
@endsection
