@props(['method' => 'm', 'name' => 'status', 'title' => 'status', 'icon' => 'toggle-large-on', 'fade' => 'off', 'value' => 1])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}{{ $fade=='on' ? ' fa-fade' : '' }}"></i> {{ __('common.'.$title) }}
    </label>
    <div class="form-check form-switch">
        <input type="hidden" name="{{ $name }}" value="0" />
        <input type="checkbox" name="{{ $name }}" class="form-check-input @error($name)is-invalid @enderror" id="{{ $method }}-{{ $name }}" value="{{ $value }}"{{ ((old($name) !== null && old($name) == $value) || (old($name) === null && $value == 1)) ? ' checked' : '' }} autocomplete="false" />
        <label class="form-check-label" for="{{ $method }}-{{ $name }}">
            <span class="status-text-active">{{ __('common.active') }}</span>
            <span class="status-text-inactive">{{ __('common.inactive') }}</span>
        </label>
    </div>
    @error($name)
        <div class="invalid-feedback d-block">
            <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
        </div>
    @enderror
</div>

<style>
.form-check-input:checked + .form-check-label .status-text-inactive {
    display: none;
}
.form-check-input:not(:checked) + .form-check-label .status-text-active {
    display: none;
}
</style> 