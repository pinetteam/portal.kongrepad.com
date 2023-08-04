@props(['name' => 'default', 'title'])
<div class="modal fade" id="{{ $name }}-modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="#{{ $name }}-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="{{ $name }}-modal-label">{{ $title }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="{{ $name }}-yield" class="text-center"></div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group w-100" role="group" aria-label="{{ __('common.processes') }}">
                        <button type="button" class="btn btn-info w-25" data-bs-dismiss="modal">{{__('common.close')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="module">
    const showModal = document.getElementById('{{ $name }}-modal');
    showModal.addEventListener('show.bs.modal', event => {
        document.getElementById("kp-loading").style.visibility = "visible";
        if(event.relatedTarget) {
            const button = event.relatedTarget;
            let url = button.getAttribute('data-resource');
            fetch(url)
                .then((response) => {
                    document.getElementById("kp-loading").style.visibility = "hidden";
                    return response.text();
                })
                .then((data) => {
                    document.getElementById("{{ $name }}-yield").innerHTML = data;
                })
                .catch();
        }
    })
</script>
