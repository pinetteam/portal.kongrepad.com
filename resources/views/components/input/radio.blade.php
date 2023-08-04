@props(['method' => 'm', 'name', 'title', 'options', 'option_value', 'option_name', 'icon' => 'question', 'fade' => 'off'])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}{{ $fade=='on' ? ' fa-fade' : '' }}"></i> {{ __('common.'.$title) }}
    </label>
    <div class="btn-group w-100" role="group" aria-label="{{ __('common.'.$title) }}">
        @foreach($options as $option=>$value)
            <input type="radio" name="{{ $name }}" class="btn-check @error($name)is-invalid @enderror" id="{{ $method }}-{{ $name }}-{{ $value[$option_value] }}" value="{{ $value[$option_value] }}" autocomplete="false"{{ ((old($name) !== null) && old($name) == $value[$option_value]) ? ' checked' : '' }} />
            <label class="btn btn-outline-{{ $value['color'] }}" for="{{ $method }}-{{ $name }}-{{ $value[$option_value] }}">{{ $value[$option_name] }}</label>
        @endforeach
    </div>
    @if($errors->any())
    @error($name)
    <div class="invalid-feedback d-block">
        <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
    </div>
    @enderror
    @endif
</div>
