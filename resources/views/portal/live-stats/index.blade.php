@extends('layout.portal.common')
@section('title', __('common.live-stats'))
@section('body')
    <div class="card bg-dark">
        <div class="card-header bg-dark text-white border-dark">
            <h1 class="m-0 text-center">{{ __('common.live-stats') }}</h1>
        </div>
        <div class="card-body mt-2">
            <div class="container text-center">
                <div class="row justify-content-center">
                    @foreach($meetings as $meeting)
                        <div class="row w-100">
                            <h4 class="pb-3 text-white text-center">{{ __('common.live-stats') }} | {{ $meeting->title }}</h4>
                        </div>
                        <div class="col col-sm-12 col-md-6 border-2">
                            <div class="card bg-dark border-dark">
                                <div class="card-block">
                                    <div class="container text-center">
                                        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-xs-1 g-2">
                                            <div class="col border-2">
                                                <span>
                                                    <div class="card-body p-0 shadow">
                                                        <div class="table-responsive">
                                                            <table class="table table-dark table-borderless">
                                                                <tbody>
                                                                <tr>
                                                                    <td class="text-center">{{ __('common.enrolled-participants') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <h4 class="text-white">{{ $meeting->participants->where('enrolled', 1)->count() }} / {{ $meeting->participants->count() }}
                                                                        </h4>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="col border-2">
                                                <span>
                                                    <div class="card-body p-0 shadow">
                                                        <div class="table-responsive">
                                                            <table class="table table-dark table-borderless">
                                                                <tbody>
                                                                <tr>
                                                                    <td class="text-center">{{ __('common.logged-in-participants') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <h4 class="text-white">{{ $meeting->participants->where('gdpr_consent', 1)->count() }} / {{ $meeting->participants->count() }}
                                                                        </h4>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="col border-2">
                                                <span>
                                                    <div class="card-body p-0 shadow">
                                                        <div class="table-responsive">
                                                            <table class="table table-dark table-borderless">
                                                                <tbody>
                                                                <tr>
                                                                    <td class="text-center">{{ __('common.active-participants') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <h4> {{ $meeting->participantLogs->where('created_at', '>=', \Carbon\Carbon::now()->subMinute())->groupBy('participant_id')->count() }}</h4>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="text-bg-primary w-100 my-2">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
