@extends('layout.portal.common')
@section('title', __('common.live-stats'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.dashboard.index") }}" class="text-decoration-none text-white">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item active text-white text-decoration-underline" aria-current="page">{{ __('common.live-stats') }}</li>
@endsection
@section('body')
    @foreach($meetings as $meeting)
        <div class="card text-bg-dark">
            <div class="card-header">
                <h1 class="m-0 text-center"><span class="fa-duotone fa-screen-users fa-fade"></span> <small>"{{ $meeting->title }}"</small> {{ __('common.live-stats') }}</h1>
            </div>
            <div class="card-body text-center">
                <h1 class="fw-bold text-white">{{ __('common.enrolled-participants') }}: <span class="badge text-bg-success">{{ $meeting->participants->where('enrolled', 1)->count() }} / {{ $meeting->participants->count() }}</span></h1>
                <h1 class="fw-bold text-white">{{ __('common.logged-in-participants') }}: <span class="badge text-bg-success">{{ $personal_access_tokens->count() }} / {{ $meeting->participants->count() }}</span></h1>
                <h1 class="fw-bold text-white">{{ __('common.online-participants') }}: <span class="badge text-bg-success">{{ $meeting->participantLogs->where('created_at', '>=', \Carbon\Carbon::now()->subMinutes(15))->groupBy('participant_id')->count() }} / {{ $meeting->participants->count() }}</span></h1>
            </div>
            <div class="card-footer p-0">
                <h2 class="h3 text-center mt-2"><span class="fa-duotone fa-screen-users fa-fade"></span> {{ __('common.logged-in-participants') }}</h2>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col"><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.name') }}</th>
                                <th scope="col"><span class="fa-regular fa-envelope mx-1"></span> {{ __('common.email') }}</th>
                                <th scope="col"><span class="fa-regular fa-right-to-bracket mx-1"></span> {{ __('common.last-login') }}</th>
                                <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}</th>
                                <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                                <th scope="col" class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personal_access_tokens as $personal_access_token)
                                <tr>
                                    <td>
                                        {{ $personal_access_token->participant->last_name }}, {{ $personal_access_token->participant->first_name }}
                                    </td>
                                    <td>{{ $personal_access_token->participant->email }}</td>
                                    <td>{{ $personal_access_token->participant->last_user_activity }}</td>
                                    <td>{{ __('common.'.$personal_access_token->participant->type) }}</td>
                                    <td>
                                        @if($personal_access_token->participant->status)
                                            <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                        @else
                                            <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                            <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.participant.show', ['meeting' => $meeting->id, 'participant' => $personal_access_token->participant->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                <span class="fa-regular fa-eye"></span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@endsection
