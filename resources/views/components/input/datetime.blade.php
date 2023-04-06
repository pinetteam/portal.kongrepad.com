@props(['method' => 'm', 'name', 'title', 'icon' => 'question'])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}"></i> {{ __('common.'.$title) }}
    </label>
    <input type="text" name="{{ $name }}" class="form-control @error($name)is-invalid @enderror" id="{{ $method }}-{{ $name }}" value="{{ old($name) }}" placeholder="{{ __('common.'.$title) }}" />
    @error($name)
        <div class="invalid-feedback d-block">
            <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
        </div>
    @enderror
</div>
<script type="module">
    const picker{{ $name }} = new tempusDominus.TempusDominus(document.getElementById('{{ $method }}-{{ $name }}'), {
        useCurrent: false,
        display: {
            components: {
                clock: true
            }
        },
        localization: {
            locale: '{{ Auth::user()->customer->language }}',
            format: 'dd/MM/yyyy HH:mm'
        }
    });
    document.getElementById('{{ $method }}-{{ $name }}').addEventListener('click', (event) => {
        if(event.target.value) {
            picker{{ $name }}.dates.setValue(tempusDominus.DateTime.convert(moment(event.target.value, 'DD/MM/YYYY HH:mm').toDate()));
        } else {
            picker{{ $name }}.dates.setValue(tempusDominus.DateTime.convert(moment().toDate()));
        }
    });
</script>
