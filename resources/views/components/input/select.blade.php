@props(['method' => 'm', 'name', 'title', 'options', 'option_value', 'option_name', 'icon' => 'question', 'fade' => 'off', 'searchable' => false])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}{{ $fade=='on' ? ' fa-fade' : '' }}"></i> {{ __('common.'.$title) }}
    </label>
    <div>
        <select name="{{ $name }}" class="@if(!$searchable)form-select @endif @error($name)is-invalid @enderror" id="{{ $method }}-{{ $name }}" aria-label="{{ __('common.'.$title) }}" autocomplete="false">
            <option selected value="">{{ __('common.choose') }}</option>
            @foreach($options as $option)
                @if(is_array($option))
                    <option @isset($option['font_type'])style="font-family: '{{ $option['font_type'] }}'" @endisset value="{{ $option[$option_value] }}"{{ old($name)==$option[$option_value] ? ($searchable ? 'data-placeholder="true"' : ' selected') : '' }}>{{ $option[$option_name] }}</option>
                @else
                    <option @isset($option->font_type)style="font-family: '{{ $option->font_type }}'" @endisset value="{{ $option->$option_value }}"{{ old($name)==$option->$option_value ? ($searchable ? 'data-placeholder="true"' : ' selected') : '' }}>{{ $option->$option_name }}</option>
                @endif
            @endforeach
        </select>
    </div>
    @error($name)
        <div class="invalid-feedback d-block">
            <i class="fa-regular fa-triangle-exclamation"></i> {{ $message }}
        </div>
    @enderror
</div>
@if($searchable)
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var selects = selects || {}
            selects['{{ $method }}-{{ $name }}'] = new SlimSelect({
                select: "#{{ $method }}-{{ $name }}"
            });
        });
    </script>
@endif
