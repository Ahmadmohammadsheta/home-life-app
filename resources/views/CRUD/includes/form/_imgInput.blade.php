

<div class="form-group">
    <div class="mb-3">
        <label for="formFile" class="form-label">File input</label>
        <input name="image @error($column['name']) is-invalid @enderror" class="form-control" type="file" id="formFile">

        @include('crud.includes.general._errors')
    </div>
</div>
