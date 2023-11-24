@extends('layout.portal.common')
@section('title', $announcement->title . ' | ' . __('common.announcement'))
@section('body')
<div class="card text-bg-dark">
    <div class="card-header">
        <h1 class="text-center"><span class="fa-duotone fa-megaphone fa-fade"></span> <small>"{{ $announcement->title }}"</small></h1>
        <div class="table-responsive">
            <table class="table table-dark table-striped-columns table-bordered">
                <tr>
                    <th scope="row" class="text-end w-25">{{ __('common.meeting') }}:</th>
                    <td class="text-start w-25">{{ $meeting->title }}</td>
                    <th scope="row" class="text-end w-25">{{ __('common.title') }}:</th>
                    <td class="text-start w-25">
                        @if($announcement->status)
                            <i style="color:green" class="fa-regular fa-toggle-on"></i>
                        @else
                            <i style="color:red" class="fa-regular fa-toggle-off"></i>
                        @endif
                        {{ $announcement->title }}
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="text-end w-25">{{ __('common.created-by') }}:</th>
                    <td class="text-start w-25">{{ $announcement->created_by_name }}</td>
                    <th scope="row" class="text-end w-25">{{ __('common.created-at') }}:</th>
                    <td class="text-start w-25">{{ $announcement->created_at }}</td>
                </tr>
                <tr>
                    <th scope="row" class="text-end w-25">{{ __('common.is-published') }}:</th>
                    <td class="text-start w-25">
                    @if($announcement->is_published)
                        <i style="color:green" class="fa-regular fa-toggle-large-on"></i>
                    @else
                        <i style="color:red" class="fa-regular fa-toggle-large-off"></i>
                    @endif
                    </td>
                    <th scope="row" class="text-end w-25">{{ __('common.publish-at') }}:</th>
                    <td class="text-start w-25">{{ $announcement->publish_at }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
