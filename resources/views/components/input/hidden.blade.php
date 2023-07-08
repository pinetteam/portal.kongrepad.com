@props(['method' => 'm', 'name', 'value'])
<input type="hidden" name="{{ $name }}" id="{{ $method }}-{{ $name }}" value="{{ $value }}" autocomplete="false" />
