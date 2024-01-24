@props(['method' => 'm', 'name', 'title', 'icon' => 'question', 'fade' => 'off'])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}{{ $fade=='on' ? ' fa-fade' : '' }}"></i> {{ __('common.'.$title) }}
    </label>
    <input type="number" name="{{ $name }}" class="form-control @error($name)is-invalid @enderror" value="{{ old($name) }}" id="{{ $method }}-{{ $name }}" placeholder="{{ __('common.'.$title) }}" min="0" autocomplete="false"/>
    @error($name)
        <div class="invalid-feedback d-block">
            <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
        </div>
    @enderror
</div>
