

<div class="form-group">
    <div class="mb-3">
        <label for="formFile" class="form-label">File input</label>
        <input name="image" class="form-control @error($column['name']) is-invalid @enderror" type="file" id="formFile">

        @include('crud.includes.general._errors')
    </div>
    @if (Str::contains($$modelObjectName->$modelObjectNameValue, '.'))
    <div class="mb-3">
        <a href="{{ asset($$modelObjectName->$modelObjectNameValue) }}" target="_blank">
            <img src="{{ asset($$modelObjectName->$modelObjectNameValue) }}" alt="My Image" style="width:45px; height:30px">
        </a>
    </div>
    @endif
</div>
