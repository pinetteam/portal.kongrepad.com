@props(['name' => 'default'])
<div class="modal fade" id="{{ $name }}-delete-modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="{{ $name }}-delete-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <form method="POST" action="" name="{{ $name }}-delete-form" id="{{ $name }}-delete-form" autocomplete="nope">
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="delete-modal-label">{{ __('common.delete') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('common.are-you-sure-you-want-to-delete') }} <strong id="{{ $name }}-delete-record" class="text-danger"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <div class="btn-group w-100" role="group" aria-label="{{ __('common.processes') }}">
                        <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                        <button type="submit" class="btn btn-success w-75" id="{{ $name }}-delete-form-submit">{{ __('common.delete') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="module">
    const deleteFormSubmit = document.getElementById('{{ $name }}-delete-form-submit');
    const deleteModal = document.getElementById('{{ $name }}-delete-modal');
    var waitForSeconds, countdown;
    deleteModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        if(button) {
            deleteFormSubmit.disabled = true;
            waitForSeconds = 5;
            clearInterval(countdown);
            document.getElementById('{{ $name }}-delete-form').action = button.getAttribute('data-route');
            deleteModal.querySelector('#{{ $name }}-delete-record').textContent = button.getAttribute('data-record');
            countdown = setInterval(function() {
                deleteFormSubmit.innerHTML = '{{ __('common.delete') }} (' + (--waitForSeconds) + ')';
                if (waitForSeconds <= 0) {
                    deleteFormSubmit.innerHTML = '{{ __('common.delete') }}';
                    deleteFormSubmit.disabled = false;
                }
            }, 1000);
        }
        deleteFormSubmit.innerHTML = '{{ __('common.delete') }} (' + (waitForSeconds) + ')';
    });
    deleteFormSubmit.addEventListener('click', function() {
        deleteFormSubmit.disabled = true;
        deleteFormSubmit.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div> {{ __('common.deleting') }}';
        document.getElementById('{{ $name }}-delete-form').submit();
    });
</script>
