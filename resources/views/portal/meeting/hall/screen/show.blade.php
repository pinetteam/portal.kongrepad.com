@extends('layout.portal.common')
@section('title', $screen->title . ' | ' . __('common.participant'))
@section('breadcrumb')
    <li class="breadcrumb-item text-white"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.show', $screen->hall->meeting->id) }}" class="text-decoration-none">{{ $screen->hall->meeting->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.index', ['meeting' => $screen->hall->meeting->id]) }}" class="text-decoration-none">{{ __('common.halls') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.show', ['meeting' => $screen->hall->meeting->id, 'hall' => $screen->hall->id]) }}" class="text-decoration-none">{{ $screen->hall->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.hall.screen.index', ['meeting' => $screen->hall->meeting->id, 'hall' => $screen->hall->id]) }}" class="text-decoration-none">{{ __('common.screens') }}</a></li>
    <li class="breadcrumb-item active text-white" aria-current="page">{{ $screen->title }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center"><span class="fa-duotone fa-presentation-screen fa-fade"></span> <small>"{{ $screen->title }}"</small></h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                        <td class="text-start w-25">{{ $screen->title }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.code') }}:</th>
                        <td class="text-start w-25">{{ $screen->code }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.description') }}:</th>
                        <td class="text-start w-25">{{ $screen->description }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.type') }}:</th>
                        <td class="text-start w-25">{{ __('common.'.$screen->type) }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.font') }}:</th>
                        <td style="font-family: '{{ $screen->font }}'" class="text-start w-25">{{ $screen->font }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.font-size') }}:</th>
                        <td class="text-start w-25">{{ $screen->font_size }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.font-color') }}:</th>
                        <td><i style="color:{{$screen->font_color}}" class="fa-solid fa-square fa-xl"></i></td>
                        <th scope="row" class="text-end w-25">{{ __('common.status') }}:</th>
                        <td class="text-start w-25">
                            @if($screen->status)
                                {{ __('common.active') }}
                            @else
                                {{ __('common.passive') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                        <td class="text-start w-25">{{ $screen->created_by_name }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                        <td class="text-start w-25">{{ $screen->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
