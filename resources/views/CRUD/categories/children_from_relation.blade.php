

@if (Route::currentRouteName() === "categories.show")

    @php($data = $childrenData)

    @include('crud._table')
@endif

