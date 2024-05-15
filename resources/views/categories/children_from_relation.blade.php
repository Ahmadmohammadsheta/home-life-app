

@if (Route::currentRouteName() === "categories.show")

    @php($data = $childrenData)

    @include('crud.includes.table._table')
@endif

