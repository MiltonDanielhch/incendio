@props(['value', 'selected'])
<option value="{{ $value }}" {{ (int)$selected == (int)$value ? 'selected' : '' }}>{{ $slot }}</option>
