@props(['method' => 'm', 'type' => 'text', 'name', 'title', 'icon' => 'question'])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}"></i> {{ __('common.'.$title) }}
    </label>
    <input type="{{ $type }}"
           name="{{ $name }}"
           class="form-control @error($name)is-invalid @enderror"
           id="{{ $method }}-{{ $name }}"
           placeholder="{{ __('common.'.$title) }}"
           @if($type!=='password')
            value="{{ old($name) }}"
           @endif
    />
    @error($name)
        <div class="invalid-feedback">
            <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
        </div>
    @enderror
</div>
