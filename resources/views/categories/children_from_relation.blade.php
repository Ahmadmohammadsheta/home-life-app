

@if (Route::currentRouteName() === "categories.show")

    @php($data = $childrenData)

    @include('crud.includes.._table')
@endif

