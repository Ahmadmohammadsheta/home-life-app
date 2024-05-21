
<div class="mb-3">
    <div class="form-check">
        <label style="text-align: center important;">{{ __('TRUE') }}</label>

        <input @class([
            'form-check-input',
            'form-check-input',
            'text-center',
            'mr-2 ',
            'is-invalid' => $errors->has($column['name'])
            ])
            type="checkbox"
            id="flexCheckChecked"
            value="{{ true }}"
            name="{{ $column['name'] }}"
            @checked(old($column['name'], $$modelObjectName->$modelObjectNameValue) == 'true')
            >

        @include('crud.includes.general._errors')
    </div>
</div>
