
@props([
    'name', 'options', 'checked' => false
])

@foreach ($options as $value => $text)

<div class="form-check mb-2">

    <input {{ $attributes->class([
            'form-check-input',
            'is-invalid' => $errors->has($name)
        ]) }}

        type="checkbox"
        id="flexCheckChecked"
        value="{{ $value }}"
        name="{{ $name }}"
        @checked(old($name, $checked) == $value)
        >

        <x-error :name="$name" />

        <label for="flexCheckChecked" class="form-check-label">{{ $text }}</label>

</div>
@endforeach

