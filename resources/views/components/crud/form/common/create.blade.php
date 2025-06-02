@props(['name' => 'default'])
<div class="offcanvas offcanvas-end modern-offcanvas" data-bs-backdrop="static" tabindex="-1" id="{{ $name }}-create-modal" aria-labelledby="{{ $name }}-create-modal-label">
    <div class="offcanvas-header modern-offcanvas-header">
        <h5 class="offcanvas-title modern-offcanvas-title" id="{{ $name }}-create-modal-label">
            <i class="fas fa-plus me-2"></i>{{ __('common.create') }}
        </h5>
        <button type="button" class="btn-close modern-btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body modern-offcanvas-body">
        <form method="POST" action="" name="{{ $name }}-create-form" id="{{ $name }}-create-form" enctype="multipart/form-data" autocomplete="nope" class="h-100 d-flex flex-column">
            @csrf
            <div class="flex-grow-1 overflow-auto">
                <div class="container-fluid">
                    <div class="row row-cols-1 justify-content-center">
                        @yield($name.'-create-form')
                    </div>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top modern-border-top">
                <div class="btn-group w-100" role="group" aria-label="{{ __('common.processes') }}">
                    <button type="button" class="btn btn-outline-secondary w-25" data-bs-dismiss="offcanvas">
                        <i class="fas fa-times me-1"></i>{{__('common.close')}}
                    </button>
                    <button type="submit" class="btn btn-primary w-75" id="{{ $name }}-create-form-submit">
                        <i class="fas fa-save me-1"></i>{{ __('common.create') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="module">
    const createModal = document.getElementById('{{ $name }}-create-modal');
    createModal.addEventListener('show.bs.offcanvas', event => {
        const button = event.relatedTarget;
        if(button) {
            document.getElementById('{{ $name }}-create-form').action = button.getAttribute('data-route');
        }
    });
    createModal.addEventListener('hide.bs.offcanvas', event => {
        const formControl = document.querySelectorAll('.form-control');
        const invalidFeedback = document.querySelectorAll('.invalid-feedback');
        invalidFeedback.forEach(element => {
            element.classList.remove("d-block");
        });
        formControl.forEach(element => {
            element.classList.remove("is-invalid");
            element.value = null;
        });
    });
</script>
@if($errors->any() && session('method') && session('name') == $name)
    @if(session('method')=='POST')
        <script type="module">
            new bootstrap.Offcanvas('#{{ $name }}-create-modal', {}).show();
            document.getElementById('{{ $name }}-create-form').action = '{{ session('route') }}';
        </script>
    @endif
@endif
