@props(['name' => 'default', 'method' => 'e'])
<div class="offcanvas offcanvas-end modern-offcanvas" data-bs-backdrop="static" tabindex="-1" id="{{ $name }}-edit-modal" aria-labelledby="{{ $name }}-edit-modal-label">
    <div class="offcanvas-header modern-offcanvas-header">
        <h5 class="offcanvas-title modern-offcanvas-title" id="{{ $name }}-edit-modal-label">
            <i class="fas fa-edit me-2"></i>{{ __('common.edit') }}
        </h5>
        <button type="button" class="btn-close modern-btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body modern-offcanvas-body">
        <form method="POST" action="" name="{{ $name }}-edit-form" id="{{ $name }}-edit-form" enctype="multipart/form-data" autocomplete="nope" class="h-100 d-flex flex-column">
            @csrf
            <input name="_method" type="hidden" value="PATCH" />
            <div class="flex-grow-1 overflow-auto">
                <div class="container-fluid">
                    <div class="row row-cols-1 justify-content-center">
                        @yield($name.'-edit-form')
                    </div>
                </div>
            </div>
            <div class="mt-3 pt-3 border-top modern-border-top">
                <div class="btn-group w-100" role="group" aria-label="{{ __('common.processes') }}">
                    <button type="button" class="btn btn-outline-secondary w-25" data-bs-dismiss="offcanvas">
                        <i class="fas fa-times me-1"></i>{{ __('common.close') }}
                    </button>
                    <button type="submit" class="btn btn-warning w-75" id="{{ $name }}-edit-form-submit">
                        <i class="fas fa-save me-1"></i>{{ __('common.edit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="module">
    const editModal = document.getElementById('{{ $name }}-edit-modal');
    editModal.addEventListener('show.bs.offcanvas', event => {
        document.getElementById("kp-loading").style.visibility = "visible";
        if(event.relatedTarget) {
            const button = event.relatedTarget;
            let url = button.getAttribute('data-resource');
            fetch(url)
                .then((response) => {
                    document.getElementById("kp-loading").style.visibility = "hidden";
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
                                console.log(value['value']);
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
                            // First clear all radio buttons for this field
                            const allRadiosForField = editModal.querySelectorAll('input[name="' + key + '"]');
                            allRadiosForField.forEach(radio => {
                                radio.checked = false;
                                radio.removeAttribute('checked');
                            });
                            
                            // Then set the correct one
                            const radioElement = editModal.querySelector('#{{ $method }}-' + key + '-' + value['value']);
                            if (radioElement !== null) {
                                radioElement.checked = true;
                                radioElement.setAttribute('checked', 'checked');
                            }
                        } else if(value['type'] === 'select') {
                            const selectElement = editModal.querySelector('#{{ $method }}-' + key);
                            if (selectElement !== null) {
                                selectElement.value = value['value'];
                                if(typeof selects !== 'undefined' && selects['{{ $method }}-' + key] != null && value['value'] !== null){
                                    selects['{{ $method }}-' + key].setSelected(value['value'].toString())
                                }
                            }
                        } else if(value['type'] === 'text') {
                            const textElement = editModal.querySelector('#{{ $method }}-' + key);
                            if (textElement !== null) {
                                textElement.value = value['value'];
                            }
                        } else if(value['type'] === 'color') {
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
    editModal.addEventListener('hide.bs.offcanvas', event => {
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
@if($errors->any() && session('method') && session('route') && session('route') && session('name') == $name)
    @if(session('method')=='PATCH' || session('method')=='PUT')
        <script type="module">
            new bootstrap.Offcanvas('#{{ $name }}-edit-modal', {}).show();
            document.getElementById('{{ $name }}-edit-form').action = '{{ session('route') }}';
        </script>
    @endif
@endif
