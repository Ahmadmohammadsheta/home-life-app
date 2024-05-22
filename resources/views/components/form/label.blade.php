@props([
    'id' => ''
])

<label for="{{ $id }}" class="text-primary">{{ $slot }}</label>
