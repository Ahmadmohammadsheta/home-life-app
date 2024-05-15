

@error($column['name'])
<span class="text-danger" role="alert">
    @foreach ($errors->get($column['name']) as $error)
    <strong>{{ $error }}</strong>
    @endforeach
</span>
@enderror









{{-- @error($column['name'])
<span class="invalid-feedback" role="alert">    {
    <strong>{{ $message }}</strong>
    @foreach ($errors->get($column['name']) as $error)
    <strong>{{ $error }}</strong>
    @endforeach
</span>
@enderror --}}



{{-- <div class="alert alert-danger">
    <ul class="">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div> --}}

