@extends('layout.portal.common')
@section('title', __('common.survey').' | '.$survey->title)
@section('body')

    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="text-center">
                <span class="fa-regular fa-square-poll-vertical fa-fade"></span> <small class="p-2">"{{ $survey->title }}"</small>
                {{ __('common.survey') }}
            </h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.survey') }}:</th>
                        <td class="text-start w-25">
                            @if($survey->status)
                                <i style="color:green" class="fa-regular fa-toggle-on"></i>
                            @else
                                <i style="color:red" class="fa-regular fa-toggle-off"></i>
                            @endif
                            {{ $survey->title }}
                        </td>
                        <th scope="row" class="text-end w-25">{{ __('common.description') }}:</th>
                        <td class="text-start w-25">{{ $survey->description }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.start-at') }}:</th>
                        <td class="text-start w-25">{{ $survey->start_at }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.finish-at') }}:</th>
                        <td class="text-start w-25">{{ $survey->finish_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.question-count') }}:</th>
                        <td class="text-start w-25">{{ $survey->questions->count() }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                        <td class="text-start w-25">{{ $survey->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card text-bg-dark mt-2">
        <div class="card-header">
            <h2 class="text-center">
                <span class="fa-regular fa-circle-question fa-fade p-2"> </span>{{ __('common.questions') }}
            </h2>
        </div>
        <div class="card-body p-0">
            <div class="card text-bg-dark mt-2">
                @foreach($questions as $question)
                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-hover">
                            <thead>
                            <tr>
                                <th scope="col "></th>
                                <th scope="col "><span class="fa-regular fa-messages-question mx-1 "></span> {{ __('common.question-title') }}</th>
                                <th scope="col"><span class="fa-regular fa-circle-sort mx-1 "></span> {{ __('common.sort-order') }}</th>
                                <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1  "></span> {{ __('common.option-count') }}</th>
                                <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1 "> </span> {{ __('common.status') }}</th>
                                <th scope="col" class="text-end"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td rowspan="2" style="width: 2%"></td>
                                <td rowspan="1">{{$question->question}}</td>
                                <td rowspan="1">{{$question->sort_order}}</td>
                                <td rowspan="1">{{$question->options->count()}}</td>
                                <td rowspan="1">
                                    @if($question->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end" rowspan="1">
                                    <div class="btn-group" role="group"
                                         aria-label="{{ __('common.processes') }}">
                                        <div data-bs-toggle="tooltip" data-bs-placement="top"
                                             data-bs-custom-class="kp-tooltip"
                                             data-bs-title="{{ __('common.add-option')}}">
                                            <button type="button"
                                                    class="btn btn-outline-success btn-sm w-100  "
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#option-{{$question->id}}-create-modal"
                                                    data-route="{{ route('portal.survey-option.store',['meeting'=>$question->survey->meeting_id, 'survey_id'=> $question->survey_id,'question_id'=> $question->id,]) }}">
                                                <i class="fa-solid fa-plus"></i> {{ __('common.add-option') }}
                                            </button>
                                        </div>
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('portal.question.show', ['meeting'=> $question->survey->meeting,'survey_id'=> $question->survey_id, 'question'=>$question->id,]) }}"
                                           title="{{ __('common.show') }}"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="kp-tooltip"
                                           data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top"
                                             data-bs-custom-class="kp-tooltip"
                                             data-bs-title="{{ __('common.edit')}}">
                                            <button class="btn btn-warning btn-sm"
                                                    title="{{ __('common.edit') }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#question-edit-modal"
                                                    data-route="{{ route('portal.question.update',[ 'meeting'=>$survey->meeting_id ,'survey_id'=> $survey->id, 'question' => $question->id]) }}"
                                                    data-resource="{{ route('portal.question.edit',[ 'meeting'=>$survey->meeting_id ,'survey_id'=> $survey->id, 'question' => $question->id]) }}"
                                                    data-id="{{ $question->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top"
                                             data-bs-custom-class="kp-tooltip"
                                             data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm"
                                                    title="{{ __('common.delete') }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#question-delete-modal"
                                                    data-route="{{ route('portal.question.destroy', ['meeting'=> $question->survey->meeting_id,'survey_id'=> $question->survey_id, 'question'=>$question->id,]) }}"
                                                    data-record="{{ $question->question }}">
                                                <span class="fa-regular fa-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="1" colspan="3">
                                    <div class="table-responsive w-100">
                                        <table class="table table-dark table-striped table-hover">
                                            <thead class="thead-dark">
                                            <tr>
                                            <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span> {{ __('common.option-title') }}</th>
                                            <th scope="col"><span class="fa-regular fa-circle-sort mx-1"></span> {{ __('common.sort-order') }}</th>
                                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                                            <th scope="col" class=""></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($question->options as $option)
                                                <tr>
                                                    <td>{{$option->option}}</td>
                                                    <td>{{$option->sort_order}}</td>
                                                    <td>
                                                        @if($option->status)
                                                            <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                                        @else
                                                            <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="btn-group" role="group"
                                                             aria-label="{{ __('common.processes') }}">
                                                            <div data-bs-toggle="tooltip"
                                                                 data-bs-placement="top"
                                                                 data-bs-custom-class="kp-tooltip"
                                                                 data-bs-title="{{ __('common.edit')}}">
                                                                <button
                                                                    class="btn btn-warning btn-sm"
                                                                    title="{{ __('common.edit') }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#option-edit-modal"
                                                                    data-route="{{ route('portal.survey-option.update',['meeting'=>$option->question->survey->meeting_id, 'survey_id'=> $option->question->survey_id,'question_id'=> $option->question_id, 'survey_option'=>$option->id,]) }}"
                                                                    data-resource="{{ route('portal.survey-option.edit',[ 'meeting'=>$question->survey->meeting_id, 'survey_id'=>$question->survey_id ,'question_id'=> $question->id, 'survey_option' => $option->id]) }}"
                                                                    data-id="{{ $option->id }}">
                                                                    <span class="fa-regular fa-pen-to-square"></span>
                                                                </button>
                                                            </div>
                                                            <div data-bs-toggle="tooltip"
                                                                 data-bs-placement="top"
                                                                 data-bs-custom-class="kp-tooltip"
                                                                 data-bs-title="{{ __('common.delete') }}">
                                                                <button class="btn btn-danger btn-sm"
                                                                        title="{{ __('common.delete') }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#option-delete-modal"
                                                                        data-route="{{ route('portal.survey-option.show', ['meeting'=>$option->question->survey->meeting_id, 'survey_id'=> $option->question->survey_id,'question_id'=> $option->question_id, 'survey_option'=>$option->id,]) }}" data-record="{{ $option->option }}">
                                                                    <span class="fa-regular fa-trash"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <x-crud.form.common.create method="c-o-{{$question->id}}" name="option-{{$question->id}}">
                                            @section('option-'.$question->id.'-create-form')
                                                <x-input.hidden method="c-o-{{$question->id}}" name="survey_id" :value="$survey->id"/>
                                                <x-input.hidden method="c-o-{{$question->id}}" name="question_id" :value="$question->id"/>
                                                <x-input.text method="c-o-{{$question->id}}" name="option" title="option" icon="list-dropdown"/>
                                                <x-input.number method="c-o-{{$question->id}}" name="sort_order" title="sort" icon="circle-sort"/>
                                                <x-input.radio method="c-o-{{$question->id}}" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
                                            @endsection
                                        </x-crud.form.common.create>
                                        <x-crud.form.common.delete name="option"/>
                                        <x-crud.form.common.edit method="e-o" name="option">
                                            @section('option-edit-form')
                                                <x-input.hidden method="e-o" name="survey_id" :value="$survey->id"/>
                                                <x-input.hidden method="e-o" name="question_id" :value="$question->id"/>
                                                <x-input.text method="e-o" name="option" title="option" icon="list-dropdown"/>
                                                <x-input.number method="e-o" name="sort_order" title="sort" icon="circle-sort"/>
                                                <x-input.radio method="e-o" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
                                            @endsection
                                        </x-crud.form.common.edit>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                @endforeach
                            <tr>
                                <div class="card-footer d-flex justify-content-center">
                                    <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#question-create-modal"
                                            data-route="{{ route('portal.question.store',['meeting'=> $survey->meeting_id,'survey_id'=> $survey->id]) }}">
                                        <i class="fa-solid fa-plus"></i> {{ __('common.create-new-question') }}
                                    </button>
                                </div>
                            </tr>
                            </thead>
                        </table>
                    </div>
            </div>
        </div>
    </div>
    </div>

    <x-crud.form.common.create name="question">
        @section('question-create-form')
            <x-input.hidden method="c" name="survey_id" :value="$survey->id"/>
            <x-input.text method="c" name="question" title="question" icon="messages-question"/>
            <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort"/>
            <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
        @endsection
    </x-crud.form.common.create>

    <x-crud.form.common.delete name="question"/>

    <x-crud.form.common.edit name="question">
        @section('question-edit-form')
            <x-input.hidden method="e" name="survey_id" :value="$survey->id"/>
            <x-input.text method="e" name="question" title="question" icon="messages-question"/>
            <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort"/>
            <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on"/>
        @endsection
    </x-crud.form.common.edit>
@endsection
