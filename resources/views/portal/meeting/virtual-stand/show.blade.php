@extends('layout.portal.common')
@section('title', $virtual_stand->title . ' | ' . __('common.virtual-stand'))
@section('breadcrumb')
    <li class="breadcrumb-item text-white"><a href="{{ route("portal.meeting.index") }}" class="text-decoration-none">{{ __('common.meetings') }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.show', $virtual_stand->meeting->id) }}" class="text-decoration-none">{{ $virtual_stand->meeting->title }}</a></li>
    <li class="breadcrumb-item text-white"><a href="{{ route('portal.meeting.virtual-stand.index', ['meeting' => $virtual_stand->meeting->id]) }}" class="text-decoration-none">{{ __('common.virtual-stands') }}</a></li>
    <li class="breadcrumb-item active text-white" aria-current="page">{{ $virtual_stand->title }}</li>
@endsection
@section('body')
    <div class="card text-bg-dark">
        <div class="card-header">
            <h1 class="m-0 text-center">{{'"' . $virtual_stand->title . '" ' . __('common.virtual-stand')}}</h1>
        </div>
        <div class="card-body">
            <div class="row flex-shrink-0 g-2">
                <div class="table-responsive">
                    <table class="table table-dark table-striped-columns table-bordered">
                        <tr>
                            <th scope="row" class="text-end w-25">{{ __('common.logo') }}:</th>
                            <td class="text-start w-25">
                                @if(isset($virtual_stand->file_name))
                                    <img src="{{ asset('storage/virtual-stands/' . $virtual_stand->file_name . '.' . $virtual_stand->file_extension) }}" alt="{{ $virtual_stand->title }}"
                                         class="img-thumbnail" style="height:36px;"/>
                                @else
                                    <i class="text-info">{{ __('common.unspecified') }}</i>
                                @endif
                            </td>
                            <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                            <td class="text-start w-25">{{ $virtual_stand->title }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-end w-25">{{ __('common.status') }}:</th>
                            <td class="text-start w-25">
                                @if($virtual_stand->status)
                                    {{ __('common.active') }}
                                @else
                                    {{ __('common.passive') }}
                                @endif
                            </td>
                            <th scope="row" class="text-end w-25">{{ __('common.meeting') }}:</th>
                            <td class="text-start w-25">{{ $meeting->title }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                            <td class="text-start w-25">{{ $virtual_stand->created_by_name }}</td>
                            <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                            <td class="text-start w-25">{{ $virtual_stand->created_at }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if(isset($virtual_stand->pdf_name))
                <div class="ratio ratio-16x9">
                    <iframe src="{{ asset('storage/virtual-stand-pdfs/' . $virtual_stand->pdf_name . '.pdf') }}"></iframe>
                </div>
            @else
                <i class="text-info">{{ __('common.unspecified') }}</i>
            @endif
        </div>
    </div>
@endsection
