@props([
    'table',
    'object',
    'first' => [
        'route' => 'index',
        'name' => 'NOT TRASHED',
        'color' => 'primary'
    ],
    'second'
])


<div class="card-header pb-0">

    <div class="w-50">
        <form action="{{ URL::current() }}" method="get" class="d-flex">
            <x-form.input
                name="name"
                class="m-1"
                :value="request('name')"
                placeholder="Search......"
            />
            <x-form.radio
                name="is_parent"
                type="radio" class="m-1"
                :checked="request('is_parent')"
                :options="[
                    true => 'True',
                    'false' => 'False',
                    '' => 'all'
                ]"
            />
            <button type="submit" class="btn btn-dark m-1 border-0 rounded-0">
                <i class="lni lni-search-alt"></i>
            </button>
        </form>
    </div>

    @if (Route::currentRouteName() === "$table.show")
    <div class="d-flex justify-content-between">
        <a class="btn btn-primary btn-block" href="{{ route($table.'.create', ['id' => request()->route("$object.id")]) }}">{{ __('ADD RELATED') }}</a>
    </div>
    @else
    <div class="d-flex">
        @if ($first != null)
        <a class="btn btn-{{ $first['color'] }}" href="{{ route($table.'.'. $first['route']) }}">{{ __($first['name']) }}</a>
        @endif
        @if ($second != null)
        <a class="btn btn-{{ $second['color'] }} mx-3" href="{{ route($table.'.'. $second['route']) }}">{{ __($second['name']) }}</a>
        @endif
    </div>
    @endif

</div>
