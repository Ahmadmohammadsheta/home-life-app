

@if (Route::currentRouteName() === "categories.show")

    @php($data = $childrenData)

    @include('CRUD.table')
@endif

