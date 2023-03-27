@props(['method' => 'm', 'type' => 'file', 'name', 'title', 'icon' => 'question'])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}"></i> {{ __('common.'.$title) }}
    </label>
    <div class="custom-file">
        <input type="{{ $type }}" name="{{ $name }}" class="form-control @error($name)is-invalid @enderror" id="{{ $method }}-{{ $name }}"             value="{{ old($name) }}">
    </div>
    @error($name)
        <div class="invalid-feedback">
            <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
        </div>
    @enderror
</div>
