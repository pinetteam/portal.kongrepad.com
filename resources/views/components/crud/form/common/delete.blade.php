@props(['name' => 'default'])
<div class="offcanvas offcanvas-end modern-offcanvas" data-bs-backdrop="static" tabindex="-1" id="{{ $name }}-delete-modal" aria-labelledby="{{ $name }}-delete-modal-label">
    <div class="offcanvas-header modern-offcanvas-header">
        <h5 class="offcanvas-title modern-offcanvas-title" id="{{ $name }}-delete-modal-label">
            <i class="fas fa-trash me-2"></i>{{ __('common.delete') }}
        </h5>
        <button type="button" class="btn-close modern-btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body modern-offcanvas-body">
        <form method="POST" action="" name="{{ $name }}-delete-form" id="{{ $name }}-delete-form" autocomplete="nope" class="h-100 d-flex flex-column">
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <div class="flex-grow-1 overflow-auto">
                <div class="alert alert-danger modern-alert">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger me-3"></i>
                        <h6 class="mb-0">{{ __('common.are-you-sure-you-want-to-delete') }}</h6>
                    </div>
                    <p class="mb-2">
                        <strong id="{{ $name }}-delete-record" class="text-danger"></strong>
                    </p>
                    <p class="mb-0">
                        <em class="text-muted">{{__('common.this-operation-will-delete-all-related-objects')}}</em>
                    </p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top modern-border-top">
                <div class="btn-group w-100" role="group" aria-label="{{ __('common.processes') }}">
                    <button type="button" class="btn btn-outline-secondary w-25" data-bs-dismiss="offcanvas">
                        <i class="fas fa-times me-1"></i>{{ __('common.close') }}
                    </button>
                    <button type="submit" class="btn btn-danger w-75" id="{{ $name }}-delete-form-submit">
                        <i class="fas fa-trash me-1"></i>{{ __('common.delete') }}
                    </button>
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
                deleteFormSubmit.innerHTML = '<i class="fas fa-trash me-1"></i>{{ __('common.delete') }} (' + (--waitForSeconds) + ')';
                if (waitForSeconds <= 0) {
                    deleteFormSubmit.innerHTML = '<i class="fas fa-trash me-1"></i>{{ __('common.delete') }}';
                    deleteFormSubmit.disabled = false;
                }
            }, 1000);
        }
        deleteFormSubmit.innerHTML = '<i class="fas fa-trash me-1"></i>{{ __('common.delete') }} (' + (waitForSeconds) + ')';
    });
</script>
