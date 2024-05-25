@props([
    'type' => '',
    'method' => 'DELETE',
    'action' => '',
    'actionType' => 'delete',
    'id' => '',
    'color' => 'danger',
    'size' => 'sm',
    'icon' => ''
])


<button form="{{$actionType.$id}}"
    {{ $attributes->class([
        "btn btn-$size",
        "btn-$color"
    ]) }}
>
<i class="lni lni-{{ $icon }}"></i>
{{ $slot }}
</button>
<form id="{{$actionType.$id}}" action="{{ $action }}" method="POST">@csrf @method($method)</form>
