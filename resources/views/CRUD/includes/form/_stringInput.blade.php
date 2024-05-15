
<div class="form-group">
    <input type="text"
    class="form-control m-2 @error($column['name']) is-invalid @enderror"
    name="{{ $column['name'] }}"
    value="{{ $$modelObjectName->$modelObjectNameValue }}"
    required>

    @include('crud.includes.general._errors')
</div>
