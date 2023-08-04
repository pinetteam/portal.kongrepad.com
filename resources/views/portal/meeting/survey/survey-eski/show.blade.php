@extends('layout.portal.common')
@section('title', __('common.survey').' | '.$survey->title)
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.survey').' | '.$survey->title }}</h1>
        </div>
        <div class="card-body">
            <div class="row flex-shrink-0">
                <div class="col card text-bg-dark p-0">
                    <div class="card-header">
                        <h2 class="m-0 text-center h3">{{ __('common.survey') }}</h2>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-pen-field mx-1"></span> {{ __('common.title') }}:</b> {{ $survey->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-input-text mx-1"></span> {{ __('common.meeting-title') }}:</b> {{ $survey->meeting->title }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-comment-dots mx-1"></span> {{ __('common.description') }}:</b> {{ $survey->description }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}:</b> {{ $survey->start_at }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}:</b> {{ $survey->finish_at }}</li>
                            <li class="list-group-item bg-dark text-white"><b><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}:</b>
                                @if($survey->status)
                                    {{ __('common.active') }}
                                @else
                                    {{ __('common.passive') }}
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card text-bg-dark mt-2">
        <div class="card-header">
            <h1 class="m-0 text-center">{{ __('common.questions') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">

                    <thead class="thead-dark">
                    <tr>

                        <th scope="col"><span class="fa-regular fa-messages-question mx-1"></span> {{ __('common.question-title') }}</th>
                        <th scope="col"><span class="fa-regular fa-circle-sort mx-1"></span> {{ __('common.sort-order') }}</th>
                        <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>

                    <tbody >
                    @foreach($questions as $question)
                        <tr>
                            <td>{{$question->title}}</td>
                            <td>{{$question->sort_order}}</td>
                            <td>
                                @if($question->status)
                                    <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                @else
                                    <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                    {{--show button--}}
                                    <a class="btn btn-info btn-sm" href="{{ route('portal.question.show', ['meeting_id'=> $question->survey->meeting_id,'survey_id'=> $question->survey_id, 'question'=>$question->id,]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                        <span class="fa-regular fa-eye"></span>
                                    </a>
                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit')}}">
                                        {{--edit button--}}
                                        <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#default-edit-modal" data-route="{{ route('portal.question.update',[ 'meeting_id'=>$survey->meeting_id ,'survey_id'=> $survey->id, 'question' => $question->id]) }}" data-resource="{{ route('portal.question.edit',[ 'meeting_id'=>$survey->meeting_id ,'survey_id'=> $survey->id, 'question' => $question->id]) }}" data-id="{{ $question->id }}">
                                            <span class="fa-regular fa-pen-to-square"></span>
                                        </button>
                                    </div>
                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                        <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#default-delete-modal" data-route="{{ route('portal.question.destroy', ['meeting_id'=> $question->survey->meeting_id,'survey_id'=> $question->survey_id, 'question'=>$question->id,]) }}" data-record="{{ $question->title }}">
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
        {{--create button--}}
        <div class="card-footer d-flex justify-content-center">
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#default-create-modal" data-route="{{ route('portal.question.store',['meeting_id'=> $survey->meeting_id,'survey_id'=> $survey->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-question') }}
            </button>
        </div>

        {{--create form--}}
        <x-crud.form.common.create >
            @section('default-create-form')
                <x-input.hidden method="c" name="survey_id" :value="$survey->id"/>
                <x-input.text method="c" name="title" title="title" icon="messages-question" />
                <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort" />
                <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.create>

        <x-crud.form.common.delete />

        {{--edit form--}}
        <x-crud.form.common.edit>
            @section('default-edit-form')
                <x-input.hidden method="e" name="survey_id" :value="$survey->id"/>
                <x-input.text method="e" name="title" title="title" icon="messages-question" />
                <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort" />
                <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.edit>
    </div>




    </div>

@endsection
