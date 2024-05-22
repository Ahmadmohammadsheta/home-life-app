@props([
    'table',
    'object'
])


@if (Route::currentRouteName() === "$table.show")
<div class="d-flex justify-content-between">
    <a class="btn btn-primary btn-block" href="{{ route($table.'.create', ['id' => request()->route("$object.id")]) }}">{{ __('ADD RELATED') }}</a>
</div>
@else
<div class="d-flex justify-content-between">
    <a class="btn btn-primary btn-block" href="{{ route($table.'.create') }}">{{ __('ADD') }}</a>
</div>
@endif
