@if (Route::currentRouteName() === "categories.show")

    @php($data = $finalCategoryData)

    @include('CRUD.table')

@endif
