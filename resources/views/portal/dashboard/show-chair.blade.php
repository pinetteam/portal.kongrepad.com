@extends('layout.portal.common')
@section('title', $meeting->title . ' | ' . __('common.chairs'))
@section('body')
    <div class="col card text-bg-dark p-0">
        <div class="card-header">
            <h2 class="m-0 text-center h3">{{ __('common.chairs') }}</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><span class="fa-regular fa-id-card mx-1"></span> {{ __('common.name') }}</th>
                        <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.type') }}</th>
                        <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.hall') }}</th>
                        <th scope="col"><span class="fa-regular fa-person-military-pointing mx-1"></span> {{ __('common.program') }}</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($chairs as $chair)
                        <tr>
                            <td>{{ $chair->chair->full_name }}</td>
                            <td>{{ __('common.'.$chair->chair->type) }}</td>
                            <td>{{ $chair->program->hall->title }}</td>
                            <td>{{ $chair->program->title }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="{{ __('common.processes') }}">
                                    <a class="btn btn-info btn-sm" href="{{ route('portal.meeting.hall.program.show', ['meeting' => $meeting->id, 'hall' => $chair->program->hall->id, 'program' => $chair->program->id]) }}" title="{{ __('common.show') }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.show') }}">
                                        <span class="fa-regular fa-eye"></span>
                                    </a>
                                    <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="kp-tooltip" data-bs-title="{{ __('common.delete') }}">
                                        <button class="btn btn-danger btn-sm" title="{{ __('common.delete') }}" data-bs-toggle="modal" data-bs-target="#chair-delete-modal" data-route="{{ route('portal.meeting.hall.program.chair.destroy', ['meeting' => $meeting->id, 'hall' => $chair->program->hall->id, 'program' => $chair->program->id, 'chair' => $chair->id ]) }}" data-record="{{ $chair->chair->full_name }}">
                                            <span class="fa-regular fa-trash"></span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <x-crud.form.common.delete name="chair" />
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
