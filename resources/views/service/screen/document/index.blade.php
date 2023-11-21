@extends('layout.screen.common')
@section('title', __('common.document-screen'))
@section('script')
    <script type="module">
        Echo.channel('service.screen.document.{{ $meeting_hall_screen->code }}')
            .listen('.document-event', data => {
                if(data.document !== null) {
                    document.getElementById("document").src = "{{ asset('storage/documents/') }}/" + data.document.file_name + '.' + data.document.file_extension;
                } else {
                    document.getElementById("document").src = '#';
                }
            });
    </script>
@endsection
@section('body')
<div class="ratio ratio-16x9">
    <iframe id='document' src="{{ (isset($document) && isset($document->file_name) && isset($document->file_extension)) ? asset('storage/documents/' . $document->file_name . '.' . $document->file_extension) : '#'}}"></iframe>
</div>
@endsection

