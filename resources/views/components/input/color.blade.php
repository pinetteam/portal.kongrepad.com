@props(['method' => 'm', 'name', 'title', 'icon' => 'question', 'fade' => 'off'])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}{{ $fade=='on' ? ' fa-fade' : '' }}"></i> {{ __('common.'.$title) }}
    </label>
    <input name="{{ $name }}" type="color" class="form-control @error($name)is-invalid @enderror" id="{{ $method }}-{{ $name }}" value="{{ old($name) }}" title="{{ __('common.'.$title) }}">
    @error($name)
        <div class="invalid-feedback d-block">
            <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
        </div>
    @enderror
</div>
