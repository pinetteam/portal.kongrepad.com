@extends('layout.portal.common')
@section('title', $meeting->title . ' | ' . __('common.participants'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-screen-users fa-fade"></span> <small>"{{ $meeting->title }}"</small> {{ __('common.participants') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $participants->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.name') }}</th>
                            <th scope="col"><span class="fa-regular fa-fingerprint mx-1"></span> {{ __('common.identification-number') }}</th>
                            <th scope="col"><span class="fa-regular fa-building-columns mx-1"></span> {{ __('common.organisation') }}</th>
                            <th scope="col"><span class="fa-regular fa-envelope mx-1"></span> {{ __('common.email') }}</th>
                            <th scope="col"><span class="fa-regular fa-mobile-screen mx-1"></span> {{ __('common.phone') }}</th>
                            <th scope="col"><span class="fa-regular fa-right-to-bracket mx-1"></span> {{ __('common.last-login') }}</th>
                            <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}</th>
                            <th scope="col"><span class="fa-regular fa-square-check mx-1"></span> {{ __('common.enrollment') }}</th>
                            <th scope="col"><span class="fa-regular fa-handshake mx-1"></span> {{ __('common.gdpr-consent') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $participant)
                            <tr>
                                <td>
                                    @if($participant->activity_status)
                                        <div class="spinner-grow spinner-grow-sm text-success" role="status"></div>
                                    @else
                                        <div class="spinner-border spinner-border-sm text-danger" role="status"></div>
                                    @endif
                                    {{ $participant->full_name }}
                                </td>
                                <td>{{ $participant->identification_number_show }}</td>
                                <td>{{ $participant->organisation_show }}</td>
                                <td>{{ $participant->email }}</td>
                                <td>{{ $participant->full_phone }}</td>
                                <td>{{ $participant->last_login }}</td>
                                <td>{{ __('common.'.$participant->type) }}</td>
                                <td>
                                    @if($participant->enrolled)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td>
                                    @if($participant->gdpr_consent)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td>
                                    @if($participant->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show-qr-code') }}">
                                            <button class="btn btn-outline-success btn-sm" title="{{ __('common.show-qr-code') }}" data-bs-toggle="modal" data-bs-target="#show-qr-code-modal" data-resource="{{ route('portal.meeting.participant.qr-code', ['meeting' => $meeting->id, 'participant' => $participant->id]) }}" data-id="{{ $participant->id }}">
                                                <span class="fa-regular fa-qrcode"></span>
                                            </button>
                                        </div>
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.participant.show', ['meeting' => $meeting->id, 'participant' => $participant->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#participant-edit-modal" data-route="{{ route('portal.meeting.participant.update', ['meeting' => $meeting->id, 'participant' => $participant->id]) }}" data-resource="{{ route('portal.meeting.participant.edit', ['meeting' => $meeting->id, 'participant' => $participant->id]) }}" data-id="{{ $participant->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#participant-delete-modal" data-route="{{ route('portal.meeting.participant.destroy', ['meeting' => $meeting, 'participant' => $participant->id]) }}" data-record="{{ $participant->full_name }}">
                                                <span class="fa-regular fa-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#participant-create-modal" data-route="{{ route('portal.meeting.participant.store', ['meeting' => $meeting->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-participant') }}
            </button>
        </div>
    </div>
    <x-common.popup.show name="show-qr-code" title="{{ __('common.show-qr-code') }}" />
    <x-crud.form.common.create name="participant" >
        @section('participant-create-form')
            <x-input.hidden method="c" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="c" name="title" title="title" icon="input-text" />
            <x-input.text method="c" name="first_name" title="first-name" icon="id-card" />
            <x-input.text method="c" name="last_name" title="last-name" icon="id-card" />
            <x-input.text method="c" name="identification_number" title="identification-number" icon="fingerprint" />
            <x-input.text method="c" name="organisation" title="organisation" icon="building-columns" />
            <x-input.email method="c" name="email" title="email" icon="envelope" />
            <x-input.select method="c" name="phone_country_id" title="phone-country" :options="$phone_countries" option_value="id" option_name="name" icon="flag" />
            <x-input.text method="c" name="phone" title="phone" icon="mobile-screen" />
            <x-input.text method="c" name="password" title="password" icon="lock" />
            <x-input.select method="c" name="type" title="type" :options="$types" option_value="value" option_name="title" icon="person-military-pointing" />
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.create>
    <x-crud.form.common.delete name="participant" />
    <x-crud.form.common.edit name="participant" >
        @section('participant-edit-form')
            <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
            <x-input.text method="e" name="title" title="title" icon="input-text" />
            <x-input.text method="e" name="first_name" title="first-name" icon="id-card" />
            <x-input.text method="e" name="last_name" title="last-name" icon="id-card" />
            <x-input.text method="e" name="identification_number" title="identification-number" icon="fingerprint" />
            <x-input.text method="e" name="organisation" title="organisation" icon="building-columns" />
            <x-input.email method="e" name="email" title="email" icon="envelope" />
            <x-input.select method="e" name="phone_country_id" title="phone-country" :options="$phone_countries" option_value="id" option_name="name" icon="flag" />
            <x-input.text method="e" name="phone" title="phone" icon="mobile-screen" />
            <x-input.text method="e" name="password" title="password" icon="lock" />
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
        @endsection
    </x-crud.form.common.edit>
@endsection
