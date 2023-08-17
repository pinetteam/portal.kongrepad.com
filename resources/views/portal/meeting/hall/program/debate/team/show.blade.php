@extends('layout.portal.common')
@section('title', $team->title . ' | ' . __('common.team'))
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
                                @if($team->logo)
                                    <img src="{{ $team->logo }}" alt="{{ $team->title }}" class="img-thumbnail img-fluid" />
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
