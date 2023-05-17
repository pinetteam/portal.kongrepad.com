@extends('layout.portal.common')
@section('title', __('common.keypad').' | '.$keypad->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.keypad').' | '.$keypad->title }}</h1>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-sm-2 flex-shrink-0 g-2">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.keypad') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                           <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-code-simple mx-1"></span> {{ __('common.code') }}:</b> {{ $keypad->code }}</li>
                           <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.title') }}:</b> {{ $keypad->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-newspaper mx-1"></span> {{ __('common.session') }}:</b> {{ $keypad->session->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.voting-started-at') }}:</b> {{ $keypad->voting_started_at }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.voting-finished-at') }}:</b> {{ $keypad->voting_finished_at }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b>
                                @if($keypad->status)
                                    {{ __('common.active') }}
                                @else
                                    {{ __('common.passive') }}
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.options') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-striped table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.title') }}</th>
                                    <th scope="col" class="text-end"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($options as $option)
                                        <tr>
                                            <td>{{ $option->title }}</td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                                    <a class="btn btn-info btn-sm" href="{{ route('portal.option.show', $option->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                                        <span class="fa-regular fa-eye"></span>
                                                    </a>
                                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                                        <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#option-edit-modal" data-route="{{ route('portal.option.update', $option->id) }}" data-resource="{{ route('portal.option.edit', $option->id) }}" data-id="{{ $option->id }}">
                                                            <span class="fa-regular fa-pen-to-square"></span>
                                                        </button>
                                                    </div>
                                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                                        <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#option-delete-modal" data-route="{{ route('portal.option.destroy', $option->id) }}" data-record="{{ $option->title }}">
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
                        <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#option-create-modal" data-route="{{ route('portal.option.store') }}">
                            <i class="fa-solid fa-plus"></i> {{ __('common.add-new-option') }}
                        </button>
                    </div>
                    <x-crud.form.common.create name="option">
                        @section('option-create-form')
                            <x-input.hidden method="c" name="keypad_id" :value="$keypad->id" />
                            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort" />
                            <x-input.text method="c" name="title" title="title" icon="input-text" />
                        @endsection
                    </x-crud.form.common.create>
                    <x-crud.form.common.delete name="option" />
                    <x-crud.form.common.edit name="option">
                        @section('option-edit-form')
                            <x-input.hidden method="e" name="keypad_id" :value="$keypad->id" />
                            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort" />
                            <x-input.text method="e" name="title" title="title" icon="input-text" />
                        @endsection
                    </x-crud.form.common.edit>
                </div>
            </div>
        </div>
    </div>
    <div class="card text-bg-dark mt-2">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.votes') }}</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{__('common.total-vote')}}
                    </caption>
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-person-chalkboard mx-1"></span> {{ __('common.owner') }}</th>
                        <th scope="col"><span class="fa-regular fa-speakation-screen mx-1"></span> {{ __('common.option') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($votes as $vote)
                            <tr>
                                <td>{{ $vote->owner->full_name }}</td>
                                <td>{{ $vote->option->title }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.keypad-vote.show', $vote->id) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit') }}">
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#vote-edit-modal" data-route="{{ route('portal.keypad-vote.update', $vote->id) }}" data-resource="{{ route('portal.keypad-vote.edit', $vote->id) }}" data-id="{{ $vote->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#vote-delete-modal" data-route="{{ route('portal.keypad-vote.destroy', $vote->id) }}" data-record="{{ $vote->title }}">
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
        <x-crud.form.common.delete name="vote" />
    </div>
@endsection
