
<div class="form-group">
    @foreach ($arrayForSelectInput as $selectItem)
    @if ($column['name'] == $selectItem['to'])
    <select name="{{ $column['name'] }}" class="form-control SlectBox m-2">
        <option class="text-center" value="" selected disabled>{{ __('Choose ').ucfirst(substr($column['name'], 0, -3)) }}</option>
            @foreach ($selectItem['data'] as $value)

            <option class=" @error($column['name']) is-invalid @enderror" value="{{ $value->id }}"
                @selected(old($column['name'], $$modelObjectName->$modelObjectNameValue) == $value->id)
                >{{ $value->name }}
            </option>

            @endforeach
    </select>
        @endif
    @endforeach

    @include('crud.includes.general._errors')
</div>

