@props(['method' => 'm', 'name', 'title', 'options', 'option_value', 'option_name', 'icon' => 'question'])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}"></i> {{ __('common.'.$title) }}
    </label>
    <select name="{{ $name }}" class="form-select @error($name)is-invalid @enderror" id="{{ $method }}-{{ $name }}" aria-label="{{ __('common.'.$title) }}" autocomplete="false">
        <option selected value="">{{ __('common.choose') }}</option>
        @foreach($options as $option)
            @if(is_array($option))
                <option value="{{ $option[$option_value] }}"{{ old($name)==$option[$option_value] ? ' selected' : '' }}>{{ $option[$option_name] }}</option>
            @else
                <option value="{{ $option->$option_value }}"{{ old($name)==$option->$option_value ? ' selected' : '' }}>{{ $option->$option_name }}</option>
            @endif
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback d-block">
            <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
        </div>
    @enderror
</div>
