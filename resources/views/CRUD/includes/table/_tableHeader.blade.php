
@if (Route::currentRouteName() === "$tableName.show")
<div class="d-flex justify-content-between">
    <a class="btn btn-primary btn-block" href="{{ route($tableName.'.create', ['id' => request()->route("$modelObjectName.id")]) }}">{{ __('ADD RELATED') }}</a>
</div>
@else
<div class="d-flex justify-content-between">
    <a class="btn btn-primary btn-block" href="{{ route($tableName.'.create') }}">{{ __('ADD') }}</a>
</div>
@endif
