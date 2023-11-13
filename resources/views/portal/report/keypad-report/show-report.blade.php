@extends('layout.portal.common')
@section('title', $keypad->question . ' | ' . __('common.report'))
@section('body')
    <div class="card text-bg-dark" xmlns="http://www.w3.org/1999/html">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-regular fa-square-poll-vertical fa-fade"></span> <small>"{{ $keypad->title }}"</small> {{ __('common.report') }}
            </h1>
        </div>
    </div>
    <div class="card text-bg-dark">
        <div class="card-body">
            <div class="ms-2 w-100 overflow-hidden">
                <div class="fw-bold text-center">{{ $keypad->keypad }}</div>
                <hr/>
                @foreach($keypad->options as $option)
                    @if($keypad->votes->count() != 0)
                        <div class="progress mt-2 h-25 bg-dark" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info text-white text-center p-2 overflow-visible" style="width: {{ $option->votes->count() / $keypad->votes->count()*100 }}%">
                                {{ $option->option }} ({{round($option->votes->count() / $keypad->votes->count()*100,2)}}%)
                            </div>
                        </div>
                    @elseif($keypad->votes->count() == 0)
                        <div class="progress mt-2 h-25 bg-dark" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info text-white text-center p-2 overflow-visible" style="width: {{ $option->votes->count()}}%">
                                {{ $option->option }} ({{ $option->votes->count() }}%)
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
