<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1060;">
    @if(session('success'))
        <div class="toast align-items-center text-bg-success border-0" id="success-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fa-solid fa-check-circle me-2"></i>
                    {!! session('success') !!}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <script type="module">
            const successToast = new bootstrap.Toast(document.getElementById('success-toast'), {
                autohide: true,
                delay: 5000
            });
            successToast.show();
        </script>
    @endif

    @if(session('warning'))
        <div class="toast align-items-center text-bg-warning border-0" id="warning-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fa-solid fa-exclamation-triangle me-2"></i>
                    {!! session('warning') !!}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <script type="module">
            const warningToast = new bootstrap.Toast(document.getElementById('warning-toast'), {
                autohide: true,
                delay: 5000
            });
            warningToast.show();
        </script>
    @endif

    @if(session('error'))
        <div class="toast align-items-center text-bg-danger border-0" id="error-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fa-solid fa-times-circle me-2"></i>
                    {!! session('error') !!}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <script type="module">
            const errorToast = new bootstrap.Toast(document.getElementById('error-toast'), {
                autohide: true,
                delay: 5000
            });
            errorToast.show();
        </script>
    @endif
</div>
