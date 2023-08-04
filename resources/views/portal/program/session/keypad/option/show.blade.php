@extends('layout.portal.common')
@section('title', __('common.option').' | '.$option->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.option').' | '.$option->title }}</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.option') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                           <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}:</b> {{ $option->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-tablet mx-1"></span> {{ __('common.keypad') }}:</b> {{ $option->keypad->title }}</li>
                        </ul>
                    </div>
                </div>

                <div class="card text-bg-dark mt-2">
                    <div class="card-header">
                        <h1 class="m-0 text-center">{{ __('common.votes') }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col"><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.name') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($votes as $vote)
                                    <tr>
                                        <td>{{ $vote->owner->full_name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
