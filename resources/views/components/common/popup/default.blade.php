@if(session('success'))
    <script type="module">
        const successModal = new bootstrap.Offcanvas('#success-modal', {})
        successModal.show();
    </script>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="success-modal" data-bs-backdrop="static" aria-labelledby="success-modal-label">
        <div class="offcanvas-header bg-kongre-primary text-white">
            <h5 class="offcanvas-title" id="success-modal-label">{!! __('common.success-modal-title') !!}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body bg-kongre-secondary text-white">
            <div class="mb-3">
                <span>{!! session('success') !!}</span>
            </div>
            <div class="mt-3 pt-3 border-top border-dark">
                <button type="button" class="btn btn-success w-100" data-bs-dismiss="offcanvas">{!! __('common.success-modal-close') !!}</button>
            </div>
        </div>
    </div>
@endif
@if(session('warning'))
    <script type="module">
        const warningModal = new bootstrap.Offcanvas('#warning-modal', {})
        warningModal.show();
    </script>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="warning-modal" data-bs-backdrop="static" aria-labelledby="warning-modal-label">
        <div class="offcanvas-header bg-kongre-primary text-white">
            <h5 class="offcanvas-title" id="warning-modal-label">{!! __('common.warning-modal-title') !!}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body bg-kongre-secondary text-white">
            <div class="mb-3">
                <span>{!! session('warning') !!}</span>
            </div>
            <div class="mt-3 pt-3 border-top border-dark">
                <button type="button" class="btn btn-success w-100" data-bs-dismiss="offcanvas">{!! __('common.warning-modal-close') !!}</button>
            </div>
        </div>
    </div>
@endif
@if(session('error'))
    <script type="module">
        const errorModal = new bootstrap.Offcanvas('#error-modal', {})
        errorModal.show();
    </script>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="error-modal" data-bs-backdrop="static" aria-labelledby="error-modal-label">
        <div class="offcanvas-header bg-kongre-primary text-white">
            <h5 class="offcanvas-title" id="error-modal-label">{!! __('common.error-modal-title') !!}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body bg-kongre-secondary text-white">
            <div class="mb-3">
                <span>{!! session('error') !!}</span>
            </div>
            <div class="mt-3 pt-3 border-top border-dark">
                <button type="button" class="btn btn-success w-100" data-bs-dismiss="offcanvas">{!! __('common.error-modal-close') !!}</button>
            </div>
        </div>
    </div>
@endif
