@props([
    'type' => 'text',
    'name',
    'value' => '',
    'object' => '',
    'objectName' => request()->route()->controller->additionalData['modelObjectName'],
    'required' => ''
])

<div class="form-group">
    <input type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $attributes->class([
            'form-control',
            'mt-1',
            'mb-2',
            'is-invalid' => $errors->has($name)
        ]) }}
        {{ $required }}
    >

    <x-error :name="$name" />

    @if ($type == 'file' && Str::contains($value, $objectName))
    <div class="mb-0">
        <a href="{{ asset($object->$name) }}" target="_blank">
            <img src="{{ asset($object->$name) }}" alt="My Image" style="width:100px; height:75px">
        </a>
    </div>
    @endif
</div>
