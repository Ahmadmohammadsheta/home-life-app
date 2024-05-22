@props([
    'arrayForSelectInput', 'name', 'selected' => '',
])

<div class="form-group">
    @foreach ($arrayForSelectInput as $selectItem)
    @if ($name == $selectItem['to'])
    <select name="{{ $name }}"
        {{ $attributes->class([
            'form-control',
            'mt-1',
            'mb-2',
            'SlectBox'
        ]) }}
    class="form-control SlectBox mt-1 mb-1">
        <option class="text-center" value="" selected disabled>{{ __('Choose ').ucfirst(substr($name, 0, -3)) }}</option>

        @foreach ($selectItem['data'] as $value)

        <option class=" @error($name) is-invalid @enderror" value="{{ $value->id }}"
            @selected($selected == $value->id)
            >{{ $value->name }}
        </option>

        @endforeach
    </select>
        @endif
    @endforeach

    <x-error :name="$name" />
</div>
