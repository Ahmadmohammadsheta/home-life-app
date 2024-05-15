
<div class="form-group">
    @if ((Str::contains($column['name'], '_id')))
    <select name="{{ $column['name'] }}" class="form-control SlectBox m-2">
        <option class="text-center" value="" selected disabled>{{ __('Choose ').ucfirst(substr($column['name'], 0, -3)) }}</option>
        @if ($column['name'] == 'parent_id')
            @foreach (("App\Models\\".ucfirst($modelObjectName))::where('id', '!=', $id)->whereNotIn('id', $allChildren)->get() as $value)

            <option class=" @error($column['name']) is-invalid @enderror" value="{{ $value->id }}"
                {{ $value->id != $$modelObjectName->$modelObjectNameValue ?: 'selected' }}
                >{{ $value->name }}</option>
            @endforeach
        @else
            @foreach (("App\Models\\".ucfirst(substr($column['name'], 0, -3)))::all() as $value)

            <option class=" @error($column['name']) is-invalid @enderror" value="{{ $value->id }}"
                {{ $value->id != $$modelObjectName->$modelObjectNameValue ?: 'selected' }}
                >{{ $value->name }}</option>
            @endforeach
        @endif
    </select>
    @endif

    @include('crud.includes.general._errors')
</div>

