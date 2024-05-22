@if (Route::currentRouteName() === "categories.show")


    @php($data = $thisRelatedThings)

    @include('crud.includes.._table')

@endif
