@props(['name' => 'default', 'method' => 'e'])
<div class="modal fade" id="{{ $name }}-edit-modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="{{ $name }}-edit-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark">
            <form method="POST" action="" name="{{ $name }}-edit-form" id="{{ $name }}-edit-form" enctype="multipart/form-data" autocomplete="nope">
                @csrf
                <input name="_method" type="hidden" value="PATCH" />
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="{{ $name }}-edit-modal-label">{{ __('common.edit') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 justify-content-center">
                            @yield('edit-form')
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group w-100" role="group" aria-label="{{ __('common.processes') }}">
                        <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                        <button type="submit" class="btn btn-success w-75" id="{{ $name }}-edit-form-submit">{{ __('common.edit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="module">
    const editModal = document.getElementById('{{ $name }}-edit-modal');
    editModal.addEventListener('show.bs.modal', event => {
        if(event.relatedTarget) {
            const button = event.relatedTarget;
            let url = button.getAttribute('data-resource');
            fetch(url)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    const resource = data.data;
                    document.getElementById('{{ $name }}-edit-form').action = resource.route;
                    for (const [key, value] of Object.entries(resource)) {
                        if(value['type'] === 'checkbox') {
                            value['value'].forEach(title => {
                                const checkboxElement = editModal.querySelector('#{{ $method }}-' + key + '-' + title.replaceAll('.',"\\."));
                                if (checkboxElement !== null) {
                                    checkboxElement.setAttribute('checked', 'checked');
                                }
                            });
                        } else if(value['type'] === 'date') {
                            const dateElement = editModal.querySelector('#{{ $method }}-' + key);
                            if (dateElement !== null) {
                                dateElement.value = value['value'];
                            }
                        } else if(value['type'] === 'datetime') {
                            const datetimeElement = editModal.querySelector('#{{ $method }}-' + key);
                            if (datetimeElement !== null) {
                                datetimeElement.value = value['value'];
                            }
                        } else if(value['type'] === 'email') {
                            const emailElement = editModal.querySelector('#{{ $method }}-' + key);
                            if (emailElement !== null) {
                                emailElement.value = value['value'];
                            }
                        } else if(value['type'] === 'file') {

                        } else if(value['type'] === 'hidden') {
                            const hiddenElement = editModal.querySelector('#{{ $method }}-' + key);
                            if (hiddenElement !== null) {
                                hiddenElement.value = value['value'];
                            }
                        } else if(value['type'] === 'multiselect') {
                            const multiselectElement = editModal.querySelector('#{{ $method }}-' + key + '-' + value['value']);
                            if (multiselectElement !== null) {
                                multiselectElement.setAttribute('selected', 'selected');
                            }
                        } else if(value['type'] === 'number') {
                            const numberElement = editModal.querySelector('#{{ $method }}-' + key);
                            if (numberElement !== null) {
                                numberElement.value = value['value'];
                            }
                        } else if(value['type'] === 'password') {

                        } else if(value['type'] === 'radio') {
                            const radioElement = editModal.querySelector('#{{ $method }}-' + key + '-' + value['value']);
                            if (radioElement !== null) {
                                radioElement.setAttribute('checked', 'checked');
                            }
                        } else if(value['type'] === 'select') {
                            const selectElement = editModal.querySelector('#{{ $method }}-' + key);
                            if (selectElement !== null) {
                                selectElement.value = value['value'];
                            }
                        } else if(value['type'] === 'text') {
                            const textElement = editModal.querySelector('#{{ $method }}-' + key);
                            if (textElement !== null) {
                                textElement.value = value['value'];
                            }
                        }
                    }
                })
                .catch();
        }
    })
    editModal.addEventListener('hide.bs.modal', event => {
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
    const editFormSubmit = document.getElementById('{{ $name }}-edit-form-submit');
    editFormSubmit.addEventListener('click', function() {
        editFormSubmit.disabled = true;
        editFormSubmit.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div> {{ __('common.editing') }}';
        document.getElementById('{{ $name }}-edit-form').submit();
    });
</script>
@if($errors->any() && session('method') && session('route'))
    @if(session('method')=='PATCH' || session('method')=='PUT')
        <script type="module">
            new bootstrap.Modal('#{{ $name }}-edit-modal', {}).show();
            document.getElementById('{{ $name }}-edit-form').action = '{{ session('route') }}';
        </script>
    @endif
@endif
