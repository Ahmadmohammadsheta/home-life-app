@props([
    'type' => 'td',
    'columnValue' => '',
    'columnAsValue' => '',
])

<{{ $type }} {{ $attributes->class([
        'border-bottom-0',
        'text-center ',
        'text-danger' => $columnValue === false ? true : false,
        'text-success' => $columnValue === true ? true : false,
    ]) }}
>
    @if ($columnAsValue == 'image')
    <a href="{{ asset($columnValue) }}" target="_blank">
        <img src="{{ asset($columnValue) }}" alt="My Image" style="width:45px; height:30px">
    </a>
    @else
    {{ $columnValue === true ? 'True' : ($columnValue === false ? 'False' : $columnValue) }}
    @endif
    {{ $slot }}
</{{ $type }}>
