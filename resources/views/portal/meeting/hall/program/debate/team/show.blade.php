@extends('layout.portal.common')
@section('title', $team->title . ' | ' . __('common.team'))
@section('breadcrumb')
    <li class="breadcrumb-item text-white"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.show', $team->debate->program->hall->meeting->id) }}" class="text-decoration-none">{{ $team->debate->program->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $team->debate->program->hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $team->debate->program->hall->meeting->id, 'hall' => $team->debate->program->hall->id]) }}" class="text-decoration-none">{{ $team->debate->program->hall->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.program.index', ['meeting' => $team->debate->program->hall->meeting->id, 'hall' => $team->debate->program->hall->id]) }}" class="text-decoration-none">{{ __('common.programs') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.program.show', ['meeting' => $team->debate->program->hall->meeting->id, 'hall' => $team->debate->program->hall->id, 'program' => $team->debate->program->id]) }}" class="text-decoration-none">{{ $team->debate->program->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.program.debate.show', ['meeting' => $team->debate->program->hall->meeting->id, 'hall' => $team->debate->program->hall->id, 'program' => $team->debate->program->id, 'debate' => $team->debate->id]) }}" class="text-decoration-none">{{ $team->debate->title }}</a></li>
    <li class="breadcrumb-item active text-white" aria-current="page">{{ $team->title }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{'"' . $team->title . '"' . __('common.team')}}</h1>
        </div>
        <div class="card-body">
            <div class="row flex-shrink-0 g-2">
                <div class="table-responsive">
                    <table class="table table-dark table-striped-columns table-bordered">
                        <tr>
                            <th scope="row" class="text-end w-25">{{ __('common.logo') }}:</th>
                            <td class="text-start w-25">
                                @if(isset($team->logo_name))
                                    <img src="{{ asset('storage/team-logos/' . $team->logo_name . '.' . $team->logo_extension) }}" alt="{{ $team->title }}"
                                         class="img-thumbnail" style="height:36px;"/>
                                @else
                                    <i class="text-info">{{ __('common.unspecified') }}</i>
                                @endif
                            </td>
                            <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                            <td class="text-start w-25">{{ $team->title }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-end w-25">{{ __('common.code') }}:</th>
                            <td class="text-start w-25">{{ $team->code }}</td>
                            <th scope="row" class="text-end w-25">{{ __('common.debate') }}:</th>
                            <td class="text-start w-25">{{ $team->debate->title}}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                            <td class="text-start w-25">{{ $team->created_by_name }}</td>
                            <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                            <td class="text-start w-25">{{ $team->created_at }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
