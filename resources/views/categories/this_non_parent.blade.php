@if (Route::currentRouteName() === "categories.show")


    @php($data = $thisRelatedThings)

    @include('crud.includes.table._table')

@endif