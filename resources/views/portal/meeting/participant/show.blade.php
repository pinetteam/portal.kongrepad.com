@extends('layout.portal.common')
@section('title', __('common.participant').' | '.$participant->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center"><span class="fa-duotone fa-screen-users fa-fade"></span> <small>"{{ $participant->full_name }}"</small> {{ __('common.participant') }}</h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                        <td class="text-start w-25">{{ $participant->title }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.name') }}:</th>
                        <td class="text-start w-25">
                            @if($participant->activity_status)
                                <i style="color:green" class="fa-regular fa-toggle-on"></i>
                            @else
                                <i style="color:red" class="fa-regular fa-toggle-off"></i>
                            @endif
                            {{ $participant->full_name }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.meeting') }}:</th>
                        <td class="text-start w-25">{{ $participant->meeting->title }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.identification-number') }}:</th>
                        <td class="text-start w-25">{{ $participant->identification_number }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.organisation') }}:</th>
                        <td class="text-start w-25">{{ $participant->organisation }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.email') }}:</th>
                        <td class="text-start w-25">{{ $participant->email }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.phone') }}:</th>
                        <td class="text-start w-25">{{ $participant->full_phone }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.status') }}:</th>
                        <td class="text-start w-25">
                            @if($participant->status)
                                {{ __('common.active') }}
                            @else
                                {{ __('common.passive') }}
                            @endif</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                        <td class="text-start w-25">#</td>
                        <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                        <td class="text-start w-25">{{ $participant->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
