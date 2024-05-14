@if (Route::currentRouteName() === "categories.show")

    @php($data = $allRelatedThings)

    @include('crud._table')

@endif
