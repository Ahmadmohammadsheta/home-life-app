

<div class="form-group">
    <label for="formFile" class="form-label">File input</label>
    <input type="text"
    class="form-control m-2 @error($cloumnName) is-invalid @enderror"
    name="{{ $cloumnName }}"
    value="{{ old($cloumnName, $$modelObjectName->$cloumnName) }}"
    required
    >

    <x-error :name="$cloumnName" />
</div>
<div class="form-group">
    <div class="mb-3">
        <label for="formFile" class="form-label">File input</label>
        <input name="image" class="form-control @error($cloumnName) is-invalid @enderror" type="file" id="formFile">

        <x-error :column="$cloumnName" />
    </div>
    @if (Str::contains($$modelObjectName->$cloumnName, $modelObjectName))
    <div class="mb-3">
        <a href="{{ asset($$modelObjectName->$cloumnName) }}" target="_blank">
            <img src="{{ asset($$modelObjectName->$cloumnName) }}" alt="My Image" style="width:100px; height:75px">
        </a>
    </div>
    @endif
</div>

<div class="form-check">
    <label for="flexCheckChecked" style="text-align: center important;">{{ __('TRUE') }}</label>

    <input @class([
        'form-check-input',
        'text-center',
        'mr-2 ',
        'is-invalid' => $errors->has($cloumnName)
        ])
        type="checkbox"
        id="flexCheckChecked"
        value="{{ true }}"
        name="{{ $cloumnName }}"
        @checked(old($cloumnName, $$modelObjectName->$cloumnName) == true)
        >

        <x-error :name="$cloumnName" />
</div>

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

<div class="form-group">
    <div class="mb-3">
        <label for="formFile" class="form-label">File input</label>
        <input name="image" class="form-control @error($column['name']) is-invalid @enderror" type="file" id="formFile">

        @include('crud.includes.general._errors')
    </div>
    @if (Str::contains($$modelObjectName->$modelObjectNameValue, '.'))
    <div class="mb-3">
        <a href="{{ asset($$modelObjectName->$modelObjectNameValue) }}" target="_blank">
            <img src="{{ asset($$modelObjectName->$modelObjectNameValue) }}" alt="My Image" style="width:100px; height:75px">
        </a>
    </div>
    @endif
</div>
