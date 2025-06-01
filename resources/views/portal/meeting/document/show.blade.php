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
                <div class="document-preview-container" style="min-height: 80vh;">
                    <iframe src="{{ asset('storage/meetings/' . $meeting->id . '/documents/' . $document->file_name) }}" 
                            style="border: none; width: 100%; height: 80vh; min-height: 800px;"
                            title="{{ $document->title }}">
                    </iframe>
                </div>
                <div class="p-3 text-center bg-dark">
                    <a href="{{ route('portal.meeting.document.download', ['meeting' => $meeting->id, 'document' => $document->file_name]) }}" class="btn btn-kongre-accent btn-lg">
                        <span class="fa-regular fa-file-arrow-down"></span> {{ __('common.download') }}
                    </a>
                    <button class="btn btn-outline-light btn-lg ms-2" onclick="toggleFullscreen()">
                        <span class="fa-regular fa-expand"></span> {{ __('common.fullscreen') ?? 'Tam Ekran' }}
                    </button>
                </div>
            @else
                <div class="p-5 text-center">
                    <i class="text-info fa-regular fa-file-slash fa-3x mb-3"></i>
                    <h4 class="text-info">{{ __('common.unspecified') }}</h4>
                    <p class="text-muted">{{ __('common.no-file-available') ?? 'Görüntülenecek dosya yok' }}</p>
                </div>
            @endif
        </div>
    </div>

<script>
function toggleFullscreen() {
    const iframe = document.querySelector('iframe');
    if (iframe.requestFullscreen) {
        iframe.requestFullscreen();
    } else if (iframe.webkitRequestFullscreen) {
        iframe.webkitRequestFullscreen();
    } else if (iframe.msRequestFullscreen) {
        iframe.msRequestFullscreen();
    }
}
</script>

<style>
.document-preview-container {
    background: #f8f9fa;
    border-radius: 0;
}

.document-preview-container iframe {
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
    .document-preview-container iframe {
        height: 60vh !important;
        min-height: 400px !important;
    }
}
</style>
@endsection
