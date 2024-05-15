@if (Route::currentRouteName() === "categories.show")

    @php($data = $allRelatedThings)

    @include('crud.includes.table._table')

@endif
