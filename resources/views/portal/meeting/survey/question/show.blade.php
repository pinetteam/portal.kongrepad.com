@extends('layout.portal.common')
@section('title', $question->question . ' | ' . __('common.question'))
@section('breadcrumb')
    <li class="breadcrumb-item text-white"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none text-white">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.show', $question->survey->meeting->id) }}" class="text-decoration-none">{{ $question->survey->meeting->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.survey.index', ['meeting' => $question->survey->meeting->id]) }}" class="text-decoration-none text-white">{{ __('common.surveys') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.survey.show', ['meeting' => $question->survey->meeting->id, $question->survey->id, ]) }}" class="text-decoration-none text-white">{{ $question->survey->title }}</a></li>
    <li class="breadcrumb-item active text-white text-decoration-underline" aria-current="page">{{ $question->question }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-regular fa-square-poll-vertical fa-fade"></span>
                @if($question->status)
                    <i style="color:green" class="fa-regular fa-toggle-on"></i>
                @else
                    <i style="color:red" class="fa-regular fa-toggle-off"></i>
                @endif
                <small>"{{ $question->question }}"</small>
            </h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                        <td class="text-start w-25">{{ $question->created_by_name }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                        <td class="text-start w-25">{{ $question->created_at }}</td>
                    </tr>
                </table>
            </div>
            <div class="card text-bg-dark mt-2">
                <div class="card-header">
                    <h2 class="m-0 text-center">{{ __('common.options') }}</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col"><span
                                        class="fa-regular fa-list-dropdown mx-1"></span> {{ __('common.option-title') }}
                                </th>
                                <th scope="col"><span
                                        class="fa-regular fa-circle-sort mx-1"></span> {{ __('common.sort-order') }}
                                </th>
                                <th scope="col"><span
                                        class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}
                                </th>
                                <th scope="col" class="text-end"></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($question->options as $option)
                                <tr>
                                    <td>{{ $option->option }}</td>
                                    <td>{{ $option->sort_order }}</td>
                                    <td>
                                        @if($option->status)
                                            <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                        @else
                                            <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                            <div data-bs-toggle="tooltip" data-bs-placement="top"
                                                 data-bs-custom-class="kp-tooltip"
                                                 data-bs-title="{{ __('common.edit')}}">
                                                <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}"
                                                        data-bs-toggle="modal" data-bs-target="#option-edit-modal"
                                                        data-route="{{ route('portal.meeting.survey.option.update',['meeting' => $question->survey->meeting_id, 'survey' => $question->survey_id, 'question' => $question->id, 'option' => $option->id]) }}"
                                                        data-resource="{{ route('portal.meeting.survey.option.edit',['meeting' => $question->survey->meeting_id, 'survey' => $question->survey_id, 'question' => $question->id, 'option' => $option->id]) }}"
                                                        data-id="{{ $option->id }}">
                                                    <span class="fa-regular fa-pen-to-square"></span>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-placement="top"
                                                 data-bs-custom-class="kp-tooltip"
                                                 data-bs-title="{{ __('common.delete') }}">
                                                <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}"
                                                        data-bs-toggle="modal" data-bs-target="#option-delete-modal"
                                                        data-route="{{ route('portal.meeting.survey.option.show', ['meeting' => $question->survey->meeting_id, 'survey' => $question->survey_id, 'question' => $question->id, 'option' => $option->id]) }}"
                                                        data-record="{{ $option->option }}">
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
                    <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal"
                            data-bs-target="#option-create-modal"
                            data-route="{{ route('portal.meeting.survey.option.store',['meeting' => $question->survey->meeting_id, 'survey' => $question->survey_id, 'question' => $question->id]) }}">
                        <i class="fa-solid fa-plus"></i> {{ __('common.create-new-option') }}
                    </button>
                </div>
                <x-crud.form.common.create name="option">
                    @section('option-create-form')
                        <x-input.hidden method="c" name="survey_id" :value="$question->survey->id"/>
                        <x-input.hidden method="c" name="question_id" :value="$question->id"/>
                        <x-input.text method="c" name="option" title="option" icon="list-dropdown"/>
                        <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort"/>
                        <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value"  option_name="title" icon="toggle-large-on"/>
                    @endsection
                </x-crud.form.common.create>
                <x-crud.form.common.delete name="option"/>
                <x-crud.form.common.edit name="option">
                    @section('option-edit-form')
                        <x-input.hidden method="e" name="survey_id" :value="$question->survey->id"/>
                        <x-input.hidden method="e" name="question_id" :value="$question->id"/>
                        <x-input.text method="e" name="option" title="option" icon="list-dropdown"/>
                        <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort"/>
                        <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
                    @endsection
                </x-crud.form.common.edit>
            </div>
        </div>
    </div>
@endsection
