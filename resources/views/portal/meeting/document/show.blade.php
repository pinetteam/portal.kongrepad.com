@extends('layout.portal.meeting-detail')
@section('title', $document->title . ' | ' . __('common.document'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.show', $meeting->id) }}" class="text-decoration-none">{{ $meeting->title }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portal.meeting.document.index', ['meeting' => $meeting->id]) }}" class="text-decoration-none">{{ __('common.documents') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $document->title }}</li>
@endsection
@section('meeting_content')
    <div class="card bg-kongre-secondary">
        <div class="card-header">
            <h1 class="text-center"><span class="fa-duotone fa-folder-open fa-fade"></span> <small>"{{ $document->title }}"</small> {{ __('common.document') }}</h1>
            <div class="table-responsive">
                <table class="table table-dark table-striped-columns table-bordered">
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.meeting') }}:</th>
                        <td class="text-start w-25">{{ $meeting->title }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                        <td class="text-start w-25">{{ $document->title }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.status') }}:</th>
                        <td class="text-start w-25">
                            @if($document->status)
                                {{ __('common.active') }}
                            @else
                                {{ __('common.passive') }}
                            @endif
                        </td>
                        <th scope="row" class="text-end w-25">{{ __('common.sharing-via-email') }}:</th>
                        <td class="text-start w-25">
                            @if($document->sharing_via_email)
                                {{ __('common.active') }}
                            @else
                                {{ __('common.passive') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                        <td class="text-start w-25">{{ $document->created_by_name }}</td>
                        <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                        <td class="text-start w-25">{{ $document->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card-body p-0">
            @if(isset($document->file_name) && isset($document->file_extension))
                <div class="ratio ratio-16x9">
                    <iframe src="{{ asset('storage/documents/' . $document->file_name . '.' . $document->file_extension) }}"></iframe>
                </div>
            @else
                <i class="text-info">{{ __('common.unspecified') }}</i>
            @endif
        </div>
    </div>
@endsection
