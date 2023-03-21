@if(session('success'))
    <script type="module">
        const successModal = new bootstrap.Modal('#success-modal', {})
        successModal.show();
    </script>
    <div class="modal fade" id="success-modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="success-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5 text-success" id="success-modal-label">{!! __('common.success-modal-title') !!}</h1>
                </div>
                <div class="modal-body">
                    <span class="text-white">{!! session('success') !!}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">{!! __('common.success-modal-close') !!}</button>
                </div>
            </div>
        </div>
    </div>
@endif
@if(session('warning'))
    <script type="module">
        const warningModal = new bootstrap.Modal('#warning-modal', {})
        warningModal.show();
    </script>
    <div class="modal fade" id="warning-modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="warning-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5 text-warning" id="warning-modal-label">{!! __('common.warning-modal-title') !!}</h1>
                </div>
                <div class="modal-body">
                    <span class="text-white">{!! session('warning') !!}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">{!! __('common.warning-modal-close') !!}</button>
                </div>
            </div>
        </div>
    </div>
@endif
@if(session('error'))
    <script type="module">
        const errorModal = new bootstrap.Modal('#error-modal', {})
        errorModal.show();
    </script>
    <div class="modal fade" id="error-modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="error-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5 text-danger" id="error-modal-label">{!! __('common.error-modal-title') !!}</h1>
                </div>
                <div class="modal-body">
                    <span class="text-white">{!! session('error') !!}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">{!! __('common.error-modal-close') !!}</button>
                </div>
            </div>
        </div>
    </div>
@endif
