@extends('layout.portal.common')
@section('title', __('common.program').' | '.$program->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center"><span class="fa-duotone fa-hundred-points fa-fade"></span> <small>"{{ $program->title }}"</small> {{ __('common.program') }}</h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.logo') }}:</th>
                        <td class="text-start w-25">
                            @if($program->logo)
                            <img src="{{ $program->logo }}" alt="{{ $program->title }}" class="img-thumbnail img-fluid" />
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
                        <td class="text-start w-25">{{ $program->created_by }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                        <td class="text-start w-25">{{ $program->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
