@props(['method' => 'm', 'name', 'title', 'options', 'option_value', 'option_name', 'icon' => 'question', 'fade' => 'off'])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}-{{ reset($options)[$option_value] }}" class="form-label">
        <i class="fa-duotone fa-{{ $icon }}{{ $fade=='on' ? ' fa-fade' : '' }}"></i> {{ __('common.'.$title) }}
    </label>
    @foreach($options as $option=>$value)
        <div class="form-check form-switch">
            <input type="checkbox" name="{{ $name }}[]" class="form-check-input {{ $method }}-{{ $name }}" id="{{ $method }}-{{ $name }}-{{ $value[$option_value] }}" value="{{ $value[$option_value] }}"{{ ((old($name) !== null) && in_array($value[$option_value], old($name))) ? ' checked' : '' }} autocomplete="false" />
            <label class="form-check-label" for="{{ $method }}-{{ $name }}-{{ $value[$option_value] }}">{{ __('common.'.$value[$option_name]) }}</label>
        </div>
    @endforeach
    @error($name)
        <div class="invalid-feedback d-block">
            <i class="fa-duotone fa-triangle-exclamation"></i> {{ $message }}
        </div>
    @enderror
</div>
