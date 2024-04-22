@if (Route::currentRouteName() === "categories.show")


    @php($data = $thisFinalCategoryData)

    @include('CRUD.table')

@endif
