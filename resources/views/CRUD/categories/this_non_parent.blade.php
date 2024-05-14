@if (Route::currentRouteName() === "categories.show")


    @php($data = $thisRelatedThings)

    @include('crud._table')

@endif
