
<div class="form-group">
    @if ((Str::contains($cloumnName, '_id')))
    <select name="{{ $cloumnName }}" class="form-control SlectBox m-2">
        <option class="text-center" value="" selected disabled>{{ __('Choose ').ucfirst(substr($cloumnName, 0, -3)) }}</option>
        @if ($cloumnName == 'parent_id')
            @foreach (("App\Models\\".ucfirst($modelObjectName))::where('id', '!=', $id)->where(function ($query) {
                        $query->where('is_parent', true); // Nested OR condition
                        })->whereNotIn('id', $allChildren)->get() as $value)

            <option class=" @error($cloumnName) is-invalid @enderror" value="{{ $value->id }}"
                @selected(old($cloumnName, $$modelObjectName->$cloumnName) == $value->id)
                >{{ $value->name }}
            </option>
            @endforeach
        @else
            @foreach (("App\Models\\".ucfirst(substr($cloumnName, 0, -3)))::all() as $value)

            <option class=" @error($cloumnName) is-invalid @enderror" value="{{ $value->id }}"
                {{ $value->id != $$modelObjectName->$cloumnName ?: 'selected' }}
                >{{ $value->name }}
            </option>
            @endforeach
        @endif
    </select>
    @endif

    <x-error :name="$cloumnName" />
</div>

