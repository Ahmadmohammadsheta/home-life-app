@props([
    'color' => 'primary',
    'size',
    'href' => '#',
    'icon' => 'book',
    'route'
])


<a {{ $attributes->class([
        "btn btn-$size",
        "btn-$color",
    ]) }}
    href="{{ $href }}"
    >
    <i class="lni lni-{{ $icon }}"></i>
    {{ $slot }}
</a>
