@extends('layout.portal.common')
@section('title', $program->title)
@section('breadcrumb')
    <li class="breadcrumb-item text-white"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.show', $program->hall->meeting->id) }}" class="text-decoration-none">{{ $program->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $program->hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $program->hall->meeting->id, 'hall' => $program->hall->id]) }}" class="text-decoration-none">{{ $program->hall->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.program.index', ['meeting' => $program->hall->meeting->id, 'hall' => $program->hall->id]) }}" class="text-decoration-none">{{ __('common.programs') }}</a></li>
    <li class="breadcrumb-item active text-white" aria-current="page">{{ $program->title }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-newspaper fa-fade"></span> <small>"{{ $program->title }}"</small> </h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.logo') }}:</th>
                        <td class="text-start w-25">
                            @if(isset($program->logo_name))
                                <img src="{{ asset('storage/program-logos/' . $program->logo_name . '.' . $program->logo_extension) }}" alt="{{ $program->title }}"
                                     class="img-thumbnail" style="height:36px;"/>
                            @else
                                <i class="text-info">{{ __('common.unspecified') }}</i>
                            @endif
                        </td>
                        <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                        <td class="text-start w-25">{{ $program->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.code') }}:</th>
                        <td class="text-start w-25">{{ $program->code }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.hall') }}:</th>
                        <td class="text-start w-25">{{ $program->hall->title}}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.start-at') }}:</th>
                        <td class="text-start w-25">{{ $program->start_at}}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.finish-at') }}:</th>
                        <td class="text-start w-25">{{ $program->finish_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.type') }}:</th>
                        <td class="text-start w-25">{{ __('common.'.$program->type) }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.status') }}:</th>
                        <td class="text-start w-25">
                            @if($program->status)
                                {{ __('common.active') }}
                            @else
                                {{ __('common.passive') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                        <td class="text-start w-25">{{ $program->created_by_name }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                        <td class="text-start w-25">{{ $program->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
