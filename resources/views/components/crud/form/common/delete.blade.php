@props(['name' => 'default'])
<div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="{{ $name }}-delete-modal" aria-labelledby="{{ $name }}-delete-modal-label">
    <div class="offcanvas-header bg-kongre-primary text-white">
        <h5 class="offcanvas-title" id="{{ $name }}-delete-modal-label">{{ __('common.delete') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body bg-kongre-secondary text-white">
        <form method="POST" action="" name="{{ $name }}-delete-form" id="{{ $name }}-delete-form" autocomplete="nope" class="h-100 d-flex flex-column">
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <div class="flex-grow-1 overflow-auto">
                <div class="alert alert-danger">
                    <p>{{ __('common.are-you-sure-you-want-to-delete') }} <strong id="{{ $name }}-delete-record" class="text-danger"></strong> ?</p>
                    <p><em id="{{ $name }}-delete-record" class="text-danger">{{__('common.this-operation-will-delete-all-related-objects')}}</em></p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top border-dark">
                <div class="btn-group w-100" role="group" aria-label="{{ __('common.processes') }}">
                    <button type="button" class="btn btn-danger w-25" data-bs-dismiss="offcanvas">{{ __('common.close') }}</button>
                    <button type="submit" class="btn btn-success w-75" id="{{ $name }}-delete-form-submit">{{ __('common.delete') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="module">
    const deleteFormSubmit = document.getElementById('{{ $name }}-delete-form-submit');
    const deleteModal = document.getElementById('{{ $name }}-delete-modal');
    var waitForSeconds, countdown;
    deleteModal.addEventListener('show.bs.offcanvas', event => {
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
</script>
