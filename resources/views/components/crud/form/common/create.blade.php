<div class="modal fade" id="create-modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="create-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark">
            <form method="POST" action="" name="create-form" id="create-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="create-modal-label">{{ __('common.create') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 justify-content-center">
                            @yield('create-form')
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group w-100" role="group" aria-label="{{ __('common.processes') }}">
                        <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal">{{__('common.close')}}</button>
                        <button type="submit" class="btn btn-success w-75">{{ __('common.create') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="module">
    const createModal = document.getElementById('create-modal');
    createModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        if(button) {
            document.getElementById('create-form').action = button.getAttribute('data-route')
        }
    })
    createModal.addEventListener('hide.bs.modal', event => {
        const formControl = document.querySelectorAll('.form-control');
        const invalidFeedback = document.querySelectorAll('.invalid-feedback');
        invalidFeedback.forEach(element => {
            element.classList.remove("d-block");
        });
        formControl.forEach(element => {
            element.classList.remove("is-invalid");
            element.value = null;
        });
    })
</script>
@if($errors->any() && session('method'))
    @if(session('method')=='POST')
        <script type="module">
            new bootstrap.Modal('#create-modal', {}).show();
            document.getElementById('create-form').action = '{{ session('route') }}';
        </script>
    @endif
@endif
