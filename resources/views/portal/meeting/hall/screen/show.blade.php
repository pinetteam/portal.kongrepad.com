@extends('layout.portal.common')
@section('title', $screen->title . ' | ' . __('common.participant'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center"><span class="fa-duotone fa-display fa-fade"></span> <small>"{{ $screen->title }}"</small></h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                        <td class="text-start w-25">{{ $screen->title }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.code') }}:</th>
                        <td class="text-start w-25">{{ $screen->code }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.hall') }}:</th>
                        <td class="text-start w-25">{{ $screen->hall->title }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.type') }}:</th>
                        <td class="text-start w-25">{{ __('common.'.$screen->type) }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.description') }}:</th>
                        <td class="text-start w-25">{{ $screen->description }}</td>
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
