
<div class="mb-3">
    <div class="form-check">
        <label style="text-align: center important;">{{ __('TRUE') }}</label>

        <input class="form-check-input text-center mr-2 @error($column['name']) is-invalid @enderror" name="{{ $column['name'] }}"  type="checkbox" value="{{ 1 }}" id="flexCheckChecked" {{ $$modelObjectName->$modelObjectNameValue == false ?: 'checked' }}>

        @include('crud.includes.general._errors')
    </div>
</div>
