
<div class="form-group">
    @foreach ($arrayForSelectInput as $selectItem)
    @if ($cloumnName == $selectItem['to'])
    <select name="{{ $cloumnName }}" class="form-control SlectBox mt-1 mb-1">
        <option class="text-center" value="" selected disabled>{{ __('Choose ').ucfirst(substr($cloumnName, 0, -3)) }}</option>
            @foreach ($selectItem['data'] as $value)

            <option class=" @error($cloumnName) is-invalid @enderror" value="{{ $value->id }}"
                @selected(old($cloumnName, $$modelObjectName->$cloumnName) == $value->id)
                >{{ $value->name }}
            </option>

            @endforeach
    </select>
        @endif
    @endforeach

    <x-error :name="$cloumnName" />
</div>

