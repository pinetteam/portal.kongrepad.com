@props(['method' => 'm', 'name', 'title', 'icon' => 'question'])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}"></i> {{ __('common.'.$title) }}
    </label>
    <input type="text" name="{{ $name }}" class="date-picker form-control @error($name)is-invalid @enderror" id="{{ $method }}-{{ $name }}" value="{{ old($name) }}" placeholder="{{ __('common.'.$title) }}" />
    @error($name)
        <div class="invalid-feedback d-block">
            <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
        </div>
    @enderror
</div>
