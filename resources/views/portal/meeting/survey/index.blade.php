@extends('layout.portal.common')
@section('title', $meeting->title .' | ' . __('common.surveys'))
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center"><span class="fa-duotone fa-square-poll-horizontal fa-fade"></span> <small>"{{ $meeting->title }}"</small> {{ __('common.surveys') }}</h1>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <caption class="text-end me-3">
                        {{ $surveys->links() }}
                    </caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span class="fa-regular fa-bee mx-1"></span> {{ __('common.meeting') }}</th>
                            <th scope="col"><span class="fa-regular fa-pen-field mx-1"></span> {{ __('common.title') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-up mx-1"></span> {{ __('common.start-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-calendar-arrow-down mx-1"></span> {{ __('common.finish-at') }}</th>
                            <th scope="col"><span class="fa-regular fa-toggle-large-on mx-1"></span> {{ __('common.status') }}</th>
                            <th scope="col" class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($surveys as $survey)
                            <tr>
                                <td>{{$survey->meeting->title}}</td>
                                <td>{{$survey->title}}</td>
                                <td>
                                    @if($survey->start_at)
                                    {{$survey->start_at}}
                                    @else
                                        <i class="text-info">{{__('common.unspecified')}}</i>
                                    @endif
                                </td>
                                <td>
                                    @if($survey->finish_at)
                                        {{$survey->finish_at}}
                                    @else
                                        <i class="text-info">{{__('common.unspecified')}}</i>
                                    @endif
                                </td>
                                <td>
                                    @if($survey->status)
                                        <i style="color:green" class="fa-regular fa-toggle-on fa-xg"></i>
                                    @else
                                        <i style="color:red" class="fa-regular fa-toggle-off fa-xg"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                        <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.survey.show',['meeting' => $survey->meeting_id, 'survey' => $survey->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                            <span class="fa-regular fa-eye"></span>
                                        </a>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.edit')}}">
                                            {{--edit button--}}
                                            <button class="btn btn-warning btn-sm" title="{{ __('common.edit') }}" data-bs-toggle="modal" data-bs-target="#default-edit-modal" data-route="{{ route('portal.meeting.survey.update', ['meeting' => $survey->meeting_id, 'survey' => $survey->id]) }}" data-resource="{{ route('portal.meeting.survey.edit', ['meeting' => $survey->meeting_id, 'survey' => $survey->id]) }}" data-id="{{ $survey->id }}">
                                                <span class="fa-regular fa-pen-to-square"></span>
                                            </button>
                                        </div>
                                        <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                            <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#default-delete-modal" data-route="{{ route('portal.meeting.survey.destroy', ['meeting' => $survey->meeting_id, 'survey' => $survey->id]) }}" data-record="{{ $survey->title }}">
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
            <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#survey-create-modal" data-route="{{ route('portal.meeting.survey.store', ['meeting' => $meeting->id]) }}">
                <i class="fa-solid fa-plus"></i> {{ __('common.create-new-survey') }}
            </button>
        </div>
        <x-crud.form.common.create name="survey">
            @section('survey-create-form')
                <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
                <x-input.number method="c" name="sort_order" title="sort" icon="circle-sort" />
                <x-input.text method="c" name="title" title="title" icon="pen-field" />
                <x-input.text method="c" name="description" title="description" icon="comment-dots" />
                <x-input.datetime method="c" name="start_at" title="start-at" icon="calendar-arrow-down" />
                <x-input.datetime method="c" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
                <x-input.radio method="c" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.create>
        <x-crud.form.common.delete />
        <x-crud.form.common.edit>
            @section('default-edit-form')
                <x-input.hidden method="e" name="meeting_id" :value="$meeting->id" />
                <x-input.number method="e" name="sort_order" title="sort" icon="circle-sort" />
                <x-input.text method="e" name="title" title="title" icon="pen-field" />
                <x-input.text method="e" name="description" title="description" icon="comment-dots" />
                <x-input.datetime method="e" name="start_at" title="start-at" icon="calendar-arrow-down" />
                <x-input.datetime method="e" name="finish_at" title="finish-at" icon="calendar-arrow-down" />
                <x-input.radio method="e" name="status" title="status" :options="$statuses" option_value="value" option_name="title" icon="toggle-large-on" />
            @endsection
        </x-crud.form.common.edit>
    </div>
@endsection



