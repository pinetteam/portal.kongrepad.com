@extends('layout.portal.common')
@section('title', __('common.question-reports'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-question"></span> {{ __('common.question-reports') }}</h1>
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
                        <th scope="col"><span class="fa-regular fa-question mx-1"></span> {{ __('common.questions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($participants as $participant)
                        <tr>
                            <td>{{ $participant->full_name }}</td>
                            <td>{{ $participant->sessionQuestions()->where([['is_hidden_name', 0], ['selected_for_show', 1]])->count() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
