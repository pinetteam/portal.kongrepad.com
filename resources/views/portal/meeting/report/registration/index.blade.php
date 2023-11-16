@extends('layout.portal.common')
@section('title', $meeting->title . ' | ' .  __('common.registration-reports'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-chart-user fa-fade"></span> {{ __('common.registration-reports') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $participants->links() }}
                    </caption>
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.name') }}</th>
                        <th scope="col"><span class="fa-duotone fa-chart-user fa-fade mx-1"></span> {{ __('common.enrolled-at') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($participants as $participant)
                        @if($participant->enrolled == 1)
                            <tr>
                                <td>{{ $participant->full_name }}</td>
                                <td>
                                    {{ $participant->enrolled_at }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
