@props(['method' => 'm', 'name', 'title', 'options', 'option_value', 'option_name', 'icon' => 'question'])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}"></i> {{ __('common.'.$title) }}
    </label>
    <div class="btn-group w-100" role="group" aria-label="{{ __('common.'.$title) }}">
        @foreach($options as $option=>$value)
            <input type="radio" name="{{ $name }}" class="btn-check" id="{{ $method }}-{{ $name }}-{{ $value[$option_value] }}" value="{{ $value[$option_value] }}"{{ ((old($name) !== null) && old($name) == $value[$option_value]) ? ' checked' : '' }} />
            <label class="btn btn-outline-{{ $value['color'] }}" for="{{ $method }}-{{ $name }}-{{ $value[$option_value] }}">{{ $value[$option_name] }}</label>
        @endforeach
    </div>
    @error($name)
        <div class="invalid-feedback d-block">
            <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
        </div>
    @enderror
</div>
