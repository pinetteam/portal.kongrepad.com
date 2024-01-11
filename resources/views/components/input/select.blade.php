@props(['method' => 'm', 'name', 'title', 'options', 'option_value', 'option_name', 'icon' => 'question', 'fade' => 'off'])
<div class="col form-group mb-3">
    <label for="{{ $method }}-{{ $name }}" class="form-label">
        <i class="fa-regular fa-{{ $icon }}{{ $fade=='on' ? ' fa-fade' : '' }}"></i> {{ __('common.'.$title) }}
    </label>
    <div>
        <input id="search-bar-container-{{ $method }}-{{ $name }}" type="text" class="form-control search-input" placeholder="{{ __('common.search') }}" oninput="searchOptions(this)">
        <select name="{{ $name }}" class="form-select @error($name)is-invalid @enderror" id="{{ $method }}-{{ $name }}" aria-label="{{ __('common.'.$title) }}" autocomplete="false">
            <option selected value="">{{ __('common.choose') }}</option>
            @foreach($options as $option)
                @if(is_array($option))
                    <option @isset($option['font_type'])style="font-family: '{{ $option['font_type'] }}'" @endisset value="{{ $option[$option_value] }}"{{ old($name)==$option[$option_value] ? ' selected' : '' }}>{{ $option[$option_name] }}</option>
                @else
                    <option @isset($option->font_type)style="font-family: '{{ $option->font_type }}'" @endisset value="{{ $option->$option_value }}"{{ old($name)==$option->$option_value ? ' selected' : '' }}>{{ $option->$option_name }}</option>
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
<script>
    function searchOptions(input) {
        var filter, options, option, i, txtValue;
        filter = input.value.toLowerCase();
        select = input.nextElementSibling;
        options = select.getElementsByTagName('option');

        for (i = 0; i < options.length; i++) {
            option = options[i];
            txtValue = option.textContent || option.innerText;

            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
    }
</script>
