@if (Route::currentRouteName() === "categories.show")

    @php($data = $allRelatedThings)

    @include('crud.includes.._table')

@endif
